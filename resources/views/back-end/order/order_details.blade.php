@extends('back-end.master')

@section('admin-title')
Order Details #{{ $order->order_number }}
@endsection

@push('admin-styles')
<style>
    .card {
        border-radius: 0;
        margin-bottom: 1rem;
    }
    .info-title {
        font-weight: 600;
        color: #6c757d;
        font-size: 14px;
    }
    .info-value {
        font-size: 14px;
    }
    .table th {
        background: #f8f9fa;
        font-weight: 600;
    }
    .badge {
        padding: 6px 12px;
    }
    .status-badge {
        font-size: 14px;
        padding: 8px 15px;
    }
</style>
@endpush

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Order Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Action Buttons -->
    <div class="row mb-3">
        <div class="col-12 text-right">
            <a href="{{ route('order.download-pdf', $order->id) }}" class="btn btn-primary">
                <i class="fas fa-download"></i> Download PDF
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-5 info-title">Order Number:</div>
                        <div class="col-7 info-value">{{ $order->order_number }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 info-title">Order Date:</div>
                        <div class="col-7 info-value">{{ $order->created_at->format('d M Y h:i A') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 info-title">Order Status:</div>
                        <div class="col-7">
                            <select class="form-control status-select" data-id="{{ $order->id }}">
                                <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 info-title">Payment Method:</div>
                        <div class="col-7 info-value">{{ strtoupper($order->payment_method) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 info-title">Payment Status:</div>
                        <div class="col-7">
                            <span class="badge badge-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-4 info-title">Name:</div>
                        <div class="col-8 info-value">{{ $order->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 info-title">Email:</div>
                        <div class="col-8 info-value">{{ $order->email }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 info-title">Phone:</div>
                        <div class="col-8 info-value">{{ $order->phone }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 info-title">Address:</div>
                        <div class="col-8 info-value">{{ $order->address }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 info-title">City:</div>
                        <div class="col-8 info-value">{{ $order->city }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 info-title">Postal Code:</div>
                        <div class="col-8 info-value">{{ $order->postal_code }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Order Items</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->product_name }}</td>
                            <td>
                                <img src="{{ asset('public/uploads/products/' . $item->product->product_image) }}" 
                                     alt="Product" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td>{{ $item->variant->color->name ?? 'N/A' }}</td>
                            <td>{{ $item->variant->size->name ?? 'N/A' }}</td>
                            <td>৳{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>৳{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-right"><strong>Subtotal:</strong></td>
                            <td>৳{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right"><strong>Shipping Charge:</strong></td>
                            <td>৳{{ number_format($order->shipping_charge, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right"><strong>Tax:</strong></td>
                            <td>৳{{ number_format($order->tax, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right"><strong>Total:</strong></td>
                            <td><strong>৳{{ number_format($order->total, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @if($order->order_notes)
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Order Notes</h5>
        </div>
        <div class="card-body">
            {{ $order->order_notes }}
        </div>
    </div>
    @endif
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
});
</script>
@endpush