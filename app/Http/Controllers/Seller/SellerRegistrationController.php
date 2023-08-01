<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerRegistrationController extends Controller
{

    public function registerShop()
    {
        return view('vendor.shop.registration');
    }

    public function storeRegisterDetails(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'string|required',
            'shop_type' => 'string|required',
            'based_in' => 'string|required',
            'email' => 'string|required|',
            'phone' => 'numeric|required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
            'shop_name' => 'string|required',
        ]);
        // dd($request->all());
        $data = $request->all();
        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => "vendor",
            'password' => Hash::make($data['password']),
        ]);

        // $user->fill($data);

        $status = $user->save();

        if ($status) {
            Shop::create([
                'user_id' => $user->id,
                'shop_name' => $data['shop_name'],
                'shop_type' => $data['shop_type'],
                'based_in' => $data['based_in'],
                'phone' => $data['phone'],
            ]);
            if (Auth::user()) {
                Auth::logout();
            }

            return redirect()->route('login')->with('success', 'Seller Account Created Successfully');
        }
    }
}
