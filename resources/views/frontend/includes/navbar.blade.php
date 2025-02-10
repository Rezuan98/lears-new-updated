
@push('ecomcss')
   <style>
    /* search result */
    #search-results li {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding: 10px;
        cursor: pointer;
    }
    #search-results li:last-child {
        border-bottom: none;
    }
    #search-results li img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 10px;
    }
    #search-results li a {
        font-weight: bold;
        text-decoration: none;
        color: #9e1111;
    }
    #search-results li a:hover {
        color: #9e1111;
    }
 /* search result */

 /* scroll navbar */

   
    </style>
@endpush





<header class="site-header">
    
    
    <!-- Top Navbar -->
    <nav class="navbar">
        <div class="container px-0">
            <div id="nav-row" class="row w-100 p-0 m-0 align-items-center">
                <!-- Left Social Icons -->
                <div id="left-icons" class="col-4 d-flex justify-content-start">
                    <a href="{{ $settings->facebook_url }}" class="social-link d-none d-lg-block"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $settings->instagram_url }}" class="social-link d-none d-lg-block"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="nav-icon d-block d-lg-none"><i class="fa-solid fa-bars"></i></a>
                    <a href="#" onclick="toggleSearch()" class="nav-icon d-block d-lg-none"><i class="fas fa-search"></i></a>
                </div>

                <!-- Center Logo -->
                <div id="logo" class="col-4 d-flex justify-content-center">
                    <a href="{{ route('home') }}" class="navbar-brand">
                        <img  src="{{asset('public/storage/' . $settings->logo)}}"  alt="Leaars Logo">
                    </a>
                </div>
 
                <!-- Right Icons -->
                <div id="right-icons" class="col-4 d-flex justify-content-end">




                    <a href="#" class="nav-icon"><i class="fas fa-user"></i></a>

                    <div id="user-dropdown" class="user-dropdown">
                        <ul>
                            @auth
                                {{-- Show these items when user is logged in --}}
                                <li><a href="{{ route('user.dashboard') }}">Profile</a></li>
                                <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="" 
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                                            Logout
                                        </a>
                                    </form>
                                </li>
                            @else
                                {{-- Show these items when user is not logged in --}}
                                <li><a href="{{ route('user.dashboard') }}">My Account</a></li>
                                <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                                <li><a href="{{ route('user.login') }}">Login</a></li>
                            @endauth
                        </ul>
                    </div>





                    @php
                    use App\Models\Cart;
                    @endphp
                    <a href="#" onclick="toggleSearch()" class="nav-icon d-none d-lg-block"><i class="fas fa-search"></i></a>
                    {{-- <a href="#" class="nav-icon d-none d-lg-block"><i class="fas fa-heart"></i></a> --}}
                    <a onclick="toggleCart(); return false;" class="nav-icon cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">{{ auth()->check() ? 
                            Cart::where('user_id', auth()->id())->sum('quantity') : 
                            collect(session('cart', []))->sum('quantity') 
                        }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
{{-- search bar hidden initially --}}
<div id="search-bar" style="display: none;">
    <div class="container">
        <div class="div d-flex">
            <div class="col-11">
                <input type="text" class="form-control search-input" placeholder="Search for products...">

            </div>
            <div class="col-1 mb-2">
                <button class="btn btn-light mt-2" onclick="toggleSearch()">x</button>

            </div>
        </div>
        <ul id="search-results" class="list-group" 
        
    style="display: none; position: absolute; z-index: 1000; width: 100%; background-color: white; border: 1px solid #ddd; border-radius: 5px; overflow: hidden; max-height: 300px; overflow-y: auto;">
</ul>

    </div>
</div>
{{-- search bar hidden initially --}}











<!-- Mobile Menu bar in hamburger -->
<div id="mobile-menu" class="mobile-menu">
    <div class="menu-header">
        <h2>Categories</h2>
        <button class="close-btn" onclick="toggleMobileMenu()">×</button>
    </div>
    <div class="menu-content">
        <ul class="category-list" style="display: flex;flex-direction:column;z-index:1050;">
            @foreach ($categories as $category)
                <li><a href="{{ route('category.products', $category->id) }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
        
    </div>
</div>


<!-- Mobile Menu bar in hamburger -->









{{-- menu bar in first big nav --}}

<div class="categories-menu">
    <div class="container">
        <ul class="category-list mt-3">
            @foreach ($categories as $category)
                <li><a href="{{ route('category.products', $category->id) }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
        
    </div>
</div>
{{-- menu bar in first big nav --}}
@include('frontend.pages.partial_cart_sidebar')


   <!-- Cart Sidebar -->
   {{-- <div id="cart-sidebar" class="cart-sidebar">
    <div class="cart-header">
        <h5>Shopping Cart</h5>
        <button class="close-cart" onclick="toggleCart()">×</button>
    </div>
    <div class="cart-items">
        @if(auth()->check())
            @php
                $cartItems = App\Models\Cart::where('user_id', auth()->id())
                    ->with(['product', 'variant'])
                    ->get();
            @endphp
        @else
            @php
                $cartItems = collect(session('cart', []));
                // Get product and variant details for session cart
                $cartItems = $cartItems->map(function($item) {
                    return (object)[
                        'id' => $item['product_id'] . '-' . $item['varient_id'],
                        'product' => App\Models\Product::find($item['product_id']),
                        'variant' => App\Models\ProductVarient::with(['color', 'size'])->find($item['varient_id']),
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ];
                });
            @endphp
        @endif
        
        <?php dd($settings); ?>

        @forelse($cartItems as $item)
        <div class="cart-item">
            <img src="{{ asset('public/uploads/products/' . $item->product->product_image) }}"
                 alt=""
                 class="cart-item-image">
            <div class="cart-item-details">
                <h6 class="cart-item-title">{{ $item->product->product_name }}</h6>
                <p class="cart-item-variant">
                    {{ $item->variant->color->name ?? 'N/A' }} /
                    {{ $item->variant->size->name ?? 'N/A' }}
                </p>
                <div class="cart-item-price">৳{{ number_format($item->price, 2) }}</div>
               
                <div class="cart-item-actions">
                    <div class="quantity-controls">
                        <button onclick="updateSidebarQuantity('{{ $item->id }}', 'decrease')">-</button>
                        <span class="sidebar-quantity" data-id="{{ $item->id }}">{{ $item->quantity }}</span>
                        <button onclick="updateSidebarQuantity('{{ $item->id }}', 'increase')">+</button>
                    </div>
                    <button class="remove-item" onclick="removeSidebarItem('{{ $item->id }}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <p>Your cart is empty</p>
        </div>
        @endforelse
    </div>

    @if($cartItems->isNotEmpty())
    <div class="cart-footer">
        <div class="cart-subtotal">
            <span>Subtotal:</span>
            <span>৳{{ number_format($cartItems->sum(function($item) {
                return $item->price * $item->quantity;
            }), 2) }}</span>
        </div>
        <div class="cart-buttons">
            <a href="{{ route('cart.index') }}" class="view-cart-btn">View Cart</a>
            <a href="{{ route('shipping') }}" class="checkout-btn">Checkout</a>
        </div>
    </div>
    @endif
</div> --}}
</header>























{{-- stictky navbar for mobile device initially hidden --}}

<header id="site-header" class="site-header">
    <!-- Top Navbar -->
    <nav class="navbar">
        <div class="container px-0">
            <div id="nav-row" class="row w-100 p-0 m-0 align-items-center">
                <!-- Left Social Icons -->
                <div id="left-icons" class="col-4 d-flex justify-content-start">
                    <a href="https://www.facebook.com/share/18K8GQ9q4u/?mibextid=wwXIfr" class="social-link d-none d-lg-block"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link d-none d-lg-block"><i class="fab fa-instagram"></i></a>
                    <a  class="nav-icon d-block d-lg-none">
                       
                        <i id="sticky-hamburger" onclick="toggleNewMobileMenu();" class="fa-solid fa-bars"></i> <!-- Hamburger Icon -->
                    </a>
                    
                    <a href="#" onclick="toggleSearch()" class="nav-icon d-block d-lg-none"><i class="fas fa-search"></i></a>
                </div>

                <!-- Center Logo -->
                <div id="logo" class="col-4 d-flex justify-content-center">
                    <a href="{{ route('home') }}" class="navbar-brand">
                        <img  src="{{asset('public/storage/' . $settings->logo)}}"  alt="Leaars Logo">
                    </a>
                </div>
 
                <!-- Right Icons -->
                <div id="right-icons" class="col-4 d-flex justify-content-end">




                    <a href="" id="sticky-nav-dropdown-icon" class="nav-icon"><i class="fas fa-user"></i></a>

                    <div id="sticky-nav-user-dropdown" class="user-dropdown">
                        <ul>
                            @auth
                                {{-- Show these items when user is logged in --}}
                                <li><a href="{{ route('user.dashboard') }}">Profile</a></li>
                                <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="" 
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                                            Logout
                                        </a>
                                    </form>
                                </li>
                            @else
                                {{-- Show these items when user is not logged in --}}
                                <li><a href="{{ route('user.dashboard') }}">My Account</a></li>
                                <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                                <li><a href="{{ route('user.login') }}">Login</a></li>
                            @endauth
                        </ul>
                    </div>





                    {{-- @php
                    use App\Models\Cart;
                    @endphp --}}
                    <a href="#" onclick="toggleSearch()" class="nav-icon d-none d-lg-block"><i class="fas fa-search"></i></a>
                    {{-- <a href="#" class="nav-icon d-none d-lg-block"><i class="fas fa-heart"></i></a> --}}
                    <a onclick="toggleCart(); return false;" class="nav-icon cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">{{ auth()->check() ? 
                            Cart::where('user_id', auth()->id())->sum('quantity') : 
                            collect(session('cart', []))->sum('quantity') 
                        }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>


{{-- search bar hidden initially --}}
<div id="search-bar" style="display: none;">
    <div class="container">
        <div class="div d-flex">
            <div class="col-11">
                <input type="text" class="form-control search-input" placeholder="Search for products...">

            </div>
            <div class="col-1 mb-2">
                <button class="btn btn-light mt-2" onclick="toggleSearch()">x</button>

            </div>
        </div>
        <ul id="search-results" class="list-group" 
        
    style="display: none; position: absolute; z-index: 1000; width: 100%; background-color: white; border: 1px solid #ddd; border-radius: 5px; overflow: hidden; max-height: 300px; overflow-y: auto;">
</ul>

    </div>
</div>
{{-- search bar hidden initially --}}




<!-- Mobile Menu bar in hamburger -->
<div id="sticky-mobile-menu" class="sticky-mobile-menu">
    
    <div class="menu-content">
        <div class="menu-header">
            <h2>Categories</h2>
            <button class="close-btn" onclick="toggleNewMobileMenu()">×</button>
        </div>
        <ul class="category-list" style="display: flex;flex-direction:column;z-index:1050;">
            @foreach ($categories as $category)
                <li><a href="{{ route('category.products', $category->id) }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Mobile Menu bar in hamburger -->


{{-- 
 menu bar in first big nav 

<div class="categories-menu">
    <div class="container">
        <ul class="category-list mt-3">
            @foreach ($categories as $category)
                <li><a href="{{ route('category.products', $category->id) }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
        
    </div>
</div>
menu bar in first big nav --}}


@include('frontend.pages.partial_cart_sidebar')
</header>




{{-- end stictky navbar for mobile device --}}

















{{-- scroll navbar for desktop --}}
    <nav class="scroll-navbar">
        
        <div class="second-navbar">
            <div class="container d-flex justify-content-between aligns-items-center">
            <div class="brand-logo">
                <a href="#" class="scroll-logo">
                    <img src="{{asset('public/storage/' . $settings->logo)}}" alt="leaars Logo" style="height: 40px;">
                </a>
            </div>
         
            
            {{-- menu bar in scroll nav --}}
            <div class="scroll-categories">

               
                    <ul class="category-list mt-2">
                        @foreach ($categories as $category)
                            <li><a href="{{ route('category.products', $category->id) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>

                
               
                
            </div>
            {{-- menu bar in scroll nav --}}
        
            <div class="scroll-icons mt-2">
                <!-- User Dropdown -->
                <div class="nav-icon user-dropdown-wrapper">
                    <a id="user-scroll-icon"  class="nav-icon"><i class="fas fa-user"></i></a>
                    <div id="user-scroll-desktop-dropdown" class="user-dropdown">
                        <ul>
                            @auth
                                {{-- Show these items when user is logged in --}}
                                <li><a href="{{ route('user.dashboard') }}">Profile</a></li>
                                <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                    </form>
                                </li>
                            @else
                                {{-- Show these items when user is not logged in --}}
                                <li><a href="{{ route('user.dashboard') }}">My Account</a></li>
                                <li><a href="{{ route('user.dashboard') }}">Orders</a></li>
                                <li><a href="{{ route('user.wishlist') }}">Wishlist</a></li>
                                <li><a href="{{ route('user.login') }}">Login</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
            
                <!-- Search Icon -->
                <a href="#" onclick="toggleSearch()" class="nav-icon d-none d-lg-block"><i class="fas fa-search"></i></a>
            
                <!-- Cart Icon -->
               
                <a onclick="toggleCart()"  class="nav-icon cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">{{ auth()->check() ? 
                        Cart::where('user_id', auth()->id())->sum('quantity') : 
                        collect(session('cart', []))->sum('quantity') 
                    }}</span>
                </a>
            </div>
            
        </div>
    </nav>
</div>


{{-- scroll navbar --}}

@push('ecomjs')

   <script>
// Add this temporarily to check if the scroll event is working
// window.addEventListener('scroll', function() {
//     console.log('Scrolling', window.scrollY);
// });
//     // scroll navbar
// // Add this to your existing JavaScript
// window.addEventListener('scroll', function() {
//     const scrollNavbar = document.querySelector('.scroll-navbar');
//     if (window.scrollY > 150) {
//         scrollNavbar.classList.add('active');
//     } else {
//         scrollNavbar.classList.remove('active');
//     }
// });
    // scroll navbar



    document.addEventListener("scroll", function () {
    const scrollNavbar = document.querySelector(".scroll-navbar");
    if (window.scrollY > 150) {
        scrollNavbar.classList.add("visible"); // Add class to make navbar visible
    } else {
        scrollNavbar.classList.remove("visible"); // Remove class to hide navbar
    }
});

// document.addEventListener("scroll", function () {
//     const mobile_bottom_nav = document.querySelector(".mobile-bottom-nav");
//     if (window.scrollY > 150) {
//         mobile_bottom_nav.classList.add("visible"); // Add class to make navbar visible
//     } else {
//         mobile_bottom_nav.classList.remove("visible"); // Remove class to hide navbar
//     }
// });







function updateCartSidebar() {
    fetch('/cart/items')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cartItemsContainer = document.querySelector('.cart-items');
                const cartSubtotalElement = document.getElementById('cart-subtotal-amount');

                // Clear existing cart items
                cartItemsContainer.innerHTML = '';

                // Convert cartItems object to an array and check its length
                const cartItemsArray = Array.isArray(data.cartItems) ? data.cartItems : Object.values(data.cartItems);

                if (cartItemsArray.length > 0) {
                    cartItemsArray.forEach(item => {
                        const price = parseFloat(item.price) || 0;

                        // Handle both response structures
                        const productImage = item.product?.product_image || item.product_image || 'default.png';
                        const productName = item.product?.product_name || item.product_name || 'N/A';
                        const variantColor = item.variant?.color || 'N/A';
                        const variantSize = item.variant?.size || 'N/A';

                        // Construct cart item HTML
                        const cartItemHTML = `
                            <div class="cart-item">
                                <img src="/public/uploads/products/${productImage}" alt="Product Image" class="cart-item-image">
                                <div class="cart-item-details">
                                    <h6 class="cart-item-title">${productName}</h6>
                                    <p class="cart-item-variant">${variantColor} / ${variantSize}</p>
                                    <div class="cart-item-price">৳${price.toFixed(2)}</div>
                                    <div class="cart-item-actions">
                                        <div class="quantity-controls">
                                            <button onclick="updateSidebarQuantity('${item.id}', 'decrease')">-</button>
                                            <span class="sidebar-quantity" data-id="${item.id}">${item.quantity || 1}</span>
                                            <button onclick="updateSidebarQuantity('${item.id}', 'increase')">+</button>
                                        </div>
                                        <button class="remove-item" onclick="removeSidebarItem('${item.id}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>`;
                        cartItemsContainer.insertAdjacentHTML('beforeend', cartItemHTML);
                    });

                    // Update subtotal
                    cartSubtotalElement.textContent = `৳${data.subtotal.toFixed(2)}`;
                } else {
                    // If cart is empty, show the empty-cart message
                    cartItemsContainer.innerHTML = `
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Your cart is empty</p>
                        </div>`;
                    cartSubtotalElement.textContent = '৳0.00';
                }
            } else {
                console.error('Failed to fetch cart items');
            }
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
}



// cart sidebar

function toggleCart() {
    const cart = document.getElementById('cart-sidebar');
    cart.classList.toggle('active');

    updateCartSidebar();
    
}




async function updateSidebarQuantity(itemId, action) {
    const quantityElement = document.querySelector(`.sidebar-quantity[data-id="${itemId}"]`);
    let newValue = parseInt(quantityElement.textContent);

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
        // Update quantity display
        quantityElement.textContent = newValue;
        
        // Update cart count in header
        document.querySelector('.cart-count').textContent = data.cartCount;

        // Update subtotal
        const priceElement = quantityElement.closest('.cart-item').querySelector('.cart-item-price');
        const unitPrice = parseFloat(priceElement.textContent.replace('৳', '').replace(',', ''));
        const newSubtotal = (unitPrice * newValue).toFixed(2);
        
        // Update cart footer subtotal
        updateCartSubtotal();
    }
}

async function removeSidebarItem(itemId) {
    if (!confirm('Are you sure you want to remove this item?')) {
        return;
    }

    const response = await fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            cart_id: itemId
        })
    });

    const data = await response.json();

    if (data.success) {
        // Remove the item from the sidebar
        const cartItem = document.querySelector(`.cart-item [data-id="${itemId}"]`).closest('.cart-item');
        cartItem.remove();

        // Update cart count in header
        document.querySelector('.cart-count').textContent = data.cartCount;

        // Update cart footer subtotal
        updateCartSubtotal();

        // If cart is empty, show empty cart message
        const cartItems = document.querySelectorAll('.cart-item');
        if (cartItems.length === 0) {
            const cartItemsContainer = document.querySelector('.cart-items');
            cartItemsContainer.innerHTML = `
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Your cart is empty</p>
                </div>
            `;
            // Hide footer
            document.querySelector('.cart-footer').style.display = 'none';
        }
    }
}

function updateCartSubtotal() {
    let subtotal = 0;
    document.querySelectorAll('.cart-item').forEach(item => {
        const price = parseFloat(item.querySelector('.cart-item-price').textContent.replace('৳', '').replace(',', ''));
        const quantity = parseInt(item.querySelector('.sidebar-quantity').textContent);
        subtotal += price * quantity;
    });

    // Update subtotal display
    const subtotalElement = document.querySelector('.cart-subtotal span:last-child');
    if (subtotalElement) {
        subtotalElement.textContent = '৳' + subtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
}

// Close cart when clicking outside
// document.addEventListener('click', function(e) {
//     const cart = document.getElementById('cart-sidebar');
//     const cartIcon = document.querySelector('.cart-icon');
//     if (!cart.contains(e.target) && !cartIcon.contains(e.target) && cart.classList.contains('active')) {
//         toggleCart();
//     }
// });
// cart sidebar

// search
document.addEventListener('DOMContentLoaded', function () {
    const searchBar = document.getElementById('search-bar');
    const searchInput = document.querySelector('.search-input'); // Ensure it matches the HTML class
    const searchResults = document.getElementById('search-results');

    // Check if elements exist before adding event listeners
    if (!searchBar || !searchInput || !searchResults) {
        console.error('Search bar or input elements not found in the DOM.');
        return; // Exit script if elements are missing
    }

    // Listen for input events on the search field
    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();

        if (query.length > 2) {
            fetch(`/live-search?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = ''; // Clear previous results

                    if (data.length > 0) {
                        data.forEach(product => {
                            const listItem = document.createElement('li');
                            listItem.className = 'list-group-item p-2'; // Bootstrap padding for spacing
                            listItem.innerHTML = `
    <div style="display: flex; align-items: center;">
        <img 
            src="${location.origin}/uploads/products/${product.product_image}" 
            alt="${product.product_name}" 
            style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px; border-radius: 5px;"
            onerror="this.src='/path/to/placeholder.jpg';"
        >
        <div>
            <a href="/product/details/${product.id}" style="text-decoration: none; font-weight: bold;color:#a70000;">${product.product_name}</a>
            <div style="color: #555; font-size: 14px;">Price: $${product.sale_price}</div>
        </div>
    </div>
`;
                            searchResults.appendChild(listItem);
                        });
                        searchResults.style.display = 'block';
                    } else {
                        const noResultsItem = document.createElement('li');
                        noResultsItem.className = 'list-group-item';
                        noResultsItem.textContent = 'No results found';
                        searchResults.appendChild(noResultsItem);
                        searchResults.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                    searchResults.style.display = 'none';
                });
        } else {
            searchResults.style.display = 'none'; // Hide results if query is too short
        }
    });

    // Hide results when clicking outside
    document.addEventListener('click', function (event) {
        if (!searchBar.contains(event.target)) {
            searchResults.style.display = 'none';
        }
    });
});




// search



function toggleNewMobileMenu() {
    
        const menu = document.getElementById('sticky-mobile-menu');
        menu.classList.toggle('open');
    }

    // Optionally, close the menu if the user clicks outside the sidebar (clicking on the body)
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('sticky-mobile-menu');
        const hamburger = document.getElementById('sticky-hamburger');
        if (!menu.contains(e.target) && !hamburger.contains(e.target)) {
            menu.classList.remove('open'); // Close the menu if clicked outside
        }
    });
</script>
@endpush

