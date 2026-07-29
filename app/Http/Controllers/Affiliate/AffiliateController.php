<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateWithdraw;
use App\Models\CommissionEarn;
use App\Models\CommissionLevel;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:affiliate');
    }


    //     public function level()
    // {
    //     $affiliate = auth()->guard('affiliate')->user();
    //     $referalCode = $affiliate->referal_code;

    //     $items = OrderItem::where('referal_id', $referalCode)->get();

    //     $totalQuantity = $items->sum('quantity');
    //     $totalSales = $items->sum(fn($i) => $i->quantity * $i->price);

    //     $levels = CommissionLevel::orderBy('start')->get();

    //     $completed = false; // ✅ initialize here
    //     $currentLevel = null;
    //     $nextLevel = null;

    //     foreach ($levels as $level) {

    //         // Check if level completed AND not yet in CommissionEarn
    //         $alreadyEarned = CommissionEarn::where('affiliate_id', $affiliate->id)
    //             ->where('level_id', $level->id)
    //             ->exists();

    //         if ($totalQuantity >= $level->end) {
    //             $completed = true; // ✅ mark as completed

    //             if (!$alreadyEarned) {
    //                 // Create commission earn record
    //                 CommissionEarn::create([
    //                     'affiliate_id' => $affiliate->id,
    //                     'level_id' => $level->id,
    //                     'total_sales' => $totalSales,
    //                     'percentage' => $level->persentage,
    //                     'amount' => ($totalSales * $level->persentage) / 100,
    //                 ]);
    //             }
    //         }

    //         // Find current level (in-progress)
    //         if ($totalQuantity >= $level->start && $totalQuantity <= $level->end) {
    //             $currentLevel = $level;
    //         }

    //         // Find next level
    //         if ($level->start > $totalQuantity && !$nextLevel) {
    //             $nextLevel = $level;
    //         }
    //     }

    //     // Progress for current level
    //     $progress = 0;
    //     if ($currentLevel) {
    //         $progress = (($totalQuantity - $currentLevel->start) / ($currentLevel->end - $currentLevel->start)) * 100;
    //         $progress = max(0, min(100, $progress));
    //     }

    //     return view('affiliate.level', compact(
    //         'levels',
    //         'currentLevel',
    //         'nextLevel',
    //         'totalQuantity',
    //         'totalSales',
    //         'progress',
    //         'completed' // ✅ pass to view
    //     ));
    // }

    public function level()
    {
        $affiliate = auth()->guard('affiliate')->user();
        $referalCode = $affiliate->referal_code;

        $items = OrderItem::where('referal_id', $referalCode)->get();

        $totalQuantity = $items->sum('quantity');
        $totalSales = $items->sum(fn($i) => $i->quantity * $i->price);

        $levels = CommissionLevel::orderBy('start')->get();

        $completed = false;
        $currentLevel = null;
        $nextLevel = null;

        foreach ($levels as $level) {

            // Already earned for this level?
            // $alreadyEarned = CommissionEarn::where('affiliate_id', $affiliate->id)
            $alreadyEarned = CommissionEarn::where('affiliate_id', $referalCode)
                ->where('level_id', $level->id)
                ->exists();

            // Calculate quantity for this level
            $levelQuantity = 0;
            if ($totalQuantity >= $level->start) {
                $levelQuantity = min($totalQuantity, $level->end) - $level->start + 1;
            }

            if ($totalQuantity >= $level->end && !$alreadyEarned && $levelQuantity > 0) {
                $completed = true;

                // Calculate level sales proportionally
                $levelSales = ($totalSales / $totalQuantity) * $levelQuantity;

                // Create commission earn record for this level
                CommissionEarn::create([
                    // 'affiliate_id' => $affiliate->id,
                    'affiliate_id' => $referalCode,
                    'level_id' => $level->id,
                    'total_sales' => $levelSales,
                    'percentage' => $level->persentage,
                    'amount' => ($levelSales * $level->persentage) / 100,
                ]);
            }

            // Current in-progress level
            if ($totalQuantity >= $level->start && $totalQuantity <= $level->end) {
                $currentLevel = $level;
            }

            // Next level
            if ($level->start > $totalQuantity && !$nextLevel) {
                $nextLevel = $level;
            }
        }

        // Progress for current level
        $progress = 0;
        if ($currentLevel) {
            $progress = (($totalQuantity - $currentLevel->start) / ($currentLevel->end - $currentLevel->start)) * 100;
            $progress = max(0, min(100, $progress));
        }

        $commission_earning = CommissionEarn::where('affiliate_id',$referalCode)->sum('amount');
        $commission_earning_withdrawal = Withdrawal::where('affiliate_id',$referalCode)->sum('amount');

        return view('affiliate.level', compact(
            'levels',
            'currentLevel',
            'nextLevel',
            'totalQuantity',
            'totalSales',
            'progress',
            'completed',
            'commission_earning',
            'commission_earning_withdrawal'
        ));
    }

    public function salesProductsEarning()
    {
        $affiliate = auth()->guard('affiliate')->user();
        $referalCode = $affiliate->referal_code;

        $data = CommissionEarn::where('affiliate_id',$referalCode)->get();
        $withdrawal = Withdrawal::where('affiliate_id',$referalCode)->sum('amount');
        return view('affiliate.level-history',compact('data','withdrawal'));
    }
    public function salesProductsWithdrawalHistory()
    {
        $affiliate = auth()->guard('affiliate')->user();
        $referalCode = $affiliate->referal_code;

        $data = Withdrawal::where('affiliate_id',$referalCode)->get();
        return view('affiliate.product-withdrawal-history',compact('data'));
    }

    public function levelWithdrawal()
    {
        $affiliate = auth()->guard('affiliate')->user();
        $referalCode = $affiliate->referal_code;
        $total = CommissionEarn::where('affiliate_id',$referalCode)->sum('amount');
        $withdrawal = Withdrawal::where('affiliate_id',$referalCode)->sum('amount');
        $balance = $total - $withdrawal;
        return view('affiliate.level-withdrawar',compact('balance','referalCode'));
    }

    public function storeWithdrawLevel(Request $request)
    {
        $request->validate([
            'affiliate_id' => 'required',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'payment_info' => 'required|string|max:500',
            'balance' => 'required|numeric'
        ]);

        if ($request->amount > $request->balance) {
            return back()->withErrors(['amount' => 'Amount cannot be greater than your balance!'])->withInput();
        }

        // Store the withdrawal request
        Withdrawal::create([
            'affiliate_id' => $request->affiliate_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_info' => $request->payment_info,
            'status' => 'pending', // Default status is 'pending'
        ]);

        return redirect()->route('affiliate.level')->with('success', 'Withdrawal request submitted successfully.');
    }






    // public function level()
    // {
    //     // $levels = CommissionLevel::where('status', 1)->get();
    //     // return view('affiliate.level', compact('levels'));

    //     $affiliate = auth()->guard('affiliate')->user();
    //     $referalCode = $affiliate->referal_code;

    //     // 1️⃣ Get all OrderItem by referal_code
    //     $items = OrderItem::where('referal_id', $referalCode)->get();

    //     // 2️⃣ Total Sales = sum(quantity * price)
    //     $totalSales = $items->sum(function ($item) {
    //         return $item->quantity * $item->price;
    //     });

    //     // 3️⃣ Detect current level based on sales range
    //     $currentLevel = CommissionLevel::where('start', '<=', $totalSales)
    //         ->where('end', '>=', $totalSales)
    //         ->first();

    //     // 4️⃣ If level found → calculate commission
    //     $earnedAmount = 0;

    //     if ($currentLevel) {
    //         $earnedAmount = ($totalSales * $currentLevel->persentage) / 100;

    //         // 5️⃣ Save earning ONLY if level end reached
    //         if ($totalSales >= $currentLevel->end) {

    //             CommissionEarn::updateOrCreate(
    //                 [
    //                     'affiliate_id' => $affiliate->id,
    //                     'level_id' => $currentLevel->id,
    //                 ],
    //                 [
    //                     'amount' => $earnedAmount,
    //                     'total_sales' => $totalSales,
    //                     'percentage' => $currentLevel->persentage,
    //                 ]
    //             );
    //         }
    //     }

    //     // 6️⃣ Total earnings from database
    //     $totalEarn = CommissionEarn::where('affiliate_id', $affiliate->id)->sum('amount');

    //     // all levels for table
    //     $levels = CommissionLevel::where('status', 1)->get();

    //     return view('affiliate.level', compact(
    //         'levels',
    //         'totalSales',
    //         'currentLevel',
    //         'earnedAmount',
    //         'totalEarn'
    //     ));
    // }

    // Dashboard
    public function dashboard()
    {

        // Get orders where the affiliate_id in orderItems matches the authenticated user's ID
        $orders = Order::with(['orderItems' => function ($query) {
            // Only load order items where the affiliate_id matches the authenticated affiliate
            $query->where('affiliate_id', Auth::guard('affiliate')->user()->id);
        }])
            ->latest()
            ->get();

        // Get the total count of orders for the authenticated affiliate
        $totalOrderCount = Order::whereHas('orderItems', function ($query) {
            $query->where('affiliate_id', Auth::guard('affiliate')->user()->id);
        })->count();


        $totalCompletedCommission = 0;
        $totalPendingCommission = 0;

        // Calculate total commission for completed and pending orders
        foreach ($orders as $order) {
            foreach ($order->orderItems as $orderItem) {
                // Calculate commission only if the product has a commission associated with it
                $productCommission = $orderItem->product->commission;

                if ($productCommission) {
                    $commissionAmount = $productCommission->amount; // Get commission amount from ProductCommission model
                    $price = $orderItem->price * $orderItem->quantity; // OrderItem price

                    // Calculate the commission percentage for this order item
                    $commissionForItem = ($commissionAmount / 100) * $price;


                    // Accumulate the total commission based on the order status
                    if ($order->status == 'completed') {
                        $totalCompletedCommission += $commissionForItem;
                    } elseif ($order->status == 'pending') {
                        $totalPendingCommission += $commissionForItem;
                    }
                }
            }
        }


        $withdraw = AffiliateWithdraw::where('affiliate_id', Auth::guard('affiliate')->user()->id)->sum('amount');

        $balance = $totalCompletedCommission - $withdraw;

        
        $affiliate = auth()->guard('affiliate')->user();
        $referalCode = $affiliate->referal_code;

        $level_product_count = OrderItem::where('referal_id',$referalCode)->sum('quantity');
        // $level_product_total_sales = OrderItem::where('referal_id', $referalCode)
        // ->get()
        // ->sum(function ($item) {
        //     return $item->quantity * $item->price;
        // });

        $level_product_total_sales = CommissionEarn::where('affiliate_id',$referalCode)->sum('total_sales');

        $level_commission_earning = CommissionEarn::where('affiliate_id',$referalCode)->sum('amount');
        $level_commission_withdrawal = Withdrawal::where('affiliate_id',$referalCode)->sum('amount');





        return view('affiliate.dashboard', compact(
            'orders',
            'totalOrderCount',
            'totalCompletedCommission',
            'totalPendingCommission',
            'withdraw',
            'balance',
            'level_product_count',
            'level_product_total_sales',
            'level_commission_earning',
            'level_commission_withdrawal'
        ));
    }

    public function settings()
    {
        return view('affiliate.settings');
    }
    public function profile()
    {
        $data = Auth::guard('affiliate')->user();
        return view('affiliate.profile', compact('data'));
    }
    public function profileEdit()
    {
        $data = Auth::guard('affiliate')->user();
        return view('affiliate.profile-edit', compact('data'));
    }

    public function passwordEdit()
    {
        return view('affiliate.auth.change-password');
    }

    public function update(Request $request)
    {
        $affilitae = Auth::guard('affiliate')->user();

        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:affiliates,username,' . $affilitae->id,
            'email' => 'required|email|max:255|unique:affiliates,email,' . $affilitae->id,
            'phone' => ['required', 'unique:affiliates,phone,' . $affilitae->id,],
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Delete old image if exists
            if ($affilitae->image && Storage::disk('public')->exists($affilitae->image)) {
                Storage::disk('public')->delete($affilitae->image);
            }

            // Generate unique filename
            $filename = 'affiliate/' . Str::uuid() . '.' . $image->getClientOriginalExtension();

            // Store image in public disk
            Storage::disk('public')->put($filename, file_get_contents($image));

            // Set validated image path
            $data['image'] = $filename;
        }

        // Update user data
        $affilitae->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully!');
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
        $user = Auth::guard('affiliate')->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password has been updated successfully.');
    }


    // salesProducts
    public function salesProducts()
    {
        $data = Product::where('status', 1)->get();
        return view('affiliate.salesProducts', compact('data'));
    }

    // Offer
    public function offers()
    {
        $data = Product::where('status', 1)
            ->whereHas('commission') // Fetch products with a commission
            ->with('commission')    // Eager load the commission relationship
            ->get();

        return view('affiliate.offers', compact('data'));
    }

    // Earnings
    public function earnings()
    {
        // Get orders where the affiliate_id in orderItems matches the authenticated user's ID
        $orders = Order::with(['orderItems' => function ($query) {
            // Only load order items where the affiliate_id matches the authenticated affiliate
            $query->where('affiliate_id', Auth::guard('affiliate')->user()->id);
        }])
            ->latest()
            ->get();


        $totalCompletedCommission = 0;
        $totalPendingCommission = 0;

        // Calculate total commission for completed and pending orders
        foreach ($orders as $order) {
            foreach ($order->orderItems as $orderItem) {
                // Calculate commission only if the product has a commission associated with it
                $productCommission = $orderItem->product->commission;

                if ($productCommission) {
                    $commissionAmount = $productCommission->amount; // Get commission amount from ProductCommission model
                    $price = $orderItem->price * $orderItem->quantity; // OrderItem price

                    // Calculate the commission percentage for this order item
                    $commissionForItem = ($commissionAmount / 100) * $price;


                    // Accumulate the total commission based on the order status
                    if ($order->status == 'completed') {
                        $totalCompletedCommission += $commissionForItem;
                    } elseif ($order->status == 'pending') {
                        $totalPendingCommission += $commissionForItem;
                    }
                }
            }
        }

        return view('affiliate.earnings', compact('orders', 'totalCompletedCommission', 'totalPendingCommission'));
    }

    // withdraw
    public function withdraw()
    {
        $data = AffiliateWithdraw::where('affiliate_id', Auth::guard('affiliate')->user()->id)->get();
        return view('affiliate.withdraw', compact('data'));
    }
    public function showWithdrawPage()
    {
        // Get orders where the affiliate_id in orderItems matches the authenticated user's ID
        $orders = Order::with(['orderItems' => function ($query) {
            // Only load order items where the affiliate_id matches the authenticated affiliate
            $query->where('affiliate_id', Auth::guard('affiliate')->user()->id);
        }])
            ->latest()
            ->get();


        $totalCompletedCommission = 0;
        $totalPendingCommission = 0;

        // Calculate total commission for completed and pending orders
        foreach ($orders as $order) {
            foreach ($order->orderItems as $orderItem) {
                // Calculate commission only if the product has a commission associated with it
                $productCommission = $orderItem->product->commission;

                if ($productCommission) {
                    $commissionAmount = $productCommission->amount; // Get commission amount from ProductCommission model
                    $price = $orderItem->price * $orderItem->quantity; // OrderItem price

                    // Calculate the commission percentage for this order item
                    $commissionForItem = ($commissionAmount / 100) * $price;


                    // Accumulate the total commission based on the order status
                    if ($order->status == 'completed') {
                        $totalCompletedCommission += $commissionForItem;
                    } elseif ($order->status == 'pending') {
                        $totalPendingCommission += $commissionForItem;
                    }
                }
            }
        }

        $withdraw = AffiliateWithdraw::where('affiliate_id', Auth::guard('affiliate')->user()->id)->sum('amount');

        $balance = $totalCompletedCommission - $withdraw;

        return view('affiliate.withdraw-request', compact('balance'));
    }

    public function storeWithdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'payment_info' => 'required|string',
        ]);

        if ($request->amount > $request->balance) {
            return back()->withErrors(['amount' => 'Withdrawal amount cannot exceed your available balance.'])->withInput();
        }

        // Store the withdrawal request
        AffiliateWithdraw::create([
            'affiliate_id' => Auth::guard('affiliate')->user()->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_info' => $request->payment_info,
            'status' => 'pending', // Default status is 'pending'
        ]);

        return redirect()->route('affiliate.withdraw')->with('success', 'Withdrawal request submitted successfully.');
    }
}
