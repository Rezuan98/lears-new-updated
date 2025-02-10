@extends('frontend.master.master')

@section('keyTitle','Category Products')
@push('ecomcss')
   <style>
.category-header {
    background-color: #f2ebebc2;
    border-bottom: 1px solid #7570705c;
}

.breadcrumb-nav {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    
}

.category-title {
    font-size: 24px;
    font-weight: 600;
    margin: 0;
}

.breadcrumb-path {
    font-size: 14px;
    color: #666;
}

.breadcrumb-path i {
    font-size: 10px;
}

/* end of breadcumb */




/* start price range filter */
.price-filter {
            padding: 0px;
            
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .price-slider-container {
            position: relative;
            padding: 0 10px;
            margin: 20px 0;
        }

        .price-display {
            position: relative;
           
           
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .input-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 20px;
        }

        .price-input {
            width: 100px;
            border: none;
            background: transparent;
            font-weight: 500;
            color: rgb(47, 46, 45);
            padding: 0;
        }

        .price-input:focus {
            outline: none;
        }

        .price-input::-webkit-inner-spin-button,
        .price-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .slider-track {
            height: 4px;
            background: #ddd;
            width: 100%;
            border-radius: 4px;
            position: relative;
        }

        .slider-range {
            height: 100%;
            background: orange;
            border-radius: 4px;
            position: absolute;
        }

        .range-input {
            position: relative;
            height: 30px;
        }

        input[type="range"] {
            -webkit-appearance: none;
            position: absolute;
            width: 100%;
            height: 4px;
            background: none;
            pointer-events: none;
            top: -15px;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            background: orange;
            border: 3px solid #fff;
            cursor: pointer;
            pointer-events: auto;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        }

        input[type="range"]::-moz-range-thumb {
            height: 18px;
            width: 18px;
            border-radius: 50%;
            background: orange;
            border: 3px solid #fff;
            cursor: pointer;
            pointer-events: auto;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        }

        .currency-symbol {
            color: #6c757d;
            font-weight: 500;
        }
        /* end of price range filter */

/* New Color Filter Styles */
.filter-section {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.color-options {
    display: flex; /* Horizontal alignment */
    flex-wrap: wrap; /* Allow wrapping for small screens */
    gap: 5px; /* Space between circles */
    justify-content: flex-start; /* Align items to the left */
}

.color-option {
    display: flex;
    align-items: center;
    gap: 8px; /* Space between the circle and label text */
}

.color-checkbox {
    display: none; /* Hide the checkbox */
}

.color-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%; /* Perfect circle */
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px #ddd;
    display: inline-block;
    cursor: pointer;
}

.color-checkbox:checked + label .color-circle {
    box-shadow: 0 0 0 2px orange; /* Highlight the selected circle */
}

.color-option label {
    cursor: pointer;
    font-weight: normal;
    display: flex;
    align-items: center;
}


/* Size Filter Styles */
.size-options {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.size-option {
    position: relative;
}

.size-checkbox {
    display: none;
}

.size-label {
    display: inline-block;
    width:30px;
    height: 30px;
    line-height: 25px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    user-select: none;
    margin: 0;
    transition: all 0.2s;
}

.size-checkbox:checked + .size-label {
    background-color: orange;
    color: white;
    
    border-color: orange;
}

.size-label:hover {
    border-color: orange;
}


/* Ensure proper layout and spacing */
.price-display .input-container {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: space-between;
}

.input-container input {
    max-width: 100px; /* Ensure inputs fit within the column */
    text-align: center;
}

.slider-track {
    height: 10px;
    background: #ddd;
    border-radius: 5px;
    position: relative;
}

.slider-range {
    position: absolute;
    height: 100%;
    background: #007bff;
    border-radius: 5px;
}

.form-range {
    position: absolute;
    width: 100%;
    height: 10px;
    background: transparent;
    -webkit-appearance: none;
    appearance: none;
    pointer-events: all;
}

.form-range::-webkit-slider-thumb {
    width: 20px;
    height: 20px;
    background: #007bff;
    border-radius: 50%;
    cursor: pointer;
    -webkit-appearance: none;
    appearance: none;
}
.spinner {
    text-align: center;
    margin: 20px;
    font-size: 18px;
    color: #a70000;
    font-weight: bold;
}

    </style> 
@endpush











@section('contents')
@push('ecomjs')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const minSlider = document.querySelector('.min-price');
    const maxSlider = document.querySelector('.max-price');
    const range = document.querySelector('.slider-range');
    const minInput = document.querySelector('.min-input');
    const maxInput = document.querySelector('.max-input');
    const productList = document.querySelector('.product-list');
    let debounceTimeout; // Variable for debounce
    const spinner = document.createElement('div'); // Create a loading spinner
    spinner.className = 'spinner';
    spinner.style.cssText = 'text-align: center; margin: 20px; font-size: 18px;';

    // Function to update slider and fetch products
    function updateRangeAndFilter() {
        const min = parseFloat(minSlider.value);
        const max = parseFloat(maxSlider.value);

        // Update input values
        minInput.value = min;
        maxInput.value = max;

        // Update slider range visual
        const percent1 = (min / minSlider.max) * 100;
        const percent2 = (max / maxSlider.max) * 100;
        range.style.left = percent1 + '%';
        range.style.width = (percent2 - percent1) + '%';

        // Debounce the fetch call
        if (debounceTimeout) clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            fetchFilteredProducts(min, max);
        }, 300); // Delay in milliseconds
    }

    // Function to fetch filtered products
    function fetchFilteredProducts(minPrice, maxPrice) {
        const url = new URL(window.location.href);
        url.searchParams.set('min_price', minPrice);
        url.searchParams.set('max_price', maxPrice);

        // Add spinner to indicate loading
        productList.innerHTML = ''; // Clear the product list
        spinner.textContent = 'Loading products...';
        productList.appendChild(spinner);

        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newProductList = doc.querySelector('.product-list');

                // Replace product list content
                if (newProductList) {
                    productList.innerHTML = newProductList.innerHTML;
                } else {
                    productList.innerHTML = '<p>No products found.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching filtered products:', error);
                productList.innerHTML = '<p>Error loading products. Please try again.</p>';
            });
    }

    // Attach event listeners to sliders
    minSlider.addEventListener('input', updateRangeAndFilter);
    maxSlider.addEventListener('input', updateRangeAndFilter);

    // Initialize range and fetch products
    updateRangeAndFilter();
});



</script>

    
@endpush
<!-- Category Header -->
<section class="category-header py-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="breadcrumb-nav text-center">
                    {{-- <h5 class="category-title">Category</h5> --}}
                    <div class="breadcrumb-path">
                        <span>Home</span>
                        <i class="fas fa-chevron-right mx-2"></i>
                        <span>Category</span>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>



<!-- Main Content -->
<!-- Category Page -->
<section class="category-page">
    <div class="container">
        <!-- Header with Filters -->
      

        <div class="row">
    <!-- Sidebar -->
    <div class="col-lg-3">
        <div class="price-filter">
            <p class="text-muted text-center mt-5">Price Range</p>
            <div class="price-display">
                <!-- Min Price Input -->
                <div class="input-container d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="currency-symbol me-1">৳</span>
                        <input type="number" name="min_price" class="min-input form-control" value="0" readonly>
                    </div>
                    <span class="currency-symbol mx-2">-</span>
                    <!-- Max Price Input -->
                    <div class="d-flex align-items-center">
                        <span class="currency-symbol me-1">৳</span>
                        <input type="number" name="max_price" class="max-input form-control" value="500000" readonly>
                    </div>
                </div>
    
                <!-- Slider -->
                <div class="slider-track position-relative mt-3">
                    <div class="slider-range bg-primary"></div>
                    <input type="range" class="min-price form-range" min="0" max="5000" value="0">
                    <input type="range" class="max-price form-range" min="0" max="5000" value="500000">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="row product-list">
            <!-- Include partial Blade file for displaying products -->
            @include('frontend.pages.category_product_partial', ['product' => $product])
        </div>
    </div>
    
    {{-- <div class="col-lg-9">
        <div class="row product-list">

           
           
           
            
            @foreach ($product as $products)
                <div class="col-lg-3 col-6">
                    <div class="product-box">
                        <span class="product-badge">
                            {{ $products->variants->first()->stock_quantity ? 'In Stock' : 'Out of stock' }}
                        </span>
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <a class="quickview-btn" href="{{ route('product.details', $products->id) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <div class="product-image">
                            <a href="{{ route('product.details', $products->id) }}">
                                <img src="{{ asset('/public/uploads/products/' . $products->product_image) }}" alt="{{ $products->name }}">
                            </a>
                        </div>
                        <div class="product-info">
                            <p class="product-title">{{ $products->product_name }}</p>
                            <span class="current-price">
                                ৳{{ $products->discount_type == 'percentage' 
                                    ? round($products->sale_price - ($products->sale_price * $products->discount_amount / 100), 2)
                                    : round($products->sale_price - $products->discount_amount, 2) }}
                            </span>
                            <span class="original-price">৳{{ $products->sale_price }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        
    </div> --}}
</div>




</div>

</div>
    </div>
</section>
@endsection