<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pathau;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Redx;
use App\Models\Setting;
use App\Models\StredFast;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view order')->only('index');
        $this->middleware('permission:create order')->only(['create', 'store']);
        $this->middleware('permission:edit order')->only(['edit', 'update']);
        $this->middleware('permission:delete order')->only('destroy');

        $this->middleware('permission:view pending-order')->only('index');
        $this->middleware('permission:create pending-order')->only(['create', 'store']);
        $this->middleware('permission:edit pending-order')->only(['edit', 'update']);
        $this->middleware('permission:delete pending-order')->only('destroy');

        $this->middleware('permission:view processing-order')->only('index');
        $this->middleware('permission:create processing-order')->only(['create', 'store']);
        $this->middleware('permission:edit processing-order')->only(['edit', 'update']);
        $this->middleware('permission:delete processing-order')->only('destroy');

        $this->middleware('permission:view on-the-way')->only('index');
        $this->middleware('permission:create on-the-way')->only(['create', 'store']);
        $this->middleware('permission:edit on-the-way')->only(['edit', 'update']);
        $this->middleware('permission:delete on-the-way')->only('destroy');

        $this->middleware('permission:view hold')->only('index');
        $this->middleware('permission:create hold')->only(['create', 'store']);
        $this->middleware('permission:edit hold')->only(['edit', 'update']);
        $this->middleware('permission:delete hold')->only('destroy');

        $this->middleware('permission:view couriers')->only('index');
        $this->middleware('permission:create couriers')->only(['create', 'store']);
        $this->middleware('permission:edit couriers')->only(['edit', 'update']);
        $this->middleware('permission:delete couriers')->only('destroy');

        $this->middleware('permission:view complete')->only('index');
        $this->middleware('permission:create complete')->only(['create', 'store']);
        $this->middleware('permission:edit complete')->only(['edit', 'update']);
        $this->middleware('permission:delete complete')->only('destroy');

        $this->middleware('permission:view cancelled')->only('index');
        $this->middleware('permission:create cancelled')->only(['create', 'store']);
        $this->middleware('permission:edit cancelled')->only(['edit', 'update']);
        $this->middleware('permission:delete cancelled')->only('destroy');
    }


    public function allOrders()
    {
        $orders = Order::with(['user', 'orderItems.product.vendor'])->latest()->get();
        return view('admin.orders.all', compact('orders'));
    }

private function buildProductVariants($products)
{
    $result = [];
 
    foreach ($products as $product) {
        $variants = $product->relationLoaded('variants')
            ? $product->variants
            : $product->variants()->with('color', 'size')->get();
 
        $variantList = [];
        foreach ($variants as $variant) {
            $colorCode = optional($variant->color)->code ?? null;
 
            // code ঠিকমতো না থাকলে color_id দিয়ে একটা consistent hex বানাও
            if (!$colorCode || $colorCode === '#') {
                $colorCode = '#' . substr(md5((string)($variant->color_id ?? 'x')), 0, 6);
            }
 
            // # prefix না থাকলে যোগ করো
            if ($colorCode && $colorCode[0] !== '#') {
                $colorCode = '#' . $colorCode;
            }
 
            $variantList[] = [
                'color_id' => $variant->color_id,
                'color'    => optional($variant->color)->name,
                'code'     => $colorCode,
                'size_id'  => $variant->size_id,
                'size'     => optional($variant->size)->name,
                'price'    => $variant->price,
                'stock'    => $variant->stock,
            ];
        }
 
        // ✅ KEY সবসময় STRING — JS এ window.PV["12"] কাজ করবে
        $result[(string) $product->id] = $variantList;
    }
 
    return $result;
}



/**
 * ✅ color/size combination অনুযায়ী সঠিক ProductVariant খুঁজে বের করে।
 * তিন রকম কেস কভার করে: color+size / শুধু color / শুধু size।
 * store(), update(), updateStatus() — সব জায়গায় একই লজিক reuse করার জন্য।
 */
private function findVariant($productId, $color, $size)
{
    if (!empty($color) && !empty($size)) {
        return ProductVariant::where('product_id', $productId)
            ->whereHas('color', fn($q) => $q->where('name', $color))
            ->whereHas('size',  fn($q) => $q->where('name', $size))
            ->first();
    }

    if (!empty($color)) {
        return ProductVariant::where('product_id', $productId)
            ->whereHas('color', fn($q) => $q->where('name', $color))
            ->first();
    }

    if (!empty($size)) {
        return ProductVariant::where('product_id', $productId)
            ->whereHas('size', fn($q) => $q->where('name', $size))
            ->first();
    }

    return null;
}

/**
 * ✅ OrderItem থেকে color/size বের করে সেই variant-এর stock ফেরত (increment) দেয়।
 */
private function restoreVariantStock($item)
{
    $variantInfo = is_array($item->product_variant_id)
        ? $item->product_variant_id
        : json_decode($item->product_variant_id, true);

    $color = $variantInfo['color'] ?? null;
    $size  = $variantInfo['size']  ?? null;

    $variant = $this->findVariant($item->product_id, $color, $size);

    if ($variant) {
        $variant->increment('stock', $item->quantity);
    }
}

/**
 * ✅ OrderItem থেকে color/size বের করে সেই variant-এর stock আবার কাটে (decrement)।
 */
private function deductVariantStock($item)
{
    $variantInfo = is_array($item->product_variant_id)
        ? $item->product_variant_id
        : json_decode($item->product_variant_id, true);

    $color = $variantInfo['color'] ?? null;
    $size  = $variantInfo['size']  ?? null;

    $variant = $this->findVariant($item->product_id, $color, $size);

    if ($variant && $variant->stock >= $item->quantity) {
        $variant->decrement('stock', $item->quantity);
    }
}
 
 
// ── 2. create() ───────────────────────────────────────────────
public function create()
{
    $users    = User::where('status', 1)->get();
    $products = Product::where('status', 1)
                    ->with(['variants.color', 'variants.size'])
                    ->get();
    $productVariants = $this->buildProductVariants($products);
    return view('admin.orders.create', compact('users', 'products', 'productVariants'));
}
 
 



public function store(Request $request)
{
    $isManual = $request->filled('manual_name');

    $request->validate([
        'user_id'    => $isManual ? 'nullable' : 'required|exists:users,id',
        'manual_name'  => $isManual ? 'required|string|max:255' : 'nullable',
        'manual_phone' => $isManual ? 'required|string|max:20'  : 'nullable',
        'products'   => 'required|array|min:1',
        'products.*' => 'exists:products,id',
        'status'         => 'nullable|in:pending,processing,on the way,on hold,completed,cancelled',
        'payment_status' => 'nullable|in:pending,paid,unpaid',
    ]);

    $colors = $request->colors ?? [];
    $sizes  = $request->sizes  ?? [];

    $items = [];
    $total = 0;

    // ✅ FIX — $idx দিয়ে quantities/colors/sizes মেলাও
    foreach ($request->products as $idx => $productId) {
        $qty     = $request->quantities[$idx] ?? 1;
        $product = Product::findOrFail($productId);

        $color = $colors[$idx] ?? null;
        $size  = $sizes[$idx]  ?? null;

        $price = $product->sale_price;
        if (!empty($color) || !empty($size)) {
            $variant = ProductVariant::where('product_id', $productId)
                ->when($color, fn($q) => $q->whereHas('color', fn($c) => $c->where('name', $color)))
                ->when($size,  fn($q) => $q->whereHas('size',  fn($s) => $s->where('name', $size)))
                ->first();
            if ($variant && $variant->price) {
                $price = $variant->price;
            }
        }

        $total += $price * $qty;

        $variantInfo = null;
        if (!empty($color) || !empty($size)) {
            $variantInfo = json_encode([
                'color' => $color,
                'size'  => $size,
            ], JSON_UNESCAPED_UNICODE);
        }

        $items[] = [
            'product_id'         => $productId,
            'quantity'           => $qty,
            'price'              => $price,
            'product_variant_id' => $variantInfo,
            'color'              => $color,
            'size'               => $size,
        ];
    }

    if ($isManual) {
        $email = $request->manual_email ?: null;

        if ($email) {
            $existingUser = User::where('email', $email)->first();
            $userId = $existingUser ? $existingUser->id : User::create([
                'name'     => $request->manual_name,
                'phone'    => $request->manual_phone,
                'email'    => $email,
                'address'  => $request->manual_address ?? null,
                'password' => bcrypt('password123'),
            ])->id;
        } else {
            $existingUser = User::where('phone', $request->manual_phone)->first();
            $userId = $existingUser ? $existingUser->id : User::create([
                'name'     => $request->manual_name,
                'phone'    => $request->manual_phone,
                'email'    => 'manual_' . $request->manual_phone . '_' . time() . '@order.com',
                'address'  => $request->manual_address ?? null,
                'password' => bcrypt('password123'),
            ])->id;
        }
    } else {
        $userId = $request->user_id;
    }

    $order = Order::create([
        'order_id'        => 'ORD-' . strtoupper(uniqid()),
        'user_id'         => $userId,
        'total'           => ($total + ($request->delivery_charge ?? 0)) - ($request->coupon ?? 0),
        'delivery_charge' => $request->delivery_charge ?? 0,
        'coupon'          => $request->coupon ?? 0,
        'paid'            => $request->paid ?? 0,
        'payment_method'  => $request->payment_method ?? 'cod',
        'transaction_id'  => $request->transaction_id ?? null,
        'payment_number'  => $request->payment_number ?? null,
        'payment_status'  => $request->payment_status ?? 'unpaid',
        'status'          => $request->status ?? 'pending',
        'notes'           => $request->notes,
    ]);

    foreach ($items as $item) {
        $order->orderItems()->create([
            'product_id'         => $item['product_id'],
            'quantity'           => $item['quantity'],
            'price'              => $item['price'],
            'product_variant_id' => $item['product_variant_id'],
        ]);

        Product::where('id', $item['product_id'])
            ->where('stock', '>=', $item['quantity'])
            ->decrement('stock', $item['quantity']);

        $variant = $this->findVariant($item['product_id'], $item['color'], $item['size']);
        if ($variant && $variant->stock >= $item['quantity']) {
            $variant->decrement('stock', $item['quantity']);
        }
    }

    return redirect()->route('admin.orders.show', $order->id)
        ->with('success', 'Order created successfully!');
}



    // ── 3. edit() ─────────────────────────────────────────────────
public function edit($id)
{
    $order    = Order::with('orderItems.product', 'user')->findOrFail($id);
    $users    = User::where('status', 1)->get();
    $products = Product::where('status', 1)
                    ->with(['variants.color', 'variants.size'])
                    ->get();
    $productVariants = $this->buildProductVariants($products);
 
    $order->orderItems->each(function ($item) {
        // product_variant_id cast array অথবা JSON string দুটোই handle করো
        $variantInfo = $item->product_variant_id;
        if (is_string($variantInfo)) {
            $variantInfo = json_decode($variantInfo, true);
        }
        $item->selected_color = $variantInfo['color'] ?? null;
        $item->selected_size  = $variantInfo['size']  ?? null;
    });
 
    return view('admin.orders.edit', compact('order', 'users', 'products', 'productVariants'));
}



public function update(Request $request, $id)
{
    $order = Order::with('orderItems')->findOrFail($id);

    $request->validate([
        'status'         => 'nullable|in:pending,processing,on the way,on hold,completed,cancelled',
        'payment_status' => 'nullable|in:pending,paid,unpaid',
    ]);

    foreach ($order->orderItems as $oldItem) {
        Product::where('id', $oldItem->product_id)
            ->increment('stock', $oldItem->quantity);

        $this->restoreVariantStock($oldItem);
    }

    $colors = $request->colors ?? [];
    $sizes  = $request->sizes  ?? [];

    $total = 0;
    $items = [];

    // ✅ FIX — $idx দিয়ে quantities/colors/sizes মেলাও
    foreach ($request->products as $idx => $productId) {
        $qty     = $request->quantities[$idx] ?? 1;
        $product = Product::findOrFail($productId);

        $color = $colors[$idx] ?? null;
        $size  = $sizes[$idx]  ?? null;

        $price = $product->sale_price;
        if (!empty($color) || !empty($size)) {
            $variant = ProductVariant::where('product_id', $productId)
                ->when($color, fn($q) => $q->whereHas('color', fn($c) => $c->where('name', $color)))
                ->when($size,  fn($q) => $q->whereHas('size',  fn($s) => $s->where('name', $size)))
                ->first();
            if ($variant && $variant->price) {
                $price = $variant->price;
            }
        }

        $total += $price * $qty;

        $variantInfo = null;
        if (!empty($color) || !empty($size)) {
            $variantInfo = json_encode([
                'color' => $color,
                'size'  => $size,
            ], JSON_UNESCAPED_UNICODE);
        }

        $items[] = [
            'product_id'         => $productId,
            'quantity'           => $qty,
            'price'              => $price,
            'product_variant_id' => $variantInfo,
            'color'              => $color,
            'size'               => $size,
        ];
    }

    $oldStatus = $order->status;
    $newStatus = $request->status ?? $order->status;

    $order->update([
        'user_id'         => $request->user_id,
        'total'           => ($total + ($request->delivery_charge ?? 0)) - ($request->coupon ?? 0),
        'delivery_charge' => $request->delivery_charge ?? 0,
        'paid'            => $request->paid ?? 0,
        'coupon'          => $request->coupon ?? 0,
        'payment_method'  => $request->payment_method,
        'transaction_id'  => $request->transaction_id,
        'payment_number'  => $request->payment_number,
        'notes'           => $request->notes,
        'status'          => $newStatus,
        'payment_status'  => $request->payment_status ?? $order->payment_status,
    ]);

    $order->orderItems()->delete();

    foreach ($items as $item) {
        $order->orderItems()->create([
            'product_id'         => $item['product_id'],
            'quantity'           => $item['quantity'],
            'price'              => $item['price'],
            'product_variant_id' => $item['product_variant_id'],
        ]);

        if ($newStatus !== 'cancelled') {
            Product::where('id', $item['product_id'])
                ->where('stock', '>=', $item['quantity'])
                ->decrement('stock', $item['quantity']);

            $variant = $this->findVariant($item['product_id'], $item['color'], $item['size']);
            if ($variant && $variant->stock >= $item['quantity']) {
                $variant->decrement('stock', $item['quantity']);
            }
        }
    }

    if ($newStatus === 'completed' && $oldStatus !== 'completed' && !$order->points_credited) {
        if ($order->total_point > 0 && $order->user_id) {
            $user = User::find($order->user_id);
            if ($user) {
                $user->increment('points', $order->total_point);
            }
        }
        $order->points_credited = true;
        $order->save();
    }

    return redirect()->route('admin.orders.show', $order->id)
        ->with('success', 'Order updated successfully!');
}

    // SteadFast

    public function sendToSteadfast($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);

        $sf = StredFast::first();

        if (!$order->user) {
            return back()->with('error', 'Order user not found!');
        }

        if ($order->orderItems->isEmpty()) {
            return back()->with('error', 'Order has no items!');
        }

        $item_description = $order->orderItems->map(function ($item) {
            $productName = $item->product->name ?? 'N/A';
            return $productName . ' x ' . $item->quantity;
        })->implode(', ');

        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' => $sf->secret_key,
            'Content-Type' => 'application/json'
        ])->post($sf->url . '/create_order', [
            'invoice'           => $order->order_id,
            'recipient_name'    => $order->user->name,
            'recipient_phone'   => $order->user->phone,
            'recipient_address' => $order->user->address ?? 'N/A',
            'cod_amount'        => $order->total,
            'note'              => $order->note ?? '',
            'item_description'  => $item_description,
            'delivery_type'     => 0,
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['consignment']['tracking_code'])) {
            $order->update([
                'steadfast_tracking' => $data['consignment']['tracking_code'],
                'steadfast_cid'     => $data['consignment']['consignment_id'],
                'status'     => 'steadfast',
            ]);

            return back()->with('success', 'Order sent to Steadfast successfully!');
        }

        return back()->with('error', 'Steadfast Error: ' . ($data['message'] ?? 'Invalid API response'));
    }


    public function steadfastStatus($invoice)
    {
        $sf = StredFast::first();
        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' => $sf->secret_key,
            'Content-Type' => 'application/json'
        ])->get($sf->url . '/status_by_invoice/' . $invoice);

        return $response->json();
    }

    public function steadfastBalance()
    {
        $sf = StredFast::first();
        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' =>  $sf->secret_key,
        ])->get($sf->url . '/get_balance');

        return $response->json();
    }

    public function steadfastReturn($consignment_id)
    {
        $sf = StredFast::first();
        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' =>  $sf->secret_key,
            'Content-Type' => 'application/json'
        ])->post($sf->url . '/create_return_request', [
            'consignment_id' => $consignment_id,
            'reason' => 'Customer Requested Return'
        ]);

        return $response->json();
    }

    // Pathao


    public function getPathaoStores()
    {
        $pathao = Pathau::first();

        // Token নিন
        $tokenResponse = Http::post($pathao->api_key . '/aladdin/api/v1/issue-token', [
            "client_id"     => "7N1aMJQbWm",
            "client_secret" => "wRcaibZkUdSNz2EI9ZyuXLlNrnAv0TdPUPXMnD39",
            "grant_type"    => "password",
            "username"      => "test@pathao.com",
            "password"      => "lovePathao",
        ]);

        $accessToken = $tokenResponse->json()['access_token'];

        // Store list আনুন
        $storeResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://courier-api-sandbox.pathao.com/aladdin/api/v1/stores');

        dd($storeResponse->json());
    }


 public function sendToPathao($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        $pathao = Pathau::first();
    
        // Step 1: Token
        $tokenResponse = Http::post($pathao->api_key . '/aladdin/api/v1/issue-token', [
            "client_id"     => $pathao->client_id,
            "client_secret" => $pathao->secret_key,
            "grant_type"    => "password",
            "username"      => $pathao->client_email,
            "password"      => $pathao->client_password,
        ]);
    
        if (!$tokenResponse->successful()) {
            return back()->with('error', 'Token Error: ' . $tokenResponse->body());
        }
    
        $accessToken = $tokenResponse->json()['access_token'];
    
        // Step 2: Order Create
        $orderResponse = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->post($pathao->api_key . '/aladdin/api/v1/orders', [
            "store_id"            => (int) $pathao->store_id,
            "merchant_order_id"   => (string) $order->order_id,
            "recipient_name"      => $order->user->name ?? 'Guest',
            "recipient_phone"     => $order->user->phone ?? '01700000000',
            "recipient_address"   => $order->user->address ?? 'N/A',
            "delivery_type"       => 48,
            "item_type"           => 2,
            "special_instruction" => $order->notes ?? '',
            "item_quantity"       => (int) $order->orderItems->sum('quantity'),
            "item_weight"         => 0.5,
            "item_description"    => $order->orderItems
                                        ->map(fn($i) => $i->product->name . ' x ' . $i->quantity)
                                        ->implode(', '),
            "amount_to_collect"   => (int) round($order->total),
        ]);
    
        $data = $orderResponse->json();
    
        // ✅ consignment_id দিয়ে save
        $consignmentId = $data['data']['consignment_id'] ?? null;
    
        if ($consignmentId) {
            $order->update([
                'pathao_tracking' => $consignmentId,
                'pathao_order_id' => $consignmentId,
                'status'          => 'pathao',
            ]);
            return back()->with('success', 'Pathao তে Order পাঠানো সফল হয়েছে! Tracking: ' . $consignmentId);
        }
    
        return back()->with('error', 'Pathao Error: ' . json_encode($data));
    }

    // Redx
    public function sendToRedX($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        $redx = Redx::first();

        $jwtToken = $redx->api_token; // JWT token from RedX
        $storeId = $redx->store_id; // Pickup store id

        $parcelDetails = $order->orderItems->map(function ($item) {
            return [
                'name' => $item->product->name ?? 'N/A',
                'qty' => $item->quantity ?? 'N/A',
                'value' => (float) $item->price,
            ];
        });

        $payload = [
            'customer_name' => $order->user->name ?? 'Guest',
            'customer_phone' => $order->user->phone,
            'delivery_area' => $order->user->address ?? 'N/A',
            'delivery_area_id' => 1,
            'customer_address' => $order->address ?? 'N/A',
            'merchant_invoice_id' => $order->order_id,
            'cash_collection_amount' => (int) round($order->total),
            'parcel_weight' => 0.5,
            'instruction' => $order->notes ?? '',
            'value' => (float) $order->total,
            'is_closed_box' => true, // boolean type now
            'pickup_store_id' => $storeId,
            'parcel_details_json' => $parcelDetails,
        ];


        $response = Http::withHeaders([
            'API-ACCESS-TOKEN' => 'Bearer ' . $jwtToken,
            'Content-Type' => 'application/json'
        ])->post('https://sandbox.redx.com.bd/v1.0.0-beta/parcel', $payload);

        $data = $response->json();
        // dd($data);

        if ($response->successful() && isset($data['tracking_id'])) {
            $order->update([
                'redx_tracking' => $data['tracking_id'] ?? null,
                'status' => 'redx'
            ]);

            return back()->with('success', 'Order sent to RedX successfully! Tracking ID: ' . ($data['tracking_id'] ?? 'N/A'));
        } else {
            return back()->with('error', 'RedX Error: ' . ($data['message'] ?? 'Unknown error'));
        }
    }








    public function show($id)
    {
        $order = Order::with('orderItems.product', 'user')->findOrFail($id);
        $setting = Setting::first();
        return view('admin.orders.show', compact('order', 'setting'));
    }



    public function updateStatus(Request $request, Order $order)
{
    $field = $request->field;
    $value = $request->value;

    if (in_array($field, ['status', 'payment_status'])) {

        // Payment paid হলে paid amount update
        if ($field === 'payment_status' && $value === 'paid') {
            $order->paid = $order->total;
        }

        // ✅ Cancel হলে stock ফেরত দাও (main product + variant দুটোই)
        if ($field === 'status' && $value === 'cancelled' && $order->status !== 'cancelled') {
            foreach ($order->orderItems as $item) {
                Product::where('id', $item->product_id)
                    ->increment('stock', $item->quantity);

                $this->restoreVariantStock($item);
            }
        }

        // ✅ আগে cancelled ছিল, এখন অন্য status হলে stock আবার কাটো (main + variant)
        if ($field === 'status' && $order->status === 'cancelled' && $value !== 'cancelled') {
            foreach ($order->orderItems as $item) {
                Product::where('id', $item->product_id)
                    ->decrement('stock', $item->quantity);

                $this->deductVariantStock($item);
            }
        }

        // ✅ Order "completed" হলে reward point credit করো — শুধু একবারই
        if ($field === 'status' && $value === 'completed' && !$order->points_credited) {
            if ($order->total_point > 0 && $order->user_id) {
                $user = User::find($order->user_id);
                if ($user) {
                    $user->increment('points', $order->total_point);
                }
            }
            $order->points_credited = true;
        }

        $order->$field = $value;
        $order->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 400);
}



    public function pendingOrders()
    {
        $orders = Order::where('status', 'pending')->latest()->get();
        return view('admin.orders.pending', compact('orders'));
    }

    public function processingOrders()
    {
        $orders = Order::where('status', 'processing')->latest()->get();
        return view('admin.orders.processing', compact('orders'));
    }

    public function onTheWayOrders()
    {
        $orders = Order::where('status', 'on the way')->latest()->get();
        return view('admin.orders.on-the-way', compact('orders'));
    }

    public function holdOrders()
    {
        $orders = Order::where('status', 'on hold')->latest()->get();
        return view('admin.orders.hold', compact('orders'));
    }

    public function courierOrders()
    {
        $orders = Order::where('status', 'pathao')->orWhere('status', 'redx')->orWhere('status', 'steadfast')->latest()->get();
        return view('admin.orders.courier', compact('orders'));
    }

    public function completeOrders()
    {
        $orders = Order::where('status', 'completed')->latest()->get();
        return view('admin.orders.complete', compact('orders'));
    }

    public function cancelledOrders()
    {
        $orders = Order::where('status', 'cancelled')->latest()->get();
        return view('admin.orders.cancelled', compact('orders'));
    }

    public function stock_report(Request $request)
    {
        $query = Product::select('id', 'name', 'sale_price', 'purchase_price', 'stock')
            ->where('status', 1);

        if ($request->keyword) {
            $query->where('name', 'LIKE', '%' . $request->keyword . '%');
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        }

        // ✅ Totals পুরো filtered set থেকে (pagination-এর আগে) — নির্ভুল
        $total_purchase = (clone $query)->sum(\DB::raw('purchase_price * stock'));
        $total_stock    = (clone $query)->sum('stock');
        $total_price    = (clone $query)->sum(\DB::raw('sale_price * stock'));
        $total_products = (clone $query)->count();

        $products   = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::where('status', 1)->get();

        return view('admin.reports.stock', compact(
            'products', 'categories', 'total_purchase', 'total_stock', 'total_price', 'total_products'
        ));
    }


   public function order_report(Request $request)
{
    $users    = User::where('status', 1)->get();
    $products = Product::where('status', 1)->orderBy('name')->get();

    $ordersQuery = OrderItem::with(['order', 'order.user', 'product'])
        ->whereHas('order', function ($q) {
            $q->where('status', 'completed');
        });

    // Filter: keyword (order_id)
    if ($request->keyword) {
        $ordersQuery->whereHas('order', function ($q) use ($request) {
            $q->where('order_id', 'LIKE', '%' . $request->keyword . '%');
        });
    }

    // Filter: user
    if ($request->user_id) {
        $ordersQuery->whereHas('order', function ($q) use ($request) {
            $q->where('user_id', $request->user_id);
        });
    }

    // Filter: product
    if ($request->product_id) {
        $ordersQuery->where('product_id', $request->product_id);
    }

    // Filter: date range
    if ($request->start_date && $request->end_date) {
        $ordersQuery->whereHas('order', function ($q) use ($request) {
            $q->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date   . ' 23:59:59',
            ]);
        });
    }

    $allOrders = (clone $ordersQuery)->get();

    $total_purchase = $allOrders->sum(fn($i) => ($i->product->purchase_price ?? 0) * $i->quantity);
    $total_item     = $allOrders->sum('quantity');
    $total_sales    = $allOrders->sum(fn($i) => ($i->price ?? 0) * $i->quantity);
    $total_orders   = $allOrders->pluck('order_id')->unique()->count();

    // ✅ Average order value
    $avg_order_value = $total_orders > 0 ? ($total_sales / $total_orders) : 0;

    // ✅ Top selling product (by quantity)
    $topProduct = $allOrders->groupBy('product_id')
        ->map(function ($group) {
            return [
                'name' => $group->first()->product->name ?? 'N/A',
                'qty'  => $group->sum('quantity'),
                'revenue' => $group->sum(fn($i) => ($i->price ?? 0) * $i->quantity),
            ];
        })
        ->sortByDesc('qty')
        ->first();

    // Daily summary
    $dailySummary = $allOrders->groupBy(function ($i) {
        return optional($i->order)->created_at?->format('Y-m-d') ?? 'N/A';
    })->map(function ($group, $date) {
        return [
            'date'     => $date,
            'qty'      => $group->sum('quantity'),
            'orders'   => $group->pluck('order_id')->unique()->count(),
            'revenue'  => $group->sum(fn($i) => ($i->price ?? 0) * $i->quantity),
            'purchase' => $group->sum(fn($i) => ($i->product->purchase_price ?? 0) * $i->quantity),
        ];
    })->sortKeysDesc();

    $orders = $ordersQuery->latest()->paginate(15)->withQueryString();

    return view('admin.reports.order', compact(
        'orders', 'users', 'products',
        'total_purchase', 'total_item', 'total_sales',
        'total_orders', 'avg_order_value', 'topProduct',
        'dailySummary'
    ));
}
}