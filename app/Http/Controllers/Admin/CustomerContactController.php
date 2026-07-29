<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerContactController extends Controller
{

    
      public function __construct()
    {
        $this->middleware('permission:view customer')->only('index');
        $this->middleware('permission:create customer')->only(['create', 'store']);
        $this->middleware('permission:edit customer')->only(['edit', 'update']);
        $this->middleware('permission:delete customer')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::latest()->get();
        return view('admin.customer-contact.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customer-contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        User::create($data);
        return redirect()->route('admin.customer-contact.index')->with('success', 'Users Create Successfully');
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
        $data = User::findOrFail($id);
        return view('admin.customer-contact.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = User::findOrFail($id);
        
        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;
         if ($request->hasFile('image') && $data->image) {
            Storage::disk('public')->delete($data->image);
        }

        $input = $request->all();
 
        if ($image) {
            $input['image'] = $image;
        }
        $data->update($input);
        
        return redirect()->route('admin.customer-contact.index')->with('success', 'Users Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::findOrFail($id);

         if ($data->image) {
            Storage::disk('public')->delete($data->image);
        }
        $data->delete();
        return redirect()->back()->with('success', 'Users Delete Successfully');
    }
}
