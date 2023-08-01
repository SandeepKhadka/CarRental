<!-- Wishlist page starts here -->
{{-- 
<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Unit Price</th>
            <th>Stock Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if (\Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->count() > 0)
            @foreach (\Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->content() as $item)
                <tr>
                    <td>
                        <div class="cart-anchor-image">
                            @php
                                $photos = explode(',', @$item->model->image);
                            @endphp
                            @if (file_exists(public_path() . '/uploads/product/' . @$item->model->image))
                                <a href="{{ route('productDetail', @$item->model->slug) }}">

                                    <img class="u-img-fluid" src={{ asset('/uploads/product/' . @$item->model->image) }}>
                                </a>
                            @else
                                <a href="{{ route('productDetail', @$item->model->slug) }}">

                                    <img class="u-img-fluid" src={{ $photos[0] }}>
                                </a>
                            @endif

                        </div>
                    </td>
                    <td>
                        <div class="cart-price">
                            Rs {{ number_format(@$item->price, 2) }}
                        </div>
                    </td>
                    <td>
                        <div class="cart-stock">
                            @if (@$item->model->stock > 0)
                                In Stock
                            @else
                                Out of stock
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="action-wrapper">
                            <a href="javascript:void(0)" class="button button-outline-secondary move-to-cart"
                                data-id="{{ @$item->rowId }}" {{ @$item->model->stock > 0 ? '' : 'hidden' }}>Add to
                                Cart</a>
                            <button class="button button-outline-secondary fas fa-trash delete_wishlist"
                                data-id="{{ @$item->rowId }}"></button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" class="text-center">You don't have any product in your wishlist.</td>
            </tr>
        @endif
    </tbody>
</table> --}}

<!-- Wishlist page ends here -->