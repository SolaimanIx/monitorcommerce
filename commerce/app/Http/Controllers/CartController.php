<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Address;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


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
        Session::forget(['coupon', 'discount']);
        Session::flash('coupon_message', ['type' => 'success', 'message' => 'Coupon code removed successfully!']);
        return redirect()->back();
    }


    public function checkout()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
    return view('checkout', compact('address'));
}


public function place_an_order(Request $request)
{
    $user_id = Auth::user()->id;
    $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

    if (!$address) {
        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|numeric|digits:10',
            'zip' => 'required|numeric|digits:6',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'locality' => 'required',
            'landmark' => 'required',
        ]);

        $address = new Address();
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->country = 'India';
        $address->user_id = $user_id;
        $address->isdefault = true;
        $address->save();
    }

    $this->setAmountForCheckout();

    $order = new Order();
    $order->user_id = $user_id;
    // Clean numeric values by removing commas
    $order->subtotal = (float)str_replace(',', '', Session::get('checkout')['subtotal']);
    $order->discount = (float)str_replace(',', '', Session::get('checkout')['discount']);
    $order->tax = (float)str_replace(',', '', Session::get('checkout')['tax']);
    $order->total = (float)str_replace(',', '', Session::get('checkout')['total']);
    $order->name = $address->name;
    $order->phone = $address->phone;
    $order->locality = $address->locality;
    $order->address = $address->address;
    $order->city = $address->city;
    $order->state = $address->state;
    $order->country = $address->country;
    $order->landmark = $address->landmark;
    $order->zip = $address->zip;
    $order->save();

    foreach (Cart::instance('cart')->content() as $item) {
        $orderItem = new OrderItem();
        $orderItem->product_id = $item->id;
        $orderItem->order_id = $order->id;
        $orderItem->price = $item->price;
        $orderItem->quantity = $item->qty;
        $orderItem->save();
    }

    // transaction for cod mode
    if ($request->mode == 'cod') {
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->order_id = $order->id;
        $transaction->mode = $request->mode;
        $transaction->status = "pending";
        $transaction->save();
    }

    Cart::instance('cart')->destroy();
    Session::forget('checkout');
    Session::forget('coupon');
    Session::forget('discounts');
    Session::put('order_id', $order->id);
    return redirect()->route('cart.order.confirmation', compact('order'));
}



public function setAmountForCheckout()
{
    if (!Cart::instance('cart')->content()->count() > 0) {
        Session::forget('checkout');
        return;
    }

    if (Session::has('coupon')) {
        Session::put('checkout', [
            'discount' => Session::get('discount')['discount'],
            'subtotal' => Cart::instance('cart')->subtotal(),
            'tax' => Session::get('discount')['tax_after_discount'],
            'total' => Session::get('discount')['total_after_discount']
        ]);
    } else {
        Session::put('checkout', [
            'discount' => 0,
            'subtotal' => Cart::instance('cart')->subtotal(),
            'tax' => Cart::instance('cart')->tax(),
            'total' => Cart::instance('cart')->total()
        ]);
    }
}

public function order_confirmation()
{
    if (Session::has('order_id')) {
        $order = Order::find(Session::get('order_id'));
        return view('order-confirmation', compact('order'));
    }
    return redirect()->route('cart.index');

}

}
