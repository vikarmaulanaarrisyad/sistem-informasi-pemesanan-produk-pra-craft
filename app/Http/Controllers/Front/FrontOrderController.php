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
            // DB::beginTransaction();

            // Ambil data produk yang ingin dipesan
            $product = Product::where('slug', $request->slug)->first();

            // Dapatkan user yang sedang login
            $user = auth()->user();

            // Cari pesanan yang masih dalam status 'pending' untuk user yang sedang login
            $order = Order::where('user_id', $user->id)
                ->where('status', 'pending')
                ->first();

            if ($order) {
                // Cek apakah produk yang ingin ditambahkan sudah ada di order detail
                $orderDetail = $order->orderDetails()->where('product_id', $product->id)->first();

                if ($orderDetail) {
                    // Jika produk sudah ada di order detail, tambahkan jumlahnya
                    $orderDetail->jumlah += $request->qty;
                    $orderDetail->jml_stok = 0;
                    $orderDetail->save();
                    DB::commit();
                } else {
                    // Jika produk belum ada di order detail, buat order detail baru
                    $orderDetail = new OrderDetail;
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $product->id;
                    $orderDetail->jumlah = $request->qty;
                    $orderDetail->jml_stok = 0;
                    $orderDetail->save();
                    DB::commit();
                }


                return redirect()->route('orders.show_cart', $product->slug)
                    ->with([
                        'message' => 'Pesanan anda berhasil dimasukkan keranjang.',
                        'success' => true,
                    ]);
            } else {
                // Jika user belum memiliki pesanan, maka buatkan pesanan baru
                $order = new Order;
                $order->user_id = $user->id;
                $order->tgl_pesanan = date('Y-m-d');
                $order->total_harga = 0;
                $order->status = 'pending';
                $order->save();


                // Tambahkan produk ke dalam order detail baru
                $orderDetail = new OrderDetail;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $product->id;
                $orderDetail->jumlah = $request->qty;
                $orderDetail->jml_stok = 0;
                $orderDetail->save();

                DB::commit();

                return redirect()->route('orders.show_cart', $product->slug)
                    ->with([
                        'message' => 'Pesanan anda berhasil dimasukkan keranjang.',
                        'success' => true,
                    ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()
                ->with([
                    'message' => 'Terjadi kesalahan',
                    'error_msg' => true,
                ]);
        }

        // try {

        //     // Ambil data produk yang ingin dipesan
        //     $product = Product::where('slug', $request->slug)->first();

        //     //mendapatkan user yang sedang login
        //     $userId = auth()->user()->id;

        //     // Ambil tanggal pesanan hari ini
        //     $tglSekarang = date('Y-m-d');

        //     // cari pesanan yang masih dalam sataus 'pending' untuk user yang sedang login
        //     $pendingOrder = Order::where('user_id', $userId)
        //         ->where('status', 'pending')
        //         ->first();

        //     // Cek apakah user sudah memiliki pesanan yang masih dalam status 'pending'
        //     if ($pendingOrder) {

        //         // Update jumlah qty sesuai produk di dalam order detail

        //         foreach ($pendingOrder->orderDetails as $orderDetail) {
        //             $orderDetail->order_id = $pendingOrder->id;
        //             $orderDetail->product_id = $product->id;
        //             $orderDetail->jumlah += $request->qty;
        //             $orderDetail->jml_stok = 0;
        //             $orderDetail->save();
        //         }

        //         DB::commit();

        //         // return 'User sudah memiliki pesanan yang masih dalam status "pending". Tidak perlu membuat pesanan baru. dan hanya menambah jumlah di tabel orderDetail';
        //         return redirect()->route('orders.show_cart', $product->slug)
        //             ->with([
        //                 'message' => 'Pesanan anda berhasil dimasukkan keranjang.',
        //                 'success' => true,
        //             ]);
        //     } else {
        //         // Cari pesanan yang sudah berhasil untuk user yang sedang login
        //         $successOrder = Order::where('user_id', $userId)
        //             ->where('status', 'success')
        //             ->first();

        //         if ($successOrder) {
        //             // Jika user sudah memiliki pesanan yang sudah berhasil,
        //             // maka buatkan pesanan baru untuk user yang sedang login
        //             $order = new Order;
        //             $order->user_id = $userId;
        //             $order->tgl_pesanan = $tglSekarang;
        //             $order->total_harga = 0;
        //             $order->save();

        //             $orderDetail = new OrderDetail;
        //             $orderDetail->order_id = $order->id;
        //             $orderDetail->product_id = $product->id;
        //             $orderDetail->jumlah = $request->qty;
        //             $orderDetail->jml_stok = 0;
        //             $orderDetail->save();

        //             DB::commit();

        //             return redirect()->route('orders.show_cart', $product->slug)
        //                 ->with([
        //                     'message' => 'Pesanan anda berhasil dimasukkan keranjang.',
        //                     'success' => true,
        //                 ]);
        //         } else {
        //             // Jika user belum memiliki pesanan, maka buatkan pesanan baru
        //             $order = new Order;
        //             $order->user_id = $userId;
        //             $order->tgl_pesanan = $tglSekarang;
        //             $order->total_harga = 0;
        //             $order->save();

        //             $orderDetail = new OrderDetail;
        //             $orderDetail->order_id = $order->id;
        //             $orderDetail->product_id = $product->id;
        //             $orderDetail->jumlah = $request->qty;
        //             $orderDetail->jml_stok = 0;
        //             $orderDetail->save();

        //             DB::commit();

        //             return redirect()->route('orders.show_cart', $product->slug)
        //                 ->with([
        //                     'message' => 'Pesanan anda berhasil dimasukkan keranjang.',
        //                     'success' => true,
        //                 ]);
        //         }
        //     }
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     DB::rollBack();
        //     return $th;
        //     return back()
        //         ->with([
        //             'message' => 'Terjadi kesalahan',
        //             'error_msg' => true,
        //         ]);
        // }
    }

    public function showCart()
    {
        $carts = Order::with('orderDetails.product')
            ->where('user_id', auth()->user()->id)
            ->where('status', 'pending')
            ->get();

        return view('frontend.product.shopping_cart', compact('carts'));
    }

    // Mengubah jumlah produk dalam keranjang belanja
    public function updateCart(Request $request, $orderId)
    {
        foreach ($request->product_ids as $key => $product) {
            // Ambil order detail berdasarkan order ID dan ID produk
            $orderDetail = OrderDetail::where('order_id', $orderId)
            ->where('product_id', $product[0])
            ->first();

            // Update jumlah pada order detail dengan qty baru
            $orderDetail->jumlah = $request['qty'][$key];
            $orderDetail->save();
        }

        return back()->with([
            'message' => 'Pesanan anda berhasil diubah.',
            'success' => true
        ]);
    }

    public function removeFromCart($orderId, $productId)
    {
        $orderDetail = OrderDetail::findOrfail($orderId)->with('product', 'order')->get();

        foreach ($orderDetail as $item) {
            if ($item->product_id == $item->product->id) {
                // return 'yes sama';
                $item->order->delete();
                $item->delete();
                return redirect()->route('homepage');
            } else {
                //
                return redirect()->back();
            }
        }
    }

    // Checkout
    public function checkout(Request $request)
    {
        // Proses pembayaran dan kirim email konfirmasi
    }
}
