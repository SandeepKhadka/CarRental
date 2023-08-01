<!-- Banner section starts here -->

<div class="default-height ph-item d-none d-md-block">
    <div class="slider-main owl-carousel">
        @if (isset($banners) && count($banners) > 0)
            @foreach ($banners as $banner)
                <div class="bg-image one">
                    <div class="slide-content slide-animation">
                        <div class="image-banner">
                            <a href="#" class="mx-auto banner-hover effect-dark-opacity">
                                <img class="img-fluid" src="{{ asset('/uploads/banner/' . $banner->image) }}"
                                    alt="{{ $banner->title }}">
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<!-- Banner section ends here -->
