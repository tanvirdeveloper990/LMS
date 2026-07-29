<nav id="sidebar">
    <div class="p-3 text-center border-bottom fw-bold">{{ Auth::guard('affiliate')->user()->name ?? 'Admin' }}</div>

    <ul class="nav flex-column mt-3">

        {{-- Dashboard --}}

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('affiliate.dashboard') ? 'active' : '' }}" href="{{ route('affiliate.dashboard') }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </li>

         <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('affiliate.offers') ? 'active' : '' }}" href="{{ route('affiliate.offers') }}">
                <i class="fas fa-gift me-2"></i> Product Offers
            </a>
        </li>


         <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('affiliate.earnings') ? 'active' : '' }}" href="{{ route('affiliate.earnings') }}">
                <i class="fas fa-home me-2"></i> Product Earnings
            </a>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('affiliate.withdraw') ? 'active' : '' }}" href="{{ route('affiliate.withdraw') }}">
                <i class="fas fa-credit-card me-2"></i> Product Withdrawal
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('affiliate.level') ? 'active' : '' }}" href="{{ route('affiliate.level') }}">
                <i class="fas fa-gem text-blue-500 me-2"></i> Level System
            </a>
        </li>

    </ul>
</nav>