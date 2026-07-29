<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\AboutUS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
      public function __construct()
    {
        $this->middleware('permission:view about')->only('index');
        $this->middleware('permission:create about')->only(['create', 'store']);
        $this->middleware('permission:edit about')->only(['edit', 'update']);
        $this->middleware('permission:delete about')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AboutUS::first();
        return view('admin.about-us.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $data=AboutUS::findOrFail($id);

        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        if($request->hasFile('image') && $data->image){
            Storage::disk('public')->delete($data->image);
        }

        $input = $request->all();

      if($image){
            $input['image']=$image;
        }

        $data->update($input);

        return redirect()->back()->with('success', 'Data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
