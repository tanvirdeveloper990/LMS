<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\CommonSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommonSectionController extends Controller
{
    
      public function __construct()
    {
        $this->middleware('permission:view common')->only('index');
        $this->middleware('permission:create common')->only(['create', 'store']);
        $this->middleware('permission:edit common')->only(['edit', 'update']);
        $this->middleware('permission:delete common')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CommonSection::all();
        return view('admin.common-section.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.common-section.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        if($image){
            $data['image']=$image;
        }
        CommonSection::create($data);
        return redirect()->route('admin.common-section.index')->with('success', 'Data Create Successfully');
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
        $data = CommonSection::findOrFail($id);
        return view('admin.common-section.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = CommonSection::findOrFail($id);
        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        if($request->hasFile('image') && $data->image)
        {
            Storage::disk('public')->delete($data->image);
        }
       
        $input = $request->all();
         if($image){
            $data['image']=$image;
        }

        $data->update($input);
        return redirect()->route('admin.common-section.index')->with('success', 'Data Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = CommonSection::findOrFail($id);
        if($data->image)
        {
            Storage::disk('public')->delete($data->image);
        }
        $data->delete();
        return redirect()->back()->with('success', 'Data Delete Successfully');
    }
}
