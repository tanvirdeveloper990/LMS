@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<style>
:root {
    --p1: #1B3A6B;
    --p2: #2563eb;
    --p3: #eff6ff;
    --pink: #EA0B66;
    --green: #059669;
    --amber: #d97706;
    --red: #dc2626;
    --border: #e5e7eb;
    --muted: #6b7280;
    --bg: #f3f4f6;
}

.dash-page { background: var(--bg); min-height: 100vh; padding: 24px 20px; }

/* ── Stat Cards ── */
.stat-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 18px 20px;
    box-shadow: 0 1px 6px rgba(0,0,0,.05);
    height: 100%;
}
.stat-card.featured {
    background: linear-gradient(135deg, var(--p1) 0%, #0f2347 100%);
    color: #fff;
    border: none;
}
.stat-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.stat-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: var(--muted); margin-bottom: 3px; }
.stat-val   { font-size: 22px; font-weight: 800; color: #111827; line-height: 1.2; }
.stat-card.featured .stat-label { color: rgba(255,255,255,.6); }
.stat-card.featured .stat-val   { color: #fff; }
.stat-change { font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 3px; margin-top: 4px; }
.stat-change.up   { color: var(--green); }
.stat-change.down { color: var(--red); }
.stat-change.neutral { color: var(--muted); }

/* ── Section card ── */
.dash-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 1px 6px rgba(0,0,0,.05);
    height: 100%;
}
.dash-card-head {
    padding: 14px 18px;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.dash-card-title { font-size: 13px; font-weight: 700; color: #111827; }
.dash-card-body  { padding: 16px 18px; }

/* ── Table ── */
.dash-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.dash-table th { color: var(--muted); font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; padding: 8px 10px; border-bottom: 1px solid var(--border); text-align: left; }
.dash-table td { padding: 10px 10px; border-bottom: 1px solid #f9fafb; color: #374151; vertical-align: middle; }
.dash-table tr:last-child td { border-bottom: none; }
.dash-table tr:hover td { background: #f9fafb; }
.prod-thumb { width: 34px; height: 34px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border); }

/* ── Stock badge ── */
.stock-badge {
    font-size: 10px; font-weight: 700;
    padding: 2px 8px; border-radius: 20px;
    display: inline-block;
}
.stock-badge.low  { background: #fef3c7; color: #92400e; }
.stock-badge.out  { background: #fee2e2; color: #991b1b; }
.stock-badge.good { background: #d1fae5; color: #065f46; }

/* ── Due badge ── */
.due-val { color: var(--red); font-weight: 700; font-size: 12px; }

/* ── Chart area ── */
#salesChart { max-height: 220px; }

/* ── Donut ── */
#stockDonut { max-height: 180px; }

/* ── Summary row under chart ── */
.chart-summary { display: flex; gap: 16px; padding: 12px 18px 14px; border-top: 1px solid var(--border); flex-wrap: wrap; }
.cs-item { text-align: center; }
.cs-label { font-size: 10px; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: .4px; }
.cs-val   { font-size: 14px; font-weight: 800; color: #111827; }

/* ── Stock legend ── */
.legend-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
.legend-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-size: 12px; }
.legend-name { color: #374151; flex: 1; }
.legend-pct  { font-weight: 700; color: #111827; font-size: 12px; }
</style>

<div class="dash-page">

    {{-- ── Top stat row ── --}}
    <div class="row g-3 mb-3">

        {{-- Today's Sales --}}
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card featured">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="stat-icon" style="background:rgba(255,255,255,.15);">
                        <i class="fas fa-chart-line" style="color:#fff;"></i>
                    </div>
                    <div>
                        <div class="stat-label">Today's Sales</div>
                        <div class="stat-val">{{ currency() }}{{ number_format($todaySales, 2) }}</div>
                    </div>
                </div>
                <div style="border-top:1px solid rgba(255,255,255,.15); padding-top:10px; font-size:12px;">
                  <div class="d-flex justify-content-between mb-1">
                        <span style="color:rgba(255,255,255,.6);">Cash on Delivery</span>
                        <span style="color:#fff; font-weight:700;">{{ currency() }}{{ number_format($todayCod, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span style="color:rgba(255,255,255,.6);">bKash / Nagad</span>
                        <span style="color:#fff; font-weight:700;">{{ currency() }}{{ number_format($todayMfs, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mt-2 pt-2" style="border-top:1px solid rgba(255,255,255,.12);">
                        <span style="color:rgba(255,255,255,.6);">vs Yesterday</span>
                        <span class="stat-change {{ $salesChange >= 0 ? 'up' : 'down' }}" style="color:{{ $salesChange >= 0 ? '#34d399' : '#f87171' }};">
                            <i class="fas fa-arrow-{{ $salesChange >= 0 ? 'up' : 'down' }}"></i>
                            {{ abs($salesChange) }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Today's Income --}}
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="stat-icon" style="background:#eff6ff;">
                        <i class="fas fa-wallet" style="color:var(--p2);"></i>
                    </div>
                    <div>
                        <div class="stat-label">Today's Income</div>
                        <div class="stat-val">{{ currency() }}{{ number_format($todayIncome, 2) }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center" style="font-size:11px; color:var(--muted);">
                    <span>vs Yesterday</span>
                    <span class="stat-change {{ $incomeChange >= 0 ? 'up' : 'down' }}">
                        <i class="fas fa-arrow-{{ $incomeChange >= 0 ? 'up' : 'down' }}"></i>
                        {{ abs($incomeChange) }}%
                    </span>
                </div>
            </div>
        </div>

        {{-- Total Due --}}
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="stat-icon" style="background:#fee2e2;">
                        <i class="fas fa-file-invoice-dollar" style="color:var(--red);"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Due Amount</div>
                        <div class="stat-val" style="color:var(--red);">{{ currency() }}{{ number_format($totalDue, 2) }}</div>
                    </div>
                </div>
                <div style="font-size:11px; color:var(--muted);">Unpaid orders</div>
            </div>
        </div>

        {{-- Total Customers --}}
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="stat-icon" style="background:#f0fdf4;">
                        <i class="fas fa-users" style="color:var(--green);"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Customers</div>
                        <div class="stat-val">{{ $customers }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-between" style="font-size:11px; color:var(--muted);">
                    <span>New (7 days)</span>
                    <span class="stat-change up"><i class="fas fa-arrow-up"></i> {{ $new_customers }}</span>
                </div>
            </div>
        </div>

        {{-- Total Products --}}
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="stat-icon" style="background:#faf5ff;">
                        <i class="fas fa-box" style="color:#7c3aed;"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Products</div>
                        <div class="stat-val">{{ $products }}</div>
                    </div>
                </div>
                <div style="font-size:11px; color:var(--muted);">{{ $categories }} categories</div>
            </div>
        </div>

        {{-- Low Stock --}}
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="stat-icon" style="background:#fff7ed;">
                        <i class="fas fa-exclamation-triangle" style="color:var(--amber);"></i>
                    </div>
                    <div>
                        <div class="stat-label">Low Stock Items</div>
                        <div class="stat-val" style="color:var(--amber);">{{ $lowStock }}</div>
                    </div>
                </div>
                <button id="open-stock-modal" class="btn btn-sm w-100 fw-semibold"
                    style="background:#fff7ed; color:var(--amber); border:1px solid #fed7aa; font-size:11px;">
                    View Details →
                </button>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="stat-icon" style="background:#fef3c7;">
                        <i class="fas fa-hourglass-half" style="color:#92400e;"></i>
                    </div>
                    <div>
                        <div class="stat-label">Pending Orders</div>
                        <div class="stat-val">{{ $pending_orders }}</div>
                    </div>
                </div>
                <div style="font-size:11px; color:var(--muted);">Awaiting processing</div>
            </div>
        </div>

        {{-- Completed Orders --}}
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="stat-icon" style="background:#d1fae5;">
                        <i class="fas fa-check-circle" style="color:var(--green);"></i>
                    </div>
                    <div>
                        <div class="stat-label">Completed Orders</div>
                        <div class="stat-val">{{ $complete_orders }}</div>
                    </div>
                </div>
                <div style="font-size:11px; color:var(--muted);">Total completed</div>
            </div>
        </div>

    </div>

    {{-- ── Row 2: Chart + Top Products ── --}}
    <div class="row g-3 mb-3">

        {{-- Sales Chart --}}
        <div class="col-lg-7">
            <div class="dash-card">
                <div class="dash-card-head">
                    <span class="dash-card-title">Sales Overview (This Month)</span>
                    <span style="font-size:11px; color:var(--muted);">Last 30 days</span>
                </div>
                <div class="dash-card-body pb-0">
                    <canvas id="salesChart"></canvas>
                </div>
                <div class="chart-summary">
                    <div class="cs-item">
                        <div class="cs-label">Total Sales</div>
                        <div class="cs-val">{{ currency() }}{{ number_format(array_sum($chartData), 0) }}</div>
                    </div>
                    <div class="cs-item">
                        <div class="cs-label">Avg Daily</div>
                        <div class="cs-val">{{ currency() }}{{ number_format(count($chartData) > 0 ? array_sum($chartData) / 30 : 0, 0) }}</div>
                    </div>
                    <div class="cs-item">
                        <div class="cs-label">Best Day</div>
                        @php
                            $maxIdx = array_search(max($chartData ?: [0]), $chartData ?: [0]);
                            $bestDay = $chartLabels[$maxIdx] ?? '—';
                            $bestVal = max($chartData ?: [0]);
                        @endphp
                        <div class="cs-val">{{ $bestDay }}</div>
                        <div style="font-size:10px; color:var(--muted);">{{ currency() }}{{ number_format($bestVal, 0) }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Selling Products --}}
        <div class="col-lg-5">
            <div class="dash-card">
                <div class="dash-card-head">
                    <span class="dash-card-title">Top Selling Products</span>
                    <a href="{{ route('admin.products.index') }}" style="font-size:11px; color:var(--p2); text-decoration:none; font-weight:600;">View All</a>
                </div>
                <div class="p-0">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th style="padding-left:18px;">Product</th>
                                <th>Category</th>
                                <th>Sold</th>
                                <th>Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $tp)
                            <tr>
                                <td style="padding-left:18px;">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($tp->product?->featured_image_1)
                                        <img src="{{ Storage::url($tp->product->featured_image_1) }}" class="prod-thumb" alt="">
                                        @endif
                                        <span class="fw-semibold" style="font-size:12px; max-width:120px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            {{ $tp->product?->name ?? '—' }}
                                        </span>
                                    </div>
                                </td>
                                <td style="font-size:11px; color:var(--muted);">{{ $tp->product?->category?->name ?? '—' }}</td>
                                <td><span class="fw-bold">{{ $tp->sold_qty }}</span></td>
                                <td style="color:var(--p1); font-weight:700;">{{ currency() }}{{ number_format($tp->sales_amount, 0) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No data yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Row 3: Top Customers + Stock Donut + Low Stock ── --}}
    <div class="row g-3">

        {{-- Top Customers --}}
        <div class="col-lg-4">
            <div class="dash-card">
                <div class="dash-card-head">
                    <span class="dash-card-title">Top Customers (By Sales)</span>
                    <a href="{{ route('admin.customers.index') }}" style="font-size:11px; color:var(--p2); text-decoration:none; font-weight:600;">View All</a>
                </div>
                <div class="p-0">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th style="padding-left:18px;">Customer</th>
                                <th>Sales</th>
                                <th>Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topCustomers as $tc)
                            <tr>
                                <td style="padding-left:18px;">
                                    <div style="font-size:12px; font-weight:600; color:#111827;">{{ $tc->user?->name ?? 'Guest' }}</div>
                                    <div style="font-size:10px; color:var(--muted);">{{ $tc->user?->phone ?? '' }}</div>
                                </td>
                                <td style="font-weight:700; font-size:12px; color:var(--p1);">{{ currency() }}{{ number_format($tc->total_sales, 0) }}</td>
                                <td class="due-val">{{ currency() }}{{ number_format($tc->total_due, 0) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-4">No data yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Stock Summary Donut --}}
        <div class="col-lg-4">
            <div class="dash-card">
                <div class="dash-card-head">
                    <span class="dash-card-title">Stock Summary</span>
                </div>
                <div class="dash-card-body">
                    @php
                        $totalProd   = $products ?: 1;
                        $goodPct     = round($goodStock / $totalProd * 100, 1);
                        $lowPct      = round($lowStock  / $totalProd * 100, 1);
                        $outPct      = round($outOfStock / $totalProd * 100, 1);
                        $overPct     = round($overStock  / $totalProd * 100, 1);
                    @endphp
                    <div class="d-flex justify-content-center mb-3">
                        <div style="position:relative; width:160px; height:160px;">
                            <canvas id="stockDonut"></canvas>
                            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center;">
                                <div style="font-size:22px; font-weight:800; color:#111827;">{{ $products }}</div>
                                <div style="font-size:10px; color:var(--muted);">Total Products</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="legend-row">
                            <span class="legend-dot" style="background:#3b82f6;"></span>
                            <span class="legend-name">In Stock (Good)</span>
                            <span class="legend-pct">{{ $goodStock }} ({{ $goodPct }}%)</span>
                        </div>
                        <div class="legend-row">
                            <span class="legend-dot" style="background:#f59e0b;"></span>
                            <span class="legend-name">Low Stock</span>
                            <span class="legend-pct">{{ $lowStock }} ({{ $lowPct }}%)</span>
                        </div>
                        <div class="legend-row">
                            <span class="legend-dot" style="background:#ef4444;"></span>
                            <span class="legend-name">Out of Stock</span>
                            <span class="legend-pct">{{ $outOfStock }} ({{ $outPct }}%)</span>
                        </div>
                        <div class="legend-row">
                            <span class="legend-dot" style="background:#10b981;"></span>
                            <span class="legend-name">Over Stock</span>
                            <span class="legend-pct">{{ $overStock }} ({{ $overPct }}%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Low Stock Alerts --}}
        <div class="col-lg-4">
            <div class="dash-card">
                <div class="dash-card-head">
                    <span class="dash-card-title">Low Stock Alerts</span>
                    <button id="open-stock-modal2" style="font-size:11px; color:var(--p2); background:none; border:none; cursor:pointer; font-weight:600;">View All</button>
                </div>
                <div class="dash-card-body p-0">
                    @forelse($lowStockProducts as $sp)
                    <div style="padding:12px 18px; border-bottom:1px solid #f9fafb; display:flex; align-items:center; gap:12px;">
                        @if($sp->featured_image_1)
                        <img src="{{ Storage::url($sp->featured_image_1) }}" style="width:40px; height:40px; object-fit:cover; border-radius:8px; border:1px solid var(--border);" alt="">
                        @else
                        <div style="width:40px; height:40px; background:#f3f4f6; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-box" style="color:#d1d5db; font-size:14px;"></i>
                        </div>
                        @endif
                        <div style="flex:1; min-width:0;">
                            <div style="font-size:12px; font-weight:600; color:#111827; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $sp->name }}</div>
                            <div style="font-size:11px; color:var(--muted);">Current Stock: {{ $sp->available_stock }} pcs</div>
                        </div>
                        <span class="stock-badge {{ $sp->available_stock <= 5 ? 'out' : 'low' }}">
                            Min: 10
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted" style="font-size:13px;">
                        <i class="fas fa-check-circle d-block mb-2" style="font-size:24px; color:#d1fae5; color:#10b981;"></i>
                        All products well stocked
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>

{{-- Stock Modal --}}
<div class="modal fade" id="stock-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Stock Management</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <h6 class="text-danger fw-semibold mb-2">⚠️ Low Stock Products (≤ 10)</h6>
        <table class="table table-sm align-middle mb-4">
          <thead class="table-light"><tr><th>Product</th><th>Available Stock</th></tr></thead>
          <tbody>
            @forelse($lowStockProducts as $product)
            <tr><td>{{ $product->name }}</td><td><span class="badge bg-warning text-dark">{{ $product->available_stock }}</span></td></tr>
            @empty
            <tr><td colspan="2" class="text-center text-muted">No low-stock products</td></tr>
            @endforelse
          </tbody>
        </table>
        <h6 class="text-success fw-semibold mb-2">✅ Good Stock Products</h6>
        <table class="table table-sm align-middle">
          <thead class="table-light"><tr><th>Product</th><th>Available Stock</th></tr></thead>
          <tbody>
            @forelse($otherProducts->take(20) as $product)
            <tr><td>{{ $product->name }}</td><td><span class="badge bg-success">{{ $product->available_stock }}</span></td></tr>
            @empty
            <tr><td colspan="2" class="text-center text-muted">No products</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
$(document).ready(function(){
    $('#open-stock-modal, #open-stock-modal2').click(function(){
        $('#stock-modal').modal('show');
    });
});

/* ── Sales Line Chart ── */
const salesCtx = document.getElementById('salesChart').getContext('2d');
const labels   = @json($chartLabels);
const data     = @json($chartData);

const gradient = salesCtx.createLinearGradient(0, 0, 0, 200);
gradient.addColorStop(0,   'rgba(27,58,107,0.18)');
gradient.addColorStop(1,   'rgba(27,58,107,0.0)');

new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Sales',
            data: data,
            borderColor: '#1B3A6B',
            backgroundColor: gradient,
            borderWidth: 2,
            pointRadius: 0,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: '#1B3A6B',
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1B3A6B',
                titleFont: { size: 11 },
                bodyFont: { size: 12, weight: '700' },
                callbacks: {
                    label: ctx => ' ৳' + Number(ctx.raw).toLocaleString()
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { font: { size: 10 }, color: '#9ca3af', maxTicksLimit: 8 },
                border: { display: false }
            },
            y: {
                grid: { color: '#f3f4f6' },
                ticks: {
                    font: { size: 10 }, color: '#9ca3af',
                    callback: val => val >= 1000 ? (val/1000).toFixed(0)+'k' : val
                },
                border: { display: false }
            }
        }
    }
});

/* ── Stock Donut ── */
const donutCtx = document.getElementById('stockDonut').getContext('2d');
new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        labels: ['In Stock', 'Low Stock', 'Out of Stock', 'Over Stock'],
        datasets: [{
            data: [{{ $goodStock }}, {{ $lowStock }}, {{ $outOfStock }}, {{ $overStock }}],
            backgroundColor: ['#3b82f6', '#f59e0b', '#ef4444', '#10b981'],
            borderWidth: 0,
            hoverOffset: 4,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '72%',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.raw }
            }
        }
    }
});
</script>
@endsection