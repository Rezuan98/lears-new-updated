<div class="offcanvas offcanvas-end d-flex flex-column" tabindex="-1" id="cartMenu" aria-labelledby="cartMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="cartMenuLabel">Shopping Cart</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1 overflow-auto">
        <!-- Cart Items -->
        <div class="container-fluid">
            <div class="row cart-item align-items-center mb-3">
                <div class="col-3">
                    <img src="{{ asset('frontend/images/kalindi2.webp') }}" alt="Product" class="img-fluid rounded">
                </div>
                <div class="col-6">
                    <h6 class="mb-1">Nike Sport Shoes</h6>
                    <p class="text-muted mb-1">Size: 42 | Black</p>
                    <div class="input-group input-group-sm">
                        <button class="btn btn-outline-secondary " type="button">-</button>
                        <input type="number" class="form-control text-center qt-input" value="1" min="1" max="10">
                        <button class="btn btn-outline-secondary " type="button">+</button>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <span class="d-block text-muted">$89.99</span>
                    <button class="btn btn-sm btn-danger mt-2">Remove</button>
                </div>
            </div>
            <!-- Repeat Cart Items -->
          </div>
          <div class="container-fluid">
            <div class="row cart-item align-items-center mb-3">
                <div class="col-3">
                    <img src="{{ asset('frontend/images/kalindi2.webp') }}" alt="Product" class="img-fluid rounded">
                </div>
                <div class="col-6">
                    <h6 class="mb-1">Nike Sport Shoes</h6>
                    <p class="text-muted mb-1">Size: 42 | Black</p>
                    <div class="input-group input-group-sm">
                        <button class="btn btn-outline-secondary" type="button">-</button>
                        <input type="number" class="form-control text-center qt-input" value="1" min="1" max="10">
                        <button class="btn btn-outline-secondary" type="button">+</button>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <span class="d-block text-muted">$89.99</span>
                    <button class="btn btn-sm btn-danger mt-2">Remove</button>
                </div>
            </div>
            <!-- Repeat Cart Items -->
          </div>
          <div class="container-fluid">
            <div class="row cart-item align-items-center mb-3">
                <div class="col-3">
                    <img src="{{ asset('frontend/images/kalindi2.webp') }}" alt="Product" class="img-fluid rounded">
                </div>
                <div class="col-6">
                    <h6 class="mb-1">Nike Sport Shoes</h6>
                    <p class="text-muted mb-1">Size: 42 | Black</p>
                    <div class="input-group input-group-sm">
                        <button class="btn btn-outline-secondary" type="button">-</button>
                        <input type="number" class="form-control text-center qt-input" value="1" min="1" max="10">
                        <button class="btn btn-outline-secondary" type="button">+</button>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <span class="d-block text-muted">$89.99</span>
                    <button class="btn btn-sm btn-danger mt-2">Remove</button>
                </div>
            </div>
            <!-- Repeat Cart Items -->
          </div>
          <div class="container-fluid">
            <div class="row cart-item align-items-center mb-3">
                <div class="col-3">
                    <img src="{{ asset('frontend/images/kalindi2.webp') }}" alt="Product" class="img-fluid rounded">
                </div>
                <div class="col-6">
                    <h6 class="mb-1">Nike Sport Shoes</h6>
                    <p class="text-muted mb-1">Size: 42 | Black</p>
                    <div class="input-group input-group-sm">
                        <button class="btn btn-outline-secondary" type="button">-</button>
                        <input type="number" class="form-control text-center qt-input" value="1" min="1" max="10">
                        <button class="btn btn-outline-secondary" type="button">+</button>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <span class="d-block text-muted">$89.99</span>
                    <button class="btn btn-sm btn-danger mt-2">Remove</button>
                </div>
            </div>
            <!-- Repeat Cart Items -->
          </div>
          <div class="container-fluid">
            <div class="row cart-item align-items-center mb-3">
                <div class="col-3">
                    <img src="{{ asset('frontend/images/kalindi2.webp') }}" alt="Product" class="img-fluid rounded">
                </div>
                <div class="col-6">
                    <h6 class="mb-1">Nike Sport Shoes</h6>
                    <p class="text-muted mb-1">Size: 42 | Black</p>
                    <div class="input-group input-group-sm">
                        <button class="btn btn-outline-secondary" type="button">-</button>
                        <input type="number" class="form-control text-center qt-input" value="1" min="1" max="10">
                        <button class="btn btn-outline-secondary" type="button">+</button>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <span class="d-block text-muted">$89.99</span>
                    <button class="btn btn-sm btn-danger mt-2">Remove</button>
                </div>
            </div>
            <!-- Repeat Cart Items -->
          </div>
    </div>
    <!-- Subtotal and Checkout -->
    <div class="cart-footer border-top pt-3 m-3">
        <div class="d-flex justify-content-between mb-2">
            <span>Subtotal:</span>
            <span>$134.99</span>
        </div>
        <button class="btn btn-primary w-100">Checkout</button>
    </div>
</div>

@push('ecomcss')
<style>
 .offcanvas {
    max-width: 400px;
    display: flex;
    flex-direction: column; /* Ensure flex-column layout */
}

.offcanvas-body {
    flex-grow: 1; /* Allow the body to take up available space */
    overflow-y: auto; /* Enable scrolling for cart items */
}

.cart-footer {
    flex-shrink: 0; /* Ensure the footer does not grow or shrink */
    background: #f8f9fa;
}

</style>
    
@endpush

@push('ecomjs')
    
@endpush