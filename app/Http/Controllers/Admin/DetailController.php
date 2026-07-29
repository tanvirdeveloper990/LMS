<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Detail::first();
        return view('admin.details.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Detail::findOrFail($id);
        $icon1 = $request->hasFile('icon1') ? ImageHelper::uploadImage($request->file('icon1')) : null;
        $icon2 = $request->hasFile('icon2') ? ImageHelper::uploadImage($request->file('icon2')) : null;
        $icon3 = $request->hasFile('icon3') ? ImageHelper::uploadImage($request->file('icon3')) : null;
        $icon4 = $request->hasFile('icon4') ? ImageHelper::uploadImage($request->file('icon4')) : null;

        if ($request->hasFile('icon1') && $data->icon1) {
            Storage::disk('public')->delete($data->icon1);
        }
        if ($request->hasFile('icon2') && $data->icon2) {
            Storage::disk('public')->delete($data->icon2);
        }
        if ($request->hasFile('icon3') && $data->icon3) {
            Storage::disk('public')->delete($data->icon3);
        }
        if ($request->hasFile('icon4') && $data->icon4) {
            Storage::disk('public')->delete($data->icon4);
        }

        $input = $request->all();

        if ($icon1) {
            $input['icon1'] = $icon1;
        }
        if ($icon2) {
            $input['icon2'] = $icon2;
        }
        if ($icon3) {
            $input['icon3'] = $icon3;
        }
        if ($icon4) {
            $input['icon4'] = $icon4;
        }

        $data->update($input);

        return redirect()->back()->with('success', 'Data Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      
    }
}
