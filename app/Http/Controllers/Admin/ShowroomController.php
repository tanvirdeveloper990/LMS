<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showroom;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShowroomController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $showrooms = Showroom::latest()->paginate(10);
        return view('admin.showroom.index', compact('showrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.showroom.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $image = $request->hasFile('image')
            ? ImageHelper::uploadImage($request->file('image'))
            : null;

        Showroom::create([
            'name'            => $data['name'],
            'email'           => $data['email'],
            'phone'           => $data['phone'],
            'address'         => $data['address'],
            'image'           => $image,
            'gallery_images'  => $this->storeGalleryImages($request),
            'opening_hours'   => $data['opening_hours'],
            'opening_time'    => $data['opening_time'],
            'description'     => $data['description'],
            'maps'            => $data['maps'],
            'showroom_video'  => $data['showroom_video'],
            'status'          => $data['status'],
        ]);

        return redirect()->route('admin.showroom.index')->with('success', 'Showroom created successfully!');
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
        $showroom = Showroom::findOrFail($id);
        return view('admin.showroom.edit', compact('showroom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $showroom = Showroom::findOrFail($id);

        $data = $this->validateData($request);

        $image = $showroom->image;

        if ($request->hasFile('image')) {
            if ($showroom->image && Storage::disk('public')->exists($showroom->image)) {
                Storage::disk('public')->delete($showroom->image);
            }
            $image = ImageHelper::uploadImage($request->file('image'));
        }

        if ($request->boolean('remove_image') && !$request->hasFile('image')) {
            if ($showroom->image && Storage::disk('public')->exists($showroom->image)) {
                Storage::disk('public')->delete($showroom->image);
            }
            $image = null;
        }

        // ✅ Gallery: keep the ones the user didn't remove, delete the removed ones, append new uploads
        $kept    = collect($request->input('existing_gallery', []))->values()->all();
        $removed = array_diff($showroom->gallery_images ?? [], $kept);
        foreach ($removed as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
        $galleryImages = array_values(array_merge($kept, $this->storeGalleryImages($request)));

        $showroom->update([
            'name'            => $data['name'],
            'email'           => $data['email'],
            'phone'           => $data['phone'],
            'address'         => $data['address'],
            'image'           => $image,
            'gallery_images'  => $galleryImages,
            'opening_hours'   => $data['opening_hours'],
            'opening_time'    => $data['opening_time'],
            'description'     => $data['description'],
            'maps'            => $data['maps'],
            'showroom_video'  => $data['showroom_video'],
            'status'          => $data['status'],
        ]);

        return redirect()->route('admin.showroom.index')->with('success', 'Showroom updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $showroom = Showroom::findOrFail($id);

        if ($showroom->image && Storage::disk('public')->exists($showroom->image)) {
            Storage::disk('public')->delete($showroom->image);
        }

        foreach ($showroom->gallery_images ?? [] as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $showroom->delete();

        return redirect()->route('admin.showroom.index')->with('success', 'Showroom deleted successfully!');
    }

    /* -------------------- helpers -------------------- */

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'nullable|email|max:255',
            'phone'             => 'nullable|string|max:30',
            'address'           => 'nullable|string|max:500',
            'image'             => 'nullable',
            'gallery_images.*'  => 'nullable|image',
            'opening_hours'     => 'nullable|string|max:255',
            'opening_time'      => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'maps'              => 'nullable|string',
            'showroom_video'    => 'nullable|string',
            'status'            => 'required|in:0,1',
        ]);
    }

    private function storeGalleryImages(Request $request): array
    {
        $paths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $paths[] = ImageHelper::uploadImage($file);
                }
            }
        }
        return $paths;
    }
}