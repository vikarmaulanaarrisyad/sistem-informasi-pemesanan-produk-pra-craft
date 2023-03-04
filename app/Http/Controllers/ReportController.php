<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = now()->subDay(30)->format('Y-m-d');
        $end = date('Y-m-d');

        if ($request->has('start') && $request->start != "" && $request->has('end') && $request->end != "") {
            $start = $request->start;
            $end = $request->end;
        }

        return view('admin.report.index', compact('start', 'end'));
    }

    public function getData($start, $end, $escape = false)
    {
        $data = [];
        $i = 1;
        $stok_keluar = 0;

        $starDate = date('Y-m-d', strtotime($start)); // ganti $date dengan tanggal yang ingin ditampilkan
        $endDate = date('Y-m-d', strtotime($end)); // ganti $date dengan tanggal yang ingin ditampilkan

        $order = Order::where('status', 'success')
            ->whereDate('tgl_pesanan', '>=', $starDate)
            ->whereDate('tgl_pesanan', '<=', $endDate)
            ->get();

        if ($order) {
            foreach ($order as $value) {
                $orderDetails = OrderDetail::where('order_id', $value->id)
                    ->first();
                $products = Product::where('id', $orderDetails->product_id)
                    ->first();

                $stok_keluar += $orderDetails->jumlah;

                $row = [];
                $row['DT_RowIndex'] = $i++;
                $row['tanggal'] = tanggal_indonesia($value->tgl_pesanan);
                $row['product'] = $products->nama_produk;
                $row['stok'] = $products->stok;
                $row['harga'] = format_uang($products->harga);
                $row['qty'] = $orderDetails->jumlah;
                $row['subtotal'] = format_uang($value->total_harga);

                array_push($data, $row);
            }
        } else {
            // handle case when no orders found for this date
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'product' => '',
            'stok' => '',
            'harga' => '',
            'qty' => '',
            'subtotal' => '',
        ];

        return $data;
    }

    public function data($start, $end)
    {
        $data = $this->getData($start, $end);

        return datatables($data)
            ->escapeColumns([])
            ->make(true);
    }
}
