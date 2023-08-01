<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\MonthlyVisitor;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    public function home(Request $request)
    {
        $currentMonth = Carbon::now()->format('Y-m');

        // Get the current visitor's IP address
        $ipAddress = $request->ip();

        // Check if the visitor record for the current month and IP address already exists in the database
        $visitorData = MonthlyVisitor::where('month', $currentMonth)
            ->where('ip_address', $ipAddress)
            ->first();

        if (!$visitorData) {
            // If the visitor record doesn't exist, create a new one and save it to the database
            $sessionId = Session::getId();
            $visitorData = new MonthlyVisitor();
            $visitorData->month = $currentMonth;
            $visitorData->session_id = $sessionId;
            $visitorData->ip_address = $ipAddress;
            $visitorData->user_agent = $request->userAgent();
            $visitorData->save();
        }

        // Call the FetchMonthlyVisitors command to update the monthly visitor counts in the database
        Artisan::call('fetch:monthly-visitors');
        
        $banners = Banner::where(['status' => 'active', 'condition' => 'banner'])->orderBy('id', 'DESC')->limit('5')->get();
        // $hot_products = Product::where(['status' => 'active', 'conditions' => 'hot'])->orderBy('id', 'DESC')->limit('9')->get();
        $hot_products = Product::where(['status' => 'active', 'conditions' => 'New'])->orderBy('id', 'DESC')->limit('9')->get();
        $redeem_products = Product::where(['status' => 'active', 'conditions' => 'redeem'])->orderBy('id', 'DESC')->limit('9')->get();
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();
        return view('frontend.index')->with([
            'banners' => $banners,
            'hot_products' => $hot_products,
            'redeem_products' => $redeem_products,
            'parent_categories' => $parent_categories,
            'child_categories' => $child_categories,
        ]);
    }

   

    public function shop(Request $request)
    {
        $route = 'shop';
        $slug = $request->slug;
        $category = Category::where('slug', $slug)->value('id');
        $cats = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('title', 'ASC')->get();
        $sort = '';

        if ($request->sort != null) {
            $sort = $request->sort;
        }
        if ($sort == 'priceAsc') {
            $category_products = Product::where(['status' => 'active', 'cat_id' => $category])->orderBy('offer_price', 'ASC')->paginate(9);
        } elseif ($sort == 'priceDesc') {
            $category_products = Product::where(['status' => 'active', 'cat_id' => $category])->orderBy('offer_price', 'DESC')->paginate(9);
        } elseif ($sort == 'discAsc') {
            $category_products = Product::where(['status' => 'active', 'cat_id' => $category])->orderBy('price', 'ASC')->paginate(9);
        } elseif ($sort == 'discDesc') {
            $category_products = Product::where(['status' => 'active', 'cat_id' => $category])->orderBy('price', 'DESC')->paginate(9);
        } else {
            $category_products = Product::where(['status' => 'active', 'cat_id' => $category])->orderBy('id', 'DESC')->paginate(6);
        }
        $parent_category = Category::where(['slug' => $request->slug])->value('id');
        $child_categories = Category::where(['status' => 'active', 'parent_id' => $category])->orderBy('id', 'DESC')->get();
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();

        return view('frontend.product.shop', compact('category_products', 'route', 'slug', 'cats', 'child_categories', 'parent_category', 'parent_categories'));
    }

    public function category()
    {
        return view('frontend.shop2');
    }

    public function single_category(Request $request, $slug)
    {

        $single_category = Category::where('slug', $request->slug)->value('id');
        $parent_category = Category::where('slug', $request->slug)->value('parent_id');
        // dd($single_category);
        // dd($_GET['sortBy']);
        if (!$single_category) {
            return redirect()->back()->with('error', 'This category is not found');
        }
        $sort = '';
        $price = [];
        if (!empty($_GET['min_price']) && !empty($_GET['max_price'])) {
            $price[0] = floor($_GET['min_price']);
            $price[1] = ceil($_GET['max_price']);
        } else {
            $price[0] = minPrice();
            $price[1] = maxPrice();
        }
        if (!empty($_GET['sortBy'])) {
            $sort = $_GET['sortBy'];
        }
        if ($sort == 'priceAsc') {
            $category_products = Product::where(['child_cat_id' => $single_category, 'cat_id' => $parent_category, 'status' => 'active'])->whereBetween('offer_price', $price)->orderBy('offer_price', 'ASC')->paginate(9);
        } elseif ($sort == 'priceDesc') {
            $category_products = Product::where(['child_cat_id' => $single_category, 'cat_id' => $parent_category, 'status' => 'active'])->whereBetween('offer_price', $price)->orderBy('offer_price', 'DESC')->paginate(9);
        } elseif ($sort == 'discAsc') {
            $category_products = Product::where(['child_cat_id' => $single_category, 'cat_id' => $parent_category, 'status' => 'active'])->whereBetween('offer_price', $price)->orderBy('price', 'ASC')->paginate(9);
        } elseif ($sort == 'discDesc') {
            $category_products = Product::where(['child_cat_id' => $single_category, 'cat_id' => $parent_category, 'status' => 'active'])->whereBetween('offer_price', $price)->orderBy('price', 'DESC')->paginate(9);
        } else {
            $category_products = Product::where(['child_cat_id' => $single_category, 'cat_id' => $parent_category, 'status' => 'active'])->whereBetween('offer_price', $price)->orderBy('id', 'DESC')->paginate(9);
        }

        if (!empty($_GET['brand'])) {
            $brand_slug = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $brand_slug)->pluck('id')->toArray();
            $category_products = $category_products->whereIn('brand_id', $brand_ids);
        }


        if (!empty($_GET['size'])) {
            $size = $_GET['size'];
            $category_products = $category_products->where('size', $size);
            // dd($category_products);
        }

        $sub_category = Category::where('slug', $request->slug)->value('apparel');
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'parent_id' => $parent_category])->orderBy('id', 'DESC')->get();
        // dd(url()->full());
        $route = 'category';
        $slug = $request->slug;
        $brands = Brand::where('status', 'active')->orderBy('title', 'ASC')->with('products')->get();
        // dd($brands);

        if ($request->ajax()) {
            $view = view('frontend.layouts._single_product', compact('category_products'))->render();
            return response()->json(['html' => $view]);
        }

        return view('frontend.shop2')->with([
            'category_products' => $category_products,
            'sub_category' => $sub_category,
            'parent_category' => $parent_category,
            'parent_categories' => $parent_categories,
            'child_categories' => $child_categories,
            'route' => $route,
            'slug' => $slug,
            'brands' => $brands,
        ]);
    }

    public function shopFilter(Request $request)
    {
        $data = $request->all();
        $sortByUrl = "";
        if (!empty($data['sortBy'])) {
            $sortByUrl .= '?sortBy=' . $data['sortBy'];
        }

        //price filter
        $priceUrl = "";
        if (!empty($data['min_price']) && !empty($data['max_price'])) {
            if ($sortByUrl == "") {
                $priceUrl .= '?min_price=' . $data['min_price'] . '&max_price=' . $data['max_price'];
            } else {
                $priceUrl .= '&min_price=' . $data['min_price'] . '&max_price=' . $data['max_price'];
            }
        }

        // brand filter
        $brandUrl = "";
        if (!empty($data['brand'])) {
            foreach ($data['brand'] as $brand) {
                if (empty($brandUrl)) {
                    if ($sortByUrl == "" && $priceUrl == "") {
                        $brandUrl .= '?brand=' . $brand;
                    } else {
                        $brandUrl .= '&brand=' . $brand;
                    }
                } else {
                    $brandUrl .= ',' . $brand;
                }
            }
        }

        $sizeUrl = "";
        if (!empty($data['size'])) {
            // dd($data['size']);
            $sizeUrl .= '&size=' . $data['size'];
        }

        return \redirect()->route('single_category', ['slug' => $data['slug'], 'filter' => $sortByUrl . $priceUrl . $brandUrl . $sizeUrl]);
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();
        if (!$product) {
            return redirect()->back();
        }
        return view('frontend.product_detail', compact('product', 'parent_categories', 'child_categories'));
    }

    public function checkout()
    {
        return view('frontend.checkout');
    }

    public function wishlist()
    {
        return view('frontend.wishlist');
    }

    public function login()
    {
        return view('frontend.login');
    }
}
