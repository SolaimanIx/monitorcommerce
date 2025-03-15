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
        // Get sorting parameters
        $selectedSort = $request->query('sort');
        $selectedCategory = $request->query('category');
        $selectedBrand = $request->query('filter_brand');
        $minPrice = (int)$request->query('min_price', Product::min('regular_price'));
        $maxPrice = (int)$request->query('max_price', Product::max('regular_price'));
        
        // Set default values if not provided
        $currentMinPrice = (int)$request->query('min_price', $minPrice);
        $currentMaxPrice = (int)$request->query('max_price', $maxPrice);
        
        // Get all categories and brands for filters
        $categories = Category::all();
        $brands = Brand::all();
        
        // Base query
        $query = Product::query();
        
        // Apply category filter if set
        if ($selectedCategory) {
            $category = Category::where('name', $selectedCategory)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        // Apply brand filter if set
        if ($selectedBrand) {
            $brand = Brand::where('name', $selectedBrand)->first();
            if ($brand) {
                $query->where('brand_id', $brand->id);
            }
        }
        
        // Apply price range filter if set
        if ($request->has('min_price') || $request->has('max_price')) {
            $query->where(function($q) use ($currentMinPrice, $currentMaxPrice) {
                $q->where('regular_price', '>=', $currentMinPrice)
                  ->where('regular_price', '<=', $currentMaxPrice);
            });
        }
        
        // Apply sorting
        switch ($selectedSort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $query->orderBy('regular_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('regular_price', 'desc');
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
        
        // Paginate results
        $products = $query->paginate(12);
        $size = 12;
        $order = -1;
        
        return view('shop', compact(
            'products', 
            'categories', 
            'brands', 
            'selectedSort',
            'selectedCategory',
            'selectedBrand',
            'minPrice',
            'maxPrice',
            'currentMinPrice',
            'currentMaxPrice',
            'size',
            'order'
        ));
    }

    public function product_details($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->get()->take(8);
        return view('details', compact('product','rproducts'));
    }
}
