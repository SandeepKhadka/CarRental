<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    //instance variable coupon
    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * This function first get all the data from coupon table
     * After that it returns to coupon index with that data
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupon_data = $this->coupon->orderBy('id', 'DESC')->get();
        return view('admin.coupon.index')->with('coupon_data', $coupon_data);
    }

    // function for updating coupon status
    public function couponStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('coupons')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('coupons')->where('id', $request->id)->update(['status' => 'inactive']);
        }
        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * This function first validate the data from form
     * After that it saves the data to the database
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            // 'code' => 'string|required|min:2',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|gt:0',
            // 'product_id' => 'required|exists:products,id'
        ]);

        $data = $request->except(['_token']);
        $data['user_id'] = auth()->user()->id ?? '';
        $data['customer_id'] = intval($request->customer_id) ?? '';
        $data['product_id'] = intval($request->product_id) ?? '';
        $username = User::where('id', $data['customer_id'])->value('username');
        if($data['product_id'] != null && $data['customer_id'] != null){
            $data['code'] = '#' . $username . '_' . $data['product_id'] . rand(0, 100);
        }
        $this->coupon->fill($data);
        $status = $this->coupon->save();
        if ($status) {
            if ($request->ajax()) {
                // If request was sent through AJAX, return success message in JSON format
                return response()->json(['message' => 'Coupon created successfully with code ' . $data['code']]);
                // return response()->json(['message' => 'Coupon created successfully with code']);
            } else
                return redirect()->route('coupon.index')->with('success', 'Coupon added successfully');
        } else {
            if ($request->ajax()) {
                // If request was sent through AJAX, return error message in JSON format
                return response()->json(['error' => 'There was problem in adding coupon!']);
            } else {
                return redirect()->back()->with('error', 'There was problem in adding coupon');
            }
        }
    }

    // function for coupon for specific user
    public function privateCoupon(Request $request)
    {
        $this->validate($request, [
            // 'code' => 'string|required|min:2',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|gt:0',
            'product_id' => 'required|exists:products,id'
        ]);

        $data = $request->except(['_token']);
        $data['user_id'] = auth()->user()->id ?? '';
        $data['customer_id'] = intval($request->customer_id) ?? '';
        $data['product_id'] = intval($request->product_id) ?? '';
        $username = User::where('id', $data['customer_id'])->value('username');
        $data['code'] = '#' . $username . '_' . $data['product_id'] . rand(0, 100);
        $this->coupon->fill($data);
        $status = $this->coupon->save();
        if ($status) {
            if ($request->ajax()) {
                // If request was sent through AJAX, return success message in JSON format
                return response()->json(['message' => 'Coupon created successfully with code ' . $data['code']]);
            } else
                return redirect()->route('coupon.index')->with('success', 'Coupon added successfully');
        } else {
            if ($request->ajax()) {
                // If request was sent through AJAX, return success message in JSON format
                return response()->json(['error' => 'There was problem in adding coupon!']);
            } else {
                return redirect()->back()->with('error', 'There was problem in adding coupon');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->coupon = $this->coupon->find($id);
        if (!$this->coupon) {
            //message
            return redirect()->back()->with('error', 'This coupon is not found');
        }

        return view('admin.coupon.view')
            ->with('coupon_data', $this->coupon);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->coupon = $this->coupon->find($id);
        if (!$this->coupon) {
            //message
            return redirect()->back()->with('error', 'This banner is not found');
        }

        return view('admin.coupon.create')
            ->with('coupon_data', $this->coupon);
    }

    /**
     * This function first validate the data from form
     * After that it updates the data to the database
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->coupon = $this->coupon->find($id);
        if (!$this->coupon) {
            return redirect()->back()->with('error', 'This coupon is not found');
        }

        $this->validate($request, [
            'code' => 'string|required|min:2',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|gt:0',
        ]);

        $data = $request->except(['_token']);
        $this->coupon->fill($data);
        $status = $this->coupon->save();
        if ($status) {
            return redirect()->route('coupon.index')->with('success', 'Coupon updated successfully');
        } else {
            return redirect()->back()->with('error', 'There was problem in updating coupon');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->coupon = $this->coupon->find($id);
        if (!$this->coupon) {
            return redirect()->back()->with('error', 'This coupon is not found');
        }

        $del = $this->coupon->delete();
        if ($del) {
            return redirect()->route('coupon.index')->with('success', 'Coupon deleted successfully');
        } else {
            //message
            return redirect()->back()->with('error', 'Sorry! there was problem in deleting coupon');
        }
    }
}
