<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ReferralLink;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

require '../vendor/autoload.php';

use Cixware\Esewa\Client;
use Cixware\Esewa\Config;

class CheckoutController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    public function checkout()
    {
        $user = Auth::user();
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();
        return view('frontend.checkout', compact('user', 'parent_categories', 'child_categories'));
    }

    public function checkoutStore(Request $request)
    {
        // dd($request->payment_method);
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
            'payment_method' => 'string|required'
        ]);

        $data = $request->except(['_token']);
        $data['sub_total'] = str_replace(',', '', $data['sub_total']);
        // $sub_total = $data['sub_total'];
        // dd(gettype($sub_total));
        // dd(doubleval($sub_total));
        $data['oid'] = uniqid();
        $data['sub_total'] = floatval($data['sub_total']);
        $data['user_id'] = auth()->user()->id;
        $data['order_number'] = Str::upper('ORD-' . Str::random(4) . rand(0, 100));
        if (Session::has('coupon')) {
            $data['coupon'] = Session::get('coupon')['value'];
            $data['total_amount'] = number_format($data['sub_total'] - session('coupon')['value'] + 100, 2);
        } else {
            $data['coupon'] = 0;
            $data['total_amount'] = number_format($data['sub_total'] + 100, 2);
        }
        $data['total_amount'] = str_replace(',', '', $data['total_amount']);
        $data['total_amount'] = floatval($data['total_amount']);
        // dd($data['total_amount']);
        $data['payment_status'] = 'unpaid';
        // if ($request->payment_method == 'cod') {
        //     $data['payment_status'] = 'unpaid';
        // } else {
        //     $data['payment_status'] = 'paid';
        // }
        $data['condition'] = 'processing';
        $data['delivery_charge'] = 100;
        $order_id = $data['order_number'];
        if (isset($request->referrer) && $request->referrer != null) {
            $refer = new ReferralLink();
            $refer->user_id = $request->referrer;
            $refer->points = 10;
            $refer->save();
        }
        // dd($data);
        $this->order->fill($data);
        $status = $this->order->save();

        foreach (Cart::instance('shopping')->content() as $item) {
            $product_id[] = $item->id;
            $product = Product::find($item->id);
            $quantity = $item->qty;
            $this->order->products()->attach($product, ['quantity' => $quantity]);
        }


        // dd($data['total_amount']);
        if ($status) {
            if ($request->payment_method == 'cod') {
                Mail::to($this->order['email'])->bcc($this->order['semail'])->cc('sandeepkhadka4935g@gmail.com')->send(new OrderMail($this->order));
                Cart::instance('shopping')->destroy();
                if (Session::has('coupon')) {
                    $couponId = session()->get('coupon.id');
                    $coupon = Coupon::where('id', $couponId)->first();
                    // Update the coupon status to inactive
                    $coupon->update(['status' => 'inactive']);
                    Session::forget('coupon');
                }

                return view('frontend.confirmation', compact('order_id'));
            } else {
                session()->put('oid', $data['oid']);
                $this->esewaPay($data['oid'], $data['total_amount']);
            }
        } else {
            return redirect()->back()->with('error', 'There was problem in placing order');
        }
        // dd($order);
    }

    public function esewaPay($oid, $amount)
    {

        $successUrl = url('/success');
        $failureUrl = url('/failure');

        // config for development
        $config = new Config($successUrl, $failureUrl);

        // initialize eSewa client
        $esewa = new Client($config);

        $esewa->process($oid, $amount, 0, 0, 0);
        // store oid in session
    }

    public function esewaPaySuccess()
    {

        $oid = $_GET['oid'];
        $redId = $_GET['refId'];
        $amount = $_GET['amt'];

        $order = Order::where('oid', $oid)->first();
        $update_status = Order::find($order->id)->update([
            'payment_status' => 'paid'
        ]);
        $order_id = $order->order_number;
        if ($update_status) {
            Mail::to($order['email'])->bcc($order['semail'])->cc('sandeepkhadka4935g@gmail.com')->send(new OrderMail($order));
            Cart::instance('shopping')->destroy();
            Session::forget('coupon');
            return view('frontend.confirmation', compact('order_id'));
        }
    }

    public function esewaPayFailed()
    {
        $oid = session()->get('oid') ?? "";
        $order = Order::where('oid', $oid)->first();

        if ($order) {
            $order->delete();
        }
        return redirect()->back()->with('error', 'Your transaction is unsuccessfull');
    }
}
