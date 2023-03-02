<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApiPelangganController extends Controller
{
    public function getDataPelanggan()
    {
        $user = User::user()->get();

        return datatables($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                <button onclick="editForm(`' . route('pelanggan.show', $user->id) . '`)" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Lihat Detail</button>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
