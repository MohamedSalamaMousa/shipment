@extends('layouts.master')
@section('title', 'ارسال شحنة')
@section('content')
    <section id="steps" class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="container bg-white p-4 rounded shadow" style="max-width: 900px">
            <div class="step-indicator">
                <div class="step active" data-step="1">
                    <div class="step-number">1</div>
                    <div>معلومات المرسل</div>
                </div>
                <div class="step" data-step="2">
                    <div class="step-number">2</div>
                    <div>معلومات المستلم</div>
                </div>
                <div class="step" data-step="3">
                    <div class="step-number">3</div>
                    <div>تفاصيل الشحنة</div>
                </div>

            </div>
            <form action="{{ route('shipping.store') }}" method="POST">
                @csrf
                <!-- الخطوات هنا -->

            <!-- Step 1 -->
            <div class="step-content" data-step="1">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم *</label>
                        <input type="text" name="sender_name" class="form-control" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رقم الهاتف *</label>
                        <input type="text" name="sender_phone" class="form-control" placeholder="0100 123 4567"
                            required />
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">رقم هاتف إضافي (اختياري)</label>
                        <input type="text" name="additional_phone_sender" class="form-control"
                            placeholder="0123 456 7890" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">المحافظة *</label>
                        <input type="text" name="sender_governorate" class="form-control" required />
                    </div>


                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">العنوان بالتفصيل *</label>
                        <input type="text" name="sender_address" class="form-control"
                            placeholder="أقرب معلم أو عنوان مختصر" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"> رقم المبنى *</label>
                        <input type="text" name="sender_House_number" class="form-control" required />
                    </div>

                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">رقم الدور *</label>
                        <input type="text" name="sender_floor_number" class="form-control" required />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">رقم الشقة *</label>
                        <input type="text" name="sender_apartment_number" class="form-control" required />
                    </div>
                </div>



                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" disabled>
                            العودة
                        </button>
                        <button type="button" class="btn btn-danger" onclick="nextStep()">
                            التالي
                        </button>
                    </div>
                </div>
            </div>



            <!-- Step 2: معلومات المستلم -->
            <div class="step-content" data-step="2">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم *</label>
                        <input type="text" name="recipient_name" class="form-control" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رقم الهاتف *</label>
                        <input type="text" name="recipient_phone" class="form-control" placeholder="0100 123 4567"
                            required />
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">رقم هاتف إضافي (اختياري)</label>
                        <input type="text" name="additional_phone_recipient" class="form-control"
                            placeholder="0123 456 7890" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">المحافظة *</label>
                        <input type="text" name="recipient_governorate" class="form-control" required />
                    </div>

                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">العنوان بالتفصيل*</label>
                        <input type="text" name="recipient_address" class="form-control"
                            placeholder="أقرب معلم أو عنوان مختصر" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"> رقم المبنى *</label>
                        <input type="text" name="recipient_House_number" class="form-control" required />
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">رقم الدور *</label>
                        <input type="text" name="recipient_floor_number" class="form-control" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رقم الشقة *</label>
                        <input type="text" name="recipient_apartment_number" class="form-control" required />
                    </div>
                </div>



                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="prevStep()">
                            العودة
                        </button>
                        <button type="button" class="btn btn-danger" onclick="nextStep()">
                            التالي
                        </button>
                    </div>
                </div>
            </div>


            <!-- Step 3: تفاصيل الشحنة -->
            <div class="row g-3 align-items-center step-content" data-step="3">
                <h5 class="fw-bold text-center mb-4">تفاصيل الشحنة</h5>

                <div class="col-md-4">
                    <label class="form-label">محتويات الشحنة *</label>
                    <input type="text" class="form-control" placeholder="مثال: كتب، ملابس..." required />
                </div>

                <div class="col-md-4">
                    <label class="form-label">الوزن الإجمالي *</label>
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="0" required />
                        <span class="input-group-text">كـج</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">اختر التحصيل</label>
                    <select class="form-select select-change" name="collection_method" id="collection_method" required>
                        <option selected disabled>اختر التحصيل</option>
                        <option value="include">شامل مصاريف الشحن</option>
                        <option value="add">اضافة مصاريف الشحن</option>
                        <option value="only">مصاريف الشحن فقط</option>
                        <option value="none">بدون تحصيل و بدون مصاريف شحن</option>
                    </select>
                </div>

                <div id="collection_fields" class="row mt-3" style="display: none;">
                    <div class="col-md-4">
                        <label class="form-label">قيمة التحصيل *</label>
                        <input type="number" name="collection_value" class="form-control" placeholder="مثال: 100"
                            min="0" />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">شكل رسوم التحصيل</label>
                        <input type="text" name="collection_fee_type" class="form-control"
                            placeholder="مثال: رسوم ثابتة، نسبة..." />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">طريقة التحصيل</label>
                        <select name="collection_payment_method" class="form-select">
                            <option selected disabled>اختر الطريقة</option>
                            <option value="instapay">انستا باي</option>
                            <option value="wallet">محفظة إلكترونية</option>
                            <option value="bank">بنك</option>
                        </select>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="col-12 d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-outline-danger" onclick="prevStep()">
                        العودة
                    </button>
                    <button type="button" class="btn btn-danger" onclick="nextStep()">
                        التالي
                    </button>
                </div>
            </div>

        </div>لهف
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // كودك هنا
            document.getElementById("collection_method").addEventListener("change", function() {
                const selected = this.value;
                const extraFields = document.getElementById("collection_fields");

                if (selected === "include" || selected === "add") {
                    extraFields.style.display = "block";
                } else {
                    extraFields.style.display = "none";
                    // مسح القيم عند الإخفاء
                    extraFields.querySelectorAll("input, select").forEach(input => {
                        input.value = "";
                    });
                }
            });
        });
    </script>


    <script>
        let currentStep = 1;

        function updateStepUI() {
            const steps = document.querySelectorAll(".step");
            const contents = document.querySelectorAll(".step-content");

            // Show the current step content and hide the others
            contents.forEach((content) => {
                if (content.dataset.step == currentStep) {
                    // If current step is 3, use display: flex, otherwise use display: block
                    content.style.display = currentStep === 3 ? "flex" : "block";
                } else {
                    content.style.display = "none";
                }
            });

            // Update the step indicator (active/completed)
            steps.forEach((step, index) => {
                const stepNumber = index + 1;
                step.classList.toggle("active", stepNumber === currentStep);
                step.classList.toggle("completed", stepNumber < currentStep);
            });
        }

        function nextStep() {
            const totalSteps = document.querySelectorAll(".step").length;
            if (currentStep < totalSteps) {
                currentStep++;
                updateStepUI();
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateStepUI();
            }
        }

        function selectType(button) {
            // Remove active from all
            document
                .querySelectorAll(".btn-check")
                .forEach((btn) => btn.classList.remove("active"));
            // Add active to the clicked one
            button.classList.add("active");
        }

        window.addEventListener("DOMContentLoaded", () => {
            updateStepUI();
            $('.select-change').select2({
                placeholder: "اختر التحصيل",
                dir: "rtl"
            });
        });
    </script>
@endsection
