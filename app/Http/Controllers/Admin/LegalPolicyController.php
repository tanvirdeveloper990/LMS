<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ImageHelper;
use App\Models\LegalPolicy;
use Illuminate\Support\Facades\Storage;

class LegalPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = LegalPolicy::first();
        return view('admin.legal-policy.index',compact('data'));
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
        $data = LegalPolicy::findOrFail($id);

        
        // $header_logo = $request->hasFile('header_logo') ? ImageHelper::uploadImage($request->file('header_logo')) : null;

        
        // if ($request->hasFile('header_logo') && $data->header_logo) {
        //     Storage::disk('public')->delete($data->header_logo);
        // }
        
        $input = $request->all();
        

        // if($header_logo){
        //     $input['header_logo'] = $header_logo;
        // }

        
        $data->update($input);

        return redirect()->back()->with('success', 'Information updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
