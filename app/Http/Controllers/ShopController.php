<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopAddress;
use App\Models\ShopBank;
use App\Models\ShopCorporateFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    protected $shop;

    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop_data = $this->shop->orderBy('id', 'DESC')->get();
        return view('admin.shop.index')->with('shop_data', $shop_data);
    }

    public function shopStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('shops')->where('id', $request->id)->update(['status' => 'verified']);
        } else {
            DB::table('shops')->where('id', $request->id)->update(['status' => 'not verified']);
        }
        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }

    public function shopUpdateStatus(Request $request)
    {
        $status = DB::table('shops')->where('id', $request->id)->value('status');
        if ($status == 'verified') {
            DB::table('shops')->where('id', $request->id)->update(['status' => 'not verified']);
        }

        if ($status == 'not verified') {
            DB::table('shops')->where('id', $request->id)->update(['status' => 'verified']);
        }

        return redirect()->route('shop.index')->with('success', 'Shop status updated successfully');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->shop = $this->shop->find($id);
        if (!$this->shop) {
            //message
            return redirect()->back()->with('error', 'This shop is not found');
        }
        $shop_address = ShopAddress::where('shop_id', $id)->first();
        $shop_file = ShopCorporateFile::where('shop_id', $id)->first();
        $shop_bank = ShopBank::where('shop_id', $id)->first();

        return view('admin.shop.view')
            ->with('shop_data', $this->shop)
            ->with('shop_address', $shop_address)
            ->with('shop_file', $shop_file)
            ->with('shop_bank', $shop_bank);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->shop = $this->shop->find($id);
        if (!$this->shop) {
            return redirect()->back()->with('error', 'This shop is not found');
        }
        $seller_id = $this->shop->user_id;
        $seller = User::where('id', $seller_id)->first();
        $shop_address = ShopAddress::where('shop_id', $id)->first();
        $shop_file = ShopCorporateFile::where('shop_id', $id)->first();
        $shop_bank = ShopBank::where('shop_id', $id)->first();
        $del = $this->shop->delete();
        if ($del) {
            $seller->delete();
            $shop_address->delete();
            $shop_file->delete();
            $shop_bank->delete();
            return redirect()->route('shop.index')->with('success', 'Shop deleted successfully');
        } else {
            //message
            return redirect()->back()->with('error', 'Sorry! there was problem in deleting shop');
        }
    }
}
