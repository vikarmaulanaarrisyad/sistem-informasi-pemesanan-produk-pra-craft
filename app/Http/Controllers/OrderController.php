<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function getDataOrder(Request $request)
    {
        $orders = Order::when(auth()->user()->hasRole('user'), function ($query) {
            $query->user();
        })
            ->when($request->has('status') && $request->status != "", function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when(
                $request->has('start_date') &&
                    $request->start_date != "" &&
                    $request->has('end_date') &&
                    $request->end_date != "",
                function ($query) use ($request) {
                    $query->whereBetween('tgl_pesanan', $request->only('start_date', 'end_date'));
                }
            )
            ->orderBy('created_at', 'asc');

        return datatables($orders)
            ->addIndexColumn()
            ->addColumn('nama', function ($orders) {
                return $orders->user->name;
            })
            ->addColumn('tanggal', function ($orders) {
                return tanggal_indonesia($orders->tgl_pesanan);
            })
            ->addColumn('status', function ($orders) {
                return '<span class="badge 2xl badge-' . $orders->statusColor() . '">' . $orders->statusText() . '</span>';
            })
            ->addColumn('aksi', function ($orders) {
                return '
                <a href="' . route('orders.detail', $orders->id) . '" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Lihat Detail</a>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function invoice(Request $request, $id)
    {
        $orders = Order::findOrfail($id);
        $orderDetail = OrderDetail::where('order_id', $orders->id)->get();

        return view('admin.orders.invoice', compact('orders', 'orderDetail'));
    }

    public function printInvoice(Request $request, $id)
    {
        $orders = Order::findOrfail($id);
        $orderDetail = OrderDetail::where('order_id', $orders->id)->get();

        return view('admin.orders.print_invoice', compact('orders', 'orderDetail'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail($id)
    {
        $orders = Order::with('user')->findOrfail($id);
        if ($orders->user_id != auth()->id() && auth()->user()->hasRole('user')) {
            abort(404);
        }

        $orderDetail = OrderDetail::where('order_id', $orders->id)->get();
        $subTotal = 0;
        foreach ($orderDetail as $item) {
            $product = Product::findOrFail($item->product_id);
            $subTotal += $item->jumlah * $product->harga;
        }

        return view('admin.orders.detail', compact('orders', 'orderDetail', 'subTotal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = Order::findOrfail($id);
        $orderDetail = OrderDetail::with('product')->where('order_id', $order->id)->get();

        // cek request status adalah succes
        if ($request->status == 'success') {
            foreach ($orderDetail as $item) {
                $product = Product::findOrfail($item->product_id);
                if ($product->stok >= $item->jumlah) {
                    // return 'lebih';
                    // Jika stok lebih dari 0 maka bisa dihitung dengan item dalam produk

                    $item->jml_stok = $product->stok - $item->jumlah;

                    $product->stok -= $item->jumlah;
                    $product->save();

                    $order->total_harga += $item->jumlah * $product->harga;
                    $order->stok_skrng = 0;
                    $order->status = 'success';
                    $order->save();

                    $item->save();
                } else {
                    // return 'kurang';
                    // Jika stok kurang dari 1
                    return response()->json(['message' => 'Stok produk kurang dari 1'], 422);
                }
            }
        } else {
            // return 'cancel';
            $order->status = 'cancel';
            $order->save();
            return response()->json(['message' => 'Pesanan berhasil dibatalkan']);
        }

        $statusText = "";
        if ($request->status == 'success') {
            $statusText = 'dikonfirmasi';
        } elseif ($request->status == 'pending') {
            $statusText = 'pending';
        } elseif ($request->status == 'cancel') {
            $statusText = 'dibatalkan';
        }

        return response()->json(['message' => 'Pesanan berhasil ' . $statusText]);
    }
}
