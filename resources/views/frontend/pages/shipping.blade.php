@extends('frontend.master.master')
@section('keyTitle','Shipping Details')
@section('contents')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            @if(!Auth::check())
            <div class="alert alert-info mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Already have an account?</span>
                    <a href="{{ route('user.login') }}" class="btn btn-sm btn-primary">Login</a>
                </div>
            </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4">Shipping Information</h3>
                    
                    <form action="{{ route('store.order') }}" method="POST" id="shippingForm">
                        @csrf
                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label required">Full Name</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" 
                                       value="{{ Auth::check() ? Auth::user()->name : old('name') }}"
                                       {{ Auth::check() ? 'readonly' : '' }}>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label required">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ Auth::check() ? Auth::user()->email : old('email') }}"
                                       {{ Auth::check() ? 'readonly' : '' }}>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label required">Phone</label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       name="phone" 
                                       value="{{ Auth::check() ? Auth::user()->phone : old('phone') }}"
                                       {{ Auth::check() ? 'readonly' : '' }}>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City/Delivery Area -->
                            <div class="col-md-6">
                                <label class="form-label required">Delivery Area</label>
                                <select class="form-select @error('city') is-invalid @enderror" 
                                        name="city" 
                                        id="deliveryLocation">
                                    <option value="inside" {{ old('city') == 'inside' ? 'selected' : '' }}>Inside Dhaka (৳50)</option>
                                    <option value="outside" {{ old('city') == 'outside' ? 'selected' : '' }}>Outside Dhaka (৳110)</option>
                                </select>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-12">
                                <label class="form-label required">Delivery Address</label>
                                <input type="text" 
                                       class="form-control @error('address') is-invalid @enderror" 
                                       name="address" 
                                       value="{{ Auth::check() ? Auth::user()->address : old('address') }}"
                                       placeholder="House no, Road no, Area">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="col-md-6">
                                <label class="form-label required">Postal Code</label>
                                <input type="text" 
                                       class="form-control @error('postal_code') is-invalid @enderror" 
                                       name="postal_code" 
                                       value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div class="col-12 mt-4">
                                <h5 class="mb-3">Select Payment Method</h5>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="payment-method-card">
                                            <input type="radio" 
                                                   class="btn-check @error('payment_method') is-invalid @enderror" 
                                                   name="payment_method" 
                                                   id="cod" 
                                                   value="cod" 
                                                   checked>
                                            <label class="btn btn-outline-secondary w-100 h-100" for="cod">
                                                <img src="{{ asset('/public/frontend/images/cod.jpg') }}" 
                                                     alt="Cash on Delivery" 
                                                     class="payment-icon">
                                                <span class="d-block mt-2">Cash on Delivery</span>
                                            </label>
                                        </div>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Order Notes -->
                            <div class="col-12">
                                <label class="form-label">Order Notes (Optional)</label>
                                <textarea class="form-control" 
                                          name="order_notes" 
                                          rows="3"
                                          placeholder="Special notes for delivery">{{ old('order_notes') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">Order Summary</h4>
                    
                    <!-- Cart Items -->
                    <div class="mb-4">
                        @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span>{{ $item->product->product_name }}</span>
                                    <small class="text-muted d-block">
                                        {{ $item->variant->color->name ?? 'N/A' }} / 
                                        {{ $item->variant->size->name ?? 'N/A' }}
                                    </small>
                                    <small class="text-muted">x {{ $item->quantity }}</small>
                                </div>
                                <span>৳{{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>৳{{ number_format($cartItems->sum(function($item) {
                                return $item->price * $item->quantity;
                            }), 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span id="shippingCost">৳50.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax (10%)</span>
                            <span>৳{{ number_format($cartItems->sum(function($item) {
                                return ($item->price * $item->quantity) * 0.1;
                            }), 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total</strong>
                            <strong id="orderTotal">৳{{ number_format(
                                $cartItems->sum(function($item) {
                                    return ($item->price * $item->quantity) * 1.1;
                                }) + 50, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('ecomcss')
<style>
    .card {
        border: none;
        border-radius: 10px;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .form-control[readonly] {
        background-color: #f8f9fa;
    }

    .required:after {
        content: '*';
        color: red;
        margin-left: 3px;
    }

    .payment-method-card {
        height: 100%;
    }
    
    .payment-method-card label {
        padding: 1rem;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-icon {
        height: 40px;
        width: auto;
        object-fit: contain;
    }
    
    .btn-check:checked + label {
        background-color: #e3f2fd;
        border-color: #1e88e5;
        color: #1e88e5;
    }
</style>
@endpush

@push('ecomjs')
<script>
document.getElementById('deliveryLocation').addEventListener('change', function() {
    const shippingCost = this.value === 'inside' ? 50 : 110;
    const subtotal = {{ $cartItems->sum(function($item) { return $item->price * $item->quantity; }) }};
    const tax = subtotal * 0.1;
    const total = subtotal + shippingCost + tax;

    document.getElementById('shippingCost').textContent = '৳' + shippingCost.toFixed(2);
    document.getElementById('orderTotal').textContent = '৳' + total.toFixed(2);
});
</script>
@endpush