@extends('layouts.app')
@section('content')

<style>
    .pt-90 {
        padding-top: 90px !important;
    }

    .pr-6px {
        padding-right: 6px;
        text-transform: uppercase;
    }

    .my-account .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 40px;
        border-bottom: 1px solid;
        padding-bottom: 13px;
    }

    .my-account .wg-box {
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        padding: 24px;
        flex-direction: column;
        gap: 24px;
        border-radius: 12px;
        background: var(--White);
        box-shadow: 0px 4px 24px 2px rgba(20, 25, 38, 0.05);
    }

    .bg-success {
        background-color: #40c710 !important;
    }

    .bg-danger {
        background-color: #f44032 !important;
    }

    .bg-warning {
        background-color: #f5d700 !important;
        color: #000;
    }

    .table-transaction>tbody>tr:nth-of-type(odd) {
        --bs-table-accent-bg: #fff !important;

    }

    .table-transaction th,
    .table-transaction td {
        padding: 0.625rem 1.5rem .25rem !important;
        color: #000 !important;
    }

    .table> :not(caption)>tr>th {
        padding: 0.625rem 1.5rem .25rem !important;
        background-color: #6a6e51 !important;
    }

    .table-bordered>:not(caption)>*>* {
        border-width: inherit;
        line-height: 32px;
        font-size: 14px;
        border: 1px solid #e1e1e1;
        vertical-align: middle;
    }

    .table-striped .image {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        flex-shrink: 0;
        border-radius: 10px;
        overflow: hidden;
    }

    .table-striped td:nth-child(1) {
        min-width: 250px;
        padding-bottom: 7px;
    }

    .pname {
        display: flex;
        gap: 13px;
    }

    .table-bordered> :not(caption)>tr>th,
    .table-bordered> :not(caption)>tr>td {
        border-width: 1px 1px;
        border-color: #6a6e51;
    }

    .my-account {
        background: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .page-title {
        color: #2c3e50;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #edf2f7;
    }

    .wg-box {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        padding: 25px;
        margin-bottom: 25px;
    }

    .wg-box h5 {
        color: #2c3e50;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #edf2f7;
    }

    .table {
        --bs-table-bg: transparent;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
    }

    .table> :not(caption)>tr>th {
        padding: 16px 20px !important;
        background: linear-gradient(to right, #5D4037, #8D6E63) !important;
        color: #ffffff !important;
        font-weight: 500;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table>tbody>tr>td {
        padding: 16px 20px !important;
        color: #2c3e50;
        font-size: 14px;
        border-bottom: 1px solid #edf2f7;
    }

    .table>tbody>tr:hover {
        background-color: #f8fafc;
    }

    .badge {
        padding: 6px 12px;
        font-weight: 500;
        border-radius: 6px;
        font-size: 12px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .bg-success {
        background: linear-gradient(45deg, #28a745, #34d058) !important;
    }

    .bg-danger {
        background: linear-gradient(45deg, #dc3545, #ff4d4d) !important;
    }

    .bg-warning {
        background: linear-gradient(45deg, #ffc107, #ffdb4d) !important;
    }

    .bg-secondary {
        background: linear-gradient(45deg, #6c757d, #868e96) !important;
    }

    .shipping-address {
        background: #f8fafc;
        padding: 20px;
        border-radius: 6px;
        font-size: 14px;
        line-height: 1.6;
    }

    .pname {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .pname .image {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        overflow: hidden;
    }

    .pname .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pname .name a {
        color: #2c3e50;
        text-decoration: none;
        font-weight: 500;
    }

    .pname .name a:hover {
        color: #795548;
    }

    .btn-primary {
        background: linear-gradient(to right, #5D4037, #8D6E63);
        border: none;
        padding: 8px 20px;
        color: #fff;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background: linear-gradient(to right, #4E342E, #795548);
    }
</style>

<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Order Details</h2>
        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
            </div>

            <div class="col-lg-10">
                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="wg-filter flex-grow">
                            <h5>Order Information</h5>
                        </div>
                        <a href="{{ route('user.orders') }}" class="btn btn-primary">Back to Orders</a>
                    </div>
                    @if($order->status == 'delivered')
                    <span class="badge bg-success">Delivered</span>
                    @elseif($order->status == 'canceled')
                    <span class="badge bg-danger">Canceled</span>
                    @else
                    <span class="badge bg-warning">Ordered</span>
                    @endif
                    <div class="table-responsive">
                        @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                        @endif
                        <table class="table table-bordered table-transaction table-striped">
                            <tr>
                                <th>Order No</th>
                                <td>{{$order->id}}</td>
                                <th>Order Status</th>
                                <td>
                                    @if($order->status == 'delivered')
                                    <span class="badge bg-success">Delivered</span>
                                    @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger">Canceled</span>
                                    @else
                                    <span class="badge bg-warning">Ordered</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{$order->phone}}</td>
                                <th>Zip Code</th>
                                <td>{{$order->zip}}</td>
                            </tr>
                            <tr>
                                <th>Order Date</th>
                                <td>{{$order->created_at}}</td>
                                <th>Delivered Date</th>
                                <td>{{$order->delivered_date ?? 'Pending'}}</td>
                            </tr>
                            <tr>
                                <th>Canceled Date</th>
                                <td colspan="3">{{$order->canceled_date ?? 'N/A'}}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="wg-box">
                    <h5>Ordered Items</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">SKU</th>
                                    <th class="text-center">Return Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $item)
                                <tr>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/products/thumbnails/') }}/{{$item->product->image}}" alt="{{$item->product->name}}">
                                        </div>
                                        <div class="name">
                                            <a href="{{ route('shop.product.details', [$item->product->slug]) }}">{{$item->product->name}}</a>
                                        </div>
                                    </td>
                                    <td class="text-center">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-center">{{$item->quantity}}</td>
                                    <td class="text-center">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    <td class="text-center">{{$item->product->category->name}}</td>
                                    <td class="text-center">{{$item->product->brand->name}}</td>
                                    <td class="text-center">{{$item->product->SKU}}</td>
                                    <td class="text-center">
                                        @if($item->return_status == 'returned')
                                        <span class="badge bg-success">Returned</span>
                                        @elseif($item->return_status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @else
                                        <span class="badge bg-danger">Not Returned</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="wg-box">
                            <h5>Shipping Address</h5>
                            <div class="shipping-address">
                                <p class="mb-1"><strong>{{$order->name}}</strong></p>
                                <p class="mb-1">{{$order->address}}</p>
                                <p class="mb-1">{{$order->locality}}</p>
                                <p class="mb-1">{{$order->city}}, {{$order->country}}</p>
                                @if($order->landmark)
                                <p class="mb-1">{{$order->landmark}}</p>
                                @endif
                                <p class="mb-1">{{$order->zip}}</p>
                                <p class="mb-0">Phone: {{$order->phone}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="wg-box">
                            <h5>Order Summary</h5>
                            <table class="table">
                                <tr>
                                    <td><strong>Subtotal</strong></td>
                                    <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tax</strong></td>
                                    <td class="text-end">${{ number_format($order->tax, 2) }}</td>
                                </tr>
                                @if($order->discount > 0)
                                <tr>
                                    <td><strong>Discount</strong></td>
                                    <td class="text-end">-${{ number_format($order->discount, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td class="text-end"><strong>${{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                                @if($transaction)
                                <tr>
                                    <td><strong>Payment Method</strong></td>
                                    <td class="text-end">{{$transaction->mode}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Status</strong></td>
                                    <td class="text-end">
                                        @if($transaction->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                        @elseif($transaction->status == 'declined')
                                        <span class="badge bg-danger">Declined</span>
                                        @elseif($transaction->status == 'refunded')
                                        <span class="badge bg-secondary">Refunded</span>
                                        @else
                                        <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                <div class="wg-box mt-5 text-right">
                    @if($order->status == 'ordered')
                    <form action="{{ route('user.order.cancel') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="order_id" value="{{$order->id}}" />
                        <button type="button" class="btn btn-danger cancel-order">Cancel Order</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    $(function() {
        $('.cancel-order').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Are you sure?",
                text: "You want to cancel this order?",
                type: "warning",
                buttons: ["No", "Yes"],
                confirmButtonColor: '#dc3545'
            }).then(function(result) {
                if (result) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush