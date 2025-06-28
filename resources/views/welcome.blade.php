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

    .card-red {
        background-color: #dc3545 !important;
        color: #fff;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-red:hover {
        transform: translateY(-5px);
    }

    .card-red i {
        color: #fff !important;
    }
</style>

<style>
    @keyframes floatBox {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-20px);
        }
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
        <div class="container-fluid">

            <!-- Hero Content -->
            <div class="row d-flex justify-content-between align-items-center">
                <div class="hero-content col-md-7">
                    <h2>تتبع شحناتك</h2>
                    @if (session('success'))
                        <div id="successMessage" class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="form-track-group input-group col-md-12" id="divTrackingNumbers"></div>

                    <div class="input-wrap position-relative w-100 mt-4">
                        <input type="text" class="form-control" placeholder="ادخل رقم التتبع الخاص بك"
                            id="TrackingNumber" name="TrackingNumber" />
                        <span style="right: 10px" class="position-absolute top-50 text-danger translate-middle-y">
                            <i class="fas fs-3 fa-box"></i>
                        </span>
                        <button type="button" class="btn btn-primary" title="تتبع"
                            id="btn-mainslider-tracksubmit">تتبع</button>
                    </div>

                    </h6>
                </div>

                <!-- Carousel Section -->

                <!-- لودر Spinner -->
                <div id="carouselLoader" class="text-center my-5">
                    <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                        <span class="visually-hidden">جاري التحميل...</span>
                    </div>
                </div>

                <!-- الكاروسيل -->
                <div class="col-md-5 me-0 mt-5" id="carouselContainer">
                    <div id="heroImageCarousel" class="carousel slide shadow rounded-4 overflow-hidden"
                        data-bs-ride="carousel">
                        <div class="carousel-inner" id="carouselImagesContainer">
                            <!-- سيتم تعبئة الصور هنا -->
                        </div>

                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroImageCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                            <span class="visually-hidden">السابق</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroImageCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                            <span class="visually-hidden">التالي</span>
                        </button>
                    </div>
                </div>

                <!-- رسالة الخطأ -->
                <div id="carouselError" class="alert alert-danger text-center d-none" role="alert">
                    حدث خطأ أثناء تحميل الصور. الرجاء المحاولة لاحقاً.
                </div>


            </div>
            <!-- Home Options -->
            <div class="home-options mt-5 pt-5">
                <div class="container">
                    <div class="row justify-content-center align-content-center row-gap-5">
                        <!-- حاسبة الأسعار -->
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="first-card text-center card-red rounded-4 p-4"
                                style="width: 100%; max-width: 280px">
                                <a class="btn btn-card text-white" href="{{ route('calculate.shipment') }}"
                                    title="حاسبة الاسعار">
                                    <div class="img-wrap">
                                        <i class="fas fa-calculator fs-1"></i>
                                    </div>
                                    <h3 class="mt-3">حاسبة الاسعار</h3>
                                    <p>احصل على أسعار الشحن الفورية</p>
                                </a>
                            </div>
                        </div>

                        <!-- إرسال شحنة -->
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="second-card text-center card-red rounded-4 p-4"
                                style="width: 100%; max-width: 280px">
                                <a class="btn btn-card text-white" title="ارسال شحنة"
                                    href="{{ route('send_shipment.index') }}">
                                    <div class="img-wrap">
                                        <i class="fa-solid fa-truck-fast fs-1"></i>
                                    </div>
                                    <h3 class="mt-3">ارسال شحنة</h3>
                                    <p>ابدأ الشحن بسهولة. لا حاجة للتسجيل!</p>
                                </a>
                            </div>
                        </div>

                        <!-- تتبع شحنة -->
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="second-card text-center card-red rounded-4 p-4"
                                style="width: 100%; max-width: 280px">
                                <a class="btn btn-card text-white" title="تتبع الشحنة" href="{{ route('tracking.index') }}">
                                    <div class="img-wrap">
                                        <i class="fa-solid fa-location-crosshairs fs-1"></i>
                                    </div>
                                    <h3 class="mt-3">تتبع شحنة</h3>
                                    <p>تتبع شحنتك في اي وقت باستخدام رقم التتبع</p>
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
            <div id="carousel-cards" class="py-5 text-center" style="background-color: #f1f5f9;">
                <div class="container">
                    <h2 class="fw-bold mb-5">الشحن لا يعرف حدوداً</h2>
                    <div class="row justify-content-center">
                        <!-- Card 1 -->
                        <div class="col-md-4 mb-4">
                            <div class="d-flex flex-column align-items-center">
                                <img src="{{ asset('assets/images/pngtree.avif') }}" class="rounded-circle mb-3"
                                    alt="سلسلة إمداد" style="width: 120px; height: 120px; object-fit: cover;">
                                <h5 class="fw-semibold">سلاسل إمداد موثوقة</h5>
                                <p class="text-muted">حلول لوجستية يمكنك الاعتماد عليها، لتجاري متطلبات السوق بشكل
                                    سريع.
                                </p>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="col-md-4 mb-4">
                            <div class="d-flex flex-column align-items-center">
                                <img src="{{ asset('assets/images/solution-solving-problem.jpg') }}"
                                    class="rounded-circle mb-3" alt="حلول مرنة"
                                    style="width: 120px; height: 120px; object-fit: fill;">
                                <h5 class="fw-semibold">حلول مرنة</h5>
                                <p class="text-muted">حلول مصممة حسب الطلب لتناسب احتياجات العملاء بكل كفاءة.</p>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="col-md-4 mb-4">
                            <div class="d-flex flex-column align-items-center">
                                <img class="rounded-circle mb-3" src="{{ asset('assets/images/images.png') }}"
                                    alt="خدمات مستدامة" style="width: 120px; height: 120px; object-fit: cover;">
                                <h5 class="fw-semibold">خدمات لوجستية مستدامة</h5>
                                <p class="text-muted">خدمات صديقة للبيئة تساعدك على رفع أرباحك وتقليل الأثر البيئي.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" py-5 text-center text-md-start">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- App Image -->
                        {{-- <div class="col-md-3 text-center mb-4 mb-md-0 position-relative">
                            <img src="{{ asset('assets/images/tetex.webp') }}" class="img-fluid" alt="App Mockup"
                                style="max-height: 450px;">
                        </div> --}}

                        <!-- Content -->
                        <div class="col-md-8">
                            <h3 class="fw-bold mb-3">حمّل تطبيق <span class="text-danger">تيتيكس</span> </h3>
                            <div class="d-flex flex-column gap-2 mb-4">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-geo-alt-fill text-danger fs-5"></i>
                                    <span>تتبع شحنتك في الوقت الحالي</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-calendar-check-fill text-danger fs-5"></i>
                                    <span>جدول مواعيد استلام وتسليم الشحنات</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-shield-lock-fill text-danger fs-5"></i>
                                    <span>ادفع بشكل آمن، بدون تلامس</span>
                                </div>
                            </div>

                            <!-- Download Buttons -->
                            <!-- Store Buttons -->
                            <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start">

                                <!-- App Store -->
                                <a href="https://apps.apple.com/eg/app/tetex/id6497331317"
                                    class="btn btn-danger d-flex align-items-center gap-2 px-3 py-2 rounded-pill shadow-sm">
                                    <i class="fab fa-apple fa-lg"></i>
                                    <div class="text-start">
                                        <div class="small">Download on</div>
                                        <strong>App Store</strong>
                                    </div>
                                </a>

                                <!-- Google Play -->
                                <a href="https://play.google.com/store/apps/details?id=com.tetex.app&hl=en"
                                    class="btn btn-danger d-flex align-items-center gap-2 px-3 py-2 rounded-pill shadow-sm">
                                    <i class="fab fa-google-play fa-lg"></i>
                                    <div class="text-start">
                                        <div class="small">Get it on</div>
                                        <strong>Google Play</strong>
                                    </div>
                                </a>
                            </div>

                            <!-- Rating -->
                            {{-- <div class="mt-3">
                                <span class="text-warning fs-4">★★★★★</span>
                                <div>المزيد من تقييمات العملاء</div>
                            </div> --}}
                        </div>

                        <!-- Mobile Image (Delivery Man + Phone Mockup) -->
                        <div class="col-md-4 text-center mt-5 mt-md-0" id="mobile-image">
                            <!-- Phone App UI Mockup -->
                            <img src="{{ asset('assets/images/mobile_icon3.png') }}" alt="Mobile App" class="img-fluid"
                                style="max-height: 550px; z-index: 1;">
                        </div>
                    </div>
                </div>
            </div>

            <div style="background-color: #f1f5f9;" class="py-5 my-5">
                <div class="row align-items-center gy-5 justify-content-between d-flex ">
                    <!-- Text Content -->
                    <div class="col-md-6 text-start">
                        <h2 class="fw-bold mb-3 ms-3 text-dark">نحن دائماً معك أينما كنت حول العالم!</h2>
                        <p class="text-muted mb-4 ms-3">
                            بفضل شبكتنا العالمية الواسعة، نحن دائماً على مقربة منك.
                            نقدم لك حلولاً سلسة وفعّالة في الشحن السريع، والنقل، والخدمات اللوجستية.
                        </p>
                        {{-- <a href="#" class="btn btn-danger ms-3 rounded-pill px-4 py-2">اعثر على مكتب تتكس</a> --}}
                    </div>
                    <!-- Map Image -->
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('assets/images/map.webp') }}" alt="World Map" class="img-fluid"
                            style="max-width: 100%;">
                    </div>
                </div>
            </div>

        </div>
    </section>
    <script>
        const loader = document.getElementById('carouselLoader');
        const container = document.getElementById('carouselContainer');
        const carouselInner = document.getElementById('carouselImagesContainer');
        const errorMsg = document.getElementById('carouselError');

        fetch('https://admin.tetexexpress.com/api/images')
            .then(response => response.json())
            .then(data => {
                const images = data.imagesList;

                if (images.length === 0) {
                    throw new Error('لا توجد صور متاحة');
                }

                images.forEach((image, index) => {
                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('carousel-item');
                    if (index === 0) itemDiv.classList.add('active');

                    itemDiv.innerHTML = `
                <img class="w-100 object-fit-fill" style="max-height: 400px !important"
                     src="${image.full_path}" alt="Slide ${index + 1}">
              `;

                    carouselInner.appendChild(itemDiv);
                });

                // بعد التحميل
                loader.classList.add('d-none');
                container.classList.remove('d-none');
            })
            .catch(error => {
                console.error('Error:', error);
                loader.classList.add('d-none');
                errorMsg.classList.remove('d-none');
            });
    </script>
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
