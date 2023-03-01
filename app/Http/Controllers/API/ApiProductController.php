<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiProductController extends Controller
{
    public function getDataProduct()
    {
        $products = Product::all();

        return datatables($products)
            ->addIndexColumn()
            ->addColumn('harga', function ($products) {
                return format_uang($products->harga);
            })
            ->editColumn('gambar', function ($products) {
                return '<img src="' . Storage::url($products->gambar) . '" class="img-thumbnail" width="50px">';
            })
            ->addColumn('aksi', function ($products) {
                return '
                <button onclick="editForm(`' . route('product.show', $products->id) . '`)" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Lihat Detail</button>
                <button onclick="deleteData(`' . route('product.destroy', $products->id) . '`, `' . $products->nama_produk . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

}
