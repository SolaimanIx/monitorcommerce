<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
  public function index()
  {
    $items = Cart::instance('wishlist')->content();
    return view('wishlist', compact('items'));
  }
  
  public function add_to_wishlist(Request $request)
  {
    // Check if item is already in cart
    $duplicatesInCart = Cart::instance('cart')->search(function ($cartItem, $rowId) use ($request) {
        return $cartItem->id === $request->id;
    });
    
    if ($duplicatesInCart->isNotEmpty()) {
        return redirect()->back()->with('error', 'This product is already in your cart!');
    }
    
    // Check if item is already in wishlist
    $duplicatesInWishlist = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($request) {
        return $cartItem->id === $request->id;
    });
    
    if ($duplicatesInWishlist->isNotEmpty()) {
        return redirect()->back()->with('info', 'This product is already in your wishlist!');
    }
    
    Cart::instance('wishlist')->add($request->id, $request->name, $request->quantity, $request->price)
        ->associate('App\Models\Product');
        
    return redirect()->back()->with('success', 'Product added to wishlist successfully!');
  }

  public function remove_from_wishlist(Request $request)
  {
    $rowId = $request->rowId;
    Cart::instance('wishlist')->remove($rowId);
    return redirect()->back()->with('success', 'Item removed from wishlist successfully!');
  }
  
  public function move_to_cart(Request $request)
  {
    $rowId = $request->rowId;
    
    // Get the item from wishlist
    $item = Cart::instance('wishlist')->get($rowId);
    
    // Remove item from wishlist
    Cart::instance('wishlist')->remove($rowId);
    
    // Check if the item already exists in the cart
    $duplicates = Cart::instance('cart')->search(function ($cartItem, $rowId) use ($item) {
        return $cartItem->id === $item->id;
    });
    
    if ($duplicates->isNotEmpty()) {
        // Item exists in cart, increase quantity
        $cartItem = Cart::instance('cart')->get($duplicates->first());
        Cart::instance('cart')->update($duplicates->first(), $cartItem->qty + $item->qty);
    } else {
        // Add item to cart
        Cart::instance('cart')->add($item->id, $item->name, $item->qty, $item->price)
            ->associate('App\Models\Product');
    }
    
    return redirect()->route('cart.index')->with('success', 'Item moved to cart successfully!');
  }
}
