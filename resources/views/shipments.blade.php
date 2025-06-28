@extends('layouts.master')
@section('title', 'شحناتي')
@section('styles')
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #fff;
            padding: 20px 0;
            text-align: center;
            color: #dc3545;
            font-weight: bold;
            border-bottom: 1px solid #eee;
        }

        .nav-tabs {
            justify-content: center;
            border-bottom: 1px solid #ccc;
        }

        .nav-tabs .nav-link {
            color: #555;
            font-weight: bold;
            border: none;
            background: none;
        }

        .nav-tabs .nav-link.active {
            background-color: #dc3545;
            color: #fff !important;
            border-radius: 10px;
            padding: 8px 20px;
        }

        .shipments-container {
            padding: 20px 10px;
            background-color: #f8f9fa;
        }

        .shipment-card {
            background-color: #fff;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #eee;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #333;
        }

        .shipment-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.15);
        }

        .shipment-status {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .status,
        .amount {
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
            color: white;
        }

        .status {
            background-color: #dc3545;
        }

        .amount {
            background-color: #6c757d;
        }

        .shipment-info {
            font-size: 15px;
        }

        .shipment-info p {
            margin: 6px 0;
            color: #555;
        }

        .shipment-info strong {
            font-size: 16px;
            display: block;
            margin-bottom: 5px;
            color: #000;
        }


        @media (min-width: 768px) {
            .shipment-card {
                flex-direction: row;
            }
        }
    </style>
@endsection

@section('content')
    <section id="main-content" class="py-4 min-vh-100">
        <div class="container">
            <div class="header mb-3">
                <h2>شحناتي</h2>
            </div>

            <ul class="nav nav-tabs mb-4" id="shipmentTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="new-tab" data-bs-toggle="tab" data-bs-target="#new-shipments"
                        type="button" role="tab" aria-controls="new-shipments" aria-selected="true">
                        الشحنات الجديدة
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past-shipments"
                        type="button" role="tab" aria-controls="past-shipments" aria-selected="false">
                        الشحنات السابقة
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="shipmentTabsContent">
                <!-- New Shipments -->
                <div class="tab-pane fade show active" id="new-shipments" role="tabpanel" aria-labelledby="new-tab">
                    <div class="shipments-container">
                        @forelse ($Currentshipments as $shipment)
                            <a href="{{ route('shipments.details', $shipment['id']) }}" style="text-decoration: none;">
                                <div class="shipment-card">
                                    <div class="shipment-status">
                                        @php
                                            $statusAr = [
                                                'confirmed' => 'تم التأكيد',
                                                'pending' => 'قيد الانتظار',
                                                'cancelled' => 'تم الإلغاء',
                                                'delivered' => 'تم التوصيل',
                                                'request_cancelled' => 'تم إلغاء الطلب',
                                            ];
                                        @endphp

                                        <span class="status">
                                            {{ $statusAr[$shipment['shipment_status']] ?? $shipment['shipment_status'] }}</span>
                                        <span class="amount">{{ $shipment['collection_value'] }}</span>
                                    </div>
                                    <div class="shipment-info mt-2">
                                        <strong>{{ $shipment['tracking_number'] }}</strong>
                                        <p>{{ $shipment['recipient_address'] }}</p>
                                        <p>{{ $shipment['recipient_governorate'] }} | {{ $shipment['recipient_phone'] }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-muted text-center">لا توجد شحنات جديدة حالياً</p>
                        @endforelse
                    </div>
                </div>

                <!-- Past Shipments -->
                <div class="tab-pane fade" id="past-shipments" role="tabpanel" aria-labelledby="past-tab">
                    <div class="shipments-container">
                        @forelse ($Pastshipments as $shipment)
                            <a href="{{ route('shipments.details', $shipment['id']) }}" style="text-decoration: none;">
                                <div class="shipment-card">
                                    <div class="shipment-status">
                                        <span class="status">
                                            {{ $statusAr[$shipment['shipment_status']] ?? $shipment['shipment_status'] }}</span>
                                        <span class="amount">{{ $shipment['collection_value'] }}</span>
                                    </div>
                                    <div class="shipment-info mt-2">
                                        <strong>{{ $shipment['tracking_number'] }}</strong>
                                        <p>{{ $shipment['recipient_address'] }}</p>
                                        <p>{{ $shipment['recipient_governorate'] }} | {{ $shipment['recipient_phone'] }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-muted text-center">لا توجد شحنات سابقة حالياً</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
