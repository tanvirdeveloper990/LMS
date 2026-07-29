<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionLevel;
use Illuminate\Http\Request;

class CommissionLevelController extends Controller
{
      public function __construct()
    {
        $this->middleware('permission:view commission-level')->only('index');
        $this->middleware('permission:create commission-level')->only(['create', 'store']);
        $this->middleware('permission:edit commission-level')->only(['edit', 'update']);
        $this->middleware('permission:delete commission-level')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $data = CommissionLevel::all();
        return view('admin.commission-level.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.commission-level.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
    
        CommissionLevel::create($data);
        return redirect()->route('admin.commission-level.index')->with('success', 'Data Create Successfully');
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
        $data = CommissionLevel::findOrFail($id);
        return view('admin.commission-level.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = CommissionLevel::findOrFail($id);
       
        $input = $request->all();
        
        $data->update($input);
        return redirect()->route('admin.commission-level.index')->with('success', 'Data Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = CommissionLevel::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data Delete Successfully');
    }
}
