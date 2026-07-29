<?php

namespace App\Http\Controllers\Vendor;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\VendorWithdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    // Dashboard
    public function dashboard()
    {

        $vendorId = Auth::guard('vendor')->id();

        // Get all product IDs of this vendor
        $productIds = Product::where('vendor_id', $vendorId)->pluck('id');

        // Count total OrderItems for vendor's products
        $totalOrders = OrderItem::whereIn('product_id', $productIds)->count();

   

        // Pending Orders
        $pending_orders = Order::whereHas('orderItems', function($query) use ($productIds) {
            $query->whereIn('product_id', $productIds);
        })->where('status', 'pending')->count();

        // Completed Orders
        $complete_orders = Order::whereHas('orderItems', function($query) use ($productIds) {
            $query->whereIn('product_id', $productIds);
        })->where('status', 'completed')->count();


        // Calculate total sales: sum of quantity * price for vendor's products
        $totalSales = OrderItem::whereIn('product_id', $productIds)
            ->sum(\DB::raw('quantity * price'));


        // Get vendor commission percentage from settings
        $vendorCommissionPercent = Setting::first()->vendor_commission ?? 0;

        // Calculate commission amount
        $commissionAmount = ($totalSales * $vendorCommissionPercent) / 100;

        $withdraw = VendorWithdraw::where('vendor_id', Auth::guard('vendor')->user()->id)->sum('payable_amount');

        $balance = $totalSales -  $commissionAmount - $withdraw;



        return view('vendor.dashboard', compact(
            'totalOrders',
            'pending_orders',
            'complete_orders',
            'totalSales',
            'commissionAmount',
            'withdraw',
            'balance',
            
        ));
    }


    public function settings()
    {
        return view('vendor.auth.settings');
    }

    public function changePassword()
    {

        return view('vendor.auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $admin = auth('vendor')->user();

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


    public function updateSettings(Request $request)
    {
        $vendor = auth('vendor')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email,' . $vendor->id,
        ]);

        // Only upload new images
        $logo = $request->hasFile('logo')
            ? ImageHelper::uploadImage($request->file('logo'))
            : $vendor->logo;

        $banner = $request->hasFile('banner')
            ? ImageHelper::uploadImage($request->file('banner'))
            : $vendor->banner;

        // Delete old logo
        if ($request->hasFile('logo') && $vendor->logo) {
            Storage::disk('public')->delete($vendor->logo);
        }

        // Delete old banner
        if ($request->hasFile('banner') && $vendor->banner) {
            Storage::disk('public')->delete($vendor->banner);
        }

        // Update only selected fields
        $vendor->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'shop_name' => $request->shop_name,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'description' => $request->description,
            'logo' => $logo,
            'banner' => $banner,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }
}
