@extends('frontend.master.master')
@section('keyTitle','Order successfull')
@section('contents')
<div class="container py-5">
    <div class="text-center mb-4">
        <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
        <h2>Thank you for your order!</h2>
        <p>Your order number is: <strong>{{ $order->order_number }}</strong></p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Details</h5>
                    
                    <!-- Order Items -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Variant</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->product_name }}</td>
                                    <td>
                                        @if($item->variant_color || $item->variant_size)
                                            {{ $item->variant_color }} / {{ $item->variant_size }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end">৳{{ number_format($item->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end">Subtotal:</td>
                                    <td class="text-end">৳{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Shipping:</td>
                                    <td class="text-end">৳{{ number_format($order->shipping_charge, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Tax:</td>
                                    <td class="text-end">৳{{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td class="text-end"><strong>৳{{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Shipping Information -->
                    <div class="mt-4">
                        <h6>Shipping Information</h6>
                        <p class="mb-1">{{ $order->name }}</p>
                        <p class="mb-1">{{ $order->address }}</p>
                        <p class="mb-1">{{ $order->city }}, {{ $order->postal_code }}</p>
                        <p class="mb-1">Phone: {{ $order->phone }}</p>
                        <p>Email: {{ $order->email }}</p>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection