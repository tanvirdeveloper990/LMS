<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ColorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view product')->only('index');
        $this->middleware('permission:create product')->only(['create', 'store']);
        $this->middleware('permission:edit product')->only(['edit', 'update']);
        $this->middleware('permission:delete product')->only('destroy');
    }

    public function index()
    {
        $colors = Color::latest()->paginate(10);
        return view('admin.products.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.products.colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|unique:colors,name|max:255',
            'code'   => 'nullable|string|max:10',
            'status' => 'required|in:0,1',
            'image'  => 'nullable',
        ]);

        $image = $request->hasFile('image')
            ? ImageHelper::uploadImage($request->file('image'))
            : null;

        Color::create([
            'name'   => $request->name,
            'code'   => $request->code,
            'status' => $request->status,
            'image'  => $image,
        ]);

        return redirect()->route('admin.colors.index')->with('success', 'Color created successfully!');
    }

    public function edit(Color $color)
    {
        return view('admin.products.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name'   => 'required|string|unique:colors,name,' . $color->id . '|max:255',
            'code'   => 'nullable|string|max:10',
            'status' => 'required|in:0,1',
            'image'  => 'nullable',
        ]);

        $image = $color->image;

        if ($request->hasFile('image')) {
            // পুরনো image থাকলে ডিলিট করো
            if ($color->image && Storage::disk('public')->exists($color->image)) {
                Storage::disk('public')->delete($color->image);
            }
            $image = ImageHelper::uploadImage($request->file('image'));
        }

        // Remove image checkbox চাপলে
        if ($request->boolean('remove_image') && !$request->hasFile('image')) {
            if ($color->image && Storage::disk('public')->exists($color->image)) {
                Storage::disk('public')->delete($color->image);
            }
            $image = null;
        }

        $color->update([
            'name'   => $request->name,
            'code'   => $request->code,
            'status' => $request->status,
            'image'  => $image,
        ]);

        return redirect()->route('admin.colors.index')->with('success', 'Color updated successfully!');
    }

    public function destroy(Color $color)
    {
        if ($color->image && Storage::disk('public')->exists($color->image)) {
            Storage::disk('public')->delete($color->image);
        }

        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'Color deleted successfully!');
    }
}