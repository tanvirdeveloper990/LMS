<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function pay(Request $request)
    {
        // 1) Validate Request
        $request->validate([
            'customer_name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'delivery_area' => 'required|string',
            'payment_method' => 'required|string',
            'total' => 'required|numeric',
        ]);

        // 2) User Check (Auth or Guest)
        if (Auth::check()) {
            $userId = Auth::id();
            $user = Auth::user();
        } else {
            $uniqueString = Str::random(6) . time();
            $guestEmail = 'guest_' . $uniqueString . '@example.com';
            $guestUsername = 'guest_' . $uniqueString;

            // Create guest user
            $guestUser = User::create([
                'name' => $request->customer_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $guestEmail,
                'username' => $guestUsername,
                'password' => bcrypt(Str::random(8)),
            ]);

            $userId = $guestUser->id;
            $user = $guestUser;
        }

       
        // 3) Generate Transaction ID
        $tran_id = "SSLCZ_" . uniqid();

        // 4) Create Order Before Payment
        $order = Order::create([
            // 'order_id' => strtoupper(Str::random(8)),
            'user_id' => $userId,
            'total' => $request->total,
            'delivery_charge' => $request->delivery_charge ?? 0,
            'coupon' => $request->coupon_amount,
            'coupon_code' => $request->coupon_code,
            'status' => 'pending',
            'payment_method' => 'sslcommerz',
            'payment_status' => 'pending',
            'transaction_id' => $tran_id,
            'payment_date' => now(),
            'delivery_area' => $request->delivery_area,
            'currency' => 'BDT',
        ]);

        
        $items = json_decode($request->items, true);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['productId'],
                'product_variant_id' => $item['variantId'] ?? null,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'affiliate_id' => $item['affiliateId'] ?? null,
                'referal_id' => $item['affiliateRefaral'] ?? null, // Ensure affiliate_id is passed
            ]);
        }

       

        // 6) Prepare SSLCommerz Data
        $post_data = [];
        $post_data['store_id'] = env('SSLCZ_STORE_ID');
        $post_data['store_passwd'] = env('SSLCZ_STORE_PASSWORD');

        $post_data['total_amount'] = $request->total;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $tran_id;

       



        // Customer Info
        $post_data['cus_name'] = $request->customer_name;
        $post_data['cus_email'] = $user->email;
        $post_data['cus_add1'] = $request->address;
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->phone;

        // Product Information
        $post_data['product_profile'] = "general";
        $post_data['product_name'] = "Order #" . $order->order_id;


      
        $post_data['ship_name']     = $request->customer_name;
        $post_data['ship_add1']     = $request->address;
        $post_data['ship_city']     = "Dhaka";
        $post_data['ship_state']    = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_country']  = "Bangladesh";
        $post_data['product_category'] = 'Ecommerce';
        $post_data['shipping_method'] = "No";

        

        // Callback URLs
        $post_data['success_url'] = url('/api/success');
        $post_data['fail_url'] = route('fail');
        $post_data['cancel_url'] = route('cancel');

        


        // 7) Call SSLCommerz
        $sslc = new SslCommerzNotification();
        $payment_options = $sslc->makePayment($post_data, 'hosted'); // hosted = redirect page

        //   dd($request->all());

        if (!is_array($payment_options)) {
            return $payment_options;
        }
    }



    // public function success(Request $request)
    // {
        
        
    //     $tran_id = $request->tran_id;

    //     DB::table('orders')->where('transaction_id', $tran_id)->update([
    //         'status' => 'Paid'
    //     ]);

    //     return redirect('/');
    // }

    public function success(Request $request)
    {
        $tran_id = $request->tran_id;

        // Find order
        $order = DB::table('orders')->where('transaction_id', $tran_id)->first();

        if (!$order) {
            return "Invalid Transaction";
        }

        // Update order → paid
        DB::table('orders')->where('transaction_id', $tran_id)->update([
            'status' => 'paid'
        ]);

        // Flash message
        session()->flash('success', 'Payment Successful! Your order has been placed.');

        // Return JavaScript like COD logic
        return response()->make("
            <script>
                // Clear cart from localStorage
                localStorage.removeItem('cart');

                // Update totals (same function you use in COD)
                if (typeof updateTotals === 'function') {
                    updateTotals();
                }

                // Redirect to success page just like COD
                window.location.href = '/success/{$order->order_id}';
            </script>
        ");
    }


    public function fail(Request $request)
    {
        return "Payment Failed";
    }

    public function cancel(Request $request)
    {
        return "Payment Cancelled";
    }
}
