<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view subcategory')->only('index');
        $this->middleware('permission:create subcategory')->only(['create', 'store']);
        $this->middleware('permission:edit subcategory')->only(['edit', 'update']);
        $this->middleware('permission:delete subcategory')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCategories = SubCategory::with('category')->orderBy('serial')->orderBy('id')->paginate(10);
        return view('admin.categories.subcategories.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get(); // Active categories for dropdown
        return view('admin.categories.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_categories')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id);
                }),
            ],

        ]);

        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        $maxSerial = SubCategory::max('serial');

        SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'serial' => $maxSerial ? $maxSerial + 1 : 1,
            'slug' => Str::slug($request->name),
            'image' => $image,
            'status' => $request->status ?? 1,
            'show_home_page' => $request->has('show_home_page') ? 1 : 0,
            'show_in_header' => $request->has('show_in_header') ? 1 : 0,
            'popular_category' => $request->has('popular_category') ? 1 : 0,
        ]);

        return redirect()->route('admin.subcategories.index')->with('success', 'SubCategory created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subcategory)
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.categories.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_categories')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id);
                })->ignore($subcategory->id),
            ],

        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
            'show_home_page' => $request->has('show_home_page') ? 1 : 0,
            'show_in_header' => $request->has('show_in_header') ? 1 : 0,
            'popular_category' => $request->has('popular_category') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            if ($subcategory->image) {
                Storage::disk('public')->delete($subcategory->image);
            }
            $data['image'] = ImageHelper::uploadImage($request->file('image'));
        }

        $subcategory->update($data);

        return redirect()->route('admin.subcategories.index')->with('success', 'SubCategory updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subcategory)
    {
        if ($subcategory->image && Storage::disk('public')->exists($subcategory->image)) {
            Storage::disk('public')->delete($subcategory->image);
        }

        $subcategory->delete();

        return redirect()->route('admin.subcategories.index')->with('success', 'SubCategory deleted successfully!');
    }

    /**
     * Update serial order via drag-drop (AJAX).
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:sub_categories,id',
        ]);

        foreach ($request->order as $index => $id) {
            SubCategory::where('id', $id)->update(['serial' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}