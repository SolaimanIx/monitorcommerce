<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        
        // Get actual min and max prices from the database
        $priceStats = DB::select("
            SELECT 
                COALESCE(MIN(CASE WHEN sale_price > 0 THEN sale_price ELSE regular_price END), 0) as min_price,
                COALESCE(MAX(CASE WHEN sale_price > 0 THEN sale_price ELSE regular_price END), 1000) as max_price
            FROM products
        ");
        
        $minPrice = max(1, floor($priceStats[0]->min_price));
        $maxPrice = ceil($priceStats[0]->max_price);
        
        // Use requested price values if provided, otherwise use actual min/max from database
        $currentMinPrice = $request->filled('min_price') ? $request->input('min_price') : $minPrice;
        $currentMaxPrice = $request->filled('max_price') ? $request->input('max_price') : $maxPrice;
        
        // Filter by price range if either min_price or max_price is provided
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->where(function($q) use ($currentMinPrice, $currentMaxPrice) {
                $q->where(function($inner) use ($currentMinPrice, $currentMaxPrice) {
                    $inner->where('sale_price', '>', 0)
                        ->where('sale_price', '>=', $currentMinPrice)
                        ->where('sale_price', '<=', $currentMaxPrice);
                })->orWhere(function($inner) use ($currentMinPrice, $currentMaxPrice) {
                    $inner->where(function($deepInner) {
                        $deepInner->where('sale_price', 0)->orWhereNull('sale_price');
                    })
                    ->where('regular_price', '>=', $currentMinPrice)
                    ->where('regular_price', '<=', $currentMaxPrice);
                });
            });
        }
        
        // Sort products based on the 'sort' parameter
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'price_low':
                    $query->orderBy(DB::raw('COALESCE(NULLIF(sale_price, 0), regular_price)'), 'asc');
                    break;
                case 'price_high':
                    $query->orderBy(DB::raw('COALESCE(NULLIF(sale_price, 0), regular_price)'), 'desc');
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
        
        $products = $query->paginate(12)->appends($request->except('page'));
        
        // Get categories for the filter sidebar
        $categories = Category::select('name')->distinct()->get();
        
        // Get brands for the brand filter
        $brands = Brand::select('name')->distinct()->get();
        
        // Pass the selected category and brand to the view
        $selectedCategory = $request->category ?? $request->brand ?? null;
        $selectedBrand = $request->filter_brand ?? null;
        $selectedSort = $request->sort ?? null;
        
        return view('shop', compact('products', 'categories', 'brands', 'selectedCategory', 'selectedBrand', 
            'selectedSort', 'minPrice', 'maxPrice', 'currentMinPrice', 'currentMaxPrice'));
    }

    public function product_details($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->get()->take(8);
        return view('details', compact('product','rproducts'));
    }
}
