<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    // login function for delivery user
    public function loginDelivery(Request $req)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required|string'
        ];

        $req->validate($rules);
        $user = Delivery::where('email', $req->email)->first();
        if ($user && $req->password == $user->password) {
            $response = [
                'user' => $user,
                'message' => 'Successfully Logged In',
                'status' => 'true'
            ];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Incorrect email or password', 'status' => 'false'];
        return response()->json($response, 400);
    }

    public function getOrderData()
    {
        $order = Order::whereIn('condition', ['shipped', 'out for delivery'])->get();
        $response = [
            'status' => 'true',
            'data' => $order
        ];
        return response()->json($response, 200);
    }

    public function applyorder(Request $request)
    {
        $order = Order::where('id', $request->id)->firstOrFail(); // Use `firstOrFail` to throw an exception if the order with the given ID does not exist
        $order->update(['condition' => 'out for delivery']); // Use an array to specify the field and its new value
        if ($order->condition === 'out for delivery') {
            // The condition was updated successfully
            $message = 'The order condition was updated successfully';
            return response()->json(['message' => $message, 'success' => 'true'], 200);
        } else {
            // The condition was not updated
            $message = 'The order condition could not be updated';
            return response()->json(['message' => $message, 'success' => 'false'], 200);
        }
    }

    public function updateOrderCondition(Request $request)
    {
        $order = Order::where('id', $request->id)->firstOrFail(); // Use `firstOrFail` to throw an exception if the order with the given ID does not exist
        $order->update(['condition' => 'delivered', 'payment_status' => 'paid']); // Use an array to specify the field and its new value
        if ($order->condition === 'delivered') {
            // The condition was updated successfully
            $message = 'The order condition was updated successfully';
            return response()->json(['message' => $message, 'success' => 'true'], 200);
        } else {
            // The condition was not updated
            $message = 'The order condition could not be updated';
            return response()->json(['message' => $message, 'success' => 'false'], 200);
        }
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
        $delivery = new Delivery();
        $delivery->name = $request->name;
        $delivery->email = $request->email;
        $delivery->address = $request->address;
        $delivery->password = $request->password;
        $delivery->save();

        return response()->json($delivery, 201);
    }

    public function getDeliveryData()
    {
        return response()->json(Delivery::all(), 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
