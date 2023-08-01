<!-- Cart lists table starts here -->
{{-- <table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach (\Gloudemans\Shoppingcart\Facades\Cart::instance('shopping')->content() as $item)
            <tr>
                <td>
                    <div class="cart-anchor-image">
                        <a href="single-product.html">
                            <img src={{ asset('/uploads/product/' . @$item->model->image) }} alt="Product">
                            <h6>{{ $item->name }}</h6>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="cart-price">
                        {{ $item->price }}
                    </div>
                </td>
                <td>
                    <div>
                        <div class="quantity">
                            <input type="number" data-id="{{ $item->rowId }}" class="quantity-text-field qty-text"
                                id="qty-input-{{ $item->rowId }}" value="{{ $item->qty }}">
                            <a class="plus-a qty-text"
                                id="qty-input-{{ $item->rowId }}" data-id="{{ $item->rowId }}"
                                data-max="1000">&#43;</a>
                            <a class="minus-a" data-min="1">&#45;</a>
                            <input type="hidden" data-id="{{ $item->rowId }}"
                                data-product-quantity="{{ $item->model->stock }}" id="update-cart-{{ $item->rowId }}">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="cart-price">
                        Rs {{ $item->subtotal() }}
                    </div>
                </td>
                <td>
                    <div class="action-wrapper">
                        <button class="button button-outline-secondary fas fa-trash cart_delete"
                            data-id="{{ $item->rowId }}"></button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table> --}}
<!-- Cart lists table ends here -->


