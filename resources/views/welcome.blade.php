@extends('layouts.master')
@section('title', 'الصفحة الرئيسية')
@section('content')
    <section id="main-content" class="p-md-5 m-md-5">
        <div class="container">
            <!-- Hero Content -->
            <div class="hero-content">
                <h2>تتبع شحناتك</h2>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- {{ session('user_data')['name'] }} --}}

                {{-- <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        تسجيل الخروج
                    </button>
                </form> --}}
                <div class="form-track-group input-group col-md-12" id="divTrackingNumbers"></div>

                <div class="input-wrap">
                    <input type="text" class="form-control" placeholder="ادخل رقم التتبع الخاص بك" id="TrackingNumber"
                        name="TrackingNumber" />

                    <span style="right: 10px" class="position-absolute top-50 text-danger translate-middle-y"><i
                            class="fas fs-3 fa-box"></i></span>

                    <a href="#" class="btn btn-primary" title="تتبع" id="btn-mainslider-tracksubmit">تتبع</a>
                </div>
                <h6 class="block-info-text text-muted mt-2" style="font-size: 14px">
                    أدخل عدة أرقام تتبع مفصولة بمسافة أو فاصلة.<br />إذا لم يعمل رقم
                    التتبع الخاص بك، تحقق من التنسيق أو اضغط
                    <a href="/support/help-center">هنا</a>
                    للحصول على الدعم.
                    <br />
                    يمكن للعملاء المسجلين الوصول إلى التتبع المتقدم عن طريق تسجيل الدخول
                    إلى حساباتهم من.
                    <a href="/ae/en/track/advanced-tracking">هنا</a>.
                </h6>
            </div>

            <!-- Home Options -->
            <div class="home-options mt-5 pt-5">
                <div class="container">
                    <div class="row justify-content-center align-content-center row-gap-5">
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="first-card text-center bg-light rounded-4 p-4"
                                style="width: 100%; max-width: 280px">
                                <a class="btn btn-card" href="{{ route('calculate.shipment') }}" title="حاسبة الاسعار">
                                    <div class="img-wrap">
                                        <i class="fas fa-calculator fs-1 text-danger"></i>
                                    </div>
                                    <h3>حاسبة الاسعار</h3>
                                    <p>احصل على أسعار الشحن الفورية</p>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="second-card text-center bg-light rounded-4 p-4"
                                style="width: 100%; max-width: 280px">
                                <a class="btn btn-card" title="ارسال شحنة">
                                    <div class="img-wrap">
                                        <i class="fa-solid fa-truck-fast fs-1 text-danger"></i>
                                    </div>
                                    <h3>ارسال شحنة</h3>
                                    <p>ابدأ الشحن بسهولة. لا حاجة للتسجيل!</p>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="third-card text-center bg-light rounded-4 p-4"
                                style="width: 100%; max-width: 280px">
                                <a class="btn btn-card" title="ارسال شحنة" href="{{ route('send_shipment.index') }}">
                                    <div class="img-wrap">
                                        <i class="fa-solid fa-truck-fast fs-1 text-danger"></i>
                                    </div>
                                    <h3>ارسال شحنة</h3>
                                    <p>ابدأ الشحن بسهولة. لا حاجة للتسجيل!</p>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
