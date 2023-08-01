<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class TrackOrderController extends Controller
{
    public function trackOrder()
    {
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();
        return view('frontend.track_order', compact('parent_categories', 'child_categories'));
    }

    public function searchOrder(Request $request, $order_number = null)
    {
        // dd($order_number);
        $request['order_number'] = $request->order_number ?? $order_number;
        $this->validate($request, [
            // 'order_number' => 'string|required|exists:orders,order_number'
            'order_number' => 'string|required'
        ]);
        $order = Order::where(['order_number' => $request->order_number, 'user_id' => auth()->user()->id])->first();
        // dd($order);
        if (empty($order)) {
            return redirect()->back()->with('error', 'This order detail is not found');
        }
        $orderDate = Carbon::parse($order->created_at)->format('d M Y H:i:s');
        $deliveredDate = Order::where(['order_number' => $request->order_number, 'user_id' => auth()->user()->id, 'condition' => 'delivered'])->value('updated_at');
        if ($deliveredDate != null) {
            $deliveredDate = Carbon::parse($deliveredDate)->format('d M Y');
        }
        $product_order = ProductOrder::where('order_id', $order->id)->get();
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();
        return view('frontend.order_detail', compact('parent_categories', 'child_categories', 'order', 'orderDate', 'deliveredDate', 'product_order'));
    }
}
