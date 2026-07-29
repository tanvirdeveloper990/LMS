<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\SellerCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerCommissionController extends Controller
{
     public function __construct()
    {
        $this->middleware('permission:view commission')->only('index');
        $this->middleware('permission:create commission')->only(['create', 'store']);
        $this->middleware('permission:edit commission')->only(['edit', 'update']);
        $this->middleware('permission:delete commission')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SellerCommission::first();
        return view('admin.seller-commision.index', compact('data'));
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
        $data = SellerCommission::findOrFail($id);
        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        if ($request->hasFile('image') && $data->image) {
            Storage::disk('public')->delete($data->image);
        }

        $input = $request->all();
        if ($image) {
            $input['image'] = $image;
        }

        $data->update($input);
        return redirect()->back()->with('success', 'Data Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
        
    }
}
