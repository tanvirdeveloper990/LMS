<?php

namespace App\Http\Controllers;

use App\Models\Shiping;
use Illuminate\Http\Request;

class ShipingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $data = Shiping::all();
        return view('admin.shiping.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shiping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        if ($image) {
            $data['image'] = $image;
        }

        Shiping::create($data);

        return redirect()->route('admin.shiping.index')->with('success', 'Data created successfully!');

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
        $data = Shiping::findorfail($id);
        return view('admin.shiping.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Shiping::findOrFail($id);
        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        if ($request->hasFile('image') && $data->image) {
            Storage::disk('public')->delete($data->image);
        }

        $input = $request->all();

        if ($image) {
            $input['image'] = $image;
        }

        $data->update($input);

        return redirect()->route('admin.shiping.index')->with('success', 'Data Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $data = Shiping::findOrFail($id);

        if ($data->image) {
            Storage::disk('public')->delete($data->image);
        }
        
        $data->delete();
        return redirect()->back()->with('success', 'Data Destroy successfully!');
    }
}
