<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PreparationCategoryController extends Controller
{
    protected $type = 'preparation';

    public function __construct()
    {
        $this->middleware('permission:view category')->only('index');
        $this->middleware('permission:create category')->only(['create', 'store']);
        $this->middleware('permission:edit category')->only(['edit', 'update']);
        $this->middleware('permission:delete category')->only('destroy');
    }

    public function index()
    {
        $categories = Category::where('type', $this->type)
            ->orderBy('serial')->orderBy('id')->paginate(10);

        return view('admin.categories.preparation-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.preparation-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|string|max:255',
        ]);

        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;
        $maxSerial = Category::where('type', $this->type)->max('serial');

        Category::create([
            'name'   => $request->name,
            'text'   => $request->text,
            'slug'   => Str::slug($request->name),
            'type'   => $this->type,
            'image'  => $image,
            'serial' => $maxSerial ? $maxSerial + 1 : 1,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.preparation-categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.preparation-categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'   => 'required|string|max:255|unique:categories,name,' . $category->id,
            'status' => 'required|in:0,1',
        ]);

        $data = [
            'name'   => $request->name,
            'text'   => $request->text,
            'slug'   => Str::slug($request->name),
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = ImageHelper::uploadImage($request->file('image'));
        }

        $category->update($data);

        return redirect()->route('admin.preparation-categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.preparation-categories.index')->with('success', 'Category deleted successfully!');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'required|integer|exists:categories,id',
        ]);

        foreach ($request->order as $index => $id) {
            Category::where('id', $id)->where('type', $this->type)->update(['serial' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}