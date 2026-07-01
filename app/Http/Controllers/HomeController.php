<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\RentalService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected RentalService $rentalService;

    public function __construct(RentalService $rentalService)
    {
        $this->rentalService = $rentalService;
    }

    /**
     * Display the camera catalog with filters.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        
        $query = Product::with(['category', 'galleries']);

        // Filter by category slug
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search by product name
        if ($request->filled('search')) {
            $query->where('produk_name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();

        // Calculate real-time available units for each product (current moment snapshot)
        $now = Carbon::now();
        foreach ($products as $product) {
            $product->available_units = $this->rentalService->getAvailableUnits(
                $product->id_produk,
                $now,
                $now->copy()->addMinutes(1) // Check availability at this exact moment
            );
        }

        return view('home', compact('products', 'categories'));
    }

    /**
     * Display the details of a specific camera.
     */
    public function show($id)
    {
        $product = Product::with(['category', 'galleries', 'results'])->findOrFail($id);

        // Calculate real-time available units
        $now = Carbon::now();
        $product->available_units = $this->rentalService->getAvailableUnits(
            $product->id_produk,
            $now,
            $now->copy()->addMinutes(1)
        );
        
        // Fetch related products (in same category, excluding current product)
        $relatedProducts = Product::with(['category', 'galleries'])
            ->where('category_id', $product->category_id)
            ->where('id_produk', '!=', $product->id_produk)
            ->limit(3)
            ->get();

        return view('pelanggan.product-detail', compact('product', 'relatedProducts'));
    }
}
