{{-- <!-- Add this after your existing navbar code -->
<div id="mobile-bottom-nav" class="mobile-bottom-nav d-lg-none">
    <div class="nav-item">
        <a href="{{ route('home') }}" class="nav-link">
            <i class="fas fa-home"></i>
            <span>Shop</span>
        </a>
    </div>
   
    <div class="nav-item">
        <a href="#" class="nav-link" onclick="toggleSearch(); return false;">
            <i class="fas fa-search"></i>
            <span>Search</span>
        </a>
    </div>
    @php
                    use App\Models\Cart;
                    @endphp
    <div class="nav-item">
        <a onclick="toggleCart()" style="font-size: 1rem;"  class="nav-icon cart-icon">
            <i class="fas fa-shopping-cart"></i>
            <span style="width: 15px;height:20px;" class="cart-count">{{ auth()->check() ? 
                Cart::where('user_id', auth()->id())->sum('quantity') : 
                collect(session('cart', []))->sum('quantity') 
            }}</span>
        </a>
    </div>
</div>

@push('ecomjs')
    <script>
        
    </script>
@endpush --}}