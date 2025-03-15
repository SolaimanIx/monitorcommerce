@extends('layouts.app')

@section('styles')
<style>
    /* Apply button specific styling to prevent size changes when clicked */
    .coupon-btn {
        position: absolute !important;
        top: 0 !important;
        right: 0 !important;
        height: 100% !important;
        padding-left: 1rem !important;
        padding-right: 1rem !important;
        background: transparent !important;
        border: none !important;
        color: #007bff !important;
        font-weight: 500 !important;
        font-size: 14px !important;
        text-transform: uppercase !important;
        cursor: pointer !important;
        outline: none !important;
        box-shadow: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: none !important;
        text-decoration: none !important;
    }
    
    /* Handle all states explicitly to prevent size changes */
    .coupon-btn:hover,
    .coupon-btn:active,
    .coupon-btn:focus,
    .coupon-btn:visited {
        outline: none !important;
        box-shadow: none !important;
        color: #0056b3 !important;
        background: transparent !important;
        border: none !important;
        text-decoration: none !important;
    }
</style>
@endsection

@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Cart</h2>
        <div class="checkout-steps">
            <a href="javascript.void(0)" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>
            <a href="javascript.void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>
            <a href="javascript.void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Review And Submit Your Order</em>
                </span>
            </a>
        </div>
        <div class="shopping-cart">
            @if($items->count() > 0)
            <div class="cart-table__wrapper">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th></th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>
                                <div class="shopping-cart__product-item">
                                    <img loading="lazy" src="{{ asset('uploads/products/thumbnails')}}/{{$item->model->image}}" width="120" height="120" alt="{{ $item->name }}" />
                                </div>
                            </td>
                            <td>
                                <div class="shopping-cart__product-item__detail">
                                    <h4>{{ $item->name }}</h4>
                                    <ul class="shopping-cart__product-item__options">
                                        <li>Color: Yellow</li>
                                        <li>Size: L</li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__product-price">${{ $item->price }}</span>
                            </td>
                            <td>
                                <div class="qty-control position-relative">
                                    <input type="number" name="quantity" value="{{ $item->qty }}" min="1" max="99" readonly class="qty-control__number text-center">
                                    <form method="POST" action="{{ route('cart.qty.decrease', ['rowId'=>$item->rowId]) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="qty-control__reduce" style="border:none;background:none">-</button>
                                    </form>
                                    <form method="POST" action="{{ route('cart.qty.increase', ['rowId'=>$item->rowId]) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="qty-control__increase" style="border:none;background:none">+</button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__subtotal">${{ number_format($item->price * $item->qty, 2) }}</span>
                            </td>
                            <td>
                                <form method="POST" action="{{route('cart.item.remove',['rowId'=>$item->rowId])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-cart" style="background:none;border:none">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                            <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                        </svg>
                                        </a>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="cart-table-footer">

                @if(Session::has('coupon'))
                    <div class="d-flex align-items-center">
                        <span class="mr-2">Applied Coupon: <strong>{{ Session::get('coupon')['code'] }}</strong></span>
                        <form action="{{route('cart.coupon.remove')}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="coupon-btn">REMOVE COUPON</button>
                        </form>
                    </div>
                    @if(Session::has('coupon_message'))
                        <div class="mt-2 alert alert-{{ Session::get('coupon_message')['type'] == 'success' ? 'success' : 'danger' }}">
                            {{ Session::get('coupon_message')['message'] }}
                        </div>
                    @endif
                @else
                    <form action="{{route('cart.coupon.apply')}}" method="POST" class="position-relative bg-body">
                        @csrf
                        <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                        <input class="coupon-btn" type="submit" value="APPLY COUPON">
                        @if(Session::has('coupon_message'))
                            <div class="mt-2 alert alert-{{ Session::get('coupon_message')['type'] == 'success' ? 'success' : 'danger' }}">
                                {{ Session::get('coupon_message')['message'] }}
                            </div>
                        @endif
                    </form>
                @endif
                    <form method="POST" action="{{route('cart.empty')}}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-light" type="submit">Clear Cart</button>
                    </form>
                </div>
            </div>
            <div>
                <div class="shopping-cart__totals-wrapper">
                    <div class="sticky-content">
                        <div class="shopping-cart__totals">
                            <h3>Cart Totals</h3>
                            <table class="cart-totals">
                                <tbody>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td>${{ number_format((float)str_replace(',', '', Cart::instance('cart')->subtotal()), 2) }}</td>
                                    </tr>
                                    @if(Session::has('discount'))
                                    <tr>
                                        <th>Discount ({{ Session::get('coupon')['code'] }})</th>
                                        <td>-${{ Session::get('discount')['discount'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Subtotal after Discount</th>
                                        <td>${{ Session::get('discount')['subtotal_after_discount'] }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Shipping</th>
                                        <td>Free</td>
                                    </tr>
                                    <tr>
                                        <th>VAT</th>
                                        <td>
                                            @if(Session::has('discount'))
                                                ${{ Session::get('discount')['tax_after_discount'] }}
                                            @else
                                                ${{ number_format((float)str_replace(',', '', Cart::instance('cart')->tax()), 2) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td>
                                            @if(Session::has('discount'))
                                                ${{ Session::get('discount')['total_after_discount'] }}
                                            @else
                                                ${{ number_format((float)str_replace(',', '', Cart::instance('cart')->total()), 2) }}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mobile_fixed-btn_wrapper">
                            <div class="button-wrapper container">
                                <a href="checkout.html" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-md-12 text-center pt-5 bp-5">
                        <p>No item found in your cart</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-info">Shop Now</a>
                    </div>
                </div>
                @endif
            </div>
    </section>
</main>

@endsection

@push('scripts')

<script>
    $(function() {
        $(".qty-control__increase").on("click", function() {
            $(this).closest("form").submit();
        });

        $(".qty-control__reduce").on("click", function() {
            $(this).closest("form").submit();
        });

        $(".remove-cart").on("click", function() {
            $(this).closest("form").submit();
        });
    });
</script>
@endpush