@extends('frontend.master.master')
@section('keyTitle','Cart')


@section('contents')
<div class="container">
    <!-- Cart Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold cart-num-count">
            Shopping Cart ({{ $cartCount }} {{ Str::plural('item', $cartCount) }})
        </h2>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            Continue Shopping
        </a>
    </div>

    <!-- Cart Content -->
    <div class="row g-4">
        <!-- Cart Items -->
        <div class="col-lg-8">
            @if($cartItems->count() > 0)
                @foreach($cartItems as $item)
                <div class="card shadow-sm mb-3 cart-item">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-2">
                                <img src="{{ asset('/public/uploads/products/' . $item->product->product_image) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="img-fluid rounded">
                            </div>
                           
                            <div class="col-4">
                                <h6>{{ $item->product->product_name }}</h6>
                                <p class="text-muted mb-0">
                                    Size: {{ $item->variant && $item->variant->size ? $item->variant->size->name : 'Not Available' }}
                                </p>
                                <p class="text-muted">
                                    Color: {{ $item->variant && $item->variant->color ? $item->variant->color->name : 'Not Available' }}
                                </p>
                                <h6 class="mb-0 item-price">৳{{ number_format($item->price, 2) }}</h6>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary decrease-qty" type="button" 
                                            onclick="updateQuantity('{{ $item->id }}', 'decrease')">-</button>

                                    <input type="number" class="form-control text-center quantity-input" 
                                           value="{{ $item->quantity }}" min="1" max="10" 
                                           data-item-id="{{ $item->id }}" readonly>

                                    <button class="btn btn-outline-secondary increase-qty" type="button"
                                            onclick="updateQuantity('{{ $item->id }}', 'increase')">+</button>
                                </div>
                            </div>
                            <div class="col-1">
                                <button class="btn text-danger remove-item" 
                                        onclick="removeItem('{{ $item->id }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Empty Cart Message -->
                <div class="empty-cart-message text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x mb-3 text-muted"></i>
                    <h3 class="text-muted">Your cart is empty</h3>
                    <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            @endif
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">Order Summary</h4>
                    <!-- Delivery Location -->
<div class="mb-4">
    <h6 class="mb-2">Delivery Location</h6>
    <select class="form-select" id="deliveryLocation" onchange="updateCartTotal()">
        <option value="inside">Inside Dhaka (৳50)</option>
        <option value="outside">Outside Dhaka (৳110)</option>
    </select>
</div>
                    <!-- Price Details -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span class="cart-subtotal">৳{{ number_format($cartItems->sum(function($item) {
                                return $item->price * $item->quantity;
                            }), 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span class="cart-shipping">৳{{ $cartItems->count() > 0 ? number_format(10.00, 2) : '0.00' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax (10%)</span>
                            <span class="cart-tax">৳{{ number_format($cartItems->sum(function($item) {
                                return ($item->price * $item->quantity) * 0.1;
                            }), 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <strong>Total</strong>
                            <strong class="cart-total">৳{{ number_format(
                                $cartItems->sum(function($item) {
                                    return ($item->price * $item->quantity) * 1.1;
                                }) + ($cartItems->count() > 0 ? 10 : 0)
                            , 2) }}</strong>
                        </div>
                    </div>

                    @if($cartItems->count() > 0)
                        <a href="{{ route('shipping') }}" class="btn btn-primary w-100 mb-3 checkout-btn">
                            Proceed to Checkout
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('ecomcss')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .card {
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }

    .quantity-input {
        max-width: 70px;
    }

    .payment-icons i {
        font-size: 24px;
        color: #6c757d;
        margin: 0 5px;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }

    .input-group {
        flex-wrap: nowrap;
    }

    .img-fluid {
        object-fit: cover;
        height: 100px;
        width: 100px;
    }

    @media (max-width: 768px) {
        .row > * {
            margin-bottom: 1rem;
        }

        .img-fluid {
        object-fit: cover;
        height: 60px;
        width: 60px;
    }
    }

    .loading {
        opacity: 0.5;
        pointer-events: none;
    }
</style>
@endpush

@push('ecomjs')
<script>
async function updateQuantity(itemId, action) {
    const input = document.querySelector(`input[data-item-id="${itemId}"]`);
    let newValue = parseInt(input.value);
    
    if (action === 'increase' && newValue < 10) {
        newValue++;
    } else if (action === 'decrease' && newValue > 1) {
        newValue--;
    } else {
        return;
    }

    const response = await fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            cart_id: itemId,
            quantity: newValue
        })
    });

    const data = await response.json();
    
    if (data.success) {
        input.value = newValue;
        // const priceElement = input.closest('.cart-item').querySelector('.item-price');
        // priceElement.textContent = '৳' + data.itemTotal.toFixed(2);
        document.querySelector('.cart-count').textContent = data.cartCount;
        updateCartTotal();
    }
}

async function removeItem(itemId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    if (!confirm('Are you sure you want to remove this item?')) {
        return;
    }

    try {
        const response = await fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                cart_id: itemId
            })
        });

        const data = await response.json();
        
        if (data.success) {
            const cartItem = document.querySelector(`input[data-item-id="${itemId}"]`).closest('.cart-item');
            cartItem.style.opacity = '0';
            setTimeout(() => {
                cartItem.remove();
                updateCartTotal();
                checkEmptyCart();
            }, 300);

            document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = data.cartCount;
            });
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to remove item');
    }
}
function updateCartTotal() {
    const cartItems = document.querySelectorAll('.cart-item');
    let subtotal = 0;
    
    cartItems.forEach(item => {
        // Get base price (single item price)
        const basePrice = parseFloat(item.querySelector('.item-price').textContent
            .replace('৳', '')
            .replace(',', ''));
        const quantity = parseInt(item.querySelector('.quantity-input').value);
        
        // Calculate item total
        subtotal += basePrice * quantity;
        
        // Update individual item total price
        item.querySelector('.item-price').textContent = '৳' + numberFormat(basePrice);
    });

    const deliveryLocation = document.getElementById('deliveryLocation').value;
    const deliveryCharge = deliveryLocation === 'inside' ? 50 : 110;
    const tax = subtotal * 0.10;
    const total = subtotal + deliveryCharge + tax;

    document.querySelector('.cart-subtotal').textContent = '৳' + numberFormat(subtotal);
    document.querySelector('.cart-shipping').textContent = '৳' + numberFormat(deliveryCharge);
    document.querySelector('.cart-tax').textContent = '৳' + numberFormat(tax);
    document.querySelector('.cart-total').textContent = '৳' + numberFormat(total);
}



function checkEmptyCart() {
    const cartItems = document.querySelectorAll('.cart-item');
    const emptyMessage = document.querySelector('.empty-cart-message');
    const cartContent = document.querySelector('.col-lg-8');
    
    if (cartItems.length === 0) {
        cartContent.innerHTML = `
            <div class="empty-cart-message text-center py-5">
                <i class="fas fa-shopping-cart fa-3x mb-3 text-muted"></i>
                <h3 class="text-muted">Your cart is empty</h3>
                <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
            </div>
        `;
    }
}

function numberFormat(number) {
    return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

// Initialize on page load
// document.addEventListener('DOMContentLoaded', function() {
//     updateCartTotal();
// });



</script>
@endpush

