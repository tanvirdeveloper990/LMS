<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\CustomerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view customer-review')->only('index');
        $this->middleware('permission:create customer-review')->only(['create', 'store']);
        $this->middleware('permission:edit customer-review')->only(['edit', 'update']);
        $this->middleware('permission:delete customer-review')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $data = CustomerReview::latest()->get();
       return view('admin.customer.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data= $request->all();

        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        if($image){
            $data['image']=$image;
        }

        CustomerReview::create($data);
        return redirect()->route('admin.customer-review.index')->with('success', 'Data created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = CustomerReview::findOrFail($id);
         return view('admin.customer.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data=CustomerReview::findOrFail($id);

        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        if($request->hasFile('image') && $data->image){
            Storage::disk('public')->delete($data->image);
        }

        $input = $request->all();
        if($image){
            $input['image']=$image;
        }

        $data->update($input);
        return redirect()->route('admin.customer-review.index')->with('success', 'Data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $data= CustomerReview::findOrFail($id);

        if($data->image){
            Storage::disk('public')->delete($data->image);
        }

        $data->delete();

        return redirect()->route('admin.customer-review.index')->with('success', 'Data deleted successfully!');
    }
}
