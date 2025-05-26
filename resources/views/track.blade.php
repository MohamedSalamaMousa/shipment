@extends('layouts.master')

@section('content')
    <div class="min-vh-100 py-5 px-3">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card p-4 shadow-lg border-0">
                    <h4 class="text-center text-primary mb-4 fw-bold">🔍 تتبع الشحنات</h4>

                    <form id="trackingForm">
                        @csrf
                        <div class="mb-3">
                            <label for="barcodeTextarea" class="form-label fw-semibold text-muted">أرقام التتبع</label>
                            <textarea class="form-control shadow-sm" name="barcodes" rows="5" placeholder="أدخل رقم التتبع (واحد في كل سطر)"
                                id="barcodeTextarea">{{ request('barcode') }}</textarea>

                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const textarea = document.getElementById('barcodeTextarea');
                                    if (textarea && textarea.value.trim() !== '') {
                                        document.getElementById('trackingForm').dispatchEvent(new Event('submit'));
                                    }
                                });
                            </script>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg fw-bold">
                                🚚 تتبع الشحنات
                            </button>
                        </div>
                    </form>

                    <div id="loadingMessage" class="text-center text-secondary my-4" style="display: none;">
                        <div class="spinner-border text-primary" role="status" style="width: 2.5rem; height: 2.5rem;">
                            <span class="visually-hidden">جارٍ التحميل...</span>
                        </div>
                        <p class="mt-3 fs-6">جاري تحميل بيانات الشحنات، يرجى الانتظار...</p>
                    </div>

                    <div id="timeline" class="mt-5"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #f4f6fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .timeline-horizontal {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 24px;
            padding: 1.5rem 1rem;
            border-top: 2px dashed #dcdcdc;
            position: relative;
            background-color: #ffffff;
            border-radius: 12px;
            margin-top: 1rem;
        }

        .timeline-horizontal::-webkit-scrollbar {
            height: 8px;
        }

        .timeline-horizontal::-webkit-scrollbar-thumb {
            background-color: #999;
            border-radius: 4px;
        }

        .timeline-step {
            flex: 0 0 auto;
            min-width: 160px;
            scroll-snap-align: start;
            text-align: center;
        }

        .step-icon {
            width: 55px;
            height: 55px;
            margin: 0 auto 10px;
            border-radius: 50%;
            font-size: 24px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .step-label {
            font-weight: bold;
            font-size: 15px;
            color: #333;
        }

        .step-details {
            font-size: 13px;
            color: #555;
            margin-top: 6px;
            text-align: start;
        }

        .active .step-icon {
            box-shadow: 0 0 0 4px rgba(255, 193, 7, 0.4);
        }

        .finished .step-icon {
            box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.4);
        }

        .yellow {
            background-color: #ffc107;
        }

        .green {
            background-color: #28a745;
        }

        .blue {
            background-color: #007bff;
        }

        .gray {
            background-color: #6c757d;
        }

        .orange {
            background-color: #fd7e14;
        }

        .timeline-title {
            font-size: 16px;
            font-weight: bold;
            color: #444;
            margin-bottom: 0.5rem;
            border-bottom: 1px solid #ddd;
            padding-bottom: 0.5rem;
            text-align: right;
        }

        @media (max-width: 768px) {
            .timeline-step {
                min-width: 140px;
            }

            .step-icon {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }

            .step-label {
                font-size: 14px;
            }

            .step-details {
                font-size: 12px;
            }
        }
    </style>

    <script>
        document.getElementById('trackingForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const barcodes = document.querySelector('textarea[name="barcodes"]').value
                .split('\n')
                .map(b => b.trim())
                .filter(Boolean);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let timelineHTML = '';

            // إظهار رسالة التحميل
            document.getElementById('loadingMessage').style.display = 'block';

            try {
                const response = await fetch("{{ route('tracking.show') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        barcodes
                    })
                });

                if (!response.ok) throw new Error(`فشل الاتصال بالخادم: ${response.statusText}`);
                const responseData = await response.json();

                if (!responseData || Object.keys(responseData).length === 0) {
                    throw new Error('البيانات المستلمة غير صحيحة أو فارغة');
                }


                for (const [barcode, resultWrapper] of Object.entries(responseData)) {
                    timelineHTML += `<div class="timeline-horizontal">`;
                    timelineHTML += `
    <div class="d-flex justify-content-center">
        <h6 class="text-secondary mt-4">الشحنة: ${barcode}</h6>
    </div>
`;
                    if (!resultWrapper || typeof resultWrapper !== 'object') {
                        timelineHTML +=
                            `<div class="timeline-step"><small class="text-danger">لا يمكن قراءة بيانات هذه الشحنة</small></div>`;
                        continue;
                    }
                    if (resultWrapper.error) {
                        timelineHTML +=
                            `<div class="timeline-step"><small class="text-danger">${resultWrapper.error}</small></div>`;
                        continue;
                    }

                    const items = resultWrapper.data?.data || [];
                    const validItems = items.filter(item => item.date);

                    if (validItems.length === 0) {
                        timelineHTML +=
                            `<div class="timeline-step"><small class="text-danger">لا توجد بيانات تتبع متاحة لهذه الشحنة</small></div>`;
                        continue;
                    }



                    validItems.forEach(item => {
                        const statusMap = {
                            1: {
                                label: "التسجيل",
                                color: "yellow",
                                icon: "📋"
                            },
                            2: {
                                label: "الشحن",
                                color: "green",
                                icon: "📦"
                            },
                            3: {
                                label: "النقل والمعالجة ",
                                color: "orange",
                                icon: "⏳"
                            },
                            4: {
                                label: "التسليم",
                                color: "blue",
                                icon: "🚚"
                            },
                            5: {
                                label: "اكتمال الطلب",
                                color: "gray",
                                icon: "✅"
                            }
                        };

                        const step = statusMap[item.status] || {
                            label: item.itemStatus || 'غير محدد',
                            color: 'gray',
                            icon: '❓'
                        };

                        const statusClass = item.isFinished ? 'finished' : item.isCurrent ? 'active' :
                            '';

                        timelineHTML += `
                            <div class="timeline-step ${statusClass}">
                                <div class="step-icon ${step.color}">${step.icon}</div>
                                <div class="step-label">${step.label}</div>
                                <div class="step-details">
                                    ${item.mainStatus || ''}<br>
                                    ${item.location ? `الموقع: ${item.location}` : ''}<br>
                                    ${item.city || ''} ${item.country || ''}<br>
                                    ${item.date || ''} ${item.time || ''}
                                </div>
                            </div>
                        `;
                    });

                    timelineHTML += `</div>`;
                }
            } catch (error) {
                console.error('Error Processing Data:', error);
                timelineHTML =
                    `<div class="timeline-step"><small class="text-danger">حدث خطأ أثناء معالجة البيانات: ${error.message}</small></div>`;
            }

            // إخفاء رسالة التحميل بعد الانتهاء
            document.getElementById('loadingMessage').style.display = 'none';

            document.getElementById('timeline').innerHTML = timelineHTML;
        });
    </script>
@endsection
