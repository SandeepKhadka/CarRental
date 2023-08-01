<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{

    // instance variable banner
    protected $banner;

    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner_data = $this->banner->orderBy('id', 'DESC')->get(); //Fetching all banner data
        return view('admin.banner.index')->with('banner_data', $banner_data); // returning to banner index view
    }

    // function to change banner status
    public function bannerStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('banners')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('banners')->where('id', $request->id)->update(['status' => 'inactive']);
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
        return view('admin.banner.create');
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
        $rules = $this->banner->getRules(); //getting rules
        $request->validate($rules); //validating ruled
        $data = $request->except(['_token', 'image']);
        // $data = $request->except(['_token']);
        if ($request->has('image')) {
            $image = $request->image;
            $file_name = uploadImage($image, 'banner', '125x125');
            if ($file_name) {
                $data['image'] = $file_name;
                // dd($file_name);        
            } else {
                return redirect()->back()->with('error', 'There was error in uploading image');
            }
        }
        $data['slug'] = $this->banner->getSlug($data['title']);
        // dd($data);
        $this->banner->fill($data);

        $status = $this->banner->save();
        if ($status) {
            return redirect()->route('banner.index')->with('success', 'Banner added successfully');
        } else {
            return redirect()->back()->with('error', 'There was problem in adding banner');
            // return redirect()->route('banner.index')->with('error', 'There was problem in adding banner');
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
        $this->banner = $this->banner->find($id);
        if (!$this->banner) {
            //message
            return redirect()->back()->with('error', 'This banner is not found');
        }

        return view('admin.banner.view')
            ->with('banner_data', $this->banner);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->banner = $this->banner->find($id);
        if (!$this->banner) {
            //message
            return redirect()->back()->with('error', 'This banner is not found');
        }

        return view('admin.banner.create')
            ->with('banner_data', $this->banner);
    }

    /**
     * This function first validate the data from form
     * After validating it upload the image to path specified if there is image sent
     * After that it update the data to the database
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->banner = $this->banner->find($id);
        if (!$this->banner) {
            return redirect()->back()->with('error', 'This banner is not found');
        }

        $rules = $this->banner->getRules('update');
        $request->validate($rules);
        $data = $request->except(['_token', 'image']);
        if ($request->has('image')) {
            $image = $request->image;
            $file_name = uploadImage($image, 'banner', '125x125');
            if ($file_name) {
                if ($this->banner->image != null && file_exists(public_path() . '/uploads/banner/' . $this->banner->image)) {
                    unlink(public_path() . '/uploads/banner/' . $this->banner->image);
                    unlink(public_path() . '/uploads/banner/Thumb-' . $this->banner->image);
                }
                $data['image'] = $file_name;
            }
        }

        $this->banner->fill($data);

        $status = $this->banner->save();
        if ($status) {
            return redirect()->route('banner.index')->with('success', 'Banner updated successfully');
        } else {
            return redirect()->back()->with('error', 'Sorry! there was problem in updating banner');
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
        $this->banner = $this->banner->find($id);
        if (!$this->banner) {
            return redirect()->back()->with('error', 'This banner is not found');
        }

        $del = $this->banner->delete();
        $image = $this->banner->image;
        if ($del) {
            if ($image != null && file_exists(public_path() . '/uploads/banner/' . $image)) {
                unlink(public_path() . '/uploads/banner/' . $image);
                unlink(public_path() . '/uploads/banner/Thumb-' . $image);
                //message
                return redirect()->route('banner.index')->with('success', 'Banner deleted successfully');
            } else {
                //message
                return redirect()->back()->with('error', 'Sorry! there was problem in deleting banner');
            }
        }
    }
}
