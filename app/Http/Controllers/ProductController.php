<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::orderBy('nama_kategori')->get()->pluck('nama_kategori', 'id');

        return view('admin.product.index', compact('category'));
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
            'nama_produk' => 'required|min:2',
            'deskripsi' => 'required|min:5',
            'harga' => 'required|regex:/^[0-9.]+$/|min:1',
            'stok'  => 'required|numeric',
            'gambar' => 'required|mimes:jpg,png,jpeg|min:200|max:2048',
            'categories' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data ' . $request->nama_produk . ' gagal tersimpan.'], 422);
        }

        if (!$request->hasFile('gambar')) {
            return response()->json(['message' => 'File tidak boleh kosong!.'], 422);
        }

        $fileImage = $request->file('gambar');

        if (!$fileImage->isValid()) {
            return response()->json(['message' => 'Upload file gagal!.'], 422);
        }

        $data = [
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => str_replace('.', '', $request->harga),
            'stok' => $request->stok,
            'gambar' => upload('product', $fileImage, 'product'),
        ];

        $product = new Product();
        $product->nama_produk = $data['nama_produk'];
        $product->deskripsi = $data['deskripsi'];
        $product->harga = $data['harga'];
        $product->stok = $data['stok'];
        $product->gambar = $data['gambar'];
        $product->save();

        $product->category_product()->attach($request->categories);

        return response()->json(['data' => $data, 'message' => 'Data ' . $request->nama_produk . ' tersimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $product->gambar = Storage::url($product->gambar);
        $product->categories = $product->category_product;


        return response()->json(['data' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|min:2',
            'deskripsi' => 'required|min:5',
            'harga' => 'required|regex:/^[0-9.]+$/|min:1',
            'stok'  => 'required|numeric',
            'gambar' => 'nullable|mimes:jpg,png,jpeg|min:200|max:2048',
            'categories' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data ' . $request->nama_produk . ' gagal tersimpan.'], 422);
        }

        $data = $request->except('gambar', 'categories');

        $data = [
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => str_replace('.', '', $request->harga),
            'stok' => $request->stok,
        ];

        if ($request->hasFile('gambar')) {
            if (Storage::disk('public')->exists($product->gambar)) {
                Storage::disk('public')->delete($product->gambar);
            }

            $data['gambar'] = upload('product', $request->file('gambar'), 'product');
        }

        $product->update($data);

        $product->category_product()->sync($request->categories);

        return response()->json(['data' => $data, 'message' => 'Data ' . $request->nama_produk . ' tersimpan']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        if (Storage::disk('public')->exists($product->gambar)) {
            Storage::disk('public')->delete($product->gambar);
        }

        return response()->json(['message' => 'Data ' . $product->nama_produk . ' terhapus']);
    }
}
