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
                    <a id="whatsappSuggestions" href="#" target="_blank" class="text-dark text-decoration-none d-block">
                        <i class="fab fa-whatsapp fa-2x text-success mb-2"></i><br>
                        تواصل معنا للشكاوى والاقتراحات
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a id="whatsappManager" href="#" target="_blank" class="text-dark text-decoration-none d-block">
                        <i class="fab fa-whatsapp fa-2x text-success mb-2"></i><br>
                        تواصل مع مدير التعاقدات
                    </a>
                </div>
            </div>


            <div class="text-center mb-5">
                <i class="fas fa-envelope fa-2x text-danger mb-2"></i>
                <p>راسلنا على: <span class="fw-bold" id="emailAddress">Tetexpress@gmail.com</span></p>
            </div>

            <div class="text-center">
                <h4 class="fw-bold mb-3">تابعنا على السوشيال ميديا</h4>
                <div class="d-flex justify-content-center gap-4">
                    <a id="instagramLink" href="#" class="text-dark fs-3"><i class="fab fa-instagram"></i></a>
                    <a id="facebookLink" href="#" class="text-dark fs-3"><i class="fab fa-facebook"></i></a>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('https://admin.tetexexpress.com/api/socailMedia')
                .then(response => response.json())
                .then(data => {
                    const social = data[0];

                    // رقم واتساب للشكاوى
                    if (social.whatsApp) {
                        const wa = social.whatsApp.replace(/\D/g, '');
                        document.getElementById('whatsappSuggestions').href = `https://wa.me/${wa}`;
                    }

                    // رقم مدير التعاقدات
                    if (social.linkedIn) {
                        const manager = social.linkedIn.replace(/\D/g, '');
                        document.getElementById('whatsappManager').href = `https://wa.me/${manager}`;
                    }

                    // البريد الإلكتروني
                    if (social.google) {
                        document.getElementById('emailAddress').innerText = social.google;
                    }

                    // روابط السوشيال ميديا
                    if (social.instagram) {
                        document.getElementById('instagramLink').href = social.instagram;
                    }
                    if (social.facebook) {
                        document.getElementById('facebookLink').href = social.facebook;
                    }

                })
                .catch(error => console.error('فشل في تحميل بيانات التواصل:', error));
        });
    </script>
@endsection
