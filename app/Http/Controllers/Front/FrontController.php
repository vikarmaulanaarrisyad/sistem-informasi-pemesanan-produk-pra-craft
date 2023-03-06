<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $categories  = Category::all();
        // $order = Order::with('orderDetails', 'user')->where('user_id', $userId)->first();
        // $orderDetail = OrderDetail::where('order_id', $order->id)->get();
        $products = Product::where('stok', '!=', 0)->get();

        return view('frontend.homepage.index', compact('categories', 'products'));
    }
}
