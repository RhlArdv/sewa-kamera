<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id_kategori', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_name' => 'required|string|max:255|unique:tb_categories,kategori_name',
        ]);

        Category::create([
            'kategori_name' => $request->kategori_name,
            'slug' => Str::slug($request->kategori_name),
        ]);

        return redirect()->route('menu.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'kategori_name' => 'required|string|max:255|unique:tb_categories,kategori_name,' . $id . ',id_kategori',
        ]);

        $category->update([
            'kategori_name' => $request->kategori_name,
            'slug' => Str::slug($request->kategori_name),
        ]);

        return redirect()->route('menu.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('menu.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
