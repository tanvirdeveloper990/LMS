<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CustomerReview;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard()
    {
        $orders          = Order::count();
        $revenue         = Order::sum('total');
        $pending_orders  = Order::where('status', 'pending')->count();
        $complete_orders = Order::where('status', 'completed')->count();
        $products        = Product::count();
        $categories      = Category::count();
        $customers       = User::count();
        $new_customers   = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $reviews         = CustomerReview::where('status', 1)->count();
        $pending_reviews = CustomerReview::where('status', 0)->count();
    
        // Today sales
        $todaySales    = Order::whereDate('created_at', today())->sum('total');
        $yesterdaySales= Order::whereDate('created_at', Carbon::yesterday())->sum('total');
        $salesChange   = $yesterdaySales > 0 ? round((($todaySales - $yesterdaySales) / $yesterdaySales) * 100, 1) : 0;
    
        // Today income (paid orders)
        $todayIncome   = Order::whereDate('created_at', today())->where('payment_status', 'paid')->sum('total');
        $yesterdayInc  = Order::whereDate('created_at', Carbon::yesterday())->where('payment_status', 'paid')->sum('total');
        $incomeChange  = $yesterdayInc > 0 ? round((($todayIncome - $yesterdayInc) / $yesterdayInc) * 100, 1) : 0;
    
        // Due amount
        $totalDue      = Order::where('payment_status', 'unpaid')->sum('total');
    
        // Monthly sales chart (last 30 days)
        $monthlySales  = Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->where('created_at', '>=', Carbon::now()->subDays(29))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');
    
        $chartLabels = [];
        $chartData   = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::now()->subDays($i)->format('d M');
            $chartData[]   = $monthlySales[$date] ?? 0;
        }
    
        // Top selling products
        $topProducts = OrderItem::with(['product.category'])
            ->selectRaw('product_id, SUM(quantity) as sold_qty, SUM(price * quantity) as sales_amount')
            ->groupBy('product_id')
            ->orderByDesc('sold_qty')
            ->limit(5)
            ->get();
    
        // Top customers
        $topCustomers = Order::with('user')
            ->selectRaw('user_id, SUM(total) as total_sales, SUM(total - COALESCE(paid, 0)) as total_due')
            ->groupBy('user_id')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();
    
       // শুধু product.stock ব্যবহার করো, variant stock বাদ
    $allProducts = Product::where('status', 1)->get();
    
    $productslist = $allProducts->map(function ($product) {
        $product->available_stock = $product->stock;
        return $product;
    });
    
    $lowStockProducts = $productslist->filter(fn($p) => $p->available_stock > 0 && $p->available_stock <= 10)->take(5);
    $otherProducts    = $productslist->filter(fn($p) => $p->available_stock > 10);
    $outOfStock       = $productslist->filter(fn($p) => $p->available_stock <= 0)->count();
    $overStock        = $productslist->filter(fn($p) => $p->available_stock > 50)->count();
    $goodStock        = $productslist->filter(fn($p) => $p->available_stock > 10 && $p->available_stock <= 50)->count();
    $lowStock         = $productslist->filter(fn($p) => $p->available_stock > 0 && $p->available_stock <= 10)->count();
        
        $todayCod   = Order::whereDate('created_at', today())->where('payment_method', 'cod')->sum('total');
        $todayMfs   = Order::whereDate('created_at', today())->whereIn('payment_method', ['bkash', 'nagad'])->sum('total');
    
        return view('admin.dashboard', compact(
            'orders', 'pending_orders', 'complete_orders', 'products', 'categories',
            'customers', 'new_customers', 'revenue', 'reviews', 'pending_reviews',
            'lowStockProducts', 'otherProducts',
            'todaySales', 'yesterdaySales', 'salesChange',
            'todayIncome', 'incomeChange', 'totalDue',
            'chartLabels', 'chartData',
            'topProducts', 'topCustomers',
            'outOfStock', 'overStock', 'goodStock', 'lowStock','todayCod', 'todayMfs'
        ));
    }


    public function settings()
    {
        return view('admin.auth.settings');
    }
    public function changePassword()
    {
        return view('admin.auth.change-password');
    }
    public function updateSettings(Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
        ]);

        $image = $request->hasFile('image') ? ImageHelper::uploadImage($request->file('image')) : null;

        if ($request->hasFile('image') && $admin->image) {
            Storage::disk('public')->delete($admin->image);
        }

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' =>  $image,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!\Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        $admin->update([
            'password' => \Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function updateCurrency(Request $request)
    {
        $setting = Setting::first();

        $request->validate([
            'currency' => 'required|string'
        ]);

        $setting->currency = $request->currency;
        $setting->save();

       return back()->with('success', 'Currency updated successfully.');

    }
}
