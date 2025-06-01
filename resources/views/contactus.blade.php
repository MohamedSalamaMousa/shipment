@extends('layouts.master')
@section('title', 'تواصل معنا')

@section('content')
    <div class="py-5 bg-light text-dark">
        <div class="container">
            <h2 class="text-center fw-bold mb-4">تواصل معنا</h2>

            <div class="text-center mb-4">
                <p class="fs-5 mb-1">مواعيد العمل بالشركة</p>
                <p>من السبت إلى الخميس</p>
                <p>من الساعة 9:00 صباحاً إلى 5:00 عصراً</p>
                <p class="text-muted">معاداً أيام الإجازات والعطلات الرسمية</p>
            </div>

            <div class="row justify-content-center text-center mb-5">
                <div class="col-md-6 mb-3">
                    <i class="fab fa-whatsapp fa-2x text-success mb-2"></i>
                    <p class="mb-0">تواصل معنا للشكاوى والاقتراحات</p>
                </div>
                <div class="col-md-6 mb-3">
                    <i class="fab fa-whatsapp fa-2x text-success mb-2"></i>
                    <p class="mb-0">تواصل مع مدير التعاقدات</p>
                </div>
            </div>

            <div class="text-center mb-5">
                <i class="fas fa-envelope fa-2x text-danger mb-2"></i>
                <p>راسلنا على: <span class="fw-bold">Tetexpress@gmail.com</span></p>
            </div>

            <div class="text-center">
                <h4 class="fw-bold mb-3">تابعنا على السوشيال ميديا</h4>
                <div class="d-flex justify-content-center gap-4">
                    <a href="#" class="text-dark fs-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-dark fs-3"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-dark fs-3"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
