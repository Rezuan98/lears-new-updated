@push('ecomcss')
<style>
    .secondery_banner {
        margin: 20px 0px;
    }

    .secondery_banner img {
        width: 100%;
        padding: 10px;
        height: 400px; /* Default height for large devices */
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .secondery_banner .banner-link:hover img {
        transform: scale(1.02);
    }

    /* Mobile devices */
    @media (max-width: 768px) {
        .secondery_banner img {
            height: 200px; /* Fixed height for mobile */
        }
    }
</style>
@endpush

@php
    $leftBanner = App\Models\SeconderyBanner::where('position', 0)
                                           ->where('status', true)
                                           ->first();
    $rightBanner = App\Models\SeconderyBanner::where('position', 1)
                                            ->where('status', true)
                                            ->first();
@endphp

<div class="secondery_banner">
    <div class="container">
        <div class="row g-1">
            @if($leftBanner)
            <div class="col-lg-6">
                @if($leftBanner->link)
                    <a href="{{ $leftBanner->link }}" class="banner-link">
                @endif
                    <img src="{{ asset('public/storage/public/secondary-banners/' . $leftBanner->image) }}" 
                         alt="{{ $leftBanner->title }}" 
                         title="{{ $leftBanner->title }}">
                @if($leftBanner->link)
                    </a>
                @endif
            </div>
            @endif

            @if($rightBanner)
            <div class="col-lg-6">
                @if($rightBanner->link)
                    <a href="{{ $rightBanner->link }}" class="banner-link">
                @endif
                    <img src="{{ asset('public/storage/public/secondary-banners/' . $rightBanner->image) }}" 
                         alt="{{ $rightBanner->title }}"
                         title="{{ $rightBanner->title }}">
                @if($rightBanner->link)
                    </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
