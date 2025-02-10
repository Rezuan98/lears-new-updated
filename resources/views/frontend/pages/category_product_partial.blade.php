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
                @if($products->discount_amount!=0)
                <span class="current-price">
                    ৳{{ $products->discount_type == 'percentage' 
                        ? round($products->sale_price - ($products->sale_price * $products->discount_amount / 100), 2)
                        : round($products->sale_price - $products->discount_amount, 2) }}
                </span>
                <span class="original-price">৳{{ $products->sale_price }}</span>
                @else
                <span class="current-price">
                    ৳{{ $products->discount_type == 'percentage' 
                        ? round($products->sale_price - ($products->sale_price * $products->discount_amount / 100), 2)
                        : round($products->sale_price - $products->discount_amount, 2) }}
                </span>
                @endif
            </div>
        </div>
    </div>
@endforeach
