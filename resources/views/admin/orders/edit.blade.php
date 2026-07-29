@extends('admin.layouts.app')
@section('title', 'Edit Order #' . $order->order_id)

@section('content')
<style>
:root{
    --p:#7c3aed; --p-dark:#5b21b6; --p-light:#ede9fe;
    --ink:#1e1b4b; --muted:#6b7280; --border:#e5e7eb;
    --green:#059669; --red:#dc2626;
}
.co-wrap{ max-width:1180px; margin:0 auto; padding:20px 16px; }
.co-top{ display:flex; justify-content:space-between; align-items:center; margin-bottom:22px; flex-wrap:wrap; gap:10px; }
.co-title{ font-size:19px; font-weight:800; color:var(--ink); display:flex; align-items:center; gap:10px; }
.co-title-icon{ width:34px; height:34px; border-radius:9px; background:var(--p); display:grid; place-items:center; color:#fff; font-size:13px; }
.co-actions{ display:flex; gap:8px; }
.co-btn{ display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; transition:.15s; }
.co-btn-outline{ border:1.5px solid var(--border); background:#fff; color:var(--ink); }
.co-btn-outline:hover{ border-color:var(--p); color:var(--p); }
.co-btn-ghost{ border:1.5px solid var(--p); background:var(--p-light); color:var(--p); }
.co-btn-ghost:hover{ background:var(--p); color:#fff; }
.co-layout{ display:grid; grid-template-columns:1fr 360px; gap:18px; align-items:start; }
@media(max-width:900px){ .co-layout{ grid-template-columns:1fr; } }
.co-card{ background:#fff; border:1px solid var(--border); border-radius:14px; overflow:hidden; margin-bottom:16px; box-shadow:0 1px 8px rgba(0,0,0,.05); }
.co-card-head{ background:linear-gradient(135deg,#faf7ff,var(--p-light)); padding:11px 18px; border-bottom:1px solid #e9d8fd; display:flex; justify-content:space-between; align-items:center; }
.co-card-title{ font-size:12.5px; font-weight:700; color:var(--p-dark); display:flex; align-items:center; gap:7px; }
.co-card-icon{ width:24px; height:24px; border-radius:6px; background:var(--p); display:grid; place-items:center; font-size:10px; color:#fff; }
.co-card-body{ padding:18px; }
.f-label{ display:block; font-size:10.5px; font-weight:700; color:var(--muted); margin-bottom:4px; text-transform:uppercase; letter-spacing:.5px; }
.f-input{ width:100%; border:1.5px solid var(--border); border-radius:8px; padding:9px 12px; font-size:13.5px; color:var(--ink); outline:none; background:#fff; font-family:inherit; transition:.15s; }
.f-input:focus{ border-color:var(--p); box-shadow:0 0 0 3px rgba(124,58,237,.1); }
.f-input[readonly]{ background:#f8f9fa; color:#9ca3af; }
.f-input::placeholder{ color:#d1d5db; }
.g2{ display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.g-prod{ display:grid; grid-template-columns:1fr 100px 90px 100px 38px; gap:8px; align-items:end; }
@media(max-width:700px){ .g2{ grid-template-columns:1fr; } .g-prod{ grid-template-columns:1fr 1fr; } }
.prod-row{ background:#faf8ff; border:1px solid #e8e0fc; border-radius:10px; padding:14px; margin-bottom:10px; }
.btn-add{ background:var(--p-light); color:var(--p); border:none; border-radius:7px; padding:7px 14px; font-size:12.5px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:5px; transition:.15s; }
.btn-add:hover{ background:var(--p); color:#fff; }
.btn-del{ background:#fee2e2; color:var(--red); border:none; border-radius:7px; width:34px; height:34px; display:grid; place-items:center; cursor:pointer; transition:.15s; }
.btn-del:hover{ background:var(--red); color:#fff; }

/* ── Variant ── */
.var-wrap{ display:none; margin-top:12px; padding-top:12px; border-top:1px dashed #ddd6fe; }
.var-label{ font-size:11px; font-weight:700; color:var(--p-dark); margin-bottom:8px; display:block; text-transform:uppercase; letter-spacing:.4px; }
.var-colors{ display:flex; flex-wrap:wrap; gap:8px; }
.var-sizes{ display:flex; flex-wrap:wrap; gap:6px; margin-top:8px; }
.c-dot{
    width:32px; height:32px; border-radius:50%;
    cursor:pointer; position:relative; flex-shrink:0;
    border:3px solid transparent;
    box-shadow:0 0 0 1.5px rgba(0,0,0,.15);
    transition:transform .15s, box-shadow .15s;
}
.c-dot:hover{ transform:scale(1.15); box-shadow:0 0 0 2px var(--p); }
.c-dot.sel{ border-color:var(--p) !important; box-shadow:0 0 0 3px rgba(124,58,237,.3) !important; transform:scale(1.1); }
.c-dot.sel::after{ content:'✓'; position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:900; color:#fff; text-shadow:0 1px 3px rgba(0,0,0,.8); }
.s-btn{ border:1.5px solid var(--border); background:#fff; border-radius:6px; padding:5px 13px; font-size:12px; font-weight:700; color:var(--ink); cursor:pointer; transition:.15s; }
.s-btn:hover:not(:disabled){ border-color:var(--p); color:var(--p); background:var(--p-light); }
.s-btn.sel{ background:var(--p); border-color:var(--p); color:#fff; }
.s-btn:disabled{ opacity:.35; cursor:not-allowed; text-decoration:line-through; }
.stk-tag{ font-size:11px; font-weight:700; margin-top:7px; display:none; }

.sum-line{ display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid var(--border); font-size:13px; }
.sum-line:last-of-type{ border:none; }
.sum-val{ font-weight:700; font-family:monospace; }
.grand{ background:linear-gradient(135deg,var(--p),var(--p-dark)); margin:10px -18px -18px; padding:14px 18px; display:flex; justify-content:space-between; align-items:center; }
.grand span{ color:#fff; font-weight:700; }
.grand .sum-val{ font-size:16px; }
.btn-submit{ width:100%; background:linear-gradient(135deg,var(--p),var(--p-dark)); color:#fff; border:none; border-radius:9px; padding:12px; font-size:14px; font-weight:700; cursor:pointer; margin-top:12px; display:flex; align-items:center; justify-content:center; gap:7px; box-shadow:0 4px 14px rgba(124,58,237,.35); transition:.15s; }
.btn-submit:hover{ transform:translateY(-1px); }
.no-prod{ text-align:center; padding:24px; color:#c4b5fd; font-size:13px; }
.no-prod i{ font-size:26px; display:block; margin-bottom:6px; }
</style>

<div class="co-wrap">

@if(session('success'))
<div style="background:#ecfdf5;border:1px solid #6ee7b7;color:#065f46;border-radius:8px;padding:10px 14px;margin-bottom:14px;font-size:13px;font-weight:600;">
    <i class="fa fa-check-circle me-1"></i>{{ session('success') }}
</div>
@endif

<div class="co-top">
    <div class="co-title">
        <span class="co-title-icon"><i class="fa fa-edit"></i></span>
        Edit Order
        <span style="font-size:14px;color:var(--muted);font-weight:500;">#{{ $order->order_id }}</span>
    </div>
    <div class="co-actions">
        <a href="{{ route('admin.orders.show', $order->id) }}" class="co-btn co-btn-ghost">
            <i class="fa fa-eye"></i> View
        </a>
        <a href="{{ route('admin.all-orders') }}" class="co-btn co-btn-outline">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<form action="{{ route('admin.orders.update', $order->id) }}" method="POST" id="orderForm">
@csrf @method('PUT')

<div class="co-layout">

<!-- ═══ LEFT ═══ -->
<div>

    <!-- Customer -->
    <div class="co-card">
        <div class="co-card-head">
            <div class="co-card-title">
                <span class="co-card-icon"><i class="fa fa-user"></i></span>
                Customer Information
            </div>
        </div>
        <div class="co-card-body">
            <div style="margin-bottom:12px;">
                <label class="f-label">Customer <span style="color:var(--red)">*</span></label>
                <select name="user_id" id="custSel" class="f-input" required>
                    <option value="">-- Choose --</option>
                    @foreach($users as $u)
                    <option value="{{ $u->id }}"
                        data-phone="{{ $u->phone }}"
                        data-address="{{ $u->address }}"
                        {{ $order->user_id == $u->id ? 'selected' : '' }}>
                        {{ $u->name }} — {{ $u->phone }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="g2">
                <div><label class="f-label">Phone</label><input id="cPhone" class="f-input" readonly value="{{ $order->user->phone ?? '' }}"></div>
                <div><label class="f-label">Address</label><input id="cAddr" class="f-input" readonly value="{{ $order->user->address ?? '' }}"></div>
            </div>
        </div>
    </div>

    <!-- Products -->
    <div class="co-card">
        <div class="co-card-head">
            <div class="co-card-title">
                <span class="co-card-icon"><i class="fa fa-box"></i></span>
                Order Items
            </div>
            <button type="button" class="btn-add" id="addBtn">
                <i class="fa fa-plus"></i> Add Product
            </button>
        </div>
        <div class="co-card-body">
            <div id="prodRows">
                @forelse($order->orderItems as $oi)
                <div class="prod-row"
                    data-ex-color="{{ $oi->selected_color }}"
                    data-ex-size="{{ $oi->selected_size }}"
                    data-pid="{{ $oi->product_id }}">
                    <div class="g-prod">
                        <div>
                            <label class="f-label">Product</label>
                            <select class="f-input p-sel">
                                <option value="">-- Select --</option>
                                @foreach($products as $p)
                                <option value="{{ $p->id }}" data-price="{{ $p->sale_price }}"
                                    {{ $oi->product_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }} ({{ currency() }}{{ number_format($p->sale_price,0) }})
                                </option>
                                @endforeach
                            </select>
                            <input type="hidden" class="p-hid" name="products[]" value="{{ $oi->product_id }}">
                        </div>
                        <div><label class="f-label">Price</label><input type="text" class="f-input p-price" readonly value="{{ number_format($oi->price,0) }}"></div>
                        <div><label class="f-label">Qty</label><input type="number" class="f-input p-qty" name="quantities[{{ $oi->product_id }}]" min="1" value="{{ $oi->quantity }}"></div>
                        <div><label class="f-label">Subtotal</label><input type="text" class="f-input p-sub" readonly value="{{ number_format($oi->quantity*$oi->price,0) }}" style="color:var(--p);font-weight:700;"></div>
                        <button type="button" class="btn-del p-del" style="margin-top:18px;"><i class="fa fa-trash fa-xs"></i></button>
                    </div>
                    <!-- Variant (built by JS on load) -->
                    <div class="var-wrap" style="display:none;">
                        <div style="margin-bottom:10px;">
                            <span class="var-label">● Color <span style="color:var(--red)">*</span></span>
                            <div class="var-colors"></div>
                            <input type="hidden" class="v-col" name="colors[{{ $oi->product_id }}]" value="{{ $oi->selected_color }}">
                        </div>
                        <div class="v-sz-grp" style="display:none;">
                            <span class="var-label">▬ Size <span style="color:var(--red)">*</span></span>
                            <div class="var-sizes"></div>
                            <input type="hidden" class="v-sz" name="sizes[{{ $oi->product_id }}]" value="{{ $oi->selected_size }}">
                            <p class="stk-tag v-stk" style="display:none;"></p>
                        </div>
                        <p class="stk-tag v-stk2" style="display:none;"></p>
                    </div>
                </div>
                @empty
                <div class="no-prod" id="noProd">
                    <i class="fa fa-box-open"></i> No items — click Add Product
                </div>
                @endforelse
            </div>

            <!-- Template for new rows -->
            <template id="rowTpl">
                <div class="prod-row">
                    <div class="g-prod">
                        <div>
                            <label class="f-label">Product</label>
                            <select class="f-input p-sel">
                                <option value="">-- Select --</option>
                                @foreach($products as $p)
                                <option value="{{ $p->id }}" data-price="{{ $p->sale_price }}">
                                    {{ $p->name }} ({{ currency() }}{{ number_format($p->sale_price,0) }})
                                </option>
                                @endforeach
                            </select>
                            <input type="hidden" class="p-hid" name="products[]">
                        </div>
                        <div><label class="f-label">Price</label><input type="text" class="f-input p-price" readonly placeholder="0"></div>
                        <div><label class="f-label">Qty</label><input type="number" class="f-input p-qty" min="1" value="1"></div>
                        <div><label class="f-label">Subtotal</label><input type="text" class="f-input p-sub" readonly placeholder="0" style="color:var(--p);font-weight:700;"></div>
                        <button type="button" class="btn-del p-del" style="margin-top:18px;"><i class="fa fa-trash fa-xs"></i></button>
                    </div>
                    <div class="var-wrap" style="display:none;">
                        <div style="margin-bottom:10px;">
                            <span class="var-label">● Color <span style="color:var(--red)">*</span></span>
                            <div class="var-colors"></div>
                            <input type="hidden" class="v-col">
                        </div>
                        <div class="v-sz-grp" style="display:none;">
                            <span class="var-label">▬ Size <span style="color:var(--red)">*</span></span>
                            <div class="var-sizes"></div>
                            <input type="hidden" class="v-sz">
                            <p class="stk-tag v-stk" style="display:none;"></p>
                        </div>
                        <p class="stk-tag v-stk2" style="display:none;"></p>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Note -->
    <div class="co-card">
        <div class="co-card-head">
            <div class="co-card-title"><span class="co-card-icon"><i class="fa fa-sticky-note"></i></span> Order Note</div>
        </div>
        <div class="co-card-body">
            <textarea name="notes" class="f-input" rows="3" placeholder="Special instructions...">{{ $order->notes }}</textarea>
        </div>
    </div>

</div>

<!-- ═══ RIGHT ═══ -->
<div>
  <div class="co-card">
    <div class="co-card-head">
        <div class="co-card-title"><span class="co-card-icon"><i class="fa fa-credit-card"></i></span> Payment Info</div>
    </div>
    <div class="co-card-body">
        <div style="margin-bottom:12px;"><label class="f-label">Method</label>
            <select name="payment_method" class="f-input">
                <option value="cod"   {{ $order->payment_method=='cod'   ? 'selected':'' }}>Cash on Delivery</option>
                <option value="bkash" {{ $order->payment_method=='bkash' ? 'selected':'' }}>bKash</option>
                <option value="nagad" {{ $order->payment_method=='nagad' ? 'selected':'' }}>Nagad</option>
            </select>
        </div>

        {{-- ✅ নতুন: Order Status --}}
        <div style="margin-bottom:12px;">
            <label class="f-label">Order Status</label>
            <select name="status" class="f-input">
                <option value="pending"    {{ $order->status=='pending'    ? 'selected':'' }}>Pending</option>
                <option value="processing" {{ $order->status=='processing' ? 'selected':'' }}>Processing</option>
                <option value="on the way" {{ $order->status=='on the way' ? 'selected':'' }}>On The Way</option>
                <option value="on hold"    {{ $order->status=='on hold'    ? 'selected':'' }}>On Hold</option>
                <option value="completed"  {{ $order->status=='completed'  ? 'selected':'' }}>Completed</option>
                <option value="cancelled"  {{ $order->status=='cancelled'  ? 'selected':'' }}>Cancelled</option>
            </select>
        </div>

        {{-- ✅ নতুন: Payment Status --}}
        <div style="margin-bottom:12px;">
            <label class="f-label">Payment Status</label>
            <select name="payment_status" class="f-input">
                <option value="pending" {{ $order->payment_status=='pending' ? 'selected':'' }}>Pending</option>
                <option value="paid"    {{ $order->payment_status=='paid'    ? 'selected':'' }}>Paid</option>
                <option value="unpaid"  {{ $order->payment_status=='unpaid'  ? 'selected':'' }}>Unpaid</option>
            </select>
        </div>

        <div style="margin-bottom:12px;"><label class="f-label">Delivery Charge</label><input type="number" name="delivery_charge" id="delCharge" class="f-input" min="0" value="{{ $order->delivery_charge ?? 0 }}"></div>
        <div style="margin-bottom:12px;"><label class="f-label">Transaction ID</label><input type="text" name="transaction_id" class="f-input" value="{{ $order->transaction_id }}" placeholder="e.g. C3K2C8A1EU"></div>
        <div style="margin-bottom:12px;"><label class="f-label">Payment Number</label><input type="text" name="payment_number" class="f-input" value="{{ $order->payment_number }}" placeholder="01XXXXXXXXX"></div>
        <div style="margin-bottom:12px;"><label class="f-label">Discount Amount</label><input type="number" name="coupon" id="discAmt" class="f-input" min="0" value="{{ $order->coupon ?? 0 }}"></div>
        <div><label class="f-label">Paid Amount</label><input type="number" name="paid" class="f-input" min="0" value="{{ $order->paid ?? 0 }}"></div>
    </div>
</div>

    <div class="co-card">
        <div class="co-card-head">
            <div class="co-card-title"><span class="co-card-icon"><i class="fa fa-calculator"></i></span> Order Summary</div>
        </div>
        <div class="co-card-body">
            <div class="sum-line"><span style="color:var(--muted)">Subtotal</span><span class="sum-val" id="sumSub">{{ currency() }}0</span></div>
            <div class="sum-line"><span style="color:var(--muted)">Delivery</span><span class="sum-val" id="sumDel">{{ currency() }}{{ number_format($order->delivery_charge??0,0) }}</span></div>
            <div class="sum-line"><span style="color:var(--red)">Discount</span><span class="sum-val" id="sumDisc" style="color:var(--red);">- {{ currency() }}{{ number_format($order->coupon??0,0) }}</span></div>
            <div class="grand"><span>Grand Total</span><span class="sum-val" id="sumTot">{{ currency() }}{{ number_format($order->total,0) }}</span></div>
            <button type="submit" class="btn-submit mt-5"><i class="fa fa-save"></i> Update Order</button>
        </div>
    </div>
</div>

</div>
</form>
</div>

<script>
// ════════════════════════════════════════════
// SAME FIX AS CREATE: display:block + getPV()
// ════════════════════════════════════════════
(function() {
    var raw = {!! json_encode($productVariants, JSON_UNESCAPED_UNICODE) !!};
    window.__PV = {};
    Object.keys(raw).forEach(function(k) {
        window.__PV[String(k)] = raw[k];
    });
    window.__SYM = '{{ currency() }}';
})();

function getPV(pid) {
    return window.__PV[String(pid)] || window.__PV[parseInt(pid)] || [];
}

// ════ CUSTOMER ════
document.getElementById('custSel').addEventListener('change', function() {
    var o = this.options[this.selectedIndex];
    document.getElementById('cPhone').value = o.dataset.phone   || '';
    document.getElementById('cAddr').value  = o.dataset.address || '';
});

// ════ INIT EXISTING ROWS ON PAGE LOAD ════
document.querySelectorAll('#prodRows .prod-row').forEach(function(row) {
    bindRow(row);
    var sel = row.querySelector('.p-sel');
    var pid = sel ? sel.value : '';
    if (pid) {
        var vars = getPV(pid);
        if (vars.length > 0) {
            showVariant(row, pid, vars);
            // Preselect saved color/size
            var exColor = row.dataset.exColor || '';
            var exSize  = row.dataset.exSize  || '';
            if (exColor) preselectVariant(row, pid, exColor, exSize, vars);
        }
    }
});
calcTotal();

// ════ ADD ROW ════
document.getElementById('addBtn').addEventListener('click', function() {
    var clone = document.importNode(document.getElementById('rowTpl').content, true);
    document.getElementById('prodRows').appendChild(clone);
    var np = document.getElementById('noProd');
    if (np) np.style.display = 'none';
    var rows = document.querySelectorAll('#prodRows .prod-row');
    bindRow(rows[rows.length - 1]);
});

// ════ BIND ROW ════
function bindRow(row) {
    var sel   = row.querySelector('.p-sel');
    var hid   = row.querySelector('.p-hid');
    var prEl  = row.querySelector('.p-price');
    var qtEl  = row.querySelector('.p-qty');
    var sbEl  = row.querySelector('.p-sub');
    var rmBtn = row.querySelector('.p-del');

    sel.addEventListener('change', function() {
        var pid   = this.value;
        var price = parseFloat(this.options[this.selectedIndex].dataset.price || 0);
        hid.value  = pid;
        prEl.value = price.toFixed(0);
        sbEl.value = (price * (parseInt(qtEl.value) || 1)).toFixed(0);
        clearVariant(row);
        if (pid) {
            var vars = getPV(pid);
            if (vars.length > 0) showVariant(row, pid, vars);
        }
        syncNames();
        calcTotal();
    });

    qtEl.addEventListener('input', function() {
        sbEl.value = (parseFloat(prEl.value || 0) * (parseInt(this.value) || 1)).toFixed(0);
        calcTotal();
    });

    rmBtn.addEventListener('click', function() {
        row.remove();
        calcTotal();
    });
}

// ════ CLEAR VARIANT ════
function clearVariant(row) {
    row.querySelector('.v-col').value          = '';
    row.querySelector('.v-sz').value           = '';
    row.querySelector('.var-colors').innerHTML = '';
    row.querySelector('.var-sizes').innerHTML  = '';
    row.querySelector('.var-wrap').style.cssText  = 'display:none;margin-top:12px;padding-top:12px;border-top:1px dashed #ddd6fe;';
    row.querySelector('.v-sz-grp').style.display  = 'none';
    var s1 = row.querySelector('.v-stk');  if (s1) s1.style.display = 'none';
    var s2 = row.querySelector('.v-stk2'); if (s2) s2.style.display = 'none';
}

// ════ SHOW VARIANT (build color dots) ════
function showVariant(row, pid, vars) {
    var seen = {}, cols = [];
    vars.forEach(function(v) {
        if (v.color_id !== null && v.color_id !== undefined && !seen[v.color_id]) {
            seen[v.color_id] = true;
            cols.push(v);
        }
    });
    if (!cols.length) return;

    // ✅ display:block — same fix as create.blade
    var varWrap = row.querySelector('.var-wrap');
    varWrap.style.display = 'block';

    var colWrap = row.querySelector('.var-colors');
    colWrap.innerHTML = '';

    cols.forEach(function(c) {
        var dot = document.createElement('div');
        dot.className = 'c-dot';
        var bg = String(c.code || '#cccccc');
        if (bg.charAt(0) !== '#') bg = '#' + bg;
        dot.style.backgroundColor = bg;
        dot.title = (c.color || 'Color') + ' — ' + bg;
        dot.dataset.cid   = String(c.color_id);
        dot.dataset.color = String(c.color || '');
        dot.addEventListener('click', function() {
            pickColor(row, pid, dot, vars);
        });
        colWrap.appendChild(dot);
    });
}

// ════ PICK COLOR ════
function pickColor(row, pid, dot, vars, silent) {
    row.querySelectorAll('.c-dot').forEach(function(d) { d.classList.remove('sel'); });
    dot.classList.add('sel');
    row.querySelector('.v-col').value = dot.dataset.color;

    var cid     = String(dot.dataset.cid);
    var szGrp   = row.querySelector('.v-sz-grp');
    var szWrap  = row.querySelector('.var-sizes');
    var stkMain = row.querySelector('.v-stk');
    var stkCol  = row.querySelector('.v-stk2');

    szWrap.innerHTML = '';
    if (!silent) row.querySelector('.v-sz').value = '';
    if (stkMain) stkMain.style.display = 'none';
    if (stkCol)  stkCol.style.display  = 'none';

    var sizes = vars.filter(function(v) {
        return String(v.color_id) === cid && v.size_id !== null && v.size_id !== undefined;
    });

    if (sizes.length > 0) {
        szGrp.style.display = 'block';
        sizes.forEach(function(s) {
            var btn = document.createElement('button');
            btn.type      = 'button';
            btn.className = 's-btn';
            btn.textContent = String(s.size || '?');
            if (!s.stock || s.stock <= 0) btn.disabled = true;
            btn.addEventListener('click', function() { pickSize(row, btn, s); });
            szWrap.appendChild(btn);
        });
    } else {
        szGrp.style.display = 'none';
        var cv = vars.find(function(v) { return String(v.color_id) === cid; });
        if (cv) {
            applyPrice(row, cv.price);
            if (stkCol) {
                stkCol.style.display = 'block';
                stkCol.textContent   = cv.stock > 0 ? '✓ ' + cv.stock + ' pcs in stock' : '✗ Out of stock';
                stkCol.style.color   = cv.stock > 0 ? 'var(--green)' : 'var(--red)';
            }
        }
    }
}

// ════ PICK SIZE ════
function pickSize(row, btn, variant) {
    row.querySelectorAll('.s-btn').forEach(function(b) { b.classList.remove('sel'); });
    btn.classList.add('sel');
    row.querySelector('.v-sz').value = String(variant.size || '');
    applyPrice(row, variant.price);
    var stk = row.querySelector('.v-stk');
    if (stk) {
        stk.style.display = 'block';
        stk.textContent   = variant.stock > 0 ? '✓ ' + variant.stock + ' pcs in stock' : '✗ Out of stock';
        stk.style.color   = variant.stock > 0 ? 'var(--green)' : 'var(--red)';
    }
}

// ════ APPLY PRICE ════
function applyPrice(row, price) {
    if (!price) return;
    var p = parseFloat(price);
    var q = parseInt(row.querySelector('.p-qty').value) || 1;
    row.querySelector('.p-price').value = p.toFixed(0);
    row.querySelector('.p-sub').value   = (p * q).toFixed(0);
    calcTotal();
}

// ════ PRESELECT saved color/size on edit page load ════
function preselectVariant(row, pid, colorName, sizeName, vars) {
    // Find the matching color dot
    var dot = null;
    row.querySelectorAll('.c-dot').forEach(function(d) {
        if (d.dataset.color === colorName) dot = d;
    });
    if (!dot) return;

    // Click color silently (don't clear size input yet)
    pickColor(row, pid, dot, vars, true);

    // Now preselect size if provided
    if (sizeName) {
        var sBtn = null;
        row.querySelectorAll('.s-btn').forEach(function(b) {
            if (b.textContent.trim() === sizeName) sBtn = b;
        });
        if (sBtn) {
            var cid = String(dot.dataset.cid);
            var v   = vars.find(function(x) {
                return String(x.color_id) === cid && x.size === sizeName;
            });
            if (v) pickSize(row, sBtn, v);
        }
    }
}

// ════ SYNC NAMES — একই ফিক্স ════
function syncNames() {
    var idx = 0;
    document.querySelectorAll('#prodRows .prod-row').forEach(function(row) {
        var pid = row.querySelector('.p-sel').value;
        if (!pid) return;

        row.querySelector('.p-hid').name = 'products[' + idx + ']';
        row.querySelector('.p-qty').name = 'quantities[' + idx + ']';
        row.querySelector('.v-col').name = 'colors[' + idx + ']';
        row.querySelector('.v-sz').name  = 'sizes[' + idx + ']';
        idx++;
    });
}

// ════ CALC TOTAL ════
function calcTotal() {
    var sub = 0;
    document.querySelectorAll('#prodRows .p-sub').forEach(function(el) {
        sub += parseFloat(el.value.replace(/,/g, '') || 0);
    });
    var del  = parseFloat(document.getElementById('delCharge').value || 0);
    var disc = parseFloat(document.getElementById('discAmt').value || 0);

    var grand = (sub + del) - disc;
    if (grand < 0) grand = 0; // total kokhono negative hobe na

    document.getElementById('sumSub').textContent  = window.__SYM + sub.toFixed(0);
    document.getElementById('sumDel').textContent  = window.__SYM + del.toFixed(0);
    document.getElementById('sumDisc').textContent = '- ' + window.__SYM + disc.toFixed(0);
    document.getElementById('sumTot').textContent  = window.__SYM + grand.toFixed(0);
}
document.getElementById('delCharge').addEventListener('input', calcTotal);
document.getElementById('discAmt').addEventListener('input', calcTotal);

// ════ SUBMIT VALIDATION ════
document.getElementById('orderForm').addEventListener('submit', function(e) {
    syncNames();
    var ok = true;
    document.querySelectorAll('#prodRows .prod-row').forEach(function(row) {
        var vw = row.querySelector('.var-wrap');
        if (!vw || vw.style.display === 'none' || vw.style.display === '') return;
        if (!row.querySelector('.v-col').value) { ok = false; return; }
        var sg = row.querySelector('.v-sz-grp');
        if (sg.style.display !== 'none' && !row.querySelector('.v-sz').value) ok = false;
    });
    if (!ok) {
        e.preventDefault();
        if (typeof toastr !== 'undefined') {
            toastr.warning('Please select Color (and Size) for variant products!');
        } else {
            alert('Please select Color (and Size) for variant products!');
        }
    }
});

</script>
@endsection