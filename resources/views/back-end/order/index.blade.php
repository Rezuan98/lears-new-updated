@extends('back-end.master')

@section('admin-title')
Manage Orders
@endsection

@push('admin-styles')
<style>
    .card {
        border-radius: 0;
    }
    .table thead tr th {
        background: #f5f5f5;
    }
    .table thead tr th, .table thead tr td {
        font-size: 14px;
    }
    label {
        display: inline-block;
        margin-bottom: .5rem;
        font-size: 14px;
    }
    h4.card-title {
        font-size: 18px!important;
    }
    .badge {
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 4px;
    }
</style>
@endpush

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Orders</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Manage Orders</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="zero_config" class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>
                       <th>Order Number</th> 
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $key => $order)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                      <td>{{ $order->order_number }}</td> 
                        <td>
                            {{ $order->name }}<br>
                            <small>{{ $order->phone }}</small>
                        </td>
                        <td>{{ $order->items->count() }}</td>
                        <td>৳{{ number_format($order->total, 2) }}</td>
                        <td>{{ strtoupper($order->payment_method) }}</td>
                        <td>
                            <select class="form-control payment-status-select" 
                                    data-id="{{ $order->id }}" 
                                    style="width: 140px; margin: auto;">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </td>
                        
                        <td>
                            <select class="form-control status-select" 
                                    data-id="{{ $order->id }}" 
                                    style="width: 140px; margin: auto;">
                                <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <button title="Action" class="btn without-focus border-0 px-1 py-0 mr-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="{{ route('order.details',$order->id) }}">
                                    <i class="fa fa-eye"></i> View Details
                                </a>
                                <a class="dropdown-item" href="{{ route('order.download-pdf',$order->id) }}">
                                    <i class="fa fa-file-pdf"></i> Invoice
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('admin-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.status-select').on('change', function() {
        const orderId = $(this).data('id');
        const status = $(this).val();
        
        $.ajax({
            url: "{{ route('order.updateStatus') }}",
            type: 'POST',
            data: {
                id: orderId,
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    toastr.success('Order status updated successfully!');
                } else {
                    toastr.error('Failed to update status!');
                }
            },
            error: function() {
                toastr.error('Something went wrong!');
                $(this).val($(this).data('original-status'));
            }
        });
    });


    $('.payment-status-select').on('change', function() {
        const orderId = $(this).data('id');
        const paymentStatus = $(this).val();
        
        $.ajax({
            url: "{{ route('order.updatePaymentStatus') }}", // Create this route
            type: 'POST',
            data: {
                id: orderId,
                payment_status: paymentStatus,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    toastr.success('Payment status updated successfully!');
                } else {
                    toastr.error('Failed to update payment status!');
                }
            },
            error: function() {
                toastr.error('Something went wrong!');
            }
        });
    });
});




</script>
@endpush