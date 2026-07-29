@extends('admin.layouts.app')
@section('title', 'Customers')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap');
:root{ --p1:#5b21b6;--p2:#7c3aed;--p3:#ede9fe;--p4:#4c1d95;--ink:#0f0e17;--muted:#6b6b8a;--border:#e4e1f5;--surf:#f4f2ff;--green:#059669;--red:#dc2626; }
*{ font-family:'Sora',sans-serif; }
.mono{ font-family:'JetBrains Mono',monospace; }
.pg{ background:var(--surf);min-height:100vh;padding:20px 14px; }
.oc{ background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(91,33,182,.07); }

.oh{ background:linear-gradient(120deg,#2d1b69,#5b21b6 55%,#7c3aed);padding:16px 22px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;position:relative;overflow:hidden; }
.oh::after{ content:'';position:absolute;right:-40px;top:-40px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.05); }
.oh-title{ color:#fff;font-size:15px;font-weight:700;margin:0;display:flex;align-items:center;gap:8px; }
.oh-icon{ width:30px;height:30px;border-radius:8px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:13px;color:#fff; }
.btn-new{ background:#fff;color:var(--p1);border:none;border-radius:8px;padding:7px 14px;font-weight:700;font-size:12px;text-decoration:none;display:flex;align-items:center;gap:5px;box-shadow:0 2px 8px rgba(0,0,0,.12);transition:all .15s;position:relative;z-index:1; }
.btn-new:hover{ transform:translateY(-1px);color:var(--p1); }

.filter-bar{ padding:12px 18px;border-bottom:1px solid var(--border);background:#faf8ff; }
.filter-form{ display:flex;gap:8px;align-items:center;flex-wrap:wrap; }
.search-input{ border:1.5px solid var(--border);border-radius:8px;padding:7px 12px;font-size:12px;outline:none;transition:border .15s;font-family:'Sora',sans-serif;min-width:200px; }
.search-input:focus{ border-color:var(--p2);box-shadow:0 0 0 3px rgba(124,58,237,.08); }
.f-select{ border:1.5px solid var(--border);border-radius:8px;padding:7px 12px;font-size:12px;outline:none;color:#374151;background:#fff;height:35px; }
.f-select:focus{ border-color:var(--p2); }
.btn-search{ background:linear-gradient(135deg,var(--p2),var(--p1));color:#fff;border:none;border-radius:8px;padding:7px 14px;font-size:12px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:5px;height:35px; }
.btn-reset{ background:#fff;border:1.5px solid var(--border);border-radius:8px;padding:7px 12px;font-size:12px;color:var(--muted);text-decoration:none;display:flex;align-items:center;gap:5px;height:35px; }
.btn-reset:hover{ border-color:var(--p2);color:var(--p2); }
.btn-print{ background:#f0fdf4;border:1.5px solid #86efac;border-radius:8px;padding:7px 14px;font-size:12px;color:#15803d;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:5px;height:35px;text-decoration:none; }
.btn-print:hover{ background:#dcfce7;color:#15803d; }

.stats{ display:flex;border-bottom:1px solid var(--border);background:#faf8ff;flex-wrap:wrap; }
.stat{ flex:1;min-width:80px;padding:10px 16px;border-right:1px solid var(--border); }
.stat:last-child{ border-right:none; }
.stat-n{ font-size:18px;font-weight:700;font-family:'JetBrains Mono',monospace;color:var(--p1); }
.stat-l{ font-size:10px;color:var(--muted);font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-top:1px; }

.tw{ overflow-x:auto; }
table.ct{ width:100%;border-collapse:separate;border-spacing:0; }
table.ct thead th{ background:#f3f0fc;color:var(--p4);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:10px 12px;border-bottom:2px solid var(--border);white-space:nowrap; }
table.ct tbody tr{ transition:background .12s; }
table.ct tbody tr:hover{ background:#faf7ff; }
table.ct tbody td{ padding:9px 12px;vertical-align:middle;border-bottom:1px solid #f0edf9;font-size:12.5px; }

.avatar{ width:34px;height:34px;border-radius:9px;object-fit:cover;border:2px solid var(--border); }
.avatar-placeholder{ width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,var(--p2),var(--p4));display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0; }
.c-name{ font-size:12.5px;font-weight:700;color:var(--ink); }
.c-sub{ font-size:10.5px;color:var(--muted);margin-top:1px; }

.badge-active{ background:#dcfce7;color:#15803d;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px; }
.badge-inactive{ background:#fee2e2;color:#dc2626;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px; }

.ag{ display:flex;gap:4px;justify-content:center; }
.abtn{ width:28px;height:28px;border-radius:7px;border:none;display:inline-flex;align-items:center;justify-content:center;font-size:11px;text-decoration:none;transition:all .15s;cursor:pointer; }
.abtn.view{ background:#ede9fe;color:var(--p2); }
.abtn.edit{ background:#dcfce7;color:#15803d; }
.abtn.del { background:#fee2e2;color:var(--red); }
.abtn.view:hover{ background:var(--p2);color:#fff; }
.abtn.edit:hover{ background:#15803d;color:#fff; }
.abtn.del:hover { background:var(--red);color:#fff; }

.empty{ text-align:center;padding:40px 20px; }
.alert-s{ background:#dcfce7;border:1px solid #86efac;color:#15803d;border-radius:8px;padding:10px 16px;margin:12px 18px;font-size:12px;font-weight:600;display:flex;align-items:center;gap:8px; }
.alert-e{ background:#fee2e2;border:1px solid #fca5a5;color:var(--red);border-radius:8px;padding:10px 16px;margin:12px 18px;font-size:12px;font-weight:600;display:flex;align-items:center;gap:8px; }
.pagination .page-link{ color:var(--p2);border-color:var(--border);border-radius:6px;margin:0 2px;font-size:12px; }
.pagination .page-item.active .page-link{ background:linear-gradient(135deg,var(--p2),var(--p4));border-color:var(--p2);color:#fff; }

/* Print styles */
@media print {
    .pg { background:#fff !important; padding:0 !important; }
    .oc { box-shadow:none !important; border:none !important; border-radius:0 !important; }
    .oh, .filter-bar, .stats, .ag, .no-print { display:none !important; }
    .print-header { display:block !important; }
    table.ct thead th { background:#f3f0fc !important; -webkit-print-color-adjust:exact; print-color-adjust:exact; }
    table.ct tbody td { font-size:11px !important; padding:6px 10px !important; }
}
.print-header { display:none; text-align:center; margin-bottom:14px; }
.print-header h4 { font-size:16px; font-weight:700; margin:0 0 4px; }
.print-header p { font-size:11px; color:#6b7280; margin:0; }
</style>

<div class="pg">
<div class="oc">

    <div class="oh no-print">
        <h5 class="oh-title">
            <span class="oh-icon"><i class="fa fa-users"></i></span>
            Customers
        </h5>
        <a href="{{ route('admin.customers.create') }}" class="btn-new">
            <i class="fa fa-plus"></i> Add Customer
        </a>
    </div>

    @if(session('success'))
    <div class="alert-s no-print"><i class="fa fa-check-circle"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert-e no-print"><i class="fa fa-times-circle"></i>{{ session('error') }}</div>
    @endif

   
<div class="filter-bar no-print">
    <form action="{{ route('admin.customers.index') }}" method="GET" class="filter-form" id="filterForm">
        <input type="text" name="search" class="search-input"
            placeholder="Search name, email, phone..."
            value="{{ request('search') }}">

        <select name="range" class="f-select" id="rangeSelect" onchange="handleRangeChange(this.value)">
            <option value="">All Time</option>
            <option value="this_month" {{ request('range') === 'this_month' ? 'selected' : '' }}>This Month</option>
            <option value="this_year"  {{ request('range') === 'this_year'  ? 'selected' : '' }}>This Year</option>
            <option value="custom"     {{ request('range') === 'custom'     ? 'selected' : '' }}>Custom Range</option>
        </select>

        {{-- Custom date inputs --}}
        <div id="customDates" style="display:{{ request('range') === 'custom' ? 'flex' : 'none' }};gap:6px;align-items:center;">
            <input type="date" name="date_from" class="f-select" id="dateFrom"
                value="{{ request('date_from') }}"
                onchange="autoSubmit()"
                style="width:130px;">
            <span style="font-size:11px;color:var(--muted);">to</span>
            <input type="date" name="date_to" class="f-select" id="dateTo"
                value="{{ request('date_to') }}"
                onchange="autoSubmit()"
                style="width:130px;">
        </div>

        @if(request('search') || request('range'))
        <a href="{{ route('admin.customers.index') }}" class="btn-reset"><i class="fa fa-times"></i> Clear</a>
        @endif

        <button type="button" class="btn-print" onclick="printTable()">
            <i class="fa fa-print"></i> Print
        </button>
    </form>
</div>

<script>
function handleRangeChange(val) {
    var customDiv = document.getElementById('customDates');
    if (val === 'custom') {
        customDiv.style.display = 'flex';
    } else {
        customDiv.style.display = 'none';
        // Auto submit for this_month / this_year / all time
        document.getElementById('filterForm').submit();
    }
}

function autoSubmit() {
    var from = document.getElementById('dateFrom').value;
    var to   = document.getElementById('dateTo').value;
    // Submit only when both dates selected
    if (from && to) {
        document.getElementById('filterForm').submit();
    }
}
</script>

   

    {{-- TABLE --}}
    <div class="tw">
    <table class="ct" id="customerTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>Status</th>
                <th class="no-print" style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($customers as $i => $customer)
        <tr>
            <td style="color:var(--muted);font-weight:600;font-size:11px;">{{ $customers->firstItem() + $loop->index }}</td>

            <td>
                <div style="display:flex;align-items:center;gap:9px;">
                    @if($customer->image)
                        <img src="{{ Storage::url($customer->image) }}" class="avatar" alt="{{ $customer->name }}">
                    @else
                        <div class="avatar-placeholder">{{ strtoupper(substr($customer->name,0,1)) }}</div>
                    @endif
                    <div>
                        <div class="c-name">{{ $customer->name }}</div>
                        <div class="c-sub">#{{ $customer->id }}</div>
                    </div>
                </div>
            </td>

            <td><span class="mono">{{ $customer->phone ?? '—' }}</span></td>
            <td style="color:var(--muted);">{{ $customer->email ?? '—' }}</td>
            <td style="color:var(--muted);max-width:140px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $customer->address ?? '—' }}</td>

            <td>
                @if($customer->status)
                    <span class="badge-active">Active</span>
                @else
                    <span class="badge-inactive">Inactive</span>
                @endif
            </td>

            <td class="no-print" style="text-align:center;">
                <div class="ag">
                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="abtn view" title="View"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('admin.customers.edit', $customer->id) }}" class="abtn edit" title="Edit"><i class="fa fa-pen"></i></a>
                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                        onsubmit="return confirm('Delete this customer?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="abtn del" title="Delete"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">
                <div class="empty">
                    <p style="color:var(--muted);font-size:13px;margin:0;">No customers found.</p>
                </div>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
    </div>

    @if($customers->hasPages())
    <div class="no-print" style="display:flex;justify-content:center;padding:16px;border-top:1px solid var(--border);background:#faf8ff;">
        {{ $customers->withQueryString()->links() }}
    </div>
    @endif

</div>
</div>

<script>
function printTable() {
    window.print();
}
</script>
@endsection