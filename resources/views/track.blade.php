@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card p-4 shadow-sm">
                    <h4 class="text-center text-primary mb-4">تتبع الشحنات</h4>

                    <form id="trackingForm">
                        @csrf
                        <div class="mb-3">


                            <textarea class="form-control" name="barcodes" rows="5" placeholder="أدخل الأكواد البريدية (واحدة لكل سطر)"
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
                            <button type="submit" class="btn btn-success">تتبع</button>
                        </div>
                    </form>

                    <!-- رسالة الانتظار -->
                    <div id="loadingMessage" class="text-center text-secondary my-3" style="display: none;">
                        <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;">
                            <span class="visually-hidden">جارٍ التحميل...</span>
                        </div>
                        <div class="mt-2">جاري تحميل بيانات الشحنات، يرجى الانتظار...</div>
                    </div>

                    <div id="timeline" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .timeline-horizontal {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            overflow-x: auto;
            position: relative;
            padding: 2rem 0;
            border-top: 2px solid #dee2e6;
            margin-top: 10px;
        }

        .timeline-step {
            text-align: center;
            position: relative;
            flex: 1;
            min-width: 140px;
            padding: 0 10px;
        }

        .step-icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 10px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            color: white;
        }

        .step-label {
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        .step-details {
            font-size: 12px;
            color: #555;
            margin-top: 5px;
        }

        .active .step-icon {
            box-shadow: 0 0 0 4px rgba(255, 193, 7, 0.3);
        }

        .finished .step-icon {
            box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.3);
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
                    timelineHTML += `<h6 class="text-secondary mt-4">الشحنة: ${barcode}</h6>`;

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

                    timelineHTML += `<div class="timeline-horizontal">`;

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
                                    ${item.date || ''} ${item.time || ''}<br>
                                    ${item.location ? `الموقع: ${item.location}` : ''}<br>
                                    ${item.city || ''} ${item.country || ''}<br>
                                    ${item.mainStatus || ''}
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
