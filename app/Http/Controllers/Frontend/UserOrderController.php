<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->sortBy;
        if ($sort == 'last_15_days') {
            $orders = Order::where('user_id', auth()->user()->id)
                ->whereBetween('created_at', [Carbon::now()->subDays(15), Carbon::now()])
                ->orderBy('id', 'DESC')
                ->get();
        } elseif ($sort == 'last_30_days') {
            $orders = Order::where('user_id', auth()->user()->id)
                ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
                ->orderBy('id', 'DESC')
                ->get();
        } elseif ($sort == 'last_6_months') {
            $orders = Order::where('user_id', auth()->user()->id)
                ->whereBetween('created_at', [Carbon::now()->subMonths(6), Carbon::now()])
                ->orderBy('id', 'DESC')
                ->get();
        } elseif ($sort == 'all_orders') {
            $orders = Order::where(['user_id' => auth()->user()->id])->orderBy('id', 'DESC')->get();
        } else {
            $orders = Order::where(['user_id' => auth()->user()->id])->orderBy('id', 'DESC')->paginate(5);
        }
        // $product_order = ProductOrder::where('order_id', $order->id)->get();
        // $orderDate = Carbon::parse($order->created_at)->format('d M Y H:i:s');

        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();
        return view('frontend.user_account.user_order', compact('orders', 'parent_categories', 'child_categories'));
    }

    public function orderFilter(Request $request)
    {
        $sort = $request->sortBy;
        return redirect()->route('my_order.index', ['sortBy' => $sort]);
        // if ($sort == 'priceAsc') {
        //     $category_products = Product::where(['child_cat_id' => $single_category, 'cat_id' => $parent_category, 'status' => 'active'])->whereBetween('offer_price', $price)->orderBy('offer_price', 'ASC')->paginate(9);
        // } elseif ($sort == 'priceDesc') {
        //     $category_products = Product::where(['child_cat_id' => $single_category, 'cat_id' => $parent_category, 'status' => 'active'])->whereBetween('offer_price', $price)->orderBy('offer_price', 'DESC')->paginate(9);
        // } elseif ($sort == 'discAsc') {
        //     $category_products = Product::where(['child_cat_id' => $single_category, 'cat_id' => $parent_category, 'status' => 'active'])->whereBetween('offer_price', $price)->orderBy('price', 'ASC')->paginate(9);
        // } elseif ($sort == 'discDesc') {
        //     $category_products = Product::where(['child_cat_id' => $single_category, 'cat_id' => $parent_category, 'status' => 'active'])->whereBetween('offer_price', $price)->orderBy('price', 'DESC')->paginate(9);
        // } else {
        //     $category_products = Product::where(['child_cat_id' => $single_category, 'cat_id' => $parent_category, 'status' => 'active'])->whereBetween('offer_price', $price)->orderBy('id', 'DESC')->paginate(9);
        // }
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
        // Get the order you want to update
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back()->with('error', 'This order is not found');
        }

        // Update the condition
        $status = $order->condition = 'cancelled';
        $order->save();
        // dd($order);
        if ($status) {
            // Show a SweetAlert message
            $message = 'The order has been cancelled.';

            // Redirect back to the previous page
            return redirect()->back()->with('success', $message);
        } else {
            // Show a SweetAlert message
            $message = 'There was problem in cancelling this order.';
            return redirect()->back()->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $order_id = $request->order_id;
        $item = ProductOrder::where(['product_id' => $id, 'order_id' => $order_id])->first();
        // dd($item);
        if (!$item) {
            return redirect()->back()->with('error', 'This order product is not found');
        }
        $del = $item->delete();
        if ($del) {
            // Show a SweetAlert message
            $message = 'This order product is removed.';

            // Redirect back to the previous page
            return redirect()->back()->with('success', $message);
        } else {
            // Show a SweetAlert message
            $message = 'There was problem in removing this order product.';
            return redirect()->back()->with('error', $message);
        }
    }
}
