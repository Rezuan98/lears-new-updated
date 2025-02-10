


@push('ecomcss')

<style>
  /* Quick View Sidebar */
.quick-view-sidebar {
    position: fixed;
    top: 0;
    right: -100%;
    width: 600px;
    height: 100vh;
    background: white;
    box-shadow: -2px 0 5px rgba(0,0,0,0.1);
    transition: right 0.3s ease;
    z-index: 1000;
}

.quick-view-sidebar.active {
    right: 0;
}

.quick-view-header {
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.close-quick-view {
    border: none;
    background: none;
    font-size: 24px;
    cursor: pointer;
}

.quick-view-content {
    max-height: calc(100vh - 60px);
    overflow-y: auto;
    padding: 20px;
}

/* Quick View Product Styles */
.product-quick-view {
    padding: 20px;
}

.main-image {
    width: 100%;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    margin-bottom: 15px;
}

.main-image img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}

.thumbnails {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding: 5px 0;
}

.thumbnails img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s;
}

.thumbnails img:hover {
    border-color: #333;
}

/* Product Info Styles */
.product-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.product-price {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 1.5rem;
}

.current-price {
    font-size: 1.5rem;
    font-weight: 600;
}

.original-price {
    text-decoration: line-through;
    color: #6c757d;
}

.discount {
    background-color: #dc3545;
    color: white;
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 0.875rem;
}

/* Variants Style */
.size-options {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

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
}

.size-option.active {
    background-color: #333;
    color: white;
    border-color: #333;
}

.color-options {
    display: flex;
    gap: 10px;
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

/* Quantity Selector */
.quantity-selector {
    display: flex;
    align-items: center;
    gap: 10px;
}

.qty-btn {
    width: 35px;
    height: 35px;
    border: 1px solid #dee2e6;
    background: none;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-input {
    width: 60px;
    text-align: center;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    height: 35px;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .quick-view-sidebar {
        width: 100%;
    }

    .main-image {
        height: 300px;
    }
}

/* Add other styles from your product details page */
</style>
    
@endpush

@push('ecomjs')
<script>
   // Quick View Functions
async function openQuickView(productId) {
    const sidebar = document.getElementById('quick-view-sidebar');
    const content = document.querySelector('.quick-view-content');

    try {
        const response = await fetch(`/product/quick-view/${productId}`);
        if (!response.ok) throw new Error('Failed to load product details');
        
        const html = await response.text();
        content.innerHTML = html;
        sidebar.classList.add('active');

        // Initialize first variants as active
        const firstSize = document.querySelector('.quick-view-content .size-option');
        const firstColor = document.querySelector('.quick-view-content .color-option');
        if (firstSize) firstSize.classList.add('active');
        if (firstColor) firstColor.classList.add('active');

    } catch (error) {
        console.error('Error loading quick view:', error);
        showToast('Failed to load product details', 'error');
    }
}

function toggleQuickView() {
    const sidebar = document.getElementById('quick-view-sidebar');
    sidebar.classList.remove('active');
}

// Close when clicking outside
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('quick-view-sidebar');
    const quickViewBtns = document.querySelectorAll('.plus-btn');
    let isQuickViewBtn = false;

    quickViewBtns.forEach(btn => {
        if (btn.contains(e.target)) isQuickViewBtn = true;
    });

    if (!sidebar.contains(e.target) && !isQuickViewBtn && sidebar.classList.contains('active')) {
        toggleQuickView();
    }
});

// Quick View Image Functions
function quickViewUpdateImage(src) {
    const mainImage = document.getElementById('quickview-main-img');
    if(mainImage) {
        mainImage.src = src;
    }
}

// Quick View Select Functions
function selectQuickViewSize(element) {
    document.querySelectorAll('.quick-view-content .size-option').forEach(el => {
        el.classList.remove('active');
    });
    element.classList.add('active');
}

function selectQuickViewColor(element) {
    document.querySelectorAll('.quick-view-content .color-option').forEach(el => {
        el.classList.remove('active');
    });
    element.classList.add('active');
}

// Quick View Quantity Functions
function incrementQuickViewQty() {
    const input = document.getElementById('quickview-quantity');
    const currentValue = parseInt(input.value);
    if (currentValue < 10) {
        input.value = currentValue + 1;
    }
}

function decrementQuickViewQty() {
    const input = document.getElementById('quickview-quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// Add to Cart from Quick View
async function addToCartFromQuickView(productId) {
    const quantity = document.getElementById('quickview-quantity').value;
    const selectedColor = document.querySelector('.quick-view-content .color-option.active')?.dataset.color;
    const selectedSize = document.querySelector('.quick-view-content .size-option.active')?.dataset.size;
    
    if (!selectedColor || !selectedSize) {
        showToast('Please select both color and size', 'error');
        return;
    }

    try {
        const response = await fetch('/add-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId,
                varient_id: selectedVariantId,
                quantity: quantity,
                price: productPrice
            })
        });

        const data = await response.json();
        
        if (data.success) {
            updateCartCounts(data.cartCount);
            showToast('Product added to cart successfully', 'success');
            toggleQuickView(); // Close quick view after successful add
        } else {
            showToast(data.message || 'Failed to add product to cart', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Failed to add product to cart', 'error');
    }
}
</script>
    
@endpush
<div class="product-quick-view">
    <!-- Product Images Section -->
    <div class="quick-view-images mb-4">
        <!-- Main Image -->
        <div class="main-image mb-3">
            <img id="quickview-main-img" 
                 src="{{ asset('uploads/products/' . $product->product_image) }}" 
                 alt="{{ $product->product_name }}" 
                 class="img-fluid">
        </div>

        <!-- Thumbnail Images -->
        <div class="thumbnails d-flex gap-2">
            <img src="{{ asset('uploads/products/' . $product->product_image) }}" 
                 alt="Main" 
                 class="img-thumbnail"
                 onclick="quickViewUpdateImage(this.src)">
            
            @foreach($product->galleryImages as $image)
                <img src="{{ asset('uploads/gallery/' . $image->image) }}" 
                     alt="Gallery" 
                     class="img-thumbnail"
                     onclick="quickViewUpdateImage(this.src)">
            @endforeach
        </div>
    </div>

    <!-- Product Info -->
    <div class="product-info">
        <h5 class="product-title mb-3">{{ $product->product_name }}</h5>
        <div class="product-price mb-4">
            @if($product->discount_amount > 0)
                <span class="current-price">৳{{ number_format($final_price, 2) }}</span>
                <span class="original-price">৳{{ number_format($product->sale_price, 2) }}</span>
                <span class="discount">
                    @if($product->discount_type == 'percentage')
                        ({{ $product->discount_amount }}% Off)
                    @else
                        (৳{{ $product->discount_amount }} Off)
                    @endif
                </span>
            @else
                <span class="current-price">৳{{ number_format($product->sale_price, 2) }}</span>
            @endif
        </div>

        <!-- Size Selection -->
        @if($product->variants)
        <div class="size-selection mb-4">
            <h6 class="mb-2">SIZE</h6>
            <div class="size-options d-flex gap-2 flex-wrap">
                @foreach($product->variants->unique('size_id') as $variant)
                <div class="size-option" onclick="selectQuickViewSize(this)" data-size="{{ $variant->size_id }}">
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
                <div class="color-option" 
                     onclick="selectQuickViewColor(this)" 
                     data-color="{{ $variant->color_id }}" 
                     style="background-color: {{ $variant->color->code }}">
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quantity -->
        <div class="quantity-section mb-4">
            <h6 class="mb-2">QUANTITY</h6>
            <div class="quantity-selector d-flex align-items-center gap-3">
                <button class="qty-btn" onclick="decrementQuickViewQty()">-</button>
                <input type="number" id="quickview-quantity" value="1" min="1" class="form-control text-center" style="width: 60px;">
                <button class="qty-btn" onclick="incrementQuickViewQty()">+</button>
            </div>
        </div>

        <!-- Add to Cart Button -->
        <button type="button" onclick="addToCartFromQuickView()" class="btn btn-dark w-100">
            ADD TO CART
        </button>
    </div>
</div>