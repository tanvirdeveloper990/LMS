<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationSubmitted;
use App\Models\CustomerComplain;
use App\Models\LegalPolicy;
use App\Models\Navigation;
use App\Helpers\ImageHelper;
use App\Models\AboutUS;
use App\Models\Affiliate;
use App\Models\Bannar;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Client;
use App\Models\CommissionLevel;
use App\Models\CommonSection;
use App\Models\Coupon;
use App\Models\CustomerContact;
use App\Models\CustomerReview;
use App\Models\Detail;
use App\Models\HowToBuy;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SellerCommission;
use App\Models\Setting;
use App\Models\Showroom;
use App\Models\SslCommerc;
use App\Models\SubCategory;
use App\Models\Team;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteController extends Controller
{

   public function index()
{
    $setting = Setting::first();
    $categories = Category::with('products')->where('status', 1)->where('show_home_page', 1)->orderBy('serial', 'asc')->get();
    $subCategories = SubCategory::with(['products', 'category'])->where('status', 1)->where('show_home_page', 1)->orderBy('serial', 'asc')->get();
    $is_new = Product::where('status', 1)->where('is_new', 1)->get();
    $is_featured = Product::where('status', 1)->where('is_featured', 1)->get();
    $allProducts = Product::where('status', 1)->latest()->take(20)->get();
    $banner = Bannar::where('status', 1)->get();
    $review = CustomerReview::where('status', 1)->get();
    $showroom = Showroom::where('status', 1)->get();
    $details = Detail::first();
    $courses = Category::where('status', 1)->where('type', 'course')->orderBy('serial')->get();
    $preparations = Category::where('status', 1)->where('type', 'preparation')->orderBy('serial')->get();
    $blogs = Blog::where('status', 1)->get();
    return view('frontend.index', compact('details','showroom', 'blogs', 'subCategories',  'setting', 'categories', 'is_new', 'is_featured', 'allProducts', 'banner', 'review','preparations','courses'));
}


  
    public function ebook()
    {
        $setting = Setting::first();
        $banner = Bannar::where('status', 1)->get();
        $ebookcategories = Category::where('status', 1)->where('type', 'ebook')->orderBy('serial')->get();
        return view('frontend.ebook', compact('setting','banner','ebookcategories'));
    }




    public function reviewstore(Request $request)
    {
        $request->validate([
            'product_id'  => 'required',
            'star'        => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|max:1000',
        ]);

        // একজন user একটা product এ একবারই review দিতে পারবে
        $existing = CustomerReview::where('product_id', $request->product_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('review_error', 'You have already reviewed this product!');
        }

        CustomerReview::create([
            'product_id'  => $request->product_id,
            'user_id'     => auth()->id(),
            'name'        => auth()->user()->name,
            'star'        => $request->star,
            'review_text' => $request->review_text,
            'status'      => '0', // default inactive — admin approve করবে
        ]);

        return back()->with('review_success', 'Review submitted! It will be visible after approval.');
    }

    public function showrooms()
{
    $setting   = Setting::first();
    $showrooms = Showroom::where('status', 1)->latest()->get();
 
    return view('frontend.showrooms', compact('setting', 'showrooms'));
}
 
public function showroomDetail($id)
{
    $setting  = Setting::first();
    $showroom = Showroom::where('status', 1)->findOrFail($id);
 
    return view('frontend.showroom-detail', compact('setting', 'showroom'));
}


    public function productSingle($slug)
    {
        $item = Product::with([
            'images',
            'variants' => fn($q) => $q->with(['color', 'size']),
            'category',
            'brand',
            'vendor',
            'reviews' => fn($q) => $q->where('status', 1)->latest(),
        ])->where('slug', $slug)->firstOrFail();

        $setting      = Setting::first();
        $affiliate    = '';
        $referal      = '';
        $shipingAreas = \App\Models\Shiping::where('status', 1)->get();
        $showrooms = Showroom::where('status', 1)->latest()->get();


        $relatedProducts = Product::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->where('status', 1)
            ->latest()
            ->get();

        $productCount = $relatedProducts->count();

        // ✅ FIX: Proper type casting so JSON is always clean
        $variantData = $item->variants->map(fn($v) => [
            'color_id'  => $v->color_id  ? (int) $v->color_id  : null,
            'color'     => $v->color?->name,
            'size_id'   => $v->size_id   ? (int) $v->size_id   : null,
            'size'      => $v->size?->name,
            'size_desc' => $v->size?->description,
            'price'     => (float) $v->price,
            'stock'     => (int) $v->stock,
        ]);

        return view('frontend.product-single', compact(
            'item',
            'setting',
            'relatedProducts',
            'productCount',
            'affiliate',
            'referal',
            'shipingAreas',
            'variantData', // ✅ pass to blade
            'showrooms'
        ));
    }





   public function products(Request $request)
    {
        $setting = \App\Models\Setting::first();

        $query        = \App\Models\Product::where('status', 1);
        $categoryName = 'All Products';
        $breadcrumbs  = [];

        // ── ✅ New Arrivals filter ────────────────────────────────
        if ($request->filled('new') && $request->new == 1) {
            $query->where('is_new', 1);
            if ($categoryName === 'All Products') {
                $categoryName = 'নতুন পণ্য';
            }
        }

        // ── ✅ Search filter ──────────────────────────────────────
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // ── Category filter ──────────────────────────────────────
        if ($request->filled('category')) {
            $category = \App\Models\Category::with('subCategories')->find($request->category);

            if ($category) {
                $categoryName  = $category->name;
                $breadcrumbs[] = ['name' => $category->name, 'type' => 'category', 'id' => $category->id];

                $subCategoryIds = $category->subCategories->pluck('id')->toArray();

                $query->where(function ($q) use ($request, $subCategoryIds) {
                    $q->where('category_id', $request->category)
                        ->orWhereIn('sub_category_id', $subCategoryIds);
                });
            }
        }

        // ── SubCategory filter ───────────────────────────────────
        if ($request->filled('sub_category')) {
            $subCategory = \App\Models\SubCategory::with('category')->find($request->sub_category);

            if ($subCategory) {
                $categoryName = $subCategory->name;
                $breadcrumbs  = [
                    ['name' => $subCategory->category->name, 'type' => 'category',    'id' => $subCategory->category_id],
                    ['name' => $subCategory->name,           'type' => 'subcategory', 'id' => $subCategory->id],
                ];

                $query->where('sub_category_id', $request->sub_category);
            }
        }

        // ── ✅ Brand filter ───────────────────────────────────────
        $brandName = null;
        if ($request->filled('brand')) {
            $brand = \App\Models\Brand::find($request->brand);

            if ($brand) {
                $brandName = $brand->name;
                // যদি category filter না থাকে, brand name-টাই শিরোনাম হবে
                if ($categoryName === 'All Products') {
                    $categoryName = $brand->name;
                }
                $breadcrumbs[] = ['name' => $brand->name, 'type' => 'brand', 'id' => $brand->id];

                $query->where('brand_id', $request->brand);
            }
        }

        // ── Price Range filter ───────────────────────────────────
        if ($request->filled('price_min')) {
            $query->where('sale_price', '>=', (float) $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('sale_price', '<=', (float) $request->price_max);
        }

        // ── Availability filter ──────────────────────────────────────
        if ($request->filled('availability')) {
            $availability = $request->availability;

            if (in_array('in_stock', $availability) && !in_array('out_of_stock', $availability)) {
                $query->where(function ($q) {
                    $q->whereHas('variants', fn($v) => $v->where('stock', '>', 0))
                        ->orWhereDoesntHave('variants');
                });
            }

            if (in_array('out_of_stock', $availability) && !in_array('in_stock', $availability)) {
                $query->whereHas('variants')
                    ->whereDoesntHave('variants', fn($v) => $v->where('stock', '>', 0));
            }
        }

        // ── Size filter ────────────────────────────────────────────
        if ($request->filled('sizes')) {
            $sizeIds = $request->sizes;
            $query->whereHas('variants', function ($v) use ($sizeIds) {
                $v->whereIn('size_id', $sizeIds);
            });
        }

        // ── ✅ Sort filter ────────────────────────────────────────
        $sortBy = $request->get('sort', 'relevance');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('sale_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('sale_price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->latest(); // relevance fallback
                break;
        }

        $products = $query->with('variants')->get();

        // ── ✅ Mobile filter panel-এর জন্য all categories + subcategories ──
        $allCategories = \App\Models\Category::where('status', 1)
            ->with(['subCategories' => fn($q) => $q->where('status', 1)])
            ->get();

        return view('frontend.products', compact(
            'setting', 'products', 'categoryName', 'breadcrumbs', 'allCategories'
        ));
    }

    // ── ✅ All Brands Page ─────────────────────────────────────────
    public function brands()
    {
        $setting = \App\Models\Setting::first();
        $brands  = \App\Models\Brand::where('status', 1)->orderBy('name', 'asc')->get();

        return view('frontend.brands', compact('setting', 'brands'));
    }




    public function checkout()
    {
        $ssl = SslCommerc::first();
        $item = Setting::first();
        $shipingAreas = \App\Models\Shiping::where('status', 1)->get();

        // ✅ Reward points: logged-in user's current available balance (0 for guests)
        $availablePoints = Auth::check() ? (int) (Auth::user()->points ?? 0) : 0;

        return view('frontend.checkout', compact('ssl', 'item', 'shipingAreas', 'availablePoints'));
    }



   public function orderStore(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string',
            'phone'          => ['required', 'string', 'regex:/^(?:\+?880|0)1[3-9]\d{8}$/'],
            'address'        => 'required|string',
            'delivery_area'  => 'required|string',
            'payment_method' => 'required|string',
            'items'          => 'required|array',
            'notes'          => 'nullable',
            'total'          => 'required|numeric',
            'transaction_id' => 'nullable|string',
            'payment_number' => ['nullable', 'string', 'regex:/^(?:\+?880|0)1[3-9]\d{8}$/'],
            'used_point'     => 'nullable|integer|min:0',
        ], [
            'phone.regex'          => 'Please enter a valid Bangladesh phone number (e.g. 01XXXXXXXXX).',
            'payment_number.regex' => 'Please enter a valid Bangladesh phone number (e.g. 01XXXXXXXXX).',
        ]);

        // ── Resolve user (logged-in vs guest) ──────────────────────
        $loggedInUser = null;

        if (Auth::check()) {
            $loggedInUser = Auth::user();
            $userId       = $loggedInUser->id;
        } else {
            $uniqueString  = Str::random(6) . time();
            $guestEmail    = 'guest_' . $uniqueString . '@example.com';
            $guestUsername = 'guest_' . $uniqueString;

            $guestUser = User::create([
                'name'     => $request->customer_name,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'email'    => $guestEmail,
                'username' => $guestUsername,
                'password' => bcrypt(Str::random(8)),
            ]);

            $userId = $guestUser->id;
        }

        $subtotal     = 0;
        $earnedPoints = 0;

        foreach ($request->items as $item) {
            $qty       = (int) ($item['quantity'] ?? 1);
            $price     = (float) ($item['price'] ?? 0);
            $subtotal += $price * $qty;

            $product = Product::find($item['productId'] ?? null);
            if ($product) {
                $earnedPoints += ((int) $product->point) * $qty;
            }
        }

        $availablePoints = $loggedInUser ? (int) $loggedInUser->points : 0;
        $requestedPoints = (int) ($request->used_point ?? 0);
        $usedPoint = max(0, min($requestedPoints, $availablePoints, (int) floor($subtotal)));

        $deliveryCharge = (float) ($request->delivery_charge ?? 0);
        $couponAmount   = (float) ($request->coupon_amount ?? 0);
        $finalTotal     = max(0, $subtotal + $deliveryCharge - $couponAmount - $usedPoint);

        $order = Order::create([
            'user_id'         => $userId,
            'total'           => $finalTotal,
            'status'          => 'pending',
            'payment_method'  => $request->payment_method,
            'delivery_area'   => $request->delivery_area,
            'delivery_charge' => $deliveryCharge,
            'notes'   => $request->notes,
            'transaction_id'  => $request->transaction_id ?? null,
            'payment_number'  => $request->payment_number ?? null,
            'payment_date'    => now(),
            'payment_status'  => 'pending',
            'coupon_code'     => $request->coupon_code ?? null,
            'coupon'          => $couponAmount,
            'total_point'     => $loggedInUser ? $earnedPoints : 0,
            'used_point'      => $usedPoint,
        ]);

        /* ── Order Items ── */
        foreach ($request->items as $item) {

            $variantInfo = null;
            $color = $item['color'] ?? null;
            $size  = $item['size']  ?? null;

            if (!empty($color) || !empty($size)) {
                $variantInfo = json_encode([
                    'color' => $color,
                    'size'  => $size,
                ], JSON_UNESCAPED_UNICODE);
            }

            OrderItem::create([
                'order_id'           => $order->id,
                'product_id'         => $item['productId'],
                'product_variant_id' => $variantInfo,
                'quantity'           => $item['quantity'],
                'price'              => $item['price'],
                'affiliate_id'       => $item['affiliateId'] ?? null,
                'referal_id'         => $item['affiliateRefaral'] ?? null,
            ]);

            /* ── ✅ ধাপ ১: মূল Product Stock কমানো (সবসময় হবে) ── */
            $product = Product::find($item['productId']);
            if ($product && $product->stock >= $item['quantity']) {
                $product->decrement('stock', $item['quantity']);
            }

            /* ── ✅ ধাপ ২: Variant Stock কমানো — কোন combination আছে সেটার উপর ভিত্তি করে ── */
            if (!empty($color) && !empty($size)) {
                // Case A: Color + Size দুটোই সিলেক্ট করা হয়েছে
                $variant = \App\Models\ProductVariant::where('product_id', $item['productId'])
                    ->whereHas('color', fn($q) => $q->where('name', $color))
                    ->whereHas('size',  fn($q) => $q->where('name', $size))
                    ->first();

                if ($variant && $variant->stock >= $item['quantity']) {
                    $variant->decrement('stock', $item['quantity']);
                }
            } elseif (!empty($color)) {
                // Case B: শুধু Color সিলেক্ট করা হয়েছে (Size নেই)
                $variant = \App\Models\ProductVariant::where('product_id', $item['productId'])
                    ->whereHas('color', fn($q) => $q->where('name', $color))
                    ->first();

                if ($variant && $variant->stock >= $item['quantity']) {
                    $variant->decrement('stock', $item['quantity']);
                }
            } elseif (!empty($size)) {
                // ✅ Case C (নতুন যোগ করা): শুধু Size সিলেক্ট করা হয়েছে (Color নেই)
                $variant = \App\Models\ProductVariant::where('product_id', $item['productId'])
                    ->whereHas('size', fn($q) => $q->where('name', $size))
                    ->first();

                if ($variant && $variant->stock >= $item['quantity']) {
                    $variant->decrement('stock', $item['quantity']);
                }
            }
            // Case D: color আর size দুটোই খালি (simple product, কোনো variant নেই)
            // → কোনো if ব্লকেই ঢুকবে না, শুধু ধাপ ১-এর main stock কমাই যথেষ্ট
        }

        if ($loggedInUser) {
            if ($usedPoint > 0) {
                $loggedInUser->decrement('points', $usedPoint);
            }
        }

        session()->flash('success', 'Order Created Successfully');

        return response()->json([
            'success'      => true,
            'id'           => $order->order_id,
            'used_point'   => $usedPoint,
            'earned_point' => $loggedInUser ? $earnedPoints : 0,
        ]);
    }



    public function about()
    {
        $data = AboutUS::first();
        $teams = Team::where('status', 1)->get();
        $clients = Client::where('status', 1)->get();
        return view('frontend.about', compact('data', 'teams', 'clients'));
    }
    public function sellers()
    {
        $sellers = Vendor::where('status', 1)->latest()->get();
        return view('frontend.sellers', compact('sellers'));
    }
    public function shop($slug)
    {
        $sellers = Vendor::where('shop_slug', $slug)->first();
        return view('frontend.sellers-shop', compact('sellers'));
    }

    public function affiliateRegister()
    {
        return view('affiliate.register');
    }
    public function affiliateLogin()
    {
        return view('affiliate.login');
    }


    // Store affiliate registration
    public function storeaffiliate(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:affiliates,email',
            'phone' => 'required|string|unique:affiliates,phone',
            'username' => 'required|string|unique:affiliates,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $affiliate = Affiliate::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'website_url' => $request->website_url,
            'social_media_link' => $request->social_media_link,
            'promotion_method' => $request->promotion_method,
            'referal_name_id' => $request->referal_name_id,
            'status' => 'pending', // default
        ]);

        return redirect()->back()->with('success', 'Registration successful! Your account is pending approval.');
    }


    public function sellerRegister()
    {
        return view('frontend.seller-register');
    }
    public function sellerLogin()
    {
        return view('frontend.seller-login');
    }


    // Store seller registration
    public function storeSeller(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'shop_name'   => 'required|string|max:255|unique:vendors,shop_name',
            'email'       => 'required|email|unique:vendors,email',
            'nid'         => 'required|digits_between:10,17|numeric|unique:vendors,nid',
            'phone'       => 'required|string|max:20|unique:vendors,phone',
            'password'    => 'required|min:6|confirmed',
            'address'     => 'nullable|string',
            'city'        => 'nullable|string|max:100',
            'country'     => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:500',

            'logo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'banner'      => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Generate shop slug
        $shop_slug = Str::slug($request->shop_name);

        // Ensure slug is unique
        $originalSlug = $shop_slug;
        $counter = 1;
        while (Vendor::where('shop_slug', $shop_slug)->exists()) {
            $shop_slug = $originalSlug . '-' . $counter++;
        }

        // Upload images using ImageHelper
        $logo = $request->hasFile('logo')
            ? ImageHelper::uploadImage($request->file('logo'))
            : null;

        $banner = $request->hasFile('banner')
            ? ImageHelper::uploadImage($request->file('banner'))
            : null;

        // Save seller
        Vendor::create([
            'name'        => $request->name,
            'shop_name'   => $request->shop_name,
            'shop_slug'   => $shop_slug,
            'email'       => $request->email,
            'nid'       => $request->nid,
            'phone'       => $request->phone,
            'password'    => Hash::make($request->password),
            'address'     => $request->address,
            'city'        => $request->city,
            'country'     => $request->country,
            'postal_code' => $request->postal_code,
            'description' => $request->description,
            'logo'        => $logo,
            'banner'      => $banner,
            'status'      => 'inactive',
        ]);

        return back()->with('success', 'Seller Registration Successful! & Waiting for Approval');
    }










    public function blogs()
    {
        $setting = Setting::first();
        $blogs = Blog::where('status', 1)->get();
        return view('frontend.blogs', compact('setting', 'blogs'));
    }


    public function singleBlog($slug)
    {
        $data = Blog::where('slug', $slug)->firstOrFail(); // not found হলে automatic 404
        $setting = Setting::first();
        $products = Product::where('status', 1)->latest()->get();
        return view('frontend.blog-single', compact('data', 'setting', 'products'));
    }


    public function productSingleAffiliateReferal($slug, $referal_code)
    {
        // Get product
        $item = Product::where('slug', $slug)->firstOrFail();

        // Get settings (if needed)
        $setting = Setting::first();

        // Get affiliate by referal_code
        $referal = Affiliate::where('referal_code', $referal_code)->firstOrFail();

        // Get related products (if applicable)
        $relatedProducts = $item->relatedProducts();

        $affiliate = ''; // optional if needed

        return view('frontend.product-single', compact('item', 'setting', 'relatedProducts', 'affiliate', 'referal'));
    }



    public function productSingleAffiliateReferalUser($slug, $referal_code)
    {
        // Get product
        $item = Product::where('slug', $slug)->firstOrFail();

        // Get settings (if needed)
        $setting = Setting::first();

        // Get affiliate by referal_code
        $referal = User::where('referal_code', $referal_code)->firstOrFail();

        // Get related products (if applicable)
        $relatedProducts = $item->relatedProducts();

        $affiliate = ''; // optional if needed

        return view('frontend.product-single', compact('item', 'setting', 'relatedProducts', 'affiliate', 'referal'));
    }


    public function productSingleAffiliate($slug, $affiliate_id)
    {
        $item = Product::where('slug', $slug)->firstOrFail(); // If not found, it will automatically throw a 404
        $setting = Setting::first();

        // Retrieve the affiliate details
        $affiliate = Affiliate::findOrFail($affiliate_id);

        // Fetch related products
        $relatedProducts = $item->relatedProducts();

        $referal = '';

        // Return the view with the necessary data
        return view('frontend.product-single', compact('item', 'setting', 'relatedProducts', 'affiliate', 'referal'));
    }





    public function categories($slug)
    {
        $category = Category::with('products')->where('slug', $slug)->firstOrFail(); // not found হলে automatic 404
        $setting = Setting::first();
        return view('frontend.categories', compact('category', 'setting'));
    }


    public function subcategoryProducts($id)
    {
        $setting = Setting::first();
        $subcategory = SubCategory::findOrFail($id);
        $category = $subcategory->category; // Parent category

        $products = Blog::where('sub_category_id', $id)->paginate(12);

        return view('products.subcategory-products', compact('setting', 'subcategory', 'category', 'products'));
    }

    public function liveSearch(Request $request)
    {
        $query = $request->get('q');
        $products = Product::select('id', 'name', 'slug', 'regular_price', 'sale_price', 'featured_image_1', 'brand_id')
            ->with('brand:id,name')
            ->where('name', 'like', "%{$query}%")
            ->where('status', 1)
            ->limit(8)
            ->get();
        return response()->json($products);
    }

    public function validateCoupon(Request $request)
    {
        $coupon = Coupon::where('coupon_code', $request->coupon_code)
            ->where('status', 1)
            ->first();

        if ($coupon) {
            return response()->json([
                'valid' => true,
                'amount' => $coupon->amount
            ]);
        } else {
            return response()->json(['valid' => false]);
        }
    }




    public function reviews()
    {
        $setting = Setting::first();
        return view('frontend.reviews', compact('setting'));
    }
    public function contacts()
    {
        $setting = Setting::first();
        return view('frontend.contacts', compact('setting'));
    }

    public function contactStore(Request $request)
    {
        $data = $request->all();
        CustomerContact::create($data);
        return redirect()->back()->with('success', 'Thank you for contacting us!');
    }




    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $imagePath = null;

        if ($socialUser->getAvatar()) {
            // Download image from URL
            $imageContents = file_get_contents($socialUser->getAvatar());

            // Generate unique filename
            $filename = 'users/' . Str::uuid() . '.jpg';

            // Store image to storage/app/public/users
            Storage::disk('public')->put($filename, $imageContents);

            $imagePath = $filename;
        }

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(24)),
                'image' => $imagePath,
            ]
        );

        // Optional: Update image if user already exists but has no image
        if (!$user->image && $imagePath) {
            $user->image = $imagePath;
            $user->save();
        }

        Auth::login($user);
        return redirect()->intended('/home');
    }


    public function showRegistrationForm($referrer_id = null)
    {
        return view('auth.register-refer', ['referrer_id' => $referrer_id]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits_between:10,14|unique:users',
            'password' => 'required|confirmed|min:6',
            'referrer_id' => 'nullable|exists:users,id',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'referrer_id' => $request->referrer_id,
        ]);

        // Log in the user
        auth()->login($user);

        // Trigger email verification event
        event(new Registered($user));

        return redirect()->route('verification.notice');
    }

    public function trackorder(Request $request)
    {
        $order = null;

        if ($request->has('invoice_id')) {
            $searchValue = trim($request->invoice_id);

            $order = Order::with('orderItems.product', 'user')
                ->where('order_id', $searchValue)
                ->orWhereHas('user', function ($query) use ($searchValue) {
                    $query->where('phone', $searchValue);
                })
                ->latest()
                ->first();
        }

        return view('frontend.track-order', compact('order'));
    }


    public function orderSuccess($order_id)
    {
        $data = Order::with('orderItems.product', 'user')
            ->where('order_id', $order_id)
            ->firstOrFail();

        return response()
            ->view('frontend.success', compact('data'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    // public function orderSuccess($order_id)
    // {
    //     $data = Order::where('order_id', $order_id)->firstOrFail();
    //     return view('frontend.success', compact('data'));
    // }


    public function deliveryPolicy()
    {
        $data = LegalPolicy::first();
        return view('frontend.help-policy.delivery-policy', compact('data'));
    }
    public function returnPolicy()
    {
        $data = LegalPolicy::first();
        return view('frontend.help-policy.return-policy', compact('data'));
    }
    public function refundPolicy()
    {
        $data = LegalPolicy::first();
        return view('frontend.help-policy.refund-policy', compact('data'));
    }
    public function warrantyPolicy()
    {
        $data = LegalPolicy::first();
        return view('frontend.help-policy.warranty-policy', compact('data'));
    }
    public function privacyPolicy()
    {
        $data = LegalPolicy::first();
        return view('frontend.help-policy.privacy-policy', compact('data'));
    }



    public function aboutUs()
    {
        $data = Navigation::first();
        return view('frontend.help-policy.about-us', compact('data'));
    }

    public function howToBuy()
    {
        $setting = Setting::first();
        $data = HowToBuy::where('status', 1)->orderby('serial', 'asc')->get();
        return view('frontend.help-policy.how-buy', compact('data'));
    }


    public function complaint()
    {
        $data = Navigation::first();
        $setting = Setting::first();
        return view('frontend.help-policy.complaint', compact('data', 'setting'));
    }

    public function complaintStore(Request $request)
    {
        $complaint = CustomerComplain::create($request->all());

        // Send Email to Admin
        Mail::to("t87373654@gmail.com")
            ->send(new ApplicationSubmitted($complaint));

        return redirect()->back()->with('success', 'Thank you for contacting us!');
    }
}
