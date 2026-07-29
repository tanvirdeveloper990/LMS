<?php

namespace App\Http\Controllers;

use App\Models\CommissionEarn;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::id();

        // Total Orders
        $orders = Order::where('user_id', $userId)->count();

        // Pending Orders
        $pending_orders = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        // Completed Orders
        $complete_orders = Order::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        $affiliate = auth()->guard('web')->user();
        $referalCode = $affiliate->referal_code;

        $level_product_count = OrderItem::where('referal_id',$referalCode)->sum('quantity');

        $level_product_total_sales = CommissionEarn::where('affiliate_id',$referalCode)->sum('total_sales');

        $level_commission_earning = CommissionEarn::where('affiliate_id',$referalCode)->sum('amount');
        $level_commission_withdrawal = Withdrawal::where('affiliate_id',$referalCode)->sum('amount');

        // ✅ Reward points balance for this user
        $reward_points = (int) (Auth::user()->points ?? 0);

        return view('user.dashboard', compact(
            'orders',
            'pending_orders',
            'complete_orders',
            'level_product_count',
            'level_product_total_sales',
            'level_commission_earning',
            'level_commission_withdrawal',
            'reward_points'

        ));
    }



    public function saveLocation(Request $request) {
    auth()->user()->update(['location' => $request->location]);
    return response()->json(['success' => true]);
}




    public function settings()
    {
        return view('settings');
    }
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
    public function profileEdit()
    {
        $data = Auth::user();
        return view('profile-edit', compact('data'));
    }

    public function passwordEdit()
    {

        return view('user.change-password');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => ['nullable', 'regex:/^\d{11}$/', 'unique:users,phone,' . $user->id],
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Image
        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $file = $request->file('image');
            $path = 'users/' . Str::uuid() . '.' . $file->getClientOriginalExtension();

            Storage::disk('public')->put($path, file_get_contents($file));

            $validated['image'] = $path;
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'min:6', 'confirmed', 'different:current_password'],
        ], [
            'current_password.current_password' => 'The current password is incorrect.',
            'new_password.confirmed' => 'The new password and confirmation password do not match.',
            'new_password.different' => 'The new password must be different from the current password.',
        ]);

        // Update password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password has been updated successfully.');
    }
}