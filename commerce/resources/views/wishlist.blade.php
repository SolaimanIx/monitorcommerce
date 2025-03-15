@extends('layouts.app')
@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Wishlist</h2>

      <div class="shopping-cart">
        <div class="cart-table__wrapper">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Product</th>
                <th></th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($items) > 0)
                @foreach($items as $item)
                  <tr>
                    <td>
                      <div class="shopping-cart__product-item">
                        <img loading="lazy" src="{{ asset('uploads/products/thumbnails/' . $item->model->image) }}" width="120" height="120" alt="{{ $item->model->name }}" />
                      </div>
                    </td>
                    <td>
                      <div class="shopping-cart__product-item__detail">
                        <h4>{{ $item->model->name }}</h4>
                        @if($item->options->count() > 0)
                          <ul class="shopping-cart__product-item__options">
                            @foreach($item->options as $key => $value)
                              <li>{{ ucfirst($key) }}: {{ $value }}</li>
                            @endforeach
                          </ul>
                        @endif
                      </div>
                    </td>
                    <td>
                      <span class="shopping-cart__product-price">${{ $item->price }}</span>
                    </td>
                    <td>
                      <div class="qty-control position-relative">
                        <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center" readonly>
                      </div><!-- .qty-control -->
                    </td>
                    <td>
                      <span class="shopping-cart__subtotal">${{ $item->price }}</span>
                    </td>
                    <td>
                      <div class="d-flex align-items-center wishlist-actions">
                        <form action="{{ route('wishlist.moveToCart') }}" method="post" class="me-2">
                          @csrf
                          <input type="hidden" name="rowId" value="{{ $item->rowId }}">
                          <button type="submit" class="btn btn-sm btn-primary move-to-cart-btn" title="Move to Cart">
                            <i class="fa fa-shopping-cart"></i> Cart
                          </button>
                        </form>
                        <form action="{{ route('wishlist.remove') }}" method="post">
                          @csrf
                          <input type="hidden" name="rowId" value="{{ $item->rowId }}">
                          <button type="submit" class="remove-cart-btn" title="Remove item">
                            <svg width="16" height="16" viewBox="0 0 10 10" fill="#ffffff" xmlns="http://www.w3.org/2000/svg">
                              <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                              <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                            </svg>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="6" class="text-center py-4">Your wishlist is empty</td>
                </tr>
              @endif
            </tbody>
          </table>
          
          <style>
            .wishlist-actions {
              display: flex;
              align-items: center;
            }
            .move-to-cart-btn {
              background-color: #4a6cf7;
              border-color: #4a6cf7;
              border-radius: 4px;
              color: #fff;
              padding: 0.375rem 0.75rem;
              transition: all 0.3s ease;
            }
            .move-to-cart-btn:hover {
              background-color: #3a5bd9;
              border-color: #3a5bd9;
              transform: translateY(-2px);
              box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            .remove-cart-btn {
              display: flex;
              align-items: center;
              justify-content: center;
              width: 30px;
              height: 30px;
              border-radius: 50%;
              background-color: #ff5252;
              border: none;
              transition: all 0.3s ease;
            }
            .remove-cart-btn:hover {
              background-color: #ff1a1a;
              transform: rotate(90deg);
              box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
          </style>
          
          @if(count($items) > 0)
            <div class="cart-table-footer">
              <div class="d-flex justify-content-end">
                <a href="{{ route('shop.index') }}" class="btn btn-light me-2">CONTINUE SHOPPING</a>
                <a href="{{ route('cart.index') }}" class="btn btn-primary">VIEW CART</a>
              </div>
            </div>
          @else
            <div class="cart-table-footer">
              <div class="d-flex justify-content-center">
                <a href="{{ route('shop.index') }}" class="btn btn-primary">CONTINUE SHOPPING</a>
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>
  </main>

@endsection