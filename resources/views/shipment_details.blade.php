@extends('layouts.master')
@section('title', 'تفاصيل الشحنة')
@section('styles')
    <style>
        body {
            background-color: #f5f7fa;
            font-family: "Tajawal", sans-serif;
        }

        .shipment-container {
            max-width: 700px;
            margin: 3rem auto;
            padding: 0 15px;
        }

        .section-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .section-card:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .section-card .card-header {
            padding: 18px 25px;
            font-weight: 700;
            font-size: 18px;
            color: #34495e;
            border-bottom: 1px solid #e1e8ed;
            background-color: #fefefe;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-card .card-body {
            padding: 20px 25px;
            color: #2c3e50;
            font-size: 15.5px;
            line-height: 1.5;
        }

        .section-card .card-body p {
            margin-bottom: 12px;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 18px;
            border-radius: 30px;
            font-size: 15px;
            font-weight: 700;
            background-color: #d1f2eb;
            color: #16a085;
            box-shadow: 0 2px 6px rgb(22 160 133 / 0.3);
            user-select: none;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
        }

        .action-buttons form,
        .action-buttons button {
            flex-shrink: 0;
        }

        .action-buttons .btn {
            border-radius: 30px;
            padding: 12px 30px;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.08);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-buttons .btn:hover {
            box-shadow: 0 6px 18px rgb(0 0 0 / 0.12);
        }

        .btn-secondary {
            background-color: #34495e;
            color: #ecf0f1;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #2c3e50;
        }

        .btn-warning {
            background-color: #f39c12;
            color: #2c3e50;
            border: none;
        }

        .btn-warning:hover {
            background-color: #d68910;
            color: #1c2833;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: #fff;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .section-title {
            text-align: center;
            margin-bottom: 35px;
            color: #2c3e50;
            font-weight: 700;
            font-size: 28px;
        }

        /* Alert styling for better visibility */
        .alert {
            max-width: 700px;
            margin: 0 auto 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
            padding: 15px 20px;
        }

        .btn-close {
            position: relative;
            top: -2px;
            right: -10px;
        }
    </style>
@endsection


@section('content')
    <section class="shipment-container my-5 px-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h2 class="section-title">
            <i class="fa-solid fa-box text-success"></i> تفاصيل الشحنة
        </h2>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <form action="{{ route('shipment.finish', $shipment['id']) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary rounded-pill px-4">
                    <i class="fa-solid fa-check-circle"></i> إنهاء الشحنة
                </button>
            </form>

            <a class="btn btn-warning text-dark" href="{{ route('complaint.create') }}"><i
                    class="fa-solid fa-exclamation-circle"></i> إرسال شكوى</a>
            <form action="{{ route('shipment.cancel', $shipment['id']) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger rounded-pill px-4">
                    <i class="fa-solid fa-times-circle"></i> طلب إلغاء الشحنة
                </button>
            </form>
        </div>

        <!-- Shipment Info -->
        <div class="section-card">
            <div class="card-header bg-light">
                <i class="fa-solid fa-truck-fast text-success"></i> بيانات الشحنة
            </div>
            <div class="card-body">
                <p><strong>رقم التتبع:</strong> <span class="badge bg-success">{{ $shipment['tracking_number'] }}</span></p>
                <p><strong>ميعاد الاستلام:</strong> {{ $shipment['receipt_time'] }}</p>
                <p><strong>ميعاد التسليم:</strong> {{ $shipment['delivery_time'] }}</p>
                <p>
                    <strong>الحالة:</strong>
                    @php
                        $statusAr = [
                            'confirmed' => 'تم التأكيد',
                            'pending' => 'قيد الانتظار',
                            'cancelled' => 'تم الإلغاء',
                            'delivered' => 'تم التوصيل',
                            'request_cancelled' => 'تم إلغاء الطلب',
                        ];
                    @endphp
                    <span class="status-badge status-confirmed">
                        {{ $statusAr[$shipment['shipment_status']] ?? $shipment['shipment_status'] }} </span>
                </p>
            </div>
        </div>

        <!-- Sender Info -->
        <div class="section-card">
            <div class="card-header bg-light">
                <i class="fa-solid fa-user text-info"></i> بيانات الراسل
            </div>
            <div class="card-body">
                <p><strong>الاسم:</strong> {{ $shipment['sender_name'] }}</p>
                <p><strong>الهاتف:</strong> {{ $shipment['sender_phone'] }}</p>
                <p><strong>المحافظة:</strong> {{ $shipment['sender_governorate'] }}</p>
                <p>
                    <strong>العنوان:</strong>
                    {{ $shipment['sender_address'] }}،
                    بيت رقم {{ $shipment['sender_House_number'] }}،
                    الدور {{ $shipment['sender_floor_number'] }}،
                    الشقة {{ $shipment['sender_apartment_number'] }}
                </p>

            </div>
        </div>

        <!-- Recipient Info -->
        <div class="section-card">
            <div class="card-header bg-light">
                <i class="fa-solid fa-user-check text-primary"></i> بيانات المرسل إليه
            </div>
            <div class="card-body">
                <p><strong>الاسم:</strong> {{ $shipment['recipient_name'] }}</p>
                <p><strong>الهاتف:</strong> {{ $shipment['recipient_phone'] }}</p>
                <p><strong>المحافظة:</strong> {{ $shipment['recipient_governorate'] }}</p>
                <p>
                    <strong>العنوان:</strong>
                    {{ $shipment['recipient_address'] }}،
                    بيت رقم {{ $shipment['recipient_House_number'] }}،
                    الدور {{ $shipment['recipient_floor_number'] }}،
                    الشقة {{ $shipment['recipient_apartment_number'] }}
                </p>

            </div>
        </div>
    </section>
    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500);
            }
        }, 4000); // 4 ثواني
    </script>
@endsection
