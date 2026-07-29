<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\HowToBuy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HowToBuyController extends Controller
{
     /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $data = HowToBuy::all();
        return view('admin.howto-buy.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.howto-buy.create');
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
        HowToBuy::create($data);
        return redirect()->route('admin.how-to-buy.index')->with('success', 'Data Create Successfully');
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
        $data = HowToBuy::findOrFail($id);
        return view('admin.howto-buy.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = HowToBuy::findOrFail($id);
        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        if($request->hasFile('image') && $data->image)
        {
            Storage::disk('public')->delete($data->image);
        }
       
        $input = $request->all();
         if($image){
            $input['image']=$image;
        }

        $data->update($input);
        return redirect()->route('admin.how-to-buy.index')->with('success', 'Data Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = HowToBuy::findOrFail($id);
        if($data->image)
        {
            Storage::disk('public')->delete($data->image);
        }
        $data->delete();
        return redirect()->back()->with('success', 'Data Delete Successfully');
    }
}
