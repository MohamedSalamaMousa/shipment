@extends('layouts.master')
@section('title', 'الشكاوي')
@section('content')
    <section class="py-5 bg-light min-vh-100">
        <div class="container">
            <h3 class="text-center text-danger mb-4">الشكاوى</h3>

            <!-- Complaint Card -->
            @forelse  ($complaints as $complaint)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small">{{ $complaint['complaint_type'] }}</span>

                            @php
                                switch ($complaint['status']) {
                                    case '1':
                                        $statusText = 'تم إغلاق الشكوى';
                                        $statusClass = 'bg-success';
                                        break;
                                    case '2':
                                        $statusText = 'تم رفض الشكوى';
                                        $statusClass = 'bg-danger';
                                        break;
                                    default:
                                        $statusText = 'تحت المراجعة';
                                        $statusClass = 'bg-warning text-dark';
                                        break;
                                }
                            @endphp

                            <span class="badge {{ $statusClass }} px-3 py-2">{{ $statusText }}</span>



                        </div>

                        <h5 class="fw-bold text-dark">{{ $complaint['complaint'] }}</h5>

                        <div class="d-flex justify-content-between text-muted small mt-2">
                            <div>رقم الشكوى: <strong>{{ $complaint['id'] }}</strong></div>
                            <div>رقم الشحنة: <strong>{{ $complaint['shipment_num'] }}</strong></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="d-flex flex-column justify-content-center align-items-center text-center my-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/5953/5953767.png" alt="No Complaints"
                        style="width: 120px" class="mb-4" />
                    <h4 class="text-muted">لا يوجد شكاوى</h4>
                </div>
            @endforelse



            <!-- Submit New Complaint -->
            <div class="text-center mt-4">
                <a href="{{ route('complaint.create') }}" class="btn btn-outline-danger px-5">
                    <i class="fa-solid fa-comment-dots ms-2"></i> إرسال شكوى
                </a>
            </div>
        </div>
    </section>
@endsection
