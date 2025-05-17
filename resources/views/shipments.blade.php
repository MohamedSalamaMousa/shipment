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
            background-color: #121e27;
            padding: 20px 0;
            text-align: center;
            color: #fff;
        }

        .nav-tabs {
            justify-content: center;
            border-bottom: 1px solid #34495e;
        }

        .nav-tabs .nav-link {
            color: #ccc;
            font-weight: bold;
            border: none;
            background: none;
        }

        .nav-tabs .nav-link.active {
            background-color: #1c2833;
            color: #fff !important;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border: 1px solid #34495e;
            border-bottom: none;
        }

        .shipments-container {
            padding: 20px 10px;
            background-color: #f7f9fa;
        }

        .shipment-card {
            background-color: #2c3e50;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #34495e;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #fff;
        }

        .shipment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .shipment-status {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .status,
        .amount {
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .status {
            background-color: #1abc9c;
        }

        .amount {
            background-color: #27ae60;
        }

        .shipment-info {
            font-size: 15px;
        }

        .shipment-info p {
            margin: 6px 0;
        }

        .shipment-info strong {
            font-size: 16px;
            display: block;
            margin-bottom: 5px;
        }

        @media (min-width: 768px) {
            .shipment-card {
                flex-direction: row;
            }
        }
    </style>
@endsection

@section('content')
    <section id="main-content" class="py-4">
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
