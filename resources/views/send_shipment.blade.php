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
            <form action="{{ route('send_shipment.create') }}" method="POST">
                @csrf
                <div id="formErrors" class="alert alert-danger d-none" role="alert"></div>
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
                            <select id="select-governorate" class="form-select select-governorate" name="sender_governorate"
                                required>
                                <option selected disabled>اختر المحافظة</option>
                                @php
                                    $governorates = config('governorates');
                                @endphp
                                @foreach ($governorates as $gov)
                                    <option value="{{ $gov }}">{{ $gov }}</option>
                                @endforeach
                            </select>
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
                            <select id="recipient-governorate" class="form-select recipient-governorate"
                                name="recipient_governorate" required>
                                <option selected disabled>اختر المحافظة</option>
                                @php
                                    $governorates = config('governorates');
                                @endphp
                                @foreach ($governorates as $gov)
                                    <option value="{{ $gov }}">{{ $gov }}</option>
                                @endforeach
                            </select>
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
                        <input type="text" class="form-control" placeholder="مثال: كتب، ملابس..." required
                            name='shipment_details' />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">الوزن الإجمالي *</label>
                        <div class="input-group">
                            <input type="number" class="form-control"
                                placeholder="الوزن بالجرام و اقصى وزن 30000 جرام للشحنه" min="1" max="30000"
                                required name='shipment_weight' />
                            <span class="input-group-text">جم</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">اختر التحصيل</label>
                        <select class="form-select select-change" name="collection" id="collection_method" required>
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
                            <label class="form-label"> رسوم التحصيل</label>
                            <select id="is_collection_included" name="is_collection_included" class="form-select">
                                <option selected disabled>رسوم التحصيل</option>
                                <option value="true">اضافة رسوم التحصيل علي الشحن </option>
                                <option value="false">عدم اضافة رسوم التحصيل علي الشحن </option>

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">طريقة التحصيل</label>
                            <select id="collection_payment_method" name="collection_method" class="form-select">
                                <option selected disabled>اختر الطريقة</option>
                                <option value= "انسا باي">انستا باي</option>
                                <option value="إلكترونية محفظة">محفظة إلكترونية</option>
                                <option value="بنك">بنك</option>
                            </select>
                        </div>

                        <div class="col-md-12 mt-3" id="instapay_fields" style="display: none;">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" name="collection_phone"
                                placeholder="رقم الهاتف المرتبط بإنستا باي" />
                        </div>

                        <div class="col-md-12 mt-3" id="wallet_fields" style="display: none;">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" name="collection_phone"
                                placeholder="رقم الهاتف للمحفظة الإلكترونية" />
                        </div>

                        <div class="col-md-12 mt-3" id="bank_fields" style="display: none;">
                            <label class="form-label">اسم البنك</label>
                            <input type="text" class="form-control mb-2" name="bank_name" placeholder="اسم البنك" />

                            <label class="form-label">رقم الحساب</label>
                            <input type="text" class="form-control mb-2" name="account_number"
                                placeholder="رقم الحساب" />

                            <label class="form-label">اسم المستفيد باللغة الانجليزية</label>
                            <input type="text" class="form-control" name="beneficiary_name"
                                placeholder="Full Name in English" />
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="col-12 d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-outline-danger" onclick="prevStep()">
                            العودة
                        </button>
                        <button type="sumbit" class="btn btn-danger">
                            التالي
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </section>


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

        function validateCurrentStep(step) {
            let valid = true;
            let messages = [];

            const isArabic = str => /^[\u0600-\u06FF\s]+$/.test(str);
            const isDigits = str => /^\d+$/.test(str);
            const isValidPhone = str => /^01[0-2,5]{1}[0-9]{8}$/.test(str);

            // Clear previous errors
            const errorBox = document.getElementById("formErrors");
            errorBox.classList.add("d-none");
            errorBox.innerHTML = "";

            if (step === 1) {
                const senderName = document.querySelector('[name="sender_name"]').value.trim();
                const phone = document.querySelector('[name="sender_phone"]').value.trim();
                const house = document.querySelector('[name="sender_House_number"]').value.trim();
                const floor = document.querySelector('[name="sender_floor_number"]').value.trim();
                const apt = document.querySelector('[name="sender_apartment_number"]').value.trim();

                if (!isArabic(senderName)) {
                    messages.push("❌ الاسم يجب أن يكون باللغة العربية فقط");
                    valid = false;
                }
                if (!isValidPhone(phone)) {
                    messages.push("❌ رقم الهاتف غير صحيح. يجب أن يحتوي على 11 رقم ويبدأ بـ 01");
                    valid = false;
                }
                if (!isDigits(house)) {
                    messages.push("❌ رقم المبنى يجب أن يكون أرقام فقط");
                    valid = false;
                }
                if (!isDigits(floor)) {
                    messages.push("❌ رقم الدور يجب أن يكون أرقام فقط");
                    valid = false;
                }
                if (!isDigits(apt)) {
                    messages.push("❌ رقم الشقة يجب أن يكون أرقام فقط");
                    valid = false;
                }
            }

            if (step === 2) {
                const recipientName = document.querySelector('[name="recipient_name"]').value.trim();
                const phone = document.querySelector('[name="recipient_phone"]').value.trim();
                const house = document.querySelector('[name="recipient_House_number"]').value.trim();
                const floor = document.querySelector('[name="recipient_floor_number"]').value.trim();
                const apt = document.querySelector('[name="recipient_apartment_number"]').value.trim();

                if (!isArabic(recipientName)) {
                    messages.push("❌ اسم المستلم يجب أن يكون باللغة العربية فقط");
                    valid = false;
                }
                if (!isValidPhone(phone)) {
                    messages.push("❌ رقم هاتف المستلم غير صحيح");
                    valid = false;
                }
                if (!isDigits(house)) {
                    messages.push("❌ رقم المبنى يجب أن يكون أرقام فقط");
                    valid = false;
                }
                if (!isDigits(floor)) {
                    messages.push("❌ رقم الدور يجب أن يكون أرقام فقط");
                    valid = false;
                }
                if (!isDigits(apt)) {
                    messages.push("❌ رقم الشقة يجب أن يكون أرقام فقط");
                    valid = false;
                }
            }

            if (!valid) {
                errorBox.innerHTML = messages.map(msg => `<div>${msg}</div>`).join("");
                errorBox.classList.remove("d-none");
            }

            return valid;
        }


        // Update nextStep() to include validation
        function nextStep() {
            const totalSteps = document.querySelectorAll(".step").length;
            if (currentStep < totalSteps) {
                if (validateCurrentStep(currentStep)) {
                    currentStep++;
                    updateStepUI();
                }
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

            $('#is_collection_included').select2({
                placeholder: "اختر التحصيل",
                dir: "rtl"
            })

            $('#collection_method').select2({
                placeholder: "اختر التحصيل",
                dir: "rtl"
            });

            $('#select-governorate').select2({
                placeholder: "اختر المحافظة",
                dir: "rtl"
            });

            $('#recipient-governorate').select2({
                placeholder: "اختر المحافظة",
                dir: "rtl"
            });

            $('#collection_payment_method').select2({
                placeholder: "اختر الطريقة",
                dir: "rtl"
            });

            $('#collection_payment_method').on('change', function() {
                $('#instapay_fields, #wallet_fields, #bank_fields').hide().find('input').val('');

                const value = $(this).val();
                if (value === "انسا باي") {
                    $('#instapay_fields').show();
                } else if (value === "إلكترونية محفظة") {
                    $('#wallet_fields').show();
                } else if (value === "بنك") {
                    $('#bank_fields').show();
                }
            });


            // Attach event listener to Select2's change event
            $('#collection_method').on('change', function() {
                const selected = $(this).val();
                const extraFields = document.getElementById("collection_fields");
                if (selected === "include" || selected === "add") {
                    extraFields.style.display = "flex";
                } else {
                    extraFields.style.display = "none";
                    // Clear the values when hiding
                    extraFields.querySelectorAll("input, select").forEach(input => {
                        input.value = "";
                    });
                }
            });
        });
    </script>
@endsection
