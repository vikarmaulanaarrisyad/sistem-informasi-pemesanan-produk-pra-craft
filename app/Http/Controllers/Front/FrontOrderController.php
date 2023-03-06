<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FrontOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $id;
        $orderDetail = OrderDetail::findOrFail($id);
        $orderDetail->delete();

        return redirect()->route('homepage');
    }

    public function addToCart(Request $request)
    {
        // mulai transaction
        DB::beginTransaction();

        try {
            // Cek apakah user sudah memiliki order pada hari ini
            $user_id = auth()->user()->id;
            $tgl_pesanan = date('Y-m-d');
            $existing_order = Order::where('user_id', $user_id)
                ->whereDate('tgl_pesanan', $tgl_pesanan)
                ->first();
            $product = Product::where('slug', $request->slug)->first();
            // dd($product);

            // jika user belum memiliki order pada hari ini, buat order baru
            if (!$existing_order) {
                // Buat order baru
                $order = new Order;
                $order->user_id = auth()->user()->id;
                $order->tgl_pesanan = date('Y-m-d');
                $order->total_harga = 0;
                $order->save();

                // Tambahkan order detail ke order baru
                $orderDetail = new OrderDetail;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $product->id;
                $orderDetail->jumlah = $request->qty;
                $orderDetail->jml_stok = 0;
                $orderDetail->save();
            } else {
                // Jika user sudah memiliki order pada hari ini, cek apakah produk sudah ada di dalam order detail
                $existing_order_detail = OrderDetail::where('order_id', $existing_order->id)
                    ->where('product_id', $product->id)
                    ->first();

                if (!$existing_order_detail) {
                    // Jika produk belum ada di dalam order detail, tambahkan order detail ke order tersebut
                    $orderDetail = new OrderDetail;
                    $orderDetail->order_id = $existing_order->id;
                    $orderDetail->product_id = $product->id;
                    $orderDetail->jumlah = $request->qty;
                    $orderDetail->jml_stok = 0;
                    $orderDetail->save();
                } else {
                    // Jika produk sudah ada di dalam order detail, tambahkan jumlah pesanan ke order detail tersebut
                    $existing_order_detail->jumlah += $request->qty;
                    $existing_order_detail->save();
                }
            }
            DB::commit();
            return back()
                ->with([
                    'message' => 'Pesanan anda berhasil di masukkan keranjang',
                    'success' => true,
                ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th;
            return back()
                ->with([
                    'message' => 'Terjadi kesalahan',
                    'error_msg' => true,
                ]);
        }
    }

    public function showCart()
    {
        $carts = Order::where('user_id', auth()->user()->id)->with('orderDetails.product')->get();

        return view('frontend.product.shopping_cart', compact('carts'));
    }

    // Mengubah jumlah produk dalam keranjang belanja
    public function updateCart(Request $request, $id)
    {
        // $cart = Cart::find($id);
        // if ($cart) {
        //     $cart->quantity = $request->quantity;
        //     $cart->save();
        //     return redirect()->route('cart.show')->with('success', 'Cart updated!');
        // } else {
        //     return redirect()->route('cart.show')->with('error', 'Cart not found!');
        // }
    }

    public function removeFromCart($orderId, $productId)
    {
        $orderDetail = OrderDetail::findOrfail($orderId)->with('product', 'order')->get();

        foreach ($orderDetail as $item) {
            if ($item->product_id == $item->product->id) {
                // return 'yes sama';
                $item->delete();
                return redirect()->route('homepage');
            } else {
                return 'No';
            }
        }
        dd($orderDetail);

        // $orderDetail = OrderDetail::findOrFail($id);
        // $orderDetail->delete();

        // if ($orderDetail) {
        //     $orderDetail->delete();
        //     return redirect()->back()->with('message', 'Product removed from cart!');
        // } else {
        //     return redirect()->back()->with('message', 'Product removed from cart!', 422);
        // }
    }

    // Checkout
    public function checkout(Request $request)
    {
        // Proses pembayaran dan kirim email konfirmasi
    }
}
