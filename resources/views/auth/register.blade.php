@extends('layouts.master')
@section('title', 'انشاء حساب جديد')
@section('styles')
    <style>
        .form-card {
            max-width: 900px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .nav-tabs .nav-link.active {
            background-color: #d32f2f;
            color: #fff !important;
        }
    </style>
@endsection
@section('content')
    <section id="register" class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="form-card">
                <!-- Header -->
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <ul class="alert alert-danger list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <div class="text-center mb-4">
                    <h4 class="fw-bold text-muted">
                        <i class="fa-solid fa-user-plus text-danger"></i>
                        تسجيل حساب جديد
                    </h4>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs justify-content-center mb-4" id="accountTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal"
                            type="button" role="tab" aria-selected="true">
                            <i class="fa-solid fa-user"></i> شخصي
                        </button>
                    </li>

                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="accountTabContent">
                    <!-- شخصي -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                        <form method="POST" action="{{ route('external.register') }}">
                            @csrf
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">الاسم *</label>
                                    <input type="text" class="form-control" required name="name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">رقم الجوال *</label>
                                    <input type="text" class="form-control" name="phone" placeholder="0100 123 4567"
                                        required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-danger">البريد الإلكتروني *</label>
                                    <input type="email" class="form-control" name="email" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-danger">كلمة المرور *</label>
                                    <input type="password" class="form-control" name="password" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-danger">تأكيد كلمة المرور *</label>
                                    <input type="password" class="form-control" name="password_confirmation" required />
                                </div>
                            </div>



                            <div class="text-end">
                                <button type="submit" class="btn btn-danger px-5">
                                    إرسال
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- شركات -->

                </div>
            </div>
        </div>
    </section>
@endsection
