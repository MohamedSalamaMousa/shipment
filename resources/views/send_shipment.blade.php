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
            <div class="row g-3 step-content" data-step="3">
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
                    <label class="form-label">عدد القطع *</label>
                    <input type="number" class="form-control" value="1" required />
                </div>

                <!-- نوع الشحنة -->
                <div class="col-12 mt-4">
                    <label class="form-label d-block mb-2">نوع الشحنة</label>
                    <div class="d-flex justify-content-center gap-4 flex-wrap">
                        <!-- طرد -->
                        <input type="radio" name="shipmentType" class="btn-check" id="typeBox" checked />
                        <label for="typeBox" class="p-4 border rounded text-center shipment-label"
                            style="cursor: pointer; width: 120px">
                            <i class="fa-solid fa-box-open fa-2x mb-2"></i>
                            <div class="fw-bold">طرد</div>
                        </label>

                        <!-- وثائق -->
                        <input type="radio" name="shipmentType" class="btn-check" id="typeDoc" />
                        <label for="typeDoc" class="p-4 border rounded text-center shipment-label"
                            style="cursor: pointer; width: 120px">
                            <i class="fa-solid fa-file-lines fa-2x mb-2"></i>
                            <div class="fw-bold">وثائق</div>
                        </label>
                    </div>
                </div>

                <!-- تنبيه -->
                <div class="col-12 text-center mt-4">
                    <p class="text-danger small">
                        لست متأكدًا أن المواد مقبولة للشحن؟ تحقق من قائمة المواد المحظورة
                        <a href="#" class="text-danger fw-bold text-decoration-underline">هنا</a>.<br />
                        الرجاء التأكد من الوزن بعد التغليف لتجنب أي تأخير في التوصيل. قد
                        يتغير السعر في حالة وجود اختلاف في الوزن.
                    </p>
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
        </div>
    </section>
    <script>
        let currentStep = 1;

        function updateStepUI() {
            const steps = document.querySelectorAll(".step");
            const contents = document.querySelectorAll(".step-content");

            // Show the current step content and hide the others
            contents.forEach((content) => {
                content.style.display =
                    content.dataset.step == currentStep ? "block" : "none";
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
        });
    </script>
@endsection
