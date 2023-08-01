<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\ShopAddress;
use App\Models\ShopBank;
use App\Models\ShopCorporateFile;
use Illuminate\Http\Request;

class ShopSettingContoller extends Controller
{
    public function displayShopSetting()
    {
        $shop_id = Shop::where('user_id', auth()->user()->id)->value('id');
        $shop_address = ShopAddress::where('shop_id', $shop_id)->first();
        $shop_file = ShopCorporateFile::where('shop_id', $shop_id)->first();
        $shop_bank = ShopBank::where('shop_id', $shop_id)->first();


        return view('vendor.shop.settings', compact('shop_id', 'shop_address', 'shop_file', 'shop_bank'));
    }

    public function storeShopDetails(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'address' => 'string|required',
            'country_region' => 'string|required',
            'province' => 'string|required',
            'city' => 'string|required|',
            'area' => 'string|required',
            'legal_name' => 'string|required',
            'pan_no' => 'string|required',
            'image' => 'required|image|max:5120',
            'account_type' => 'string|required',
            'account_no' => 'string|required',
            'bank_name' => 'string|required',
            'branch_name' => 'string|required',
        ]);

        $data = $request->all();
        $shop_id = Shop::where('user_id', auth()->user()->id)->value('id');
        if ($request->has('image')) {
            $image = $request->image;
            $file_name = uploadImage($image, 'shop', '125x125');
            if ($file_name) {
                $data['image'] = $file_name;
                // dd($file_name);        
            } else {
                return redirect()->back()->with('error', 'There was error in uploading document');
            }
        }
        // dd($shop_id);
        ShopAddress::create([
            'shop_id' => $shop_id,
            'address' => $data['address'],
            'country_region' => $data['country_region'],
            'province' => $data['province'],
            'city' => $data['city'],
            'area' => $data['area'],
        ]);

        ShopCorporateFile::create([
            'shop_id' => $shop_id,
            'legal_name' => $data['legal_name'],
            'pan_no' => $data['pan_no'],
            'image' => $file_name,
        ]);

        ShopBank::create([
            'shop_id' => $shop_id,
            'account_type' => $data['account_type'],
            'account_no' => $data['account_no'],
            'bank_name' => $data['bank_name'],
            'branch_name' => $data['branch_name'],
        ]);

        return redirect()->back()->with('success', 'Shop Details Stored Successfully');
    }

    public function updateShopDetails(Request $request, $id)
    {
        // dd($request->all());
        $shop_address = ShopAddress::where('shop_id', $id)->first();
        $shop_file = ShopCorporateFile::where('shop_id', $id)->first();
        $shop_bank = ShopBank::where('shop_id', $id)->first();
        if (!$shop_address || !$shop_file || !$shop_bank) {
            return redirect()->back()->with('error', 'This shop details is not found');
        }
        $this->validate($request, [
            'address' => 'string|required',
            'country_region' => 'string|required',
            'province' => 'string|required',
            'city' => 'string|required|',
            'area' => 'string|required',
            'legal_name' => 'string|required',
            'pan_no' => 'string|required',
            'image' => 'image|max:5120',
            'account_type' => 'string|required',
            'account_no' => 'string|required',
            'bank_name' => 'string|required',
            'branch_name' => 'string|required',
        ]);

        $address_data = $request->only(['address', 'country_region', 'province', 'city', 'area']);
        // dd($address_data);
        $file_data = $request->only(['legal_name', 'pan_no']);
        $bank_data = $request->only(['account_type', 'account_no', 'bank_name', 'branch_name']);
        // $shop_id = Shop::where('user_id', auth()->user()->id)->value('id');
        if ($request->has('image')) {
            $image = $request->image;
            $file_name = uploadImage($image, 'shop', '125x125');
            if ($file_name) {
                $bank_data['image'] = $file_name;
                // dd($file_name);        
            } else {
                return redirect()->back()->with('error', 'There was error in uploading document');
            }
        }

        $shop_address->fill($address_data);
        $status = $shop_address->save();
        if ($status) {
            $shop_file->fill($file_data);
            $status2 = $shop_file->save();
            if ($status2) {
                $shop_bank->fill($bank_data);
                $status3 = $shop_bank->save();
                return redirect()->back()->with('success', 'Shop Details Updated Successfully');
            }
        }

        // dd($data['address']);
        // ShopAddress::create([
        //     'shop_id' => $shop_id,
        //     'address' => $data['address'],
        //     'country_region' => $data['country_region'],
        //     'province' => $data['province'],
        //     'city' => $data['city'],
        //     'area' => $data['area'],
        // ]);

        // ShopCorporateFile::create([
        //     'shop_id' => $shop_id,
        //     'legal_name' => $data['legal_name'],
        //     'pan_no' => $data['pan_no'],
        //     'image' => $file_name,
        // ]);

        // ShopBank::create([
        //     'shop_id' => $shop_id,
        //     'account_type' => $data['account_type'],
        //     'account_no' => $data['account_no'],
        //     'bank_name' => $data['bank_name'],
        //     'branch_name' => $data['branch_name'],
        // ]);
    }
}
