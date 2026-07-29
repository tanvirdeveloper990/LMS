<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
     public function __construct()
    {
        $this->middleware('permission:view offer')->only('index');
        $this->middleware('permission:create offer')->only(['create', 'store']);
        $this->middleware('permission:edit offer')->only(['edit', 'update']);
        $this->middleware('permission:delete offer')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Offer::first();
        return view('admin.offer.index', compact('data'));
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
         $data=Offer::findOrFail($id);

        $offer_image = $request->hasFile('offer_image') ? ImageHelper::uploadImage($request->file('offer_image')) : null;

        if($request->hasFile('offer_image') && $data->offer_image){
            Storage::disk('public')->delete($data->offer_image);
        }

        $input = $request->all();

      if($offer_image){
            $input['offer_image']=$offer_image;
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
