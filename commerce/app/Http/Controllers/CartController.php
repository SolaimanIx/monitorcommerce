<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    public function index()
    {
        if(Session::has('coupon')) {
            $this->calculateDiscount();
        }
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        Cart::instance('cart')->add(
            $request->id,
            $request->name,
            $request->quantity,
            $request->price
        )->associate('App\Models\Product');

        return redirect()->back();
    }

    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        if ($qty <= 99) {  // Adding a reasonable maximum quantity limit
            Cart::instance('cart')->update($rowId, $qty);
        }
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        if ($qty > 0) {
            Cart::instance('cart')->update($rowId, $qty);
        }
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if (isset($coupon_code)) {
            $coupon = Coupon::where('code', $coupon_code)->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', (float)str_replace(',', '', Cart::instance('cart')->subtotal()))->first();
            if (!$coupon) {
                Session::flash('coupon_message', ['type' => 'error', 'message' => 'Invalid coupon code!']);
                return redirect()->back();
            } else {
                Session::put('coupon', [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value
                ]);
                $this->calculateDiscount();
                Session::flash('coupon_message', ['type' => 'success', 'message' => 'Coupon code applied successfully!']);
                return redirect()->back();
            }
        } else {
            Session::flash('coupon_message', ['type' => 'error', 'message' => 'Please enter a coupon code!']);
            return redirect()->back();
        }
    }

    public function calculateDiscount()
    {
        if (Session::has('coupon')) {
            $subtotalWithoutFormatting = (float)str_replace(',', '', Cart::instance('cart')->subtotal());
            
            $discount = 0;
            if (Session::get('coupon')['type'] == 'fixed') {
                $discount = Session::get('coupon')['value'];
            } else {
                $discount = ($subtotalWithoutFormatting * Session::get('coupon')['value']) / 100;
            }
            
            $subtotalAfterDiscount = $subtotalWithoutFormatting - $discount;
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
            $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;
            
            Session::put('discount', [
                'discount' => number_format($discount, 2, '.', ','),
                'subtotal_after_discount' => number_format($subtotalAfterDiscount, 2, '.', ','),
                'tax_after_discount' => number_format($taxAfterDiscount, 2, '.', ','),
                'total_after_discount' => number_format($totalAfterDiscount, 2, '.', ',')
            ]);
        }
    }

    public function remove_coupon_code()
    {
        if (Session::has('coupon')) {
            Session::forget('coupon');
            Session::forget('discount');
            Session::flash('coupon_message', ['type' => 'success', 'message' => 'Coupon code removed successfully!']);
        }
        return redirect()->back();
    }
}
