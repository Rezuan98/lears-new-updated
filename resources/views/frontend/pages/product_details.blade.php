@extends('frontend.master.master')

@section('keyTitle','Product Details')
@push('ecomcss')
<style>
    .size-option {
        min-width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e5e5e5;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        padding: 8px 25px;
        font-size: 14px;
        font-weight: 500;
        background: white;
    }

    .size-option:hover {
        border-color: #333;
        transform: translateY(-1px);
    }

    .size-option.active {
        background-color: #333;
        color: white;
        border-color: #333;
    }

    .color-option {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: 2px solid #dee2e6;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .color-option:hover {
        opacity: 0.8;
    }

    .color-option.active {
        border: 2px solid #212529;
        box-shadow: 0 0 0 2px #fff, 0 0 0 4px #212529;
    }


    /* end css for color size */


    .toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 25px;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    border-radius: 4px;
    transform: translateX(100%);
    transition: transform 0.3s ease-in-out;
    z-index: 1000;
}

.toast-notification.show {
    transform: translateX(0);
}

.toast-notification.success {
    border-left: 4px solid #28a745;
}

.toast-notification.error {
    border-left: 4px solid #dc3545;
}

.toast-content {
    display: flex;
    align-items: center;
    gap: 10px;
}

.toast-content i {
    font-size: 1.25rem;
}

.toast-content i.fa-check-circle {
    color: #28a745;
}

.toast-content i.fa-exclamation-circle {
    color: #dc3545;
}

/* Loading State */
.btn .spinner-border {
    width: 1rem;
    height: 1rem;
    border-width: 0.15em;
}

</style>


@endpush
@section('contents')
<div class="breadcrumb-wrap py-3 border-bottom">
    <div class="container">
        <div class="breadcrumb-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="">Category</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->category->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container mt-2">
    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 col-md-6 col-sm-6 p-0 m-0">
            <div class="product-images">
                <!-- Main Image -->
                <div id="product-image-container" class="main-image mb-3">
                    <img style="width:100%;height:400px;padding:10px;" id="product-image" data-zoom-image="{{ asset('/public/uploads/products/' . $product->product_image) }}" src="{{ asset('/public/uploads/products/' . $product->product_image) }}" alt="{{ $product->name }}" class="img-fluid">
                </div>

                <!-- Thumbnail Images -->
                <div class="thumbnails d-flex gap-1 justify-content-center d-lg-block d-none">
                    @foreach($product->galleryImages as $image)
                    <img src="{{ asset('/public/uploads/gallery/' . $image->image) }}" alt="{{ $product->name }}" class="img-thumbnail cursor-pointer" onclick="updateMainImage(this.src)">
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="product-info">
                <h1 class="product-details-title mb-3">{{ $product->product_name?? 'NO Name' }}</h1>


                <?php
               $discount_type = $product->discount_type;
               $discount_amount = $product->discount_amount;
               $sale_price = $product->sale_price;
               $final_price = $sale_price; // Default to sale price
               
               if ($discount_amount > 0) {
                   if ($discount_type == 'flat') {
                       $final_price = $sale_price - $discount_amount;
                   } elseif ($discount_type == 'percentage') {
                       $discount_value = ($sale_price * $discount_amount) / 100;
                       $final_price = $sale_price - $discount_value;
                   }
               }
               ?>

                <div class="product-price mb-4">
                    @if($discount_amount > 0)
                    <span class="current-price h3">৳{{ number_format($final_price, 2) }}</span>
                    <span class="original-price text-muted text-decoration-line-through ms-2">৳{{ number_format($sale_price, 2) }}</span>
                    <span class="text-danger ms-2">
                        @if($discount_type == 'percentage')
                        ({{ $discount_amount }}% Off)
                        @else
                        (৳{{ $discount_amount }} Off)
                        @endif
                    </span>
                    @else
                    <span class="current-price h3">৳{{ number_format($sale_price, 2) }}</span>
                    @endif
                </div>

                <!-- Product Description -->
                <div class="product-description mb-4">
                    <h6 class="mb-2">DESCRIPTION</h6>
                    <p>{{ $product->description }}</p>
                </div>

                <div class="brand">
                    <p><strong>Brand:  </strong>{{ $product->brand->name; }}</p>
                </div>
                {{-- <div class="stock">
                    <p><strong>Stock:  </strong>{{ $product->variants->stock_quantity; }}</p>
                </div> --}}
                @if($product->variants)

                <!-- Size Selection -->
                <div class="size-selection mb-4">
                    <h6 class="mb-2">SIZE</h6>
                    <div class="size-options d-flex gap-2 flex-wrap">
                        @foreach($product->variants->unique('size_id') as $variant)
                        <div class="size-option {{ $loop->first ? 'active' : '' }}" onclick="selectSize(this)" data-size="{{ $variant->size_id }}">
                            {{ $variant->size->name }}
                        </div>
                        
                        @endforeach
                    </div>
                </div>
                @endif

                

                <!-- Color Selection -->
                <div class="color-selection mb-4">
                    <h6 class="mb-2">COLOR</h6>
                    <div class="color-options d-flex gap-2">
                        @foreach($product->variants->unique('color_id') as $variant)
                        <div class="color-option {{ $loop->first ? 'active' : '' }}" onclick="selectColor(this)" data-color="{{ $variant->color_id }}" style="background-color: {{ $variant->color->code }}">
                        </div>
                        @endforeach
                    </div>
                </div>







                    


                <!-- Quantity -->
                <div class="quantity-section mb-4">
                    <h6 class="mb-2">QUANTITY</h6>
                    <div class="quantity-selector d-flex align-items-center gap-3">
                        <button class="qty-btn" onclick="decrementQty()">-</button>
                        <input type="number" id="quantity" value="1" min="1" class="form-control text-center" style="width: 60px;">
                        <button class="qty-btn" onclick="incrementQty()">+</button>
                    </div>
                    @if($product->variants->sum('stock_quantity') < 10) <small class="text-danger">Only {{ $product->variants->sum('stock_quantity') }} left in stock!</small>
                        @endif
                </div>

                <!-- Add to Cart Button -->
                <button type="button" onclick="addToCart()" class="btn btn-dark w-100 mb-3">
                    ADD TO CART
                </button>
           
                <!-- Wishlist Button -->
                {{-- <button type="button" class="btn btn-outline-dark w-100 mb-4">
                    ADD TO WISHLIST
                </button> --}}



                <!-- Product Details -->
                {{-- <div class="product-details">
                    <h6 class="mb-2">DETAILS</h6>
                    <ul class="list-unstyled">
                        @foreach(json_decode($product->details, true) ?? [] as $key => $value)
                        <li>• {{ $key }}: {{ $value }}</li>
                        @endforeach
                    </ul>
                </div> --}}
            </div>
        </div>
    </div>
</div>



@endsection
@push('ecomjs')
<script>
   
/////////////////////////////////////////////////////////
function updateMainImage(src) {
    document.getElementById('product-image').src = src;
    document.getElementById('product-image').setAttribute('data-zoom-image', src);
}

function selectColor(element) {
    document.querySelectorAll('.color-option').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
}

function selectSize(element) {
    document.querySelectorAll('.size-option').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
}

function incrementQty() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    const maxStock = {{ $product->variants->sum('stock_quantity') }}; // Get max stock from PHP
    
    if (currentValue < maxStock) {
        input.value = currentValue + 1;
    } else {
        showToast('Maximum available stock reached', 'error');
    }
}
function decrementQty() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// Auto select first items on page load
document.addEventListener('DOMContentLoaded', function() {
    const firstSize = document.querySelector('.size-option');
    const firstColor = document.querySelector('.color-option');
    if (firstSize) firstSize.classList.add('active');
    if (firstColor) firstColor.classList.add('active');
});

/////////////////////////////////////////////////
















// code to add to cart function

async function addToCart() {
    const productId = {{ $product->id }};
    const quantity = document.getElementById('quantity').value;
    const selectedColor = document.querySelector('.color-option.active')?.dataset.color;
    const selectedSize = document.querySelector('.size-option.active')?.dataset.size;
    
    // Validation
    if (!selectedColor || !selectedSize) {
        showToast('Please select both color and size', 'error');
        return;
    }

    // Find the variant ID based on selected color and size
    const variant = {{ Js::from($product->variants) }}.find(v => 
        v.color_id.toString() === selectedColor && 
        v.size_id.toString() === selectedSize
    );

    if (!variant) {
        showToast('Selected combination is not available', 'error');
        return;
    }

    // Show loading state
    const addToCartBtn = document.querySelector('button[onclick="addToCart()"]');
    const originalText = addToCartBtn.innerHTML;
    addToCartBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
    addToCartBtn.disabled = true;

    try {
        const response = await fetch('/add-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                varient_id: variant.id,
                quantity: quantity,
                price: {{ $final_price }} // Using the price calculated in your blade template
            })
        });

        const data = await response.json();
        
        if (data.success) {
            updateCartCounts(data.cartCount);
            toggleCart()
           
            
            showToast('Product added to cart successfully', 'success');
        } else {
            showToast(data.message || 'Failed to add product to cart', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Failed to add product to cart', 'error');
    } finally {
        // Restore button state
        addToCartBtn.innerHTML = originalText;
        addToCartBtn.disabled = false;
    }
}

// function updateCartSidebar() {
//     fetch('/cart/items')
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 const cartItemsContainer = document.querySelector('.cart-items');
//                 const cartSubtotalElement = document.getElementById('cart-subtotal-amount');

//                 // Clear existing cart items
//                 cartItemsContainer.innerHTML = '';
               

//                 // Convert cartItems object to an array and check its length
//                 const cartItemsArray = Object.values(data.cartItems);

//                 if (cartItemsArray.length > 0) {
                  

//                     cartItemsArray.forEach(item => {
//     // Convert price to a number or default to 0
//     const price = parseFloat(item.price) || 0;

//     // Construct cart item HTML
//     const cartItemHTML = `
//         <div class="cart-item">
//             <img src="/uploads/products/${item.product_image}" alt="Product Image" class="cart-item-image">
//             <div class="cart-item-details">
//                 <h6 class="cart-item-title">${item.product_name}</h6>
//                 <p class="cart-item-variant">${item.variant?.color || 'N/A'} / ${item.variant?.size || 'N/A'}</p>
//                 <div class="cart-item-price">৳${price.toFixed(2)}</div>
//                 <div class="cart-item-actions">
//                     <div class="quantity-controls">
//                         <button onclick="updateSidebarQuantity('${item.id}', 'decrease')">-</button>
//                         <span class="sidebar-quantity" data-id="${item.id}">${item.quantity || 1}</span>
//                         <button onclick="updateSidebarQuantity('${item.id}', 'increase')">+</button>
//                     </div>
//                     <button class="remove-item" onclick="removeSidebarItem('${item.id}')">
//                         <i class="fas fa-trash"></i>
//                     </button>
//                 </div>
//             </div>
//         </div>`;
//     cartItemsContainer.insertAdjacentHTML('beforeend', cartItemHTML);
// });

//                     // Update subtotal
//                     cartSubtotalElement.textContent = `৳${data.subtotal.toFixed(2)}`;
//                 } else {
//                     // If cart is empty, show the empty-cart message
//                     cartItemsContainer.innerHTML = `
//                         <div class="empty-cart">
//                             <i class="fas fa-shopping-cart"></i>
//                             <p>Your cart is empty</p>
//                         </div>`;
//                     cartSubtotalElement.textContent = '৳0.00';
//                 }
//             } else {
//                 console.error('Failed to fetch cart items');
//             }
//         })
//         .catch(error => {
//             console.error('Error fetching cart items:', error);
//         });
// }






// Helper functions
function updateCartCounts(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        element.textContent = count;
    });
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(toast);
    
    // Force a reflow
    toast.offsetHeight;
    
    // Show toast
    toast.classList.add('show');
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}







    
</script>
@endpush
