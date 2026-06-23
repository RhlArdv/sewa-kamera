<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductResult;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('id_produk', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_name' => 'required|string|max:255',
            'category_id' => 'required|exists:tb_categories,id_kategori',
            'unit' => 'required|integer|min:0',
            'prices.6' => 'required|numeric|min:0',
            'prices.12' => 'required|numeric|min:0',
            'prices.24' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'results.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->except(['photos', 'results']);
        $product = Product::create($data);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('galleries', 'public');
                ProductGallery::create([
                    'produk_id' => $product->id_produk,
                    'foto' => $path
                ]);
            }
        }

        if ($request->hasFile('results')) {
            foreach ($request->file('results') as $result) {
                $path = $result->store('results', 'public');
                ProductResult::create([
                    'produk_id' => $product->id_produk,
                    'foto' => $path
                ]);
            }
        }

        return redirect()->route('menu.products.index')->with('success', 'Produk dan foto berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::with(['galleries', 'results'])->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'produk_name' => 'required|string|max:255',
            'category_id' => 'required|exists:tb_categories,id_kategori',
            'unit' => 'required|integer|min:0',
            'prices.6' => 'required|numeric|min:0',
            'prices.12' => 'required|numeric|min:0',
            'prices.24' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'results.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $product->update($request->except(['photos', 'results']));

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('galleries', 'public');
                ProductGallery::create([
                    'produk_id' => $product->id_produk,
                    'foto' => $path
                ]);
            }
        }

        if ($request->hasFile('results')) {
            foreach ($request->file('results') as $result) {
                $path = $result->store('results', 'public');
                ProductResult::create([
                    'produk_id' => $product->id_produk,
                    'foto' => $path
                ]);
            }
        }

        return redirect()->route('menu.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Hapus foto terkait dari storage
        foreach ($product->galleries as $gallery) {
            Storage::disk('public')->delete($gallery->foto);
        }
        
        $product->delete(); // On delete cascade will remove gallery records if set, but we delete the actual files above.

        return redirect()->route('menu.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function destroyPhoto($id)
    {
        $gallery = ProductGallery::findOrFail($id);
        
        // Hapus file fisik
        Storage::disk('public')->delete($gallery->foto);
        
        // Hapus record
        $gallery->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function destroyResult($id)
    {
        $result = ProductResult::findOrFail($id);
        
        Storage::disk('public')->delete($result->foto);
        $result->delete();

        return back()->with('success', 'Hasil jepretan berhasil dihapus.');
    }
}
