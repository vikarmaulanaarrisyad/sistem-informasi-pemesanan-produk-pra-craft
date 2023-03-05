<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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

        $starDate = date('Y-m-d', strtotime($start));
        $endDate = date('Y-m-d', strtotime($end));

        $orders = Order::where('status', 'success')
            ->whereDate('tgl_pesanan', '>=', $starDate)
            ->whereDate('tgl_pesanan', '<=', $endDate)
            ->get();

        if ($orders) {
            foreach ($orders as $order) {
                foreach ($order->orderDetails  as $orderDetail) {
                    $products = Product::findOrfail($orderDetail->product_id);

                    $row = [];
                    $row['DT_RowIndex'] = $i++;
                    $row['tanggal'] = tanggal_indonesia($order->tgl_pesanan);
                    $row['product'] = $products->nama_produk;
                    $row['stok'] = $orderDetail->jml_stok;
                    $row['harga'] = format_uang($products->harga);
                    $row['qty'] = $orderDetail->jumlah;
                    $row['subtotal'] = format_uang($products->harga * $orderDetail->jumlah);

                    array_push($data, $row);
                }

                // Add the total order price row
                $data[] = [
                    'DT_RowIndex' => '',
                    'tanggal' => '',
                    'product' => '',
                    'stok' => '',
                    'harga' => '',
                    'qty' => '',
                    'subtotal' => '',
                    'total' => format_uang($order->whereDate('tgl_pesanan', '>=', $starDate)->whereDate('tgl_pesanan', '<=', $endDate)->sum('total_harga')),
                ];
            }
        } else {
            // handle case when no orders found for this date
        }

        return $data;
    }

    public function data($start, $end)
    {
        $data = $this->getData($start, $end);

        return datatables($data)
            ->escapeColumns([])
            ->make(true);
    }

    public function exportPDF($start, $end)
    {
        $data = $this->getData($start, $end);
        $pdf = PDF::loadView('admin.report.pdf', compact('start', 'end', 'data'));

        return $pdf->stream('Laporan-transaksi-' . date('Y-m-d-his') . '.pdf');
    }
}
