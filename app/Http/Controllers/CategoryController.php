<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.category.index');
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
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|min:2',
            'slug'  => 'unique:categories,slug',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data ' . $request->nama_kategori . ' gagal tersimpan'], 422);
        }

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori)
        ];

        $category = new Category();
        $category->nama_kategori = $data['nama_kategori'];
        $category->slug = $data['slug'];
        $category->save();

        return response()->json(['message' => 'Data ' . $request->nama_kategori . ' tersimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json(['data' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|min:2',
            'slug' => 'unique:categories,slug' . $category->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data ' . $request->nama_kategori . ' gagal tersimpan'], 422);
        }

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori)
        ];

        $category->nama_kategori = $data['nama_kategori'];
        $category->slug = $data['slug'];
        $category->update();

        return response()->json(['message' => 'Data ' . $request->nama_kategori . ' tersimpan']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Data ' . $category->nama_kategori . ' terhapus']);
    }
}
