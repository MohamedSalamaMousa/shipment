<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComplaintController extends Controller
{
    //
    public function index()
    {
        $token = session('user_token');

        $response = Http::withToken($token)->get('https://admin.tetexexpress.com/api/web/ShowComplaints');
        $complaints = $response->json('data');
        return view('complaint_details', compact('complaints'));
    }
    public function create()
    {
        return view('complaint_create');
    }

    public function sendComplaint(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $validated = $request->validate([
            'name'            => 'required|string|max:100',
            'shipment_num'    => 'required|string|max:1000',
            'complaint_type'  => 'required|string|in:الاستلامات,التسليمات,المالية',
            'complaint'       => 'required|string|max:1000',
        ]);

        try {
            // جلب التوكن من السيشن
            $token = session('user_token');

            // إرسال الطلب إلى واجهة برمجة التطبيقات
            $response = Http::withToken($token)->post('https://admin.tetexexpress.com/api/complaint', $validated);

            // التحقق من نجاح الإرسال
            if ($response->successful()) {
                return redirect()->route('complaint.index')->with('success', 'تم إرسال الشكوى بنجاح.');
            }

            // التعامل مع أخطاء الاستجابة من API
            $message = $response->json('message') ?? 'حدث خطأ غير معروف.';
            return redirect()->back()->with('error', 'فشل إرسال الشكوى: ' . $message);
        } catch (\Exception $e) {
            // التعامل مع أي استثناء غير متوقع
            return redirect()->back()->with('error', 'حدث خطأ أثناء إرسال الشكوى: ' . $e->getMessage());
        }
    }
}