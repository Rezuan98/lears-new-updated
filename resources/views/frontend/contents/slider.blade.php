<div class="container slider-container">
    <div class="slider">
        @forelse($sliders as $slider)
            <div class="slide">
                @if($slider->link)
                    <a href="{{ $slider->link }}">
                @endif
                
                <img src="{{ asset('/public/uploads/sliders/' . $slider->image) }}" 
                     alt="{{ $slider->title ?? 'Slide Image' }}">
                     
                @if($slider->link)
                    </a>
                @endif
            </div>
        @empty
            <div class="slide">
                <img src="{{ asset('/public/frontend/images/banner.jpg') }}" alt="Default Slide">
            </div>
        @endforelse
    </div>
</div>