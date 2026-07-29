<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Bannar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannarController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view banner')->only('index');
        $this->middleware('permission:create banner')->only(['create', 'store']);
        $this->middleware('permission:edit banner')->only(['edit', 'update']);
        $this->middleware('permission:delete banner')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $data = Bannar::all();
        return view('admin.bannar.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bannar.create');
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

        Bannar::create($data);

        return redirect()->route('admin.bannars.index')->with('success', 'Data created successfully!');

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
        $data = Bannar::findorfail($id);
        return view('admin.bannar.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Bannar::findOrFail($id);
        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        if ($request->hasFile('image') && $data->image) {
            Storage::disk('public')->delete($data->image);
        }

        $input = $request->all();

        if ($image) {
            $input['image'] = $image;
        }

        $data->update($input);

        return redirect()->route('admin.bannars.index')->with('success', 'Data Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $data = Bannar::findOrFail($id);

        if ($data->image) {
            Storage::disk('public')->delete($data->image);
        }
        
        $data->delete();
        return redirect()->back()->with('success', 'Data Destroy successfully!');
    }
}
