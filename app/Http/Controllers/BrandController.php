<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    // instance variable brand
    protected $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * This function first fetch all brand data
     * After that it redirects to brand index view with that brand data
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand_data = $this->brand->orderBy('id', 'DESC')->get();
        return view('admin.brand.index')->with('brand_data', $brand_data);
    }

    // function to update brand status
    public function brandStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('brands')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('brands')->where('id', $request->id)->update(['status' => 'inactive']);
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
        return view('admin.brand.create');
    }

    /**
     * This function first validate the data from form
     * After validating it upload the image to path specified
     * After that it saves the data to the database
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->brand->getRules();
        $request->validate($rules);
        $data = $request->except(['_token', 'image']);
        if ($request->has('image')) {
            $image = $request->image;
            $file_name = uploadImage($image, 'brand', '125x125');
            if ($file_name) {
                $data['image'] = $file_name;
                // dd($file_name);        
            } else {
                return redirect()->back()->with('error', 'There was error in uploading image');
            }
        }
        $data['slug'] = $this->brand->getSlug($data['title']);
        // dd($data);
        $this->brand->fill($data);

        $status = $this->brand->save();
        if ($status) {
            return redirect()->route('brand.index')->with('success', 'Brand added successfully');
        } else {
            return redirect()->back()->with('error', 'There was problem in adding brand');
            // return redirect()->route('brand.index')->with('error', 'There was problem in adding brand');
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
        $this->brand = $this->brand->find($id);
        if (!$this->brand) {
            //message
            return redirect()->back()->with('error', 'This brand is not found');
        }

        return view('admin.brand.view')
            ->with('brand_data', $this->brand);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->brand = $this->brand->find($id);
        if (!$this->brand) {
            //message
            return redirect()->back()->with('error', 'This brand is not found');
        }

        return view('admin.brand.create')
            ->with('brand_data', $this->brand);
    }

    /**
     * This function first validate the data from form
     * After validating it upload the image to path specified if image is sent
     * After that it updates the data to the database
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->brand = $this->brand->find($id);
        if (!$this->brand) {
            return redirect()->back()->with('error', 'This brand is not found');
        }

        $rules = $this->brand->getRules('update');
        $request->validate($rules);
        $data = $request->except(['_token', 'image']);
        if ($request->has('image')) {
            $image = $request->image;
            $file_name = uploadImage($image, 'brand', '125x125');
            if ($file_name) {
                if ($this->brand->image != null && file_exists(public_path() . '/uploads/brand/' . $this->brand->image)) {
                    unlink(public_path() . '/uploads/brand/' . $this->brand->image);
                    unlink(public_path() . '/uploads/brand/Thumb-' . $this->brand->image);
                }
                $data['image'] = $file_name;
            }
        }

        $this->brand->fill($data);

        $status = $this->brand->save();
        if ($status) {
            return redirect()->route('brand.index')->with('success', 'Brand updated successfully');
        } else {
            return redirect()->back()->with('error', 'Sorry! there was problem in updating brand');
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
        $this->brand = $this->brand->find($id);
        if (!$this->brand) {
            return redirect()->back()->with('error', 'This brand is not found');
        }

        $del = $this->brand->delete();
        $image = $this->brand->image;
        if ($del) {
            if ($image != null && file_exists(public_path() . '/uploads/brand/' . $image)) {
                unlink(public_path() . '/uploads/brand/' . $image);
                unlink(public_path() . '/uploads/brand/Thumb-' . $image);
                //message
                return redirect()->route('brand.index')->with('success', 'Brand deleted successfully');
            }
            return redirect()->route('brand.index')->with('success', 'Brand deleted successfully');
        } else {
            //message
            return redirect()->back()->with('error', 'Sorry! there was problem in deleting brand');
        }
    }
}
