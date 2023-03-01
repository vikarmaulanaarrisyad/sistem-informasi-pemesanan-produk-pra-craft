<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{
    public function getDataCategory()
    {
        $category = Category::all();

        return datatables($category)
            ->addIndexColumn()
            ->addColumn('aksi', function ($category) {
                return '
                <button onclick="editForm(`' . route('category.show', $category->id) . '`)" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Lihat Detail</button>
                <button onclick="deleteData(`' . route('category.destroy', $category->id) . '`, `' . $category->nama_kategori . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');

        $categories = Category::where("nama_kategori", "LIKE", "%$keyword%")->get();

        return $categories;
    }
}
