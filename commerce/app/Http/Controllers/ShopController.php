<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request){
        $query = Product::query();

        // Filter by category if 'brand' parameter is provided (keeping old name for backward compatibility)
        if ($request->has('brand')) {
            $categoryId = Category::where('name', $request->brand)->pluck('id');
            $query->whereIn('category_id', $categoryId);
        }
        
        // Filter by category if 'category' parameter is provided
        if ($request->has('category')) {
            $categoryId = Category::where('name', $request->category)->pluck('id');
            $query->whereIn('category_id', $categoryId);
        }
        
        // Filter by brand if 'filter_brand' parameter is provided
        if ($request->has('filter_brand')) {
            $brandId = Brand::where('name', $request->filter_brand)->pluck('id');
            $query->whereIn('brand_id', $brandId);
        }
        
        // Sort products based on the 'sort' parameter
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'price_low':
                    $query->orderBy('sale_price', 'asc')
                          ->orderBy('regular_price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('sale_price', 'desc')
                          ->orderBy('regular_price', 'desc');
                    break;
                case 'name_az':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_za':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default sorting
            $query->orderBy('created_at', 'desc');
        }
        
        $products = $query->paginate(12);
        
        // Get categories for the filter sidebar
        $categories = Category::select('name')->distinct()->get();
        
        // Get brands for the brand filter
        $brands = Brand::select('name')->distinct()->get();
        
        // Pass the selected category and brand to the view
        $selectedCategory = $request->category ?? $request->brand ?? null;
        $selectedBrand = $request->filter_brand ?? null;
        $selectedSort = $request->sort ?? null;
        
        return view('shop', compact('products', 'categories', 'brands', 'selectedCategory', 'selectedBrand', 'selectedSort'));
    }

    public function product_details($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->get()->take(8);
        return view('details', compact('product','rproducts'));
    }
}
