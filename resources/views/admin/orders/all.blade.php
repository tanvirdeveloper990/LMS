@extends('admin.layouts.app')
@section('title', 'All Orders')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap');
:root {
    --p1:#5b21b6; --p2:#7c3aed; --p3:#ede9fe; --p4:#4c1d95;
    --ink:#0f0e17; --muted:#6b6b8a; --border:#e4e1f5; --surface:#f4f2ff;
}
*{ font-family:'Sora',sans-serif; }
.mono{ font-family:'JetBrains Mono',monospace; }
.pg{ background:var(--surface); min-height:100vh; padding:28px 16px; }
.oc{ background:#fff; border:1px solid var(--border); border-radius:20px; overflow:hidden; box-shadow:0 4px 32px rgba(91,33,182,.07); }
.oh{ background:linear-gradient(120deg,#2d1b69 0%,#5b21b6 55%,#7c3aed 100%); padding:22px 28px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; position:relative; overflow:hidden; }
.oh::after{ content:''; position:absolute; right:-40px; top:-40px; width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,.05); }
.oh-title{ color:#fff; font-size:18px; font-weight:700; margin:0; display:flex; align-items:center; gap:10px; }
.oh-icon{ width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:15px;color:#fff; }
.btn-new{ background:#fff;color:var(--p1);border:none;border-radius:10px;padding:9px 18px;font-weight:700;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:6px;box-shadow:0 2px 10px rgba(0,0,0,.12);transition:all .15s;position:relative;z-index:1; }
.btn-new:hover{ transform:translateY(-1px); color:var(--p1); }
.stats{ display:flex; border-bottom:1px solid var(--border); background:#faf8ff; flex-wrap:wrap; }
.stat{ flex:1;min-width:100px;padding:14px 20px;border-right:1px solid var(--border); }
.stat:last-child{ border-right:none; }
.stat-n{ font-size:22px;font-weight:700;font-family:'JetBrains Mono',monospace; }
.stat-l{ font-size:10.5px;color:var(--muted);font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-top:2px; }
.tw{ overflow-x:auto; }
table.ot{ width:100%;border-collapse:separate;border-spacing:0; }
table.ot thead th{ background:#f3f0fc;color:var(--p4);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;padding:13px 16px;border-bottom:2px solid var(--border);white-space:nowrap; }
table.ot tbody tr{ transition:background .12s; }
table.ot tbody tr:hover{ background:#faf7ff; }
table.ot tbody td{ padding:15px 16px;vertical-align:top;border-bottom:1px solid #f0edf9; }
.c-id{ font-family:'JetBrains Mono',monospace;font-size:13px;font-weight:700;color:var(--p2); }
.c-date{ font-size:11px;color:var(--muted);margin-top:4px; }
.c-name{ font-size:13.5px;font-weight:700;color:var(--ink); }
.c-sub{ font-size:12px;color:var(--muted);margin-top:3px; }
.c-addr{ font-size:11px;color:#b0a8c8;margin-top:3px;max-width:150px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
.ar{ display:flex;justify-content:space-between;gap:8px;font-size:12.5px;padding:3px 0; }
.al{ color:var(--muted);font-size:11px;font-weight:700;text-transform:uppercase; }
.av{ font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:700; }
.av.g{ color:#059669; } .av.r{ color:#dc2626; } .av.d{ color:var(--ink); }
.sbadge{ display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:20px;font-size:11.5px;font-weight:700;white-space:nowrap; }
.s-pen{ background:#fef9c3;color:#854d0e; }
.s-pro{ background:#dbeafe;color:#1d4ed8; }
.s-otw{ background:#ccfbf1;color:#0f766e; }
.s-hol{ background:#ffedd5;color:#9a3412; }
.s-cou{ background:#ede9fe;color:#5b21b6; }
.s-com{ background:#dcfce7;color:#15803d; }
.s-can{ background:#fee2e2;color:#991b1b; }
.ppill{ display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:8px;font-size:11px;font-weight:700;margin-top:6px; }
.ppill.paid{ background:#dcfce7;color:#15803d; }
.ppill.unpaid{ background:#fee2e2;color:#991b1b; }
.meth-badge{ display:inline-block;padding:3px 9px;border-radius:6px;font-size:11px;font-weight:700;background:var(--p3);color:var(--p1);margin-top:6px; }
.cc{ display:inline-flex;align-items:center;gap:4px;padding:5px 12px;border-radius:8px;font-size:11.5px;font-weight:700;text-decoration:none;transition:all .15s; }
.cc:hover{ transform:translateY(-1px); }
.cc-pathao{ background:#fde8e8;color:#c41b1b; }
.ag{ display:flex;gap:6px;justify-content:center; }
.abtn{ width:34px;height:34px;border-radius:9px;border:none;display:inline-flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;transition:all .15s;cursor:pointer; }
.abtn.view{ background:#ede9fe;color:var(--p2); }
.abtn.edit{ background:#dcfce7;color:#15803d; }
.abtn.view:hover{ background:var(--p2);color:#fff;transform:translateY(-2px);box-shadow:0 4px 12px rgba(124,58,237,.3); }
.abtn.edit:hover{ background:#15803d;color:#fff;transform:translateY(-2px);box-shadow:0 4px 12px rgba(21,128,61,.25); }
.empty{ text-align:center;padding:60px 20px; }
.empty-ico{ width:72px;height:72px;border-radius:20px;background:var(--p3);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:28px;color:#a78bfa; }
.pagination .page-link{ color:var(--p2);border-color:var(--border);border-radius:8px;margin:0 2px;font-size:13px; }
.pagination .page-item.active .page-link{ background:linear-gradient(135deg,var(--p2),var(--p4));border-color:var(--p2);color:#fff; }
.pagination .page-link:hover{ background:var(--p3);color:var(--p4); }
@media(max-width:768px){ .stats .stat{ min-width:50%; } table.ot thead th, table.ot tbody td{ padding:10px 12px; } }
</style>

<div class="pg">
<div class="oc">

    <div class="oh">
        <h5 class="oh-title">
            <span class="oh-icon"><i class="fa fa-shopping-bag"></i></span>
            All Orders
        </h5>
        <a href="{{ route('admin.orders-create') }}" class="btn-new">
            <i class="fa fa-plus"></i> New Order
        </a>
    </div>

    @php
        $total     = $orders->count();
        $pending   = $orders->where('status','pending')->count();
        $completed = $orders->where('status','completed')->count();
        $cancelled = $orders->where('status','cancelled')->count();
        $revenue   = $orders->where('status','completed')->sum('total');
    @endphp
    <div class="stats">
        <div class="stat"><div class="stat-n" style="color:var(--p1);">{{ $total }}</div><div class="stat-l">Total Orders</div></div>
        <div class="stat"><div class="stat-n" style="color:#d97706;">{{ $pending }}</div><div class="stat-l">Pending</div></div>
        <div class="stat"><div class="stat-n" style="color:#059669;">{{ $completed }}</div><div class="stat-l">Completed</div></div>
        <div class="stat"><div class="stat-n" style="color:#dc2626;">{{ $cancelled }}</div><div class="stat-l">Cancelled</div></div>
        <div class="stat"><div class="stat-n" style="color:var(--p2);">{{ currency() }}{{ number_format($revenue,0) }}</div><div class="stat-l">Revenue</div></div>
    </div>

    <div class="tw">
    <table class="ot">
        <thead>
            <tr>
                <th>#</th>
                <th>Order</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Courier</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
        @php
            $sm = [
                'pending'    => ['cls'=>'s-pen','ico'=>'fa-clock'],
                'processing' => ['cls'=>'s-pro','ico'=>'fa-spinner'],
                'on the way' => ['cls'=>'s-otw','ico'=>'fa-truck'],
                'on hold'    => ['cls'=>'s-hol','ico'=>'fa-pause'],
                'courier'    => ['cls'=>'s-cou','ico'=>'fa-box'],
                'completed'  => ['cls'=>'s-com','ico'=>'fa-check-circle'],
                'cancelled'  => ['cls'=>'s-can','ico'=>'fa-times-circle'],
            ];
            $si     = $sm[strtolower($order->status)] ?? ['cls'=>'s-pen','ico'=>'fa-circle'];
            $due    = $order->total - ($order->paid ?? 0);
            $isPaid = strtolower($order->payment_status ?? '') === 'paid';
        @endphp
        <tr>
            <td style="color:var(--muted);font-size:12px;font-weight:600;">{{ $loop->iteration }}</td>

           <td style="min-width:155px;">
                <div class="c-id">#{{ str_pad($order->order_id,5,'0',STR_PAD_LEFT) }}</div>
                <div class="c-date"><i class="fa fa-calendar-alt me-1" style="color:#c4b5fd;"></i>{{ $order->created_at?->format('d M Y') ?? '—' }}</div>
                <div class="c-date"><i class="fa fa-clock me-1" style="color:#c4b5fd;"></i>{{ $order->created_at?->format('h:i A') ?? '—' }}</div>
                @php $shops = $order->orderItems->map(fn($i)=>$i->product->vendor->shop_name??null)->filter()->unique()->values(); @endphp
                @foreach($shops as $shop)
                    <span style="display:inline-block;margin-top:5px;background:#ede9fe;color:#6d28d9;font-size:10px;font-weight:700;padding:2px 8px;border-radius:6px;"><i class="fa fa-store me-1"></i>{{ $shop }}</span>
                @endforeach
            </td>

            <td style="min-width:160px;">
                <div class="c-name">{{ $order->user->name ?? 'Guest' }}</div>
                <div class="c-sub mono"><i class="fa fa-phone me-1" style="color:#c4b5fd;font-size:10px;"></i>{{ $order->user->phone ? \Illuminate\Support\Str::limit($order->user->phone, 11, '') : '—' }}</div>
            </td>

            <td style="min-width:155px;">
                <div class="ar"><span class="al">Total</span><span class="av d">{{ currency() }}{{ number_format($order->total,2) }}</span></div>
                <div class="ar"><span class="al">Paid</span><span class="av g">{{ currency() }}{{ number_format($order->paid??0,2) }}</span></div>
                @if($due > 0)<div class="ar"><span class="al">Due</span><span class="av r">{{ currency() }}{{ number_format($due,2) }}</span></div>@endif
                @if($order->payment_method)<span class="meth-badge"><i class="fa fa-credit-card me-1"></i>{{ ucfirst($order->payment_method) }}</span>@endif
            </td>

            <td style="min-width:140px;">
                <span class="sbadge {{ $si['cls'] }}">
                    <i class="fa {{ $si['ico'] }}" style="font-size:10px;"></i>
                    {{ ucfirst($order->status) }}
                </span>
            </td>

                  <td>
                        <div class="d-flex gap-1 flex-wrap">
                            
                          <a href="{{ route('admin.orders.sendPathao', $order->id) }}" 
                            onclick="return confirm('Are you sure you want to send this order to Pathao?')">
                                <span class="badge text-light bg-danger">Pathao</span>
                            </a>


                            
                          <a href="{{ route('admin.orders.sendRedX', $order->id) }}" 
                                onclick="return confirm('Are you sure you want to send this order to RedX?')">
                                <span class="badge bg-warning text-light">RedX</span>
                                </a>

                            <a href="{{ route('admin.orders.send.steadfast', $order->id) }}" 
                                onclick="return confirm('Are you sure you want to send this order to Steadfast?')">
                                    <span class="badge bg-info text-light">Steadfast</span>
                                </a>


            
                        </div>
                    </td>

            <td style="text-align:center;">
                <div class="ag">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="abtn view" title="View"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="abtn edit" title="Edit"><i class="fa fa-pen"></i></a>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty"><div class="empty-ico"><i class="fa fa-shopping-bag"></i></div><p style="color:var(--muted);font-size:14px;margin:0;">No orders found.</p></div></td></tr>
        @endforelse
        </tbody>
    </table>
    </div>

    @if(method_exists($orders,'hasPages') && $orders->hasPages())
    <div style="display:flex;justify-content:center;padding:20px;border-top:1px solid var(--border);background:#faf8ff;">
        {{ $orders->withQueryString()->links() }}
    </div>
    @endif

</div>
</div>
@endsection