<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function cart()
    {
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();
        return view('frontend.cart', compact('parent_categories', 'child_categories'));
    }
    public function cartStore(Request $request)
    {
        // dd($request->all());
        $product_qty = $request->input('product_qty');
        $product_id = $request->input('product_id');
        $product_size = $request->input('product_size');
        $product = Product::getProductByCart($product_id);
        $price = $product[0]['offer_price'];
        if ($product_size != '') {
            $title = $product[0]['title'] . "," . $product_size;
        } else {
            $title = $product[0]['title'];
        }
        // dd($title);

        $cart_array = [];

        foreach (Cart::instance('shopping')->content() as $item) {
            $cart_array[] = $item->id;
        }

        $result = Cart::instance('shopping')->add($product_id, $title, $product_qty, $price)->associate('App\Models\Product');

        if ($result) {
            $response['status'] = true;
            $response['product_id'] = $product_id;
            $response['total'] = Cart::subtotal();
            $response['cart_count'] = Cart::instance('shopping')->count();
            $response['message'] = "Item was added to your cart";
        }
        if ($request->ajax()) {
            $header = view('frontend.layouts.topnav')->render();
            $response['header'] = $header;
        }

        return json_encode($response);
    }

    public function cartDelete(Request $request)
    {
        $id = $request->input('cart_id');
        Cart::instance('shopping')->remove($id);
        $response['status'] = true;
        $response['message'] = "Product successfully removed from the cart";
        $response['total'] = Cart::subtotal();
        $response['cart_count'] = Cart::instance('shopping')->count();
        $ids = [];
        if (Cart::instance('shopping')->count() > 0) {
            $cartItems = Cart::instance('shopping')->content();

            foreach ($cartItems as $item) {
                $ids[] = $item->id;
            }
        } else {
            if (Session::has('coupon')) {
                Session::forget('coupon');
            }
        }
        if (Session::has('coupon')) {
            $couponId = session()->get('coupon.id');
            $coupon = Coupon::where('id', $couponId)->first();
            if ($coupon->product_id != null && $coupon->customer_id != null && isset(auth()->user()->id)) {
                if ($coupon->customer_id != auth()->user()->id || !in_array(strval($coupon->product_id), $ids)) {
                    Session::forget('coupon');
                }
            }
        }
        if ($request->ajax()) {
            $header = view('frontend.layouts.topnav')->render();
            $response['header'] = $header;
        }
        return json_encode($response);
    }

    public function cartUpdate(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'product_qty' => 'required|numeric',
        ]);

        $rowId = $request->input('rowId');
        $request_quantity = $request->input('product_qty');
        $productQuantity = $request->input('productQuantity');

        if ($request_quantity > $productQuantity) {
            $message = "We currently do not have enough items in stock";
            $response['status'] = false;
        } elseif ($request_quantity < 1) {
            $message = "You cannot add less than 1 quantity";
            $response['status'] = false;
        } else {
            Cart::instance('shopping')->update($rowId, $request_quantity);
            $message = "Quantity was updated successfully";
            $response['status'] = true;
            $response['total'] = Cart::subtotal();
            $response['cart_count'] = Cart::instance('shopping')->count();
        }

        if ($request->ajax()) {
            $header = view('frontend.layouts.topnav')->render();
            $cart_list = view('frontend.layouts.cart_lists')->render();
            $response['header'] = $header;
            $response['cart_list'] = $cart_list;
            $response['message'] = $message;
        }

        return $response;
    }

    public function couponAdd(Request $request)
    {
        $coupon = Coupon::where(['code' => $request->input('code'), 'status' => 'active'])->first();
        if (!$coupon) {
            return back()->with('error', 'Invalid coupon code, Please enter valid coupon code');
        }
        $ids = [];
        if (Cart::instance('shopping')->count() > 0) {
            $cartItems = Cart::instance('shopping')->content();

            foreach ($cartItems as $item) {
                $ids[] = $item->id;
            }
        }

        if ($coupon->product_id != null && $coupon->customer_id != null) {
            if ($coupon->customer_id != auth()->user()->id || !in_array(strval($coupon->product_id), $ids)) {
                // dd($ids);
                return back()->with('error', 'Invalid coupon code, Please enter valid coupon code');
            }
        }
        if ($coupon) {
            $total_price = (float) str_replace(',', '', Cart::instance('shopping')->subtotal());
            session()->put('coupon', [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'value' => $coupon->discount($total_price),
            ]);
            return back()->with('success', 'Coupon applied successfully');
        }
    }

    public function addToCart(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|required',
            'price' => 'nullable|numeric',
            'quantiy' => 'nullable|numeric',
        ]);

        $data = $request->except(['_token']);
        $data['user_id'] = auth()->user()->id;

        $product_qty = $request->input('product_qty');
        $product_id = $request->input('product_id');
        $product_size = $request->input('product_size');
        $product = Product::getProductByCart($product_id);
        $price = $product[0]['offer_price'];

        $cart_array = [];
    }
}
