<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ReferralLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;


class ReedemController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    public function reedem()
    {
        $category_products = Product::where('conditions', 'redeem')->orderBy('id', 'DESC')->paginate(9);
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();
        return view('frontend.redeem.redeem')->with([
            'category_products' => $category_products,
            'child_categories' => $child_categories,
            'parent_categories' => $parent_categories,
        ]);
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $userId = $request->query('user_id');
        $productId = $request->query('product_id');
        $product_detail = Product::where('id', $productId)->get();
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();
        return view('frontend.redeem.redeem_checkout', compact('user', 'parent_categories', 'child_categories', 'userId', 'productId', 'product_detail'));
    }

    public function storeCheckout(Request $request)
    {
        $userId = ReferralLink::where('user_id', auth()->user()->id)->first();
        $productId = $request->product_id;
        $user_points = ReferralLink::where('user_id', $userId)->sum('points');
        $product_point = Product::where('id', $productId)->value('points');

        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|required|exists:users,email',
            'phone' => 'string|required',
            'address' => 'string|required',
            'city' => 'string|required',
            'country' => 'string|required',
            'state' => 'string|nullable',
            'postcode' => 'numeric|nullable',
            'note' => 'string|nullable',
            'semail' => 'email|required',
            'sphone' => 'string|required',
            'saddress' => 'string|required',
            'scity' => 'string|required',
            'scountry' => 'string|required',
            'sstate' => 'string|nullable',
            'spostcode' => 'numeric|nullable',
        ]);

        $data = $request->except(['_token', 'product_id']);
        $data['sub_total'] = 0;
        // $sub_total = $data['sub_total'];
        // dd(gettype($sub_total));
        // dd(doubleval($sub_total));
        $data['oid'] = uniqid();
        $data['sub_total'] = 0;
        $data['user_id'] = auth()->user()->id;
        $data['order_number'] = Str::upper('ORD-' . Str::random(4) . rand(0, 100));
        $data['total_amount'] = 0;
        $data['payment_status'] = 'redeem';

        $data['condition'] = 'processing';
        $data['delivery_charge'] = 0;
        $order_id = $data['order_number'];
        $this->order->fill($data);
        $status = $this->order->save();

        $product = Product::find($productId);
        $quantity = 1;
        $this->order->products()->attach($product, ['quantity' => $quantity]);

        // dd($data['total_amount']);
        if ($status) {
            if ($request->payment_method == 'cod') {
                $user = ReferralLink::where('user_id', auth()->user()->id)->first();
                if($user){
                    $user->delete();
                }
                Mail::to($this->order['email'])->bcc($this->order['semail'])->cc('sandeepkhadka4935g@gmail.com')->send(new OrderMail($this->order));
                return view('frontend.confirmation', compact('order_id'));
            }
        } else {
            return redirect()->back()->with('error', 'There was problem in placing order');
        }
    }

    public function checkReferral(Request $request)
    {
        $userId = $request->input('user_id');
        $productId = $request->input('product_id');
        $referralLink = ReferralLink::where('user_id', $userId)->first();
        $user_points = ReferralLink::where('user_id', $userId)->sum('points');
        $product_point = Product::where('id', $productId)->value('points');
        if ($referralLink) {
            if ($user_points < $product_point) {
                return response()->json(['status' => 'error', 'message' => 'You do not have enough referral point.']);
            }
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'You do not have enough referral point.']);
        }
    }
}
