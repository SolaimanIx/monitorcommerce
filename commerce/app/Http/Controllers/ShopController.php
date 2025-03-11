<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request){
        $query = Product::query();

        if ($request->has('brand')) {
            // Use the category name for filtering instead of brand
            $categoryId = Category::where('name', $request->brand)->pluck('id');
            $query->whereIn('category_id', $categoryId);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Use categories as "brands" since there's no brand column
        $brands = Category::select('name')->distinct()->get();
        
        return view('shop', compact('products', 'brands'));
    }

    public function product_details($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->get()->take(8);
        return view('details', compact('product','rproducts'));
    }
}
