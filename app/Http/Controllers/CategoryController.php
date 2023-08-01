<?php

namespace App\Http\Controllers;

use App\Models\Apparel;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // instance variable category
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * This function fetch the data form category table
     * After fetching the data it returns to category index view with that data
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category_data = $this->category->orderBy('id', 'DESC')->get();
        return view('admin.category.index')->with('category_data', $category_data);
    }

    public function categoryStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('categories')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('categories')->where('id', $request->id)->update(['status' => 'inactive']);
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
        $parent_cats = Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();
        $apparels = Apparel::orderBy('id', 'DESC')->get();
        return view('admin.category.create', compact('parent_cats', 'apparels'));
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
        $rules = $this->category->getRules();
        $request->validate($rules);
        $data = $request->except(['_token', 'image']);
        if ($request->has('image')) {
            $image = $request->image;
            $file_name = uploadImage($image, 'category', '125x125');
            if ($file_name) {
                $data['image'] = $file_name;
                // dd($file_name);        
            } else {
                return redirect()->back()->with('error', 'There was error in uploading image');
            }
        }
        $data['slug'] = $this->category->getSlug($data['title']);
        $data['is_parent'] = $request->input('is_parent', 0);
        if ($request->is_parent == 1) {
            $data['parent_id'] = null;
        }
        // dd($data);
        $this->category->fill($data);

        $status = $this->category->save();
        if ($status) {
            return redirect()->route('category.index')->with('success', 'Category added successfully');
        } else {
            return redirect()->back()->with('error', 'There was problem in adding category');
            // return redirect()->route('category.index')->with('error', 'There was problem in adding category');
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
        $this->category = $this->category->find($id);
        $parent_cats = Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();
        $apparels = Apparel::orderBy('id', 'DESC')->get();
        if (!$this->category) {
            //message
            return redirect()->back()->with('error', 'This category is not found');
        }

        return view('admin.category.view')
            ->with('category_data', $this->category)
            ->with('parent_cats', $parent_cats)
            ->with('apparels', $apparels);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->category = $this->category->find($id);
        $parent_cats = Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();
        $apparels = Apparel::orderBy('id', 'DESC')->get();
        if (!$this->category) {
            //message
            return redirect()->back()->with('error', 'This category is not found');
        }

        return view('admin.category.create')
            ->with('category_data', $this->category)
            ->with('parent_cats', $parent_cats)
            ->with('apparels', $apparels);
    }

    /**
     * This function first validate the data from form
     * After validating it upload the image to path specified if the image is sent
     * After that it updates the data to the database
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->category = $this->category->find($id);
        if (!$this->category) {
            return redirect()->back()->with('error', 'This category is not found');
        }

        $rules = $this->category->getRules('update');
        $request->validate($rules);
        $data = $request->except(['_token', 'image']);
        if ($request->has('image')) {
            $image = $request->image;
            $file_name = uploadImage($image, 'category', '125x125');
            if ($file_name) {
                if ($this->category->image != null && file_exists(public_path() . '/uploads/category/' . $this->category->image)) {
                    unlink(public_path() . '/uploads/category/' . $this->category->image);
                    unlink(public_path() . '/uploads/category/Thumb-' . $this->category->image);
                }
                $data['image'] = $file_name;
            }
        }
        // dd($request->all());

        if ($request->is_parent == 1) {
            $data['parent_id'] = null;
        }

        $data['is_parent'] = $request->input('is_parent', 0);
        $this->category->fill($data);

        $status = $this->category->save();
        if ($status) {
            return redirect()->route('category.index')->with('success', 'category updated successfully');
        } else {
            return redirect()->back()->with('error', 'Sorry! there was problem in updating category');
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
        $this->category = $this->category->find($id);
        $child_cat_id = Category::where('parent_id', $id)->pluck('id');
        if (!$this->category) {
            return redirect()->back()->with('error', 'This category is not found');
        }

        $del = $this->category->delete();
        $image = $this->category->image;
        if ($del) {
            if ($image != null && file_exists(public_path() . '/uploads/category/' . $image)) {
                unlink(public_path() . '/uploads/category/' . $image);
                unlink(public_path() . '/uploads/category/Thumb-' . $image);
                //message
                // return redirect()->route('category.index')->with('success', 'category deleted successfully');
            }
            if (count($child_cat_id) > 0) {
                Category::shiftChild($child_cat_id);
            }
            return redirect()->route('category.index')->with('success', 'Category deleted successfully');
        } else {
            //message
            return redirect()->back()->with('error', 'Sorry! there was problem in deleting category');
        }
    }

    public function getChildByParentID(Request $request, $id)
    {
        $category = Category::find($request->id);
        if ($category) {
            $child_id = Category::getChildByParentID($request->id);
            if (count($child_id) <= 0) {
                return response()->json(['status' => false, 'data' => null, 'msg' => '']);
            }
            return response()->json(['status' => true, 'data' => $child_id, 'msg' => '']);
        } else {
            return response()->json(['status' => false, 'data' => null, 'msg' => '']);
        }
    }
}
