<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ReferralLinkMail;
use App\Models\Category;
use App\Models\Product;
use App\Models\ReferralLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ReferAndEarnController extends Controller
{
    public function sendLink(Request $request)
    {
        $referrer = auth()->user();
        $product = Product::find($request->product_id);
        $email = $request->email;

        // Generate referral link
        $referralLink = new ReferralLink();
        $referralLink->user_id = $referrer->id;
        $referralLink->product_id = $product->id;
        $referralLink->link = URL::signedRoute('refer.product', [
            'slug' => $product->slug,
            'referer' => $referrer->id,
        ]);


        // dd($referralLink);
        // Send referral email
        Mail::to($email)->send(new ReferralLinkMail($referralLink));

        return response()->json(['status' => true, 'message' => 'Referral link sent successfully']);
    }

    public function productDetail($slug, $referrer)
    {
        $product = Product::where('slug', $slug)->first();
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();
        if (!$product) {
            return redirect()->back();
        }
        return view('frontend.refer.refer_product_detail', compact('product', 'parent_categories', 'child_categories', 'referrer'));
    }

    public function checkout($referrer)
    {
        $user = Auth::user();
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();
        return view('frontend.refer.checkout', compact('user', 'parent_categories', 'child_categories', 'referrer'));
    }
}
