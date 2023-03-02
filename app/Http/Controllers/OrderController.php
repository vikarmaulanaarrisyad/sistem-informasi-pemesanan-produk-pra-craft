<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
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
    public function create()
    {
        //
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
        $orders = Order::findOrfail($id);
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
            'status' => 'required|in:confirmed,not confirmed,pending',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $statusText = "";
        if ($request->status == 'confirmed') {
            $statusText = 'dikonfirmasi';
        } elseif ($request->status == 'pending') {
            $statusText = 'pending';
        }

        $orders = Order::findOrfail($id);
        $orderDetail = OrderDetail::where('order_id', $orders->id)->get();

        $stokKurang = false;
        $subTotal = 0;
        foreach ($orderDetail as $item) {
            $product = Product::findOrfail($item->product_id);
            if ($product->stok >= $item->jumlah) {
                $stokAwal = $product->stok;
                $stokSekarang = $stokAwal - $item->jumlah;
                $product->stok = $stokSekarang;

                $subTotal += $item->jumlah * $product->harga;
                $orders->total_harga = $subTotal;

                $product->update();
            } else {
                $stokKurang = true;
                break;
            }
        }

        if ($stokKurang) {
            $orders->update(['status' => 'pending']);
            return response()->json(['message' => 'Stok kurang dari 0'], 422);
        } else {
            $orders->update(['status' => 'confirmed']);
            return response()->json(['message' => 'Pesanan diproses'], 200);
        }
        return response()->json(['data' => $orders, 'message' => 'Pesanan berhasil ' . $statusText]);
    }
}
