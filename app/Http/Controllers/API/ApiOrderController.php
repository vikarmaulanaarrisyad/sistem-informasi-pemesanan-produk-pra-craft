<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiOrderController extends Controller
{
    public function getDataOrder()
    {
        $orders = Order::all();

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
}
