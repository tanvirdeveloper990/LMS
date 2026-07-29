<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\CustomerContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index()
    {
        $data = CustomerContact::latest()->get();
        return view('admin.contact.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        CustomerContact::create($data);
        return redirect()->route('admin.contacts.index')->with('success', 'Users Create Successfully');
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
        $data = CustomerContact::findOrFail($id);
        return view('admin.customer-contact.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = CustomerContact::findOrFail($id);
        
        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;
         if ($request->hasFile('image') && $data->image) {
            Storage::disk('public')->delete($data->image);
        }

        $input = $request->all();
 
        if ($image) {
            $input['image'] = $image;
        }
        $data->update($input);
        
        return redirect()->route('admin.contacts.index')->with('success', 'Users Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = CustomerContact::findOrFail($id);

         if ($data->image) {
            Storage::disk('public')->delete($data->image);
        }
        $data->delete();
        return redirect()->back()->with('success', 'Users Delete Successfully');
    }
}
