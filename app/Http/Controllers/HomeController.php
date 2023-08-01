<?php

namespace App\Http\Controllers;

use App\Models\MonthlyVisitor;
use App\Models\Order;
use App\Models\Product;
use Chatify\ChatifyMessenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware to ensure that user is authenticated before accessing routes
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Redirect user to their respective dashboard based on their role
        return redirect()->route(request()->user()->role);
    }

    public function admin(Request $request)
    {
        // Get the sum of unique visitors for all months
        $monthlyUniqueVisitorsCount = MonthlyVisitor::count();

        // Find overall monthly sales for current year
        $currentYear = date('Y');

        // Query to fetch total quantity of all products ordered for each month in current year
        $monthly_sales = DB::table('product_orders')
            ->selectRaw('SUM(product_orders.quantity) AS total_quantity, MONTH(orders.created_at) AS month')
            ->join('orders', 'product_orders.order_id', '=', 'orders.id')
            ->join('products', 'product_orders.product_id', '=', 'products.id')
            ->where('orders.condition', '=', 'delivered')
            ->whereYear('orders.created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialize an array with 0 for 7 months (if no sales happened for a month, it will default to 0)
        $monthlyTotalSales = array_fill(0, 7, 0);

        // Loop through the query results to get total quantity of products ordered for each month
        foreach ($monthly_sales as $sale) {
            $monthlyTotalSales[$sale->month - 1] = (int)$sale->total_quantity;
        }

        // Variable to hold total sales data for the view
        $the_sales = $monthlyTotalSales;

        // Query to fetch total revenue earned from all products sold for each month in current year
        $monthly_revenue = DB::table('product_orders')
            ->selectRaw('SUM(product_orders.quantity * products.offer_price * 0.9) AS total_earnings, MONTH(orders.created_at) AS month')
            ->join('orders', 'product_orders.order_id', '=', 'orders.id')
            ->join('products', 'product_orders.product_id', '=', 'products.id')
            ->where('orders.condition', '=', 'delivered')
            ->whereYear('orders.created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialize an array with 0 for 7 months (if no revenue was earned for a month, it will default to 0)
        $monthlyTotalEarnings = array_fill(0, 7, 0);

        // Loop through the query results to get total earnings for each month
        foreach ($monthly_revenue as $sale) {
            $monthlyTotalEarnings[$sale->month - 1] = (int)$sale->total_earnings;
        }

        // Variable to hold revenue data for the view
        $revenue = $monthlyTotalEarnings;

        // Query to fetch 6 latest orders
        $orders = Order::orderBy('id', 'DESC')->limit(6)->get();

        return view('admin.dashboard', compact('monthlyUniqueVisitorsCount', 'the_sales', 'orders', 'revenue'));
    }

    public function seller()
    {
        // Get the products and their order information for the authenticated vendor
        $orders = Product::select('products.id', 'products.vendor_id', 'product_orders.product_id', 'product_orders.order_id')
            ->join('product_orders', 'products.id', '=', 'product_orders.product_id')
            ->where(['vendor_id' => auth()->user()->id])
            ->get();

        // Create an array of all order IDs for the authenticated vendor
        $all_orders = [];
        foreach ($orders as $order) {
            $all_orders[] = $order->order_id;
        }

        // Get the ID of the authenticated vendor
        $vendor_id = auth()->user()->id;

        // Get the sales information for the authenticated vendor
        $sales = DB::table('product_orders')
            ->select('products.title', 'products.offer_price', 'products.price', 'product_orders.quantity', 'orders.total_amount')
            ->join('orders', 'product_orders.order_id', '=', 'orders.id')
            ->join('products', 'product_orders.product_id', '=', 'products.id')
            ->where('orders.condition', '=', 'delivered')
            ->where('products.vendor_id', '=', $vendor_id)
            ->get();

        // Calculate the total number of sales, total sales amount, and total earnings for the authenticated vendor
        $total_sales = $sales->sum('quantity');
        $total_sales_amount = $sales->sum('offer_price');
        $total_earnings = 0;
        foreach ($sales as $sale) {
            $total_earnings += ($sale->offer_price * $sale->quantity) * 0.9;
        }

        // Get the ID of the authenticated vendor and the current year
        $vendor_id = auth()->user()->id;
        $currentYear = date('Y');

        // Get the monthly sales information for the authenticated vendor for the current year
        $monthly_sales = DB::table('product_orders')
            ->selectRaw('SUM(product_orders.quantity) AS total_quantity, MONTH(orders.created_at) AS month')
            ->join('orders', 'product_orders.order_id', '=', 'orders.id')
            ->join('products', 'product_orders.product_id', '=', 'products.id')
            ->where('orders.condition', '=', 'delivered')
            ->where('products.vendor_id', '=', $vendor_id)
            ->whereYear('orders.created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Create an array of the total quantity of sales for each month
        $monthlyTotalSales = array_fill(0, 7, 0);
        foreach ($monthly_sales as $sale) {
            $monthlyTotalSales[$sale->month - 1] = (int)$sale->total_quantity;
        }

        // Get the sales information for each month for the authenticated vendor
        $the_sales = $monthlyTotalSales;

        // Get the monthly revenue information for the authenticated vendor for the current year
        $monthly_revenue = DB::table('product_orders')
            ->selectRaw('SUM(product_orders.quantity * products.offer_price * 0.9) AS total_earnings, MONTH(orders.created_at) AS month')
            ->join('orders', 'product_orders.order_id', '=', 'orders.id')
            ->join('products', 'product_orders.product_id', '=', 'products.id')
            ->where('orders.condition', '=', 'delivered')
            ->where('products.vendor_id', '=', $vendor_id)
            ->whereYear('orders.created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyTotalEarnings = array_fill(0, 7, 0);
        foreach ($monthly_revenue as $sale) {
            $monthlyTotalEarnings[$sale->month - 1] = (int)$sale->total_earnings;
        }

        $revenue = $monthlyTotalEarnings;

        $total_order = Order::whereIn('id', $all_orders)->where('condition', 'processing')->orderBy('id', 'DESC')->count();
        $orders = Order::whereIn('id', $all_orders)->orderBy('id', 'DESC')->limit(6)->get();
        $products_order = Order::whereIn('id', $all_orders)->where('condition', 'delivered')->orderBy('id', 'DESC')->get();
        $unreadCount = ChatifyMessenger::getCountUnseenMessages();
        return view('vendor.dashboard', compact('total_order', 'total_sales', 'total_earnings', 'the_sales', 'revenue', 'orders', 'unreadCount'));
    }

    public function customer()
    {
        return view('frontend.index');
    }
}
