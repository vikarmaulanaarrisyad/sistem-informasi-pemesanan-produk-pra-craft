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
        $categories  = Category::all();
        // $order = Order::all();
        // $orderDetail = OrderDetail::where('order_id', $order->id)->get();
        $products = Product::where('stok', '>', 1)->get();

        return view('frontend.homepage.index', compact('categories', 'products'));
    }
}
