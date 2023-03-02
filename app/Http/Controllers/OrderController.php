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

        return view('admin.orders.detail', compact('orders', 'orderDetail'));
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

        $orders = Order::findOrfail($id);

        $orders->update($request->only('status'));

        $statusText = "";
        if ($request->status == 'confirmed') {
            $statusText = 'dikonfirmasi';
        } elseif ($request->status == 'pending') {
            $statusText = 'pending';
        }

        if ($orders->status == 'confirmed') {
            $orderDetail = OrderDetail::where('order_id', $orders->id)->get();

            foreach ($orderDetail as $item) {
                $product = Product::findOrfail($item->product_id);
                $stokAwal = $product->stok;
                $stokSekarang = $stokAwal - $item->jumlah;
                $product->stok = $stokSekarang;
                $product->update();
            }
        }

        return response()->json(['data' => $orders, 'message' => 'Pesanan berhasil ' . $statusText]);
    }
}
