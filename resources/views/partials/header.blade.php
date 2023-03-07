
<nav class="navbar navbar-expand-md navbar-dark navbar-custom">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            {{-- <li class="nav-item active"> --}}

            @if(Auth::check() and Auth::user()->role == 'admin')
            <li class="nav-item">
            <a class="nav-link" href="{{ route('getCustomers') }}">Customer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('getPets') }}">Pet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('getEmployees') }}">Employee</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('getGroomings') }}">Pet Grooming</a>
            </li>
            @elseif(Auth::check() and Auth::user()->role == 'employee')
             <li class="nav-item">
                <a class="nav-link" href="{{ route('getConsultations')}}">Consultation</a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="{{ route('getOrders') }}">Transaction</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('shop.index') }}">Shop</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Consultation</a>
            </li>
            @endif
        </ul>
    </div>
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="#">Acme Clinic</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            @if(Auth::check() and Auth::user()->role == 'admin') 
            @elseif(Auth::check() and Auth::user()->role == 'employee')
            @else

            <li class="nav-item">
                <a class="btn btn-outline-light" type="submit" href="{{ route('grooming.shoppingCart') }}">
                    <i class="bi-cart-fill me-1"></i>
                    My Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
                </a>
            </li>
            
            @endif
            @if(Auth::check() and Auth::user()->role == 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.employee') }}">Profile</a>
            </li>
            @elseif(Auth::check() and Auth::user()->role == 'employee')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.profile') }}">Profile</a>
            </li>
            @elseif(Auth::check() and Auth::user()->role == 'customer')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.profile') }}">Profile</a>
            </li>
            @else
            @endif
            @if(Auth::check())        
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.logout') }}">Logout</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.signup') }}">Sign-up</a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="{{ route('user.signupEmployee') }}">Apply Job</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.signin') }}">Login</a>
            </li>
            @endif
        </ul>
    </div>
</nav>