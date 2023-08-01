<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function autoSearch(Request $request)
    {
        $query = $request->get('term', '');
        $products = Product::where('title', 'LIKE', '%' . $query . '%')->get();

        $data = [];
        foreach ($products as $product) {
            $data[] = array('value' => $product->title, 'id' => $product->id);
        }
        if (count($data)) {
            return $data;
        } else {
            return ['value' => 'No result found', 'id' => ''];
        }
    }

    public function search(Request $request)
    {
        $ids = $request->ids ?? null;
        // dd($ids);
        $query = $request->input('query') ?? $request->slug;
        // dd($ids);
        if ($ids != null) {
            // dd($ids);
            $category_products = Product::whereIn('id', $ids)->orderByRaw('FIELD(id, ' . implode(',', $ids) . ')')->where('status', 'active')->paginate(9);
            // dd($category_products);
        } else {
            $category_products = Product::where('title', 'LIKE', '%' . $query . '%')->orderBy('id', 'DESC')->where('status', 'active')->paginate(12);
        }
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        $child_categories = Category::where(['status' => 'active', 'is_parent' => 0])->orderBy('id', 'DESC')->get();



        // $single_category = Category::where('slug', $request->slug)->value('id');
        // $parent_category = Category::where('slug', $request->slug)->value('parent_id');
        // if (!$single_category) {
        //     return redirect()->back()->with('error', 'This category is not found');
        // }
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
        if ($ids != null) {
            if ($sort == 'priceAsc') {
                $category_products = Product::whereIn('id', $ids)->whereBetween('offer_price', $price)->orderBy('offer_price', 'ASC')->paginate(9);
            } elseif ($sort == 'priceDesc') {
                $category_products = Product::whereIn('id', $ids)->whereBetween('offer_price', $price)->orderBy('offer_price', 'DESC')->paginate(9);
            } elseif ($sort == 'discAsc') {
                $category_products = Product::whereIn('id', $ids)->whereBetween('offer_price', $price)->orderBy('price', 'ASC')->paginate(9);
            } elseif ($sort == 'discDesc') {
                $category_products = Product::whereIn('id', $ids)->whereBetween('offer_price', $price)->orderBy('price', 'DESC')->paginate(9);
            } elseif ($sort == 'latest') {
                $category_products = Product::whereIn('id', $ids)->whereBetween('offer_price', $price)->orderBy('id', 'DESC')->paginate(9);
            }
        } else {
            if ($sort == 'priceAsc') {
                $category_products = Product::where('title', 'LIKE', '%' . $query . '%')->whereBetween('offer_price', $price)->orderBy('offer_price', 'ASC')->paginate(9);
            } elseif ($sort == 'priceDesc') {
                $category_products = Product::where('title', 'LIKE', '%' . $query . '%')->whereBetween('offer_price', $price)->orderBy('offer_price', 'DESC')->paginate(9);
            } elseif ($sort == 'discAsc') {
                $category_products = Product::where('title', 'LIKE', '%' . $query . '%')->whereBetween('offer_price', $price)->orderBy('price', 'ASC')->paginate(9);
            } elseif ($sort == 'discDesc') {
                $category_products = Product::where('title', 'LIKE', '%' . $query . '%')->whereBetween('offer_price', $price)->orderBy('price', 'DESC')->paginate(9);
            } elseif ($sort == 'latest') {
                $category_products = Product::where('title', 'LIKE', '%' . $query . '%')->whereBetween('offer_price', $price)->orderBy('id', 'DESC')->paginate(9);
            }
        }

        if (!empty($_GET['brand'])) {
            $brand_slug = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $brand_slug)->pluck('id')->toArray();
            $category_products = $category_products->whereIn('brand_id', $brand_ids);
        }

        if (!empty($_GET['size'])) {
            $size = $_GET['size'];
            $category_products = $category_products->where('size', $size);
        }

        $sub_category = Category::where('slug', $request->slug)->value('apparel');
        $parent_categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->get();
        // $child_categories = Category::where(['status' => 'active', 'parent_id' => $parent_category])->orderBy('id', 'DESC')->get();
        $route = 'category';
        $slug = $request->slug;
        $brands = Brand::where('status', 'active')->orderBy('title', 'ASC')->with('products')->get();

        if ($request->ajax()) {
            $view = view('frontend.layouts._single_product', compact('category_products'))->render();
            return response()->json(['html' => $view]);
        }

        return view('frontend.search_product.result_product')->with([
            'category_products' => $category_products,
            'slug' => $query,
            'child_categories' => $child_categories,
            'parent_categories' => $parent_categories,
            'brands' => $brands,
            'route' => $route,
        ]);
    }

    // Search Results

    public function searchFilter(Request $request)
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

        return \redirect()->route('search', ['slug' => $data['slug'], 'filter' => $sortByUrl . $priceUrl . $brandUrl . $sizeUrl]);
    }
}
