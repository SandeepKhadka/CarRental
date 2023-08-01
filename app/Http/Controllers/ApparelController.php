<?php

namespace App\Http\Controllers;

use App\Models\Apparel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApparelController extends Controller
{
    protected $apparel;

    public function __construct(Apparel $apparel)
    {
        $this->apparel = $apparel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apparel_data = $this->apparel->orderBy('id', 'DESC')->get();
        return view('admin.apparel.index')->with('apparel_data', $apparel_data);
    }

    public function apparelStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('apparels')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('apparels')->where('id', $request->id)->update(['status' => 'inactive']);
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
        return view('admin.apparel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
        ]);

        $order_id = $this->apparel->all();
        $data = $request->except(['_token']);
        $data['order_id'] = getOrderId($order_id);
        $this->apparel->fill($data);
        $status = $this->apparel->save();
        if ($status) {
            return redirect()->route('apparel.index')->with('success', 'Apparel added successfully');
        } else {
            return redirect()->back()->with('error', 'There was problem in adding apparel');
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
        $this->apparel = $this->apparel->find($id);
        if (!$this->apparel) {
            //message
            return redirect()->back()->with('error', 'This apparel is not found');
        }

        return view('admin.apparel.view')
            ->with('apparel_data', $this->apparel);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->apparel = $this->apparel->find($id);
        if (!$this->apparel) {
            //message
            return redirect()->back()->with('error', 'This banner is not found');
        }

        return view('admin.apparel.create')
            ->with('apparel_data', $this->apparel);
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
        $this->apparel = $this->apparel->find($id);
        if (!$this->apparel) {
            return redirect()->back()->with('error', 'This apparel is not found');
        }

        $this->validate($request, [
            'title' => 'string|required',
            'order_id' => 'required|integer|gt:0',
        ]);

        $data = $request->except(['_token']);
        $this->apparel->fill($data);
        $status = $this->apparel->save();
        if ($status) {
            return redirect()->route('apparel.index')->with('success', 'Apparel updated successfully');
        } else {
            return redirect()->back()->with('error', 'There was problem in updating apparel');
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
        $this->apparel = $this->apparel->find($id);
        if (!$this->apparel) {
            return redirect()->back()->with('error', 'This apparel is not found');
        }

        $del = $this->apparel->delete();
        if ($del) {
            return redirect()->route('apparel.index')->with('success', 'Apparel deleted successfully');
        } else {
            //message
            return redirect()->back()->with('error', 'Sorry! there was problem in deleting apparel');
        }
    }
}
