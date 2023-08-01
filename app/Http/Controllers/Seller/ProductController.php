<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_data = $this->product->where('vendor_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view('vendor.product.index')->with('product_data', $product_data);
    }

    public function productStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('products')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('products')->where('id', $request->id)->update(['status' => 'inactive']);
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
        $status = Shop::where('user_id', auth()->user()->id)->value('status');
        if ($status == "not verified") {
            return redirect()->back()->with('error', 'Your shop is not verified!');
        }
        return view('vendor.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->image);
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'stock' => 'numeric|nullable',
            'price' => 'numeric|required',
            'discount' => 'numeric|nullable',
            'image' => 'required',
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'size' => 'nullable',
            'condition' => 'nullable'
        ]);

        if (isset($request->multiple_photos) && $request->multiple_photos == 'on') {
            $data = $request->except(['_token']);
        } else {
            $data = $request->except(['_token', 'image']);
            if ($request->has('image')) {
                $image = $request->image;
                $file_name = uploadImage($image, 'product', '125x125');
                if ($file_name) {
                    $data['image'] = $file_name;
                } else {
                    return redirect()->back()->with('error', 'There was error in uploading image');
                }
            }
        }
        $data['slug'] = $this->product->getSlug($data['title']);
        $offer_price = ($request->price - (($request->price * $request->discount) / 100));
        $data['offer_price'] = $offer_price;
        $data['vendor_id'] = auth()->user()->id;

        $this->product->fill($data);
        $status = $this->product->save();

        if ($status) {
            if ($request->has('image')) {
                if ($this->product->image != null && file_exists(public_path() . '/uploads/product/' . $this->product->image)) {
                    $image_name_without_extension = pathinfo($this->product->image, PATHINFO_FILENAME);
                    $extension = pathinfo($this->product->image, PATHINFO_EXTENSION);
                    $new_file_name = $image_name_without_extension . '_' . $this->product->id . '.' . $extension;

                    // Get the source file path
                    $source_file_path = public_path('uploads/product/' . $this->product->image);

                    // Get the destination folder path
                    $destination_folder_path = public_path('uploads/similar_images/');
                    // Create directory if it doesn't exist
                    if (!file_exists($destination_folder_path)) {
                        mkdir($destination_folder_path, 0777, true);
                    }

                    // Get the destination file path
                    $destination_file_path = $destination_folder_path . $new_file_name;

                    // Copy the file to the new folder with the new file name
                    if (copy($source_file_path, $destination_file_path)) {
                        return redirect()->route('seller-product.index')->with('success', 'Product added successfully');
                    } else {
                        return redirect()->back()->with('error', 'There was problem in adding product');
                    }
                }
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
        $this->product = $this->product->find($id);
        if (!$this->product) {
            //message
            return redirect()->back()->with('error', 'This product is not found');
        }

        return view('vendor.product.view')
            ->with('product_data', $this->product);
    }

    public function productAttribute($id)
    {
        $this->product = $this->product->find($id);
        $productattr = ProductAttribute::where('product_id', $id)->orderBy('id', 'DESC')->get();
        if (!$this->product) {
            //message
            return redirect()->back()->with('error', 'This product is not found');
        }

        return view('vendor.product.product-attribute')
            ->with('product', $this->product)
            ->with('productattr', $productattr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->product = $this->product->find($id);
        if (!$this->product) {
            //message
            return redirect()->back()->with('error', 'This product is not found');
        }

        return view('vendor.product.create')
            ->with('product_data', $this->product);
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
        $this->product = $this->product->find($id);
        if (!$this->product) {
            return redirect()->back()->with('error', 'This product is not found');
        }

        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'stock' => 'numeric|nullable',
            'price' => 'numeric|required',
            'discount' => 'numeric|nullable',
            'image' => 'nullable',
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'size' => 'nullable',
            'condition' => 'nullable'
        ]);

        if (isset($request->multiple_photos) && $request->multiple_photos == 'on') {
            $data = $request->except(['_token']);
        } else {
            $data = $request->except(['_token', 'image']);
            if ($request->has('image')) {
                $image = $request->image;
                $file_name = uploadImage($image, 'product', '125x125');
                if ($file_name) {
                    if ($this->product->image != null && file_exists(public_path() . '/uploads/product/' . $this->product->image)) {
                        unlink(public_path() . '/uploads/product/' . $this->product->image);
                        unlink(public_path() . '/uploads/product/Thumb-' . $this->product->image);
                        if ($this->product->image != null && file_exists(public_path() . '/uploads/similar_images/' . $this->product->image . '_' . $this->product->id)) {
                            unlink(public_path() . '/uploads/similar_images/' . $this->product->image . '_' . $this->product->id);
                        }
                    }
                    $data['image'] = $file_name;
                }
            }
        }
        // dd($request->all());

        $offer_price = ($request->price - (($request->price * $request->discount) / 100));
        $data['offer_price'] = $offer_price;

        $this->product->fill($data);

        $status = $this->product->save();
        if ($status) {
            if ($request->has('image')) {
                if ($this->product->image != null && file_exists(public_path() . '/uploads/product/' . $this->product->image)) {
                    $image_name_without_extension = pathinfo($this->product->image, PATHINFO_FILENAME);
                    $extension = pathinfo($this->product->image, PATHINFO_EXTENSION);
                    $new_file_name = $image_name_without_extension . '_' . $this->product->id . '.' . $extension;

                    // Get the source file path
                    $source_file_path = public_path('uploads/product/' . $this->product->image);

                    // Get the destination folder path
                    $destination_folder_path = public_path('uploads/similar_images/');
                    // Create directory if it doesn't exist
                    if (!file_exists($destination_folder_path)) {
                        mkdir($destination_folder_path, 0777, true);
                    }

                    // Get the destination file path
                    $destination_file_path = $destination_folder_path . $new_file_name;

                    // Copy the file to the new folder with the new file name
                    if (copy($source_file_path, $destination_file_path)) {
                        return redirect()->route('seller-product.index')->with('success', 'Product added successfully');
                    } else {
                        return redirect()->back()->with('error', 'There was problem in adding product');
                    }
                }
            }
            // return redirect()->route('seller-product.index')->with('success', 'Product updated successfully');
        }
        //else {
        //     return redirect()->back()->with('error', 'Sorry! there was problem in updating product');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->product = $this->product->find($id);
        if (!$this->product) {
            return redirect()->back()->with('error', 'This product is not found');
        }

        $id = $this->product->id;
        $del = $this->product->delete();
        $image = $this->product->image;
        if ($del) {
            if ($image != null && file_exists(public_path() . '/uploads/product/' . $image)) {
                unlink(public_path() . '/uploads/product/' . $image);
                unlink(public_path() . '/uploads/product/Thumb-' . $image);
                $image_name_without_extension = pathinfo($image, PATHINFO_FILENAME);
                $extension = pathinfo($image, PATHINFO_EXTENSION);
                // dd($image_name_without_extension);
                if ($image != null && file_exists(public_path() . '/uploads/similar_images/' . $image_name_without_extension . '_' . $id . '.' . $extension)) {
                    // dd('/uploads/similar_images/' . $image_name_without_extension . '_' . $this->produ  ct->id . '.' . $extension);
                    unlink(public_path() . '/uploads/similar_images/' . $image_name_without_extension . '_' . $id . '.' . $extension);
                    return redirect()->route('seller-product.index')->with('success', 'Product deleted successfully');
                }
                //message
                // return redirect()->route('product.index')->with('success', 'product deleted successfully');
            }
            return redirect()->route('seller-product.index')->with('success', 'Product deleted successfully');
        } else {
            //message
            return redirect()->back()->with('error', 'Sorry! there was problem in deleting product');
        }
    }

    public function deleteProductAttribute($id)
    {
        $productattr = ProductAttribute::find($id);
        if (!$productattr) {
            return redirect()->back()->with('error', 'This product attribute is not found');
        }

        $del = $productattr->delete();
        if ($del) {
            return redirect()->back()->with('success', 'Product Attribute deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Sorry! there was problem in deleting product attribute');
        }
    }

    public function addProductAttribute(Request $request, $id)
    {
        // $this->validate($request, [
        //     'size' => 'nullable|string',
        //     'original_price' => 'nullable|numeric',
        //     'offer_price' => 'nullable|numeric',
        //     'stock' => 'nullable|numeric',
        // ]);

        $data = $request->all();

        foreach ($data['original_price'] as $key => $val) {
            if (!empty($val)) {
                $attribute = new ProductAttribute();
                $attribute['original_price'] = $val;
                $attribute['offer_price'] = $data['offer_price'][$key];
                $attribute['stock'] = $data['stock'][$key];
                $attribute['product_id'] = $id;
                $attribute['size'] = $data['size'][$key];
                $attribute->save();
            }
        }
        return redirect()->back()->with('success', 'Product attribute successfully added');
    }
}
