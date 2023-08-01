<!-- Single product page starts here -->

@if (isset($category_products) && count($category_products) > 0)
    @foreach ($category_products as $product)
        @php
            $photos = explode(',', $product->image);
        @endphp
        <div class="product-item col-lg-4 col-md-6 col-sm-6">
            <div class="item">
                <div class="image-container">
                    @if (file_exists(public_path() . '/uploads/product/' . $product->image))
                        <a class="item-img-wrapper-link" href="{{ route('productDetail', $product->slug) }}">
                            <img class="img-fluid" src={{ asset('/uploads/product/' . $product->image) }}>
                        </a>
                    @else
                        <a class="item-img-wrapper-link" href="{{ route('productDetail', $product->slug) }}">
                            <img class="img-fluid" src={{ $photos[0] }}>
                        </a>
                    @endif
                    <div class="item-action-behaviors">
                        <a class="item-mail" href="#"
                            onclick="if (confirm('Do you want to start a conversation about this product?')) { submitForm(); }">Chat</a>
                        <a class="item-addwishlist add_to_wishlist" href="javascript:void(0)" data-quantity="1"
                            data-id="{{ $product->id }}" id="add_to_wishlist_{{ $product->id }}">Add to
                            Wishlist</a>
                        <a class="item-addCart add_to_cart" href="javascript:void(0)" data-quantity="1"
                            data-product-id="{{ $product->id }}" id="add_to_cart{{ $product->id }}"
                            data-size="{{ $product->size }}">Add to Cart</a>
                    </div>
                </div>
                <div class="item-content">
                    <div class="what-product-is">

                        <ul class="bread-crumb">
                            <li>
                                <a
                                    href="">{{ ucfirst(\App\Models\Brand::where('id', $product->brand_id)->value('title')) }}</a>

                            </li>
                        </ul>
                        <h6 class="item-title">
                            <a href="">{{ ucfirst($product->title) }}</a>
                        </h6>
                        <div class="item-description">
                            <p>{!! html_entity_decode($product->summary) !!}
                            </p>
                        </div>
                        @php
                            $avg_rating = \App\Models\ProductReview::where('product_id', @$product->id)->avg('rate');
                            $avg_rating = floatval($avg_rating);
                            $rating = explode('.', $avg_rating);
                            $rating[0] = intval($rating[0]);
                            if (isset($rating[1])) {
                                $rating[1] = intval($rating[1]);
                            }
                        @endphp
                        <div class="u-s-m-b-15">
                            <div class="pd-detail__rating gl-rating-style">
                                @for ($i = 0; $i < $rating[0]; $i++)
                                    <i class="fas fa-star"
                                        style="font-size: 14px; color: orange; margin-right: -4px;"></i>
                                @endfor
                                @if (isset($rating[1]) && $rating[1] > 0)
                                    <i class="fas fa-star-half-alt"
                                        style="font-size: 14px; color: orange; margin-right: -4px;"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="price-template">
                        <div class="item-new-price">
                            Rs
                            {{ isset($product->discount) ? $product->offer_price : $product->price }}
                        </div>
                        <div class="item-old-price ml-1">
                            Rs {{ isset($product->discount) ? $product->price : '' }}
                        </div>
                    </div>
                </div>
                <div class="tag new" style="width: 100px; font-size: 14px">
                    <span>{{ isset($product->discount) ? $product->discount : '' }}% off</span>
                </div>
            </div>
        </div>
    @endforeach
@endif

<!-- Single product page ends here -->
