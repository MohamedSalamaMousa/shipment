<header class="position-relative">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid px-3">
            <a class="navbar-brand fw-bold text-danger" href="#">تيتكس</a>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible Content -->
            <div class="collapse navbar-collapse text-center" id="mainNavbar">
                <!-- Right-side nav (pushed left in RTL) -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('send_shipment.index') }}">رسال شحنة جديدة</a>
                    </li>
                    @if (Session::has('user_token'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('shipments.current') }}">شحناتي</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="#">الشكاوي والأسئلة</a>
                    </li>
                </ul>

                <!-- Login/User Dropdown -->
                @if (!session('user_data'))
                    <div class="d-lg-flex justify-content-lg-end text-center mt-3 mt-lg-0">
                        <a id="show-login-form" href="#login" class="btn btn-danger rounded-pill px-4">تسجيل الدخول</a>
                    </div>
                @else
                    <div class="d-lg-flex justify-content-lg-end align-items-center text-center mt-3 mt-lg-0">
                        <!-- Dropdown for logged-in user -->
                        <div class="dropdown me-2">
                            <button class="btn btn-danger rounded-pill px-4 dropdown-toggle d-flex align-items-center"
                                type="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user me-2"></i> <!-- Adding an icon for better visuals -->
                                <span>{{ session('user_data')['name'] }} مرحبا</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="dropdownMenuLink"
                                style="min-width: 200px;">
                                <li><a class="dropdown-item text-end" href="#">الصفحة الشخصية</a></li>
                                <li><a class="dropdown-item text-end" href="#">الإعدادات</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-end text-danger">تسجيل
                                            الخروج</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Login Form (unchanged) -->
    <div id="login-form" style="left: 20px" class="login-form position-absolute">
        <div class="container d-flex justify-content-center mt-3">
            <div class="card p-4 shadow-sm" style="max-width: 400px; min-width: 400px; width: 100%">
                <div class="text-center mb-4">
                    <h5 class="fw-bold text-muted">
                        <i class="fa-solid fa-right-to-bracket text-danger"></i>
                        سجل الدخول إلى حسابك
                    </h5>
                </div>
                <form method="POST" action="{{ route('login.perform') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="phone" class="form-label text-danger small">رقم الهاتف *</label>
                        <input type="text" name="phone" class="form-control border-0 border-bottom" id="phone"
                            placeholder="01012345678" required />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-danger small">كلمة المرور *</label>
                        <input type="password" name="password" class="form-control border-0 border-bottom"
                            id="password" placeholder="••••••••" required />
                    </div>
                    <div class="text-end mb-3">
                        <a href="#" class="small text-muted text-decoration-none">هل نسيت كلمة المرور؟</a>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-danger rounded-pill">تسجيل الدخول</button>
                    </div>
                    @if (session('error'))
                        <div class="text-danger small mt-2">{{ session('error') }}</div>
                    @endif
                </form>
                <hr />
                <div class="text-center">
                    <div class="mb-2">
                        <span class="fw-bold text-muted">
                            <i class="fa-solid fa-user-plus text-danger"></i>
                            جديد مع أرامكس؟
                        </span>
                    </div>
                    <a href="register.html" class="btn btn-outline-danger rounded-pill px-4">إنشاء حساب</a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Add Custom CSS for Dropdown -->
<style>
    .dropdown-toggle {
        transition: background-color 0.3s ease;
    }

    .dropdown-toggle:hover {
        background-color: #c82333;
        /* Slightly darker shade of red on hover */
    }

    .dropdown-menu {
        border: none;
        border-radius: 10px;
        padding: 10px 0;
    }

    .dropdown-item {
        padding: 8px 20px;
        transition: background-color 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-divider {
        margin: 5px 0;
    }
</style>
