@extends('admin.layouts.app')
@section('title', 'Customer — {{ $customer->name }}')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap');
:root{ --p1:#5b21b6;--p2:#7c3aed;--p3:#ede9fe;--p4:#4c1d95;--ink:#0f0e17;--muted:#6b6b8a;--border:#e4e1f5;--surf:#f4f2ff;--green:#059669;--red:#dc2626; }
*{ font-family:'Sora',sans-serif;box-sizing:border-box; }
.mono{ font-family:'JetBrains Mono',monospace; }
.pg{ background:var(--surf);min-height:100vh;padding:28px 16px; }
.wrap{ max-width:860px;margin:0 auto;display:flex;flex-direction:column;gap:20px; }

.tbar{ display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px; }
.tbar-title{ font-size:21px;font-weight:700;color:var(--ink);display:flex;align-items:center;gap:10px; }
.btn-action{ background:#fff;border:1.5px solid var(--border);color:var(--ink);border-radius:10px;padding:8px 16px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .15s; }
.btn-action:hover{ border-color:var(--p2);color:var(--p2); }
.btn-edit{ background:linear-gradient(135deg,var(--p2),var(--p4));color:#fff;border:none; }
.btn-edit:hover{ color:#fff;opacity:.9; }

/* profile card */
.profile-card{ background:#fff;border:1px solid var(--border);border-radius:20px;overflow:hidden;box-shadow:0 4px 24px rgba(91,33,182,.07); }
.profile-banner{ background:linear-gradient(120deg,#2d1b69,#5b21b6 55%,#7c3aed);height:90px;position:relative; }
.profile-avatar-wrap{ position:absolute;bottom:-40px;left:28px; }
.profile-avatar{ width:84px;height:84px;border-radius:18px;object-fit:cover;border:4px solid #fff;box-shadow:0 4px 16px rgba(0,0,0,.15); }
.profile-avatar-placeholder{ width:84px;height:84px;border-radius:18px;background:linear-gradient(135deg,var(--p2),var(--p4));display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:700;color:#fff;border:4px solid #fff;box-shadow:0 4px 16px rgba(0,0,0,.15); }
.profile-body{ padding:52px 28px 24px; }
.profile-name{ font-size:22px;font-weight:700;color:var(--ink);margin-bottom:4px; }
.profile-id{ font-size:12px;color:var(--muted);font-family:'JetBrains Mono',monospace; }

.info-grid{ display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:20px; }
@media(max-width:600px){ .info-grid{ grid-template-columns:1fr; } }
.info-item{ background:var(--surf);border:1px solid var(--border);border-radius:12px;padding:14px 16px; }
.info-item-label{ font-size:10.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px; }
.info-item-val{ font-size:13.5px;font-weight:600;color:var(--ink); }

/* orders table */
.section-card{ background:#fff;border:1px solid var(--border);border-radius:18px;overflow:hidden;box-shadow:0 2px 16px rgba(91,33,182,.05); }
.section-head{ background:linear-gradient(120deg,#f5f3ff,#ede9fe);padding:14px 22px;border-bottom:1px solid var(--border);font-size:14px;font-weight:700;color:var(--p4);display:flex;align-items:center;gap:8px; }
table.ot{ width:100%;border-collapse:collapse; }
table.ot thead th{ background:#f3f0fc;color:var(--p4);font-size:11px;font-weight:700;text-transform:uppercase;padding:11px 14px;border-bottom:1px solid var(--border); }
table.ot tbody td{ padding:12px 14px;font-size:13px;border-bottom:1px solid #f0edf9; }
table.ot tbody tr:hover{ background:#faf7ff; }
.sbadge{ display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:16px;font-size:11px;font-weight:700; }
.s-pen{ background:#fef9c3;color:#854d0e; }
.s-com{ background:#dcfce7;color:#15803d; }
.s-can{ background:#fee2e2;color:#991b1b; }
.s-def{ background:#f1f5f9;color:#475569; }
</style>

<div class="pg">
<div class="wrap">

    <div class="tbar">
        <div class="tbar-title"><i class="fa fa-user-circle" style="color:var(--p2);"></i> Customer Profile</div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn-action btn-edit"><i class="fa fa-pen"></i> Edit</a>
            <a href="{{ route('admin.customers.index') }}" class="btn-action"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>

    {{-- PROFILE CARD --}}
    <div class="profile-card">
        <div class="profile-banner">
            <div class="profile-avatar-wrap">
                @if($customer->image)
                    <img src="{{ Storage::url($customer->image) }}" class="profile-avatar" alt="{{ $customer->name }}">
                @else
                    <div class="profile-avatar-placeholder">{{ strtoupper(substr($customer->name,0,1)) }}</div>
                @endif
            </div>
        </div>
        <div class="profile-body">
            <div class="profile-name">{{ $customer->name }}</div>
            <div class="profile-id">Customer ID #{{ $customer->id }}</div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-item-label"><i class="fa fa-phone me-1"></i> Phone</div>
                    <div class="info-item-val mono">{{ $customer->phone ?? '—' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label"><i class="fa fa-envelope me-1"></i> Email</div>
                    <div class="info-item-val">{{ $customer->email ?? '—' }}</div>
                </div>
                <div class="info-item" style="grid-column:span 2;">
                    <div class="info-item-label"><i class="fa fa-map-marker-alt me-1"></i> Address</div>
                    <div class="info-item-val">{{ $customer->address ?? '—' }}</div>
                </div>
            </div>

            {{-- Stats --}}
            <div style="display:flex;gap:16px;margin-top:20px;flex-wrap:wrap;">
                <div style="background:var(--p3);border-radius:12px;padding:14px 20px;text-align:center;flex:1;min-width:100px;">
                    <div style="font-size:22px;font-weight:700;color:var(--p1);font-family:'JetBrains Mono',monospace;">{{ $customer->orders->count() }}</div>
                    <div style="font-size:11px;color:var(--muted);font-weight:700;text-transform:uppercase;margin-top:2px;">Total Orders</div>
                </div>
                <div style="background:#dcfce7;border-radius:12px;padding:14px 20px;text-align:center;flex:1;min-width:100px;">
                    <div style="font-size:22px;font-weight:700;color:var(--green);font-family:'JetBrains Mono',monospace;">{{ currency() }}{{ number_format($customer->orders->where('status','completed')->sum('total'),0) }}</div>
                    <div style="font-size:11px;color:var(--muted);font-weight:700;text-transform:uppercase;margin-top:2px;">Total Spent</div>
                </div>
                <div style="background:#fef9c3;border-radius:12px;padding:14px 20px;text-align:center;flex:1;min-width:100px;">
                    <div style="font-size:22px;font-weight:700;color:#854d0e;font-family:'JetBrains Mono',monospace;">{{ $customer->orders->where('status','pending')->count() }}</div>
                    <div style="font-size:11px;color:var(--muted);font-weight:700;text-transform:uppercase;margin-top:2px;">Pending</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ORDERS --}}
    @if($customer->orders->count())
    <div class="section-card">
        <div class="section-head"><i class="fa fa-shopping-bag"></i> Order History</div>
        <div style="overflow-x:auto;">
        <table class="ot">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order ID</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($customer->orders->sortByDesc('created_at') as $order)
            @php
                $sc = match(strtolower($order->status)) {
                    'completed' => 's-com',
                    'cancelled' => 's-can',
                    'pending'   => 's-pen',
                    default     => 's-def',
                };
            @endphp
            <tr>
                <td style="color:var(--muted);font-size:12px;">{{ $loop->iteration }}</td>
                <td class="mono" style="font-weight:700;color:var(--p2);">#{{ str_pad($order->order_id,5,'0',STR_PAD_LEFT) }}</td>
                <td class="mono">{{ currency() }}{{ number_format($order->total,2) }}</td>
                <td class="mono" style="color:var(--green);">{{ currency() }}{{ number_format($order->paid??0,2) }}</td>
                <td><span class="sbadge {{ $sc }}">{{ ucfirst($order->status) }}</span></td>
                <td style="font-size:12px;color:var(--muted);">{{ $order->created_at->format('d M Y') }}</td>
                <td style="text-align:center;">
                    <a href="{{ route('admin.orders.show', $order->id) }}"
                        style="background:var(--p3);color:var(--p2);border-radius:8px;width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-size:12px;">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    @endif

</div>
</div>
@endsection