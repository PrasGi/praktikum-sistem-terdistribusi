<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if (Cache::get('user')['role'] == 'admin')
            <li class="nav-heading">admin</li>

            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'transactions' ? 'active' : '' }} collapsed"
                    href="{{ route('transactions') }}">
                    <i class="bi bi-person"></i>
                    <span>Transaction</span>
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'dashboard' ? 'active' : '' }} collapsed"
                    href="{{ route('dashboard') }}">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-heading">user</li>

            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'finance' ? 'active' : '' }} collapsed"
                    href="{{ route('finance') }}">
                    <i class="bi bi-calendar-heart"></i>
                    <span>Finance</span>
                </a>
            </li>
        @endif
    </ul>

</aside><!-- End Sidebar-->
