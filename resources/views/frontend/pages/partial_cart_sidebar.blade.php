<div id="cart-sidebar" class="cart-sidebar">
    <div class="cart-header">
        <h5>Shopping Cart</h5>
        <button class="close-cart" onclick="toggleCart()">×</button>
    </div>
    <div class="cart-items">
        <!-- Cart items will be dynamically populated here -->
    </div>
    <div class="cart-footer">
        <div class="cart-subtotal">
            <span>Subtotal:</span>
            <span id="cart-subtotal-amount"></span>
        </div>
        <div class="cart-buttons">
            <a href="{{ route('cart.index') }}" class="view-cart-btn">View Cart</a>
            <a href="{{ route('shipping') }}" class="checkout-btn">Checkout</a>
        </div>
    </div>
</div>


