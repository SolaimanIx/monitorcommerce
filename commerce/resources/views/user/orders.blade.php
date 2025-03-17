@extends('layouts.app')
@section('content')

<style>
    .my-account {
        background: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .page-title {
        color: #2c3e50;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #edf2f7;
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
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table>tbody>tr>td {
        padding: 16px 20px !important;
        color: #2c3e50;
        font-size: 14px;
        border: none;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
    }

    .table>tbody>tr:hover {
        background-color: #f8fafc;
        transition: all 0.3s ease;
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
        color: #fff !important;
    }

    .bg-danger {
        background: linear-gradient(45deg, #dc3545, #ff4d4d) !important;
        color: #fff !important;
    }

    .bg-warning {
        background: linear-gradient(45deg, #ffc107, #ffdb4d) !important;
        color: #000 !important;
    }

    .view-icon {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #edf2f7;
        border-radius: 8px;
        color: #2c3e50;
        transition: all 0.3s ease;
    }

    .view-icon:hover {
        background: #795548;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .wg-pagination {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #edf2f7;
    }

    .table-responsive {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
</style>
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Orders</h2>
        <div class="row">
            <div class="col-lg-2">

                @include('user.account-nav')
            </div>

            <div class="col-lg-10">
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 80px">OrderNo</th>
                                    <th>Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Tax</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-center">Delivered On</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->id }}</td>
                                    <td class="text-center">{{ $order->name }}</td>
                                    <td class="text-center">{{ $order->phone }}</td>
                                    <td class="text-center">${{ number_format($order->subtotal, 2) }}</td>
                                    <td class="text-center">${{ number_format($order->tax, 2) }}</td>
                                    <td class="text-center">${{ number_format($order->total, 2) }}</td>
                                    <td class="text-center">
                                        @if ($order->status == 'delivered')
                                        <span class="badge bg-success">Delivered</span>
                                        @elseif ($order->status == 'canceled')
                                        <span class="badge bg-danger">Canceled</span>
                                        @else
                                        <span class="badge bg-warning">Ordered</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $order->created_at }}</td>
                                    <td class="text-center">{{ $order->orderItems->count() }}</td>
                                    <td class="text-center">{{ $order->delivered_date ?? '' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('user.order.details', $order->id) }}">
                                            <div class="list-icon-function view-icon">
                                                <div class="item eye">
                                                    <i class="fa fa-eye"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $orders->links('pagination::bootstrap-5') }}

                </div>
            </div>

        </div>
    </section>
</main>
@endsection