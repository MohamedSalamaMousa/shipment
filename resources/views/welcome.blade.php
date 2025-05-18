@extends('layouts.master')
@section('title', 'الصفحة الرئيسية')

<style>
    /* Custom styling for the success message */
    .alert-success {
        background-color: #d4edda;
        /* Light green background */
        color: #155724;
        /* Dark green text */
        border: 1px solid #c3e6cb;
        /* Green border */
        border-radius: 15px;
        /* Rounded corners */
        padding: 15px 20px;
        /* Comfortable padding */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
        font-size: 16px;
        /* Slightly larger text */
        font-weight: 500;
        /* Medium weight for readability */
        text-align: center;
        /* Center the text */
        margin-bottom: 20px;
        /* Space below the alert */
        position: relative;
        max-width: 500px;
        /* Limit width for better readability */
        margin-left: auto;
        margin-right: auto;
    }

    /* Add a small icon before the success message */
    .alert-success::before {
        content: '\f058';
        /* FontAwesome check-circle icon */
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        color: #28a745;
        /* Green icon */
        margin-left: 10px;
        /* Space between icon and text */
        font-size: 20px;
        vertical-align: middle;
    }

    /* Ensure the hero content has proper spacing */
    .hero-content {
        text-align: center;
        padding: 20px 0;
    }

    #serviceCarousel .carousel-item i {
        color: #fff;
        transition: transform 0.3s ease;
    }

    #serviceCarousel .carousel-item:hover i {
        transform: scale(1.2);
    }
</style>

@section('content')
    <!-- Toast Container -->
    @if (session('success_send_shipment'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
            <div id="shipmentToast" class="toast align-items-center text-white bg-success border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        ✅ تم إرسال الشحنة بنجاح
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->has('msg'))
        <div class="container mt-3 d-flex justify-content-center">
            <div class="alert alert-danger alert-dismissible fade show w-100 text-center" role="alert"
                style="max-width: 600px;">
                <strong>{{ $errors->first('msg') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif


    @if (session('success_send_shipment'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const toastEl = document.getElementById("shipmentToast");
                if (toastEl) {
                    const toast = new bootstrap.Toast(toastEl, {
                        delay: 1500
                    });
                    toast.show();
                }
            });
        </script>
    @endif

    <section id="main-content" class="p-md-5 m-md-5 min-vh-100">
        <div class="container">

            <!-- Hero Content -->
            <div class="hero-content">
                <h2>تتبع شحناتك</h2>
                @if (session('success'))
                    <div id="successMessage" class="alert alert-success">
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

                <div class="input-wrap position-relative mt-4">
                    <input type="text" class="form-control" placeholder="ادخل رقم التتبع الخاص بك" id="TrackingNumber"
                        name="TrackingNumber" />
                    <span style="right: 10px" class="position-absolute top-50 text-danger translate-middle-y">
                        <i class="fas fs-3 fa-box"></i>
                    </span>
                    <button type="button" class="btn btn-primary" title="تتبع"
                        id="btn-mainslider-tracksubmit">تتبع</button>
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
            <!-- Carousel Section -->
            <div class="my-5">
                <div id="serviceCarousel" class="carousel slide rounded-4 overflow-hidden shadow" data-bs-interval="3000"
                    data-bs-ride="carousel">
                    <div class="carousel-inner text-center text-white" style="background-color: #dc3545;">

                        <!-- Slide 1: Tracking -->
                        <div class="carousel-item active p-5">
                            <i class="fa-solid fa-box-open fa-3x mb-3"></i>
                            <h4 class="mb-2">سهولة تتبع الشحنات</h4>
                            <p>تتبع شحنتك في أي وقت باستخدام رقم التتبع بكل سهولة.</p>
                        </div>

                        <!-- Slide 2: Send without account -->
                        <div class="carousel-item p-5">
                            <i class="fa-solid fa-paper-plane fa-3x mb-3"></i>
                            <h4 class="mb-2">أرسل شحنتك بدون حساب</h4>
                            <p>لا حاجة للتسجيل. أرسل شحنتك بسرعة ومرونة.</p>
                        </div>

                        <!-- Slide 3: 24/7 Support -->
                        <div class="carousel-item p-5">
                            <i class="fa-solid fa-headset fa-3x mb-3"></i>
                            <h4 class="mb-2">دعم فني على مدار الساعة</h4>
                            <p>نحن بجانبك دائمًا لحل أي استفسار أو مشكلة.</p>
                        </div>
                    </div>

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#serviceCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">السابق</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#serviceCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">التالي</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 2000);
            }

            const trackButton = document.getElementById('btn-mainslider-tracksubmit');
            if (trackButton) {
                trackButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    const trackingNumber = document.getElementById('TrackingNumber').value.trim();
                    if (trackingNumber) {
                        const url = "{{ route('tracking.index') }}?barcode=" + encodeURIComponent(
                            trackingNumber);
                        window.location.href = url;
                    } else {
                        alert('يرجى إدخال رقم التتبع');
                    }
                });
            }
        });
    </script>

@endsection
