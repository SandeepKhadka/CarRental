<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_data = Product::where('vendor_id', auth()->user()->id)->orderBy('id', 'DESC')->get('id');
        $orders = Product::select('products.id', 'products.vendor_id', 'product_orders.product_id', 'product_orders.order_id')
            ->join('product_orders', 'products.id', '=', 'product_orders.product_id')
            ->where(['vendor_id' => auth()->user()->id])
            ->get();
        // dd($orders);
        $all_orders = [];
        foreach($orders as $order){
            $all_orders[] = $order->order_id;
        }

        // dd($all_orders);


        $order_data = $this->order->whereIn('id', $all_orders)->orderBy('id', 'DESC')->get();
        return view('vendor.order.index')->with('order_data', $order_data);
    }

    public function orderStatus(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        if ($order) {
            if ($request->input('condition') == 'delivered') {
                foreach ($order->products as $item) {
                    $product = Product::where('id', $item->pivot->product_id)->first();
                    $stock = $product->stock;
                    $stock -= $item->pivot->quantity;
                    $product->update(['stock' => $stock]);
                    Order::where('id', $request->input('order_id'))->update(['payment_status' => 'paid']);
                }
            }

            $status = Order::where('id', $request->input('order_id'))->update(['condition' => $request->input('condition')]);
            if ($status) {
                return back()->with('success', 'Order successfully updated');
            } else {
                return back()->with('error', 'Something went wrong! Please try again!');
            }
        }
        abort(404);
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
        $this->order = $this->order->find($id);
        if (!$this->order) {
            //message
            return redirect()->back()->with('error', 'This order is not found');
        }

        $product_order = ProductOrder::where(['order_id' => $id])->get();
        return view('vendor.order.single_order')
            ->with('order_data', $this->order)
            ->with('product_order', $product_order);
    }

    public function orderDetails($id)
    {
        $this->order = $this->order->find($id);
        if (!$this->order) {
            //message
            return redirect()->back()->with('error', 'This order is not found');
        }
        return view('vendor.order.view')
            ->with('order_data', $this->order);
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
        $this->order = $this->order->find($id);
        if (!$this->order) {
            return redirect()->back()->with('error', 'This order is not found');
        }

        $del = $this->order->delete();
        if ($del) {
            return redirect()->route('order.index')->with('success', 'Order deleted successfully');
        } else {
            //message
            return redirect()->back()->with('error', 'Sorry! there was problem in deleting order');
        }
    }
}