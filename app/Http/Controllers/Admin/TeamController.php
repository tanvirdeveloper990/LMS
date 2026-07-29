<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view team')->only('index');
        $this->middleware('permission:create team')->only(['create', 'store']);
        $this->middleware('permission:edit team')->only(['edit', 'update']);
        $this->middleware('permission:delete team')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $data = Team::all();
        return view('admin.team.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.team.create');
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
        Team::create($data);
        return redirect()->route('admin.teams.index')->with('success', 'Data Create Successfully');
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
        $data = Team::findOrFail($id);
        return view('admin.cteam.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Team::findOrFail($id);
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
        return redirect()->route('admin.teams.index')->with('success', 'Data Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Team::findOrFail($id);
        if($data->image)
        {
            Storage::disk('public')->delete($data->image);
        }
        $data->delete();
        return redirect()->back()->with('success', 'Data Delete Successfully');
    }
}
