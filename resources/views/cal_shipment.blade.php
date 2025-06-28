@extends('layouts.master')
@section('title', 'حساب شحنتك')


<style>
    .alert-info {
        background-color: #e9f7f9;
        /* Light cyan background */
        color: #2c3e50;
        /* Dark blue-gray text */
        border: 2px solid #00c4cc;
        /* Cyan border */
        border-radius: 20px;
        /* More rounded corners */
        padding: 20px;
        /* Increased padding for better spacing */
        box-shadow: 0 8px 20px rgba(0, 196, 204, 0.3);
        /* Subtle cyan shadow */
        font-size: 16px;
        /* Slightly larger text */
        font-weight: 500;
        /* Medium weight for readability */
        text-align: center;
        /* Center the text */
        margin-top: 20px;
        /* Space above the alert */
        position: relative;
        max-width: 600px;
        /* Limit width for better readability */
        margin-left: auto;
        margin-right: auto;
        transition: all 0.3s ease;
        /* Smooth transition for hover/focus */
        animation: fadeIn 0.5s ease-in-out;
        /* Fade-in animation */
    }

    .alert-danger {
        background-color: #f8d7da;
        /* Light red background */
        color: #721c24;
        /* Dark red text */
        border: 2px solid #dc3545;
        /* Red border */
        border-radius: 20px;
        /* More rounded corners */
        padding: 20px;
        /* Increased padding */
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        /* Red shadow */
        font-size: 16px;
        /* Slightly larger text */
        font-weight: 500;
        /* Medium weight */
        text-align: center;
        /* Center the text */
        margin-top: 20px;
        /* Space above the alert */
        position: relative;
        max-width: 600px;
        /* Limit width */
        margin-left: auto;
        margin-right: auto;
        transition: all 0.3s ease;
        /* Smooth transition */
        animation: fadeIn 0.5s ease-in-out;
        /* Fade-in animation */
    }

    /* Hover effect for better interaction */
    .alert-info:hover,
    .alert-danger:hover {
        transform: translateY(-5px);
        /* Slight lift on hover */
        box-shadow: 0 12px 25px rgba(243, 121, 137, 0.4);
        /* Enhanced shadow on hover */
    }

    .alert-shipping-custom {
        background-color: #f9f9f9;
        color: #333;
        border-left: 5px solid #dc3545;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        padding: 20px 25px;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s ease-in-out;
        position: relative;
    }

    .alert-shipping-custom h6 {
        font-weight: bold;
        color: #dc3545;
        margin-bottom: 12px;
    }

    .alert-shipping-custom i {
        color: #dc3545;
        margin-left: 8px;
    }

    .alert-shipping-custom .shipping-detail {
        margin-bottom: 6px;
        display: flex;
        align-items: center;
    }

    .alert-shipping-custom .shipping-detail i {
        margin-left: 10px;
        font-size: 1rem;
        color: #555;
    }

    /* تكبير وتنسيق نتائج السعر */
    .alert-shipping-custom {
        font-size: 1.1rem !important;
        line-height: 1.9;
        padding: 24px !important;
        border-radius: 16px !important;
    }

    .alert-shipping-custom .shipping-detail {
        font-size: 1.1rem !important;
        margin-bottom: 12px !important;
    }

    .alert-shipping-custom strong {
        font-weight: 700;
    }

    .alert-shipping-custom i {
        font-size: 1.2rem !important;
        color: #dc3545;
        margin-left: 10px;
    }

    /* عند الضغط على "تفاصيل أكثر" */
    #moreDetails {
        padding: 15px 20px;
        font-size: 1.05rem;
        font-weight: 600;
        /* bold */
        color: #333;
        background-color: #fdfdfd;
        border: 2px dashed #dc3545;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.05);
        margin-top: 16px;
        transition: all 0.3s ease-in-out;
    }

    /* كل بند داخل التفاصيل */
    #moreDetails div {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        padding: 6px 10px;
        border-radius: 8px;
        transition: background 0.2s;
    }

    #moreDetails div:hover {
        background-color: #f8f8f8;
    }

    /* الأيقونات */
    #moreDetails i {
        color: #28a745;
        font-size: 1.1rem;
        min-width: 18px;
    }

    label.form-label {
        font-size: 1.1rem !important;
        font-weight: 600;
    }


    /* Fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Add a small icon before the result (optional, adjust based on preference) */
    .alert-info::before,
    .alert-danger::before {
        content: '\f058';
        /* FontAwesome check-circle for info, can change for danger */
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;

        color: #00c4cc;
        /* Cyan for info, red for danger */
        margin-right: -15px;
        /* Space between icon and text */
        font-size: 20px;
        vertical-align: middle;
    }

    .alert-danger::before {
        content: '\f06a';
        /* FontAwesome times-circle for danger */
        color: #dc3545;
        padding-left: 10px;
        /* Red for danger */
    }
</style>

@section('content')
    <section id="prices" class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container p-5 shadow rounded-4">
            <h2 class="text-center text-danger">أسعار الشحن</h2>

            <!-- Nav Tabs -->
            <ul class="nav nav-pills justify-content-center mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-danger" id="pills-domestic-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-domestic" type="button" role="tab" aria-controls="pills-domestic"
                        aria-selected="false">
                        <i class="fa-solid fa-truck"></i> <span class="fw-bold fs-5">محلي</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-danger" id="pills-international-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-international" type="button" role="tab"
                        aria-controls="pills-international" aria-selected="true">
                        <i class="fa-solid fa-plane-departure"></i> <span class="fw-bold fs-5">دولي</span>
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="pills-tabContent">
                <!-- International Tab -->
                <div class="tab-pane fade" id="pills-international" role="tabpanel"
                    aria-labelledby="pills-international-tab">
                    <form id="globalPriceForm" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">الدولة المرسل منها *</label>
                            <input type="text" class="form-control" readonly placeholder="مصر" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الدولة المرسل اليها *</label>
                            <select id="country" name="country" class="form-select">
                                @php
                                    $countries = config('countries');
                                @endphp
                                <option selected disabled>اختر الدولة</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الوزن *</label>
                            <input type="number" name="shipping_weight" min="1" max="30000"
                                placeholder="الوزن بالجرام و اقصى وزن 30000 جرام للشحنه" class="form-control"
                                min="0" />
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-danger rounded-5 mt-3">
                                احصل على السعر الدولي
                            </button>
                        </div>
                    </form>
                    <div id="global-shipping-price-result" class="alert-shipping-custom d-none mt-3"></div>
                </div>

                <!-- Domestic Tab -->
                <div class="tab-pane fade active show" id="pills-domestic" role="tabpanel"
                    aria-labelledby="pills-domestic-tab">
                    <form id="priceCalculatorForm" class="row g-3">
                        <!-- من المحافظة -->
                        <div class="col-md-4">
                            <label class="form-label">المحافظة المرسل منها *</label>
                            <select class="form-select select-governorate" name="from_governorate" required>
                                <option selected disabled>اختر المحافظة</option>
                                @php
                                    $governorates = config('governorates');
                                @endphp
                                @foreach ($governorates as $gov)
                                    <option value="{{ $gov }}">{{ $gov }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- إلى المحافظة -->
                        <div class="col-md-4">
                            <label class="form-label">المحافظة المرسل اليها *</label>
                            <select class="form-select select-governorate" name="to_governorate" required>
                                <option selected disabled> اختر المحافظة</option>
                                @foreach ($governorates as $gov)
                                    <option value="{{ $gov }}">{{ $gov }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- الوزن -->
                        <div class="col-md-4">
                            <label class="form-label">الوزن *</label>
                            <input type="number" class="form-control" min="1" max="30000"
                                placeholder="الوزن بالجرام و اقصى وزن 30000 جرام للشحنه" name="weight" min="0"
                                required />
                        </div>

                        <!-- زر الإرسال -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-danger rounded-5 mt-3">
                                احصل على السعر المحلي
                            </button>
                        </div>

                        <!-- عرض السعر -->
                        <div class="col-12">
                            <div id="shipping-price-result" class="alert-shipping-custom d-none mt-3"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            // تفعيل select2 (إذا كنت تستخدمها)
            $('.select-governorate').select2({
                placeholder: "اختر المحافظة",
                dir: "rtl"
            });

            $('#country').select2({
                placeholder: "اختر المحافظة",
                dir: "rtl"
            });

            // عند إرسال النموذج المحلي
            $('#priceCalculatorForm').on('submit', function(e) {
                e.preventDefault();

                const fromGovernorate = $('select[name="from_governorate"]').val();
                const toGovernorate = $('select[name="to_governorate"]').val();
                const weight = $('input[name="weight"]').val();

                // Clear previous results before sending new request
                $('#shipping-price-result').addClass('d-none');

                // إرسال البيانات إلى API لحساب السعر المحلي
                $.ajax({
                    url: '{{ route('local_shipment') }}',
                    type: 'POST',
                    data: {
                        from_governorate: fromGovernorate,
                        to_governorate: toGovernorate,
                        weight: weight,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            const data = response.data;

                            let resultHtml = `
                                <div class="shipping-detail"><i class="fas fa-truck"></i> سعر الشحن المحلي: &nbsp;<strong>${data.price} جنيه</strong></div>
                                <div class="shipping-detail"><i class="fas fa-weight-hanging"></i> الوزن:  &nbsp;<strong>${data.k_Local_price} جنيه</strong> &nbsp; لكل كيلوجرام تكراري</div>
                                <div class="shipping-detail"><i class="fas fa-money-bill-wave"></i> التحصيل: &nbsp;<strong>${data.fee_per_unit}</strong> &nbsp; لكل 1000 ج</div>
                                <div class="shipping-detail"><i class="fas fa-clock"></i> وقت الاستلام: &nbsp;<strong>${data.receipt_time}</strong></div>
                                <div class="shipping-detail"><i class="fas fa-shipping-fast"></i> وقت التوصيل: &nbsp;<strong>${data.delivery_time}</strong></div>
                                `;

                            $('#shipping-price-result')
                                .removeClass('d-none alert-danger').html(resultHtml);
                        } else {
                            $('#shipping-price-result')
                                .removeClass('d-none')
                                .removeClass('alert-shipping-custom')
                                .addClass('alert alert-danger')
                                .text('تعذر جلب بيانات السعر، الرجاء المحاولة مرة أخرى.');
                        }
                    },
                    error: function() {
                        $('#shipping-price-result')
                            .removeClass('d-none')
                            .removeClass('alert-shipping-custom')
                            .addClass('alert alert-danger')
                            .text('حدث خطأ أثناء حساب السعر. تأكد من صحة البيانات.');
                    }
                });
            });

            // عند إرسال النموذج الدولي
            $('#globalPriceForm').on('submit', function(e) {
                e.preventDefault();

                const country = $('select[name="country"]').val();
                const weight = $('input[name="shipping_weight"]').val();

                // Clear previous results before sending new request
                $('#global-shipping-price-result').addClass('d-none');

                // إرسال البيانات إلى API لحساب السعر الدولي
                $.ajax({
                    url: '{{ route('global_shipment') }}',
                    type: 'POST',
                    data: {
                        country: country,
                        shipping_weight: weight,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            const data = response.data;

                            let resultHtml = `
                            <div class="shipping-detail"><i class="fas fa-globe"></i> سعر الشحن الدولي: &nbsp;<strong>${data.price} جنيه</strong></div>
                            <div class="shipping-detail"><i class="fas fa-plus-circle"></i> السعر الإضافي: &nbsp;<strong>${data.additional_price} جنيه</strong></div>

                            <div>
                                <a class="text-danger d-inline-block mt-2" data-bs-toggle="collapse" href="#moreDetails" role="button" aria-expanded="false" aria-controls="moreDetails">
                                    <i class="fas fa-chevron-down"></i> تفاصيل أكثر
                                </a>
                                <div class="collapse mt-2 text-muted small" id="moreDetails">
                                    <div>الأسعار متغيرة حسب محافظة الاستلام</div>
                                    <div>أقصى وزن 30000 جرام للقطعة</div>
                                    <div>الشحن طيران فقط</div>
                                    <div><i class="fas fa-check-circle text-success me-1"></i> مدة التسليم من 5 أيام إلى 8 أيام عمل</div>
                                    <div><i class="fas fa-check-circle text-success me-1"></i> مدة الاستلام 3 أيام عمل</div>
                                    <div><i class="fas fa-check-circle text-success me-1"></i> إتاحة التتبع</div>
                                    <div><i class="fas fa-check-circle text-success me-1"></i> مصاريف الشحن عند الاستلام</div>
                                    <div><i class="fas fa-check-circle text-success me-1"></i> المرتجع مجاني</div>
                                    <div><i class="fas fa-check-circle text-success me-1"></i> لا يوجد تحصيل من المرسل إليه</div>
                                </div>
                            </div>
                            `;

                            $('#global-shipping-price-result')
                                .removeClass('d-none alert-danger')
                                .addClass('alert-shipping-custom')
                                .html(resultHtml);
                        } else {
                            $('#global-shipping-price-result')
                                .removeClass('d-none alert-shipping-custom')
                                .addClass('alert alert-danger')
                                .text(
                                    'تعذر جلب بيانات السعر الدولي، الرجاء المحاولة مرة أخرى.');
                        }
                    },
                    error: function() {
                        $('#global-shipping-price-result')
                            .removeClass('d-none alert-shipping-custom')
                            .addClass('alert alert-danger')
                            .text('حدث خطأ أثناء حساب السعر الدولي. تأكد من صحة البيانات . ');
                    }
                });
            });
        });
    </script>
@endsection
