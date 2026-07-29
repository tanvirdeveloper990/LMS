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
use App\Models\Vendor;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;

class ProductController extends Controller
{
     public function __construct()
{
    // Product permissions
    $this->middleware('permission:view product')->only('index');
    $this->middleware('permission:create product')->only(['create', 'store']);
    $this->middleware('permission:edit product')->only(['edit', 'update']);
    $this->middleware('permission:delete product')->only('destroy');

    $this->middleware('permission:view seller-product')->only('indexSeller');
    $this->middleware('permission:create seller-product')->only(['createSeller', 'storeSeller']);
    $this->middleware('permission:edit seller-product')->only(['editSeller', 'updateSeller']);
    $this->middleware('permission:delete seller-product')->only('destroySeller');
}


  public function index(Request $request)
{
    $query = Product::with(['category', 'subCategory', 'subSubCategory', 'brand']);

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
    $categories = Category::where('status', 1)->get();

    return view('admin.products.index', compact('products', 'categories'));
}

public function sellerProduct(Request $request)
{
    $query = Product::with(['category', 'subCategory', 'subSubCategory', 'brand', 'vendor'])
        ->whereNotNull('vendor_id');

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }
    if ($request->filled('vendor_id')) {
        $query->where('vendor_id', $request->vendor_id);
    }
    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    $products = $query->latest()->paginate(10);
    $categories = Category::where('status', 1)->get();
    $sales = Vendor::whereHas('products', function($q) {
        $q->whereNotNull('vendor_id');
    })->select('id', 'shop_name', 'name')->get();

    return view('admin.products.seller_product', compact('products', 'categories', 'sales'));
    //                      ^^^^^^^^^^^^^^
    //                      index নয়, seller_product
}

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $colors = Color::where('status', 1)->get();
        $sizes = Size::where('status', 1)->get();
        return view('admin.products.create', compact('categories', 'brands', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'sub_sub_category_id' => 'nullable|exists:sub_sub_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255|unique:products,name',
            'sku' => 'required|string|max:255|unique:products,name',
            'status' => 'required|in:0,1',
            'regular_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'point' => 'nullable|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured_image_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured_image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'variants.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::create([
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

        // Multiple images
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

        // Featured images
        if ($request->hasFile('featured_image_1')) {
            $product->update(['featured_image_1' => ImageHelper::uploadImage($request->file('featured_image_1'))]);
        }
        if ($request->hasFile('featured_image_2')) {
            $product->update(['featured_image_2' => ImageHelper::uploadImage($request->file('featured_image_2'))]);
        }

        // Variants (with per-variant image upload)
        if (!empty($request->variants)) {
            foreach ($request->variants as $index => $variant) {
                if (
                    !empty($variant['color_id']) ||
                    !empty($variant['size_id']) ||
                    (!empty($variant['price']) && !empty($variant['stock']))
                ) {
                    $variantImagePath = null;
                    if ($request->hasFile("variants.$index.image")) {
                        $variantImagePath = ImageHelper::uploadImage($request->file("variants.$index.image"));
                    }

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id'   => $variant['color_id'] ?? null,
                        'size_id'    => $variant['size_id'] ?? null,
                        'price'      => $variant['price'] ?? null,
                        'stock'      => $variant['stock'] ?? null,
                        'image'      => $variantImagePath,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }



    public function edit(Product $product)
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $colors = Color::where('status', 1)->get();
        $sizes = Size::where('status', 1)->get();
        $subcategories = SubCategory::where('category_id', $product->category_id)->get();
        $subsubcategories = SubSubCategory::where('sub_category_id', $product->sub_category_id)->get();

        return view('admin.products.edit', compact(
            'product',
            'categories',
            'brands',
            'colors',
            'sizes',
            'subcategories',
            'subsubcategories'
        ));
    }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'sub_sub_category_id' => 'nullable|exists:sub_sub_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'sku' => 'required|string|max:255|unique:products,sku,' . $id,

            'status' => 'required|in:0,1',
            'regular_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'point' => 'nullable|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured_image_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured_image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'variants.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product->update([
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

        // Upload multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = ImageHelper::uploadImage($img);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);
            }
        }

        // Upload featured images
        if ($request->hasFile('featured_image_1')) {
            $path = ImageHelper::uploadImage($request->file('featured_image_1'));
            $product->update(['featured_image_1' => $path]);
        }
        if ($request->hasFile('featured_image_2')) {
            $path = ImageHelper::uploadImage($request->file('featured_image_2'));
            $product->update(['featured_image_2' => $path]);
        }

        // ── Variants: delete old variant images from storage, then re-create ──
        $oldVariants = $product->variants()->get();
        foreach ($oldVariants as $oldVariant) {
            if (!empty($oldVariant->image) && Storage::disk('public')->exists($oldVariant->image)) {
                // Only delete if this image isn't being reused (kept) by the incoming request
                $isKept = false;
                foreach ($request->variants ?? [] as $incoming) {
                    if (!empty($incoming['existing_image']) && $incoming['existing_image'] === $oldVariant->image) {
                        $isKept = true;
                        break;
                    }
                }
                if (!$isKept) {
                    Storage::disk('public')->delete($oldVariant->image);
                }
            }
        }
        $product->variants()->delete();

        if (!empty($request->variants)) {
            foreach ($request->variants as $index => $variant) {
                if (
                    !empty($variant['color_id']) ||
                    !empty($variant['size_id']) ||
                    (!empty($variant['price']) && !empty($variant['stock']))
                ) {
                    // Keep existing image unless a new one is uploaded
                    $variantImagePath = $variant['existing_image'] ?? null;

                    if ($request->hasFile("variants.$index.image")) {
                        $variantImagePath = ImageHelper::uploadImage($request->file("variants.$index.image"));
                    }

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id'   => $variant['color_id'] ?? null,
                        'size_id'    => $variant['size_id'] ?? null,
                        'price'      => $variant['price'] ?? null,
                        'stock'      => $variant['stock'] ?? null,
                        'image'      => $variantImagePath,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }


    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            if (Storage::disk('public')->exists($img->image)) Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        foreach ($product->variants as $variant) {
            if (!empty($variant->image) && Storage::disk('public')->exists($variant->image)) {
                Storage::disk('public')->delete($variant->image);
            }
        }

        $product->variants()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    // AJAX
    public function getSubCategories(Category $category)
    {
        return response()->json($category->subCategories()->where('status', 1)->get());
    }

    public function getSubSubCategories(SubCategory $subCategory)
    {
        return response()->json($subCategory->subSubCategories()->where('status', 1)->get());
    }

    public function removeImage(Request $request, $id)
{
    $image = ProductImage::findOrFail($id);

    // Delete from storage
    if (Storage::exists($image->image)) {
        Storage::delete($image->image);
    }

    // Delete from database
    $image->delete();

    // AJAX er jonno JSON response pathabo
    return response()->json([
        'status'  => 'success',
        'message' => 'Image removed successfully!'
    ]);
}
}