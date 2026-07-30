<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;

class EbookProductController extends Controller
{
    protected $type = 'ebook';

    public function __construct()
    {
        $this->middleware('permission:view product')->only('index');
        $this->middleware('permission:create product')->only(['create', 'store']);
        $this->middleware('permission:edit product')->only(['edit', 'update']);
        $this->middleware('permission:delete product')->only('destroy');
    }

    public function index(Request $request)
    {
        $query = Product::where('type', $this->type)
            ->with(['category', 'subCategory', 'subSubCategory', 'brand']);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $products = $query->latest()->paginate(10);

        // ✅ শুধু ebook type-এর ক্যাটাগরি দেখাবে
        $categories = Category::where('status', 1)->where('type', 'ebook')->get();

        return view('admin.products.ebook-products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->where('type', 'ebook')->get();
        $brands = Brand::where('status', 1)->get();
        $colors = Color::where('status', 1)->get();
        $sizes = Size::where('status', 1)->get();
        return view('admin.products.ebook-products.create', compact('categories', 'brands', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'sub_sub_category_id' => 'nullable|exists:sub_sub_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255|unique:products,name',
            'sku' => 'required|string|max:255|unique:products,sku',
            'status' => 'required|in:0,1',
            'regular_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'point' => 'nullable|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured_image_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured_image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::create([
            'type' => $this->type,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_sub_category_id' => $request->sub_sub_category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status,
            'purchase_price' => $request->purchase_price,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'point' => $request->point ?? 0,
            'unit' => $request->unit,
            'review_video' => $request->review_video,
            'stock' => $request->stock ?? 0,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'is_popular' => $request->has('is_popular') ? 1 : 0,
            'is_new' => $request->has('is_new') ? 1 : 0,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if ($img->isValid()) {
                    $path = ImageHelper::uploadImage($img);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $path,
                    ]);
                }
            }
        }

        if ($request->hasFile('featured_image_1')) {
            $product->update(['featured_image_1' => ImageHelper::uploadImage($request->file('featured_image_1'))]);
        }
        if ($request->hasFile('featured_image_2')) {
            $product->update(['featured_image_2' => ImageHelper::uploadImage($request->file('featured_image_2'))]);
        }

        return redirect()->route('admin.ebook-products.index')->with('success', 'Ebook product created successfully!');
    }

    public function edit(Product $ebook_product)
    {
        $categories = Category::where('status', 1)->where('type', 'ebook')->get();
        $brands = Brand::where('status', 1)->get();
        $colors = Color::where('status', 1)->get();
        $sizes = Size::where('status', 1)->get();
        $subcategories = SubCategory::where('category_id', $ebook_product->category_id)->get();
        $subsubcategories = SubSubCategory::where('sub_category_id', $ebook_product->sub_category_id)->get();

        return view('admin.products.ebook-products.edit', [
            'product' => $ebook_product,
            'categories' => $categories,
            'brands' => $brands,
            'colors' => $colors,
            'sizes' => $sizes,
            'subcategories' => $subcategories,
            'subsubcategories' => $subsubcategories,
        ]);
    }

    public function update(Request $request, Product $ebook_product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'sub_sub_category_id' => 'nullable|exists:sub_sub_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255|unique:products,name,' . $ebook_product->id,
            'sku' => 'required|string|max:255|unique:products,sku,' . $ebook_product->id,
            'status' => 'required|in:0,1',
            'regular_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'point' => 'nullable|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured_image_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured_image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $ebook_product->update([
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_sub_category_id' => $request->sub_sub_category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status,
            'unit' => $request->unit,
            'purchase_price' => $request->purchase_price,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'point' => $request->point ?? 0,
            'review_video' => $request->review_video,
            'stock' => $request->stock ?? 0,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'is_popular' => $request->has('is_popular') ? 1 : 0,
            'is_new' => $request->has('is_new') ? 1 : 0,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = ImageHelper::uploadImage($img);
                ProductImage::create([
                    'product_id' => $ebook_product->id,
                    'image' => $path,
                ]);
            }
        }

        if ($request->hasFile('featured_image_1')) {
            $path = ImageHelper::uploadImage($request->file('featured_image_1'));
            $ebook_product->update(['featured_image_1' => $path]);
        }
        if ($request->hasFile('featured_image_2')) {
            $path = ImageHelper::uploadImage($request->file('featured_image_2'));
            $ebook_product->update(['featured_image_2' => $path]);
        }

        return redirect()->route('admin.ebook-products.index')->with('success', 'Ebook product updated successfully!');
    }

    public function destroy(Product $ebook_product)
    {
        foreach ($ebook_product->images as $img) {
            if (Storage::disk('public')->exists($img->image)) Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        foreach ($ebook_product->variants as $variant) {
            if (!empty($variant->image) && Storage::disk('public')->exists($variant->image)) {
                Storage::disk('public')->delete($variant->image);
            }
        }

        $ebook_product->variants()->delete();
        $ebook_product->delete();

        return redirect()->route('admin.ebook-products.index')->with('success', 'Ebook product deleted successfully!');
    }

    public function removeImage(Request $request, $id)
    {
        $image = ProductImage::findOrFail($id);

        if (Storage::exists($image->image)) {
            Storage::delete($image->image);
        }

        $image->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Image removed successfully!'
        ]);
    }
}