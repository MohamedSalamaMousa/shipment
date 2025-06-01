@extends('layouts.master')
@section('title', 'من نحن')

@section('content')
    <div class="py-5 bg-light text-dark">
        <div class="container">

            <h2 class="text-center fw-bold mb-4">من نحن</h2>

            <div class="text-center mb-4">
                <p class="fs-5 fw-bold">شركة تيـتكس للشحن المحلي والدولي</p>
                <p>سجل تجاري رقم: <strong>46722</strong></p>
                <p>رقم ضريبي: <strong>696950413</strong></p>
            </div>

            <div class="mb-5" style="line-height: 2;">
                <p>
                    تتعامل شركة تيتكس حكومي كامل لتوفير سبل الأمان والراحة للعملاء، وتشرف الشركة بالتعامل المشترك بينها وبين
                    البريد المصري بتعاقد رقم
                    <strong>9546</strong>
                    بآلية تعامل حكومي كامل.
                </p>
                <p>
                    تقدم شركة تيتكس كافة الخدمات الممكنة لتسهيل الدعم وشحن البضائع بمختلف أنواعها. كما تتبع شركتنا مسار
                    البضائع لضمان وصولها بالسلامة والأمان، وتقدم خدمات الشحن لتأمين ضمان البضائع ومختلف الشحنات من خلال
                    كشوفات للتسليم والاستلام.
                </p>
                <p>
                    بالإضافة إلى تقديم خدمات شحن الطرود والمستندات والوثائق وأي أوراق هامة، كل هذا وبالتأكيد نعمل على توصيل
                    الشحنة بأقل تكلفة تشعرك بمعنى الخدمة المميزة والاطمئنان.
                </p>
                <p>
                    كما أنه يوجد تتبع كامل للشحنات عن طريق موقع الشركة أو التطبيق الخاص بالشركة.
                </p>
            </div>

            <!-- شركاء النجاح -->
            <div class="text-center">
                <h3 class="fw-bold text-success mb-4">شركاء النجاح</h3>
                <div class="row justify-content-center g-4">
                    <div class="col-6 col-md-4 col-lg-3">
                        <img src="{{ asset('assets/images/egypt-post.jpg') }}" class="img-fluid rounded shadow-sm"
                            alt="البريد المصري">
                    </div>
                    {{-- <div class="col-6 col-md-4 col-lg-3">
                        <img src="{{ asset('assets/images/partner-a.png') }}" class="img-fluid rounded shadow-sm"
                            alt="شريك A&M">
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <img src="{{ asset('assets/images/partner-ngo.png') }}" class="img-fluid rounded shadow-sm"
                            alt="منظمة حقوق الإنسان">
                    </div> --}}
                </div>
            </div>

        </div>
    </div>
@endsection
