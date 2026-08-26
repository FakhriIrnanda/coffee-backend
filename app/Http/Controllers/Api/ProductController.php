<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->featured) {
            $query->where('is_featured', true);
        }

        $products = $query->latest()->get();
        return response()->json(['data' => $products]);
    }

    public function adminIndex(Request $request)
    {
        $query = Product::with('category');

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->get();
        return response()->json($products);
    }

    public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'is_featured' => 'sometimes|boolean',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

    $product = Product::create([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $imagePath,
        'is_featured' => $request->is_featured ?? false,
    ]);

    return response()->json([
        'message' => 'Produk berhasil dibuat',
        'product' => $product,
    ], 201);
}

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'category_id' => 'sometimes|exists:categories,id',
        'name' => 'sometimes|string|max:255',
        'description' => 'nullable|string',
        'price' => 'sometimes|numeric|min:0',
        'stock' => 'sometimes|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'is_active' => 'sometimes|boolean',
        'is_featured' => 'sometimes|boolean',
    ]);

    if ($request->hasFile('image')) {
        // Hapus gambar lama
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->image = $request->file('image')->store('products', 'public');
    }

    $product->update($request->except('image'));

    return response()->json([
        'message' => 'Produk berhasil diupdate',
        'product' => $product,
    ]);
}

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus',
        ]);
    }
}