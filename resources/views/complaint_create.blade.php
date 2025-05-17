@extends('layouts.master')
@section('title', 'تقديم شكوى')
@section('content')
    <section class="py-5">
        <div class="container" style="max-width: 600px">
            <h3 class="text-center text-danger fw-bold mb-3">إرسال شكوى</h3>
            <p class="text-muted text-center mb-4">
                تواصل معنا في حالة مواجهة أي مشكلة أو استفسار.
            </p>
            <form method="POST" action="{{ route('complaint.store') }}">
                @csrf
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
                <div class="mb-3">
                    <label class="form-label">الاسم</label>
                    <input type="text" class="form-control" name='name' placeholder="أدخل الاسم الكامل" required/>
                </div>
                <div class="mb-3">
                    <label class="form-label">رقم الشحنة</label>
                    <input type="text" class="form-control" placeholder="أدخل رقم الشحنة" name='shipment_num' required />
                </div>
                <div class="mb-3">
                    <label class="form-label">نوع الشكوى</label>
                    <select class="form-select" name="complaint_type" required>
                        <option value="" disabled selected>اختر نوع الشكوى</option>
                        <option value="الاستلامات">الاستلامات</option>
                        <option value="التسليمات">التسليمات</option>
                        <option value="المالية">المالية</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">تفاصيل الشكوى</label>
                    <textarea class="form-control" rows="4" placeholder="اكتب تفاصيل الشكوى هنا..." name='complaint' required></textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-danger">إرسال الشكوى</button>
                </div>
            </form>
        </div>
    </section>

@endsection
