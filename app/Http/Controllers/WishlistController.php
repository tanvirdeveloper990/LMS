<?php

namespace App\Http\Controllers;

use App\Models\CommissionEarn;
use App\Models\CommissionLevel;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function Orderindex()
    {
        $orders = Order::with('orderItems')->where('user_id', Auth::id())
            ->get();
        return view('user.order', compact('orders'));
    }

    public function orderView($id)
    {
        $order = Order::with(['orderItems.product'])->where('id', $id)->firstOrFail();
        return response()->json($order);
    }

    public function level()
    {
        // $levels = CommissionLevel::where('status',1)->get();
        // return view('user.level',compact('levels'));
        $affiliate = auth()->guard('web')->user();
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

        return view('user.level', compact(
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

     // salesProducts
    public function salesProducts()
    {
        $data = Product::where('status', 1)->get();
        return view('user.salesProducts', compact('data'));

    }

    public function salesProductsEarning()
    {
        $affiliate = auth()->guard('web')->user();
        $referalCode = $affiliate->referal_code;

        $data = CommissionEarn::where('affiliate_id',$referalCode)->get();
        $withdrawal = Withdrawal::where('affiliate_id',$referalCode)->sum('amount');
        return view('user.level-history',compact('data','withdrawal'));
    }
    public function salesProductsWithdrawalHistory()
    {
        $affiliate = auth()->guard('web')->user();
        $referalCode = $affiliate->referal_code;

        $data = Withdrawal::where('affiliate_id',$referalCode)->get();
        return view('user.product-withdrawal-history',compact('data'));
    }

    public function levelWithdrawal()
    {
        $affiliate = auth()->guard('web')->user();
        $referalCode = $affiliate->referal_code;
        $total = CommissionEarn::where('affiliate_id',$referalCode)->sum('amount');
        $withdrawal = Withdrawal::where('affiliate_id',$referalCode)->sum('amount');
        $balance = $total - $withdrawal;
        return view('user.level-withdrawar',compact('balance','referalCode'));
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

        return redirect()->route('levels')->with('success', 'Withdrawal request submitted successfully.');
    }




    // 🧡 Wishlist দেখানো
    public function index()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get();
        return view('user.wishlist', compact('wishlists'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'error', 'message' => 'Please login to add to wishlist.']);
        }

        $product_id = $request->product_id;
        $user_id = auth()->id();

        $exists = Wishlist::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if ($exists) {
            $exists->delete();
            $wishlistCount = Wishlist::where('user_id', $user_id)->count();

            return response()->json([
                'status' => 'removed',
                'message' => 'Removed from wishlist.',
                'wishlistCount' => $wishlistCount,
            ]);
        }

        Wishlist::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
        ]);

        $wishlistCount = Wishlist::where('user_id', $user_id)->count();

        return response()->json([
            'status' => 'added',
            'message' => 'Added to wishlist.',
            'wishlistCount' => $wishlistCount,
        ]);
    }
}
