<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShipmentsController extends Controller
{
    //
    public function getShipments(Request $request)
    {
        try {
            $token = session('user_token');

            $currentResponse = Http::withToken($token)->get('https://admin.tetexexpress.com/api/web/current_shipments');
            $pastResponse = Http::withToken($token)->get('https://admin.tetexexpress.com/api/web/previous_shipments');

            if ($currentResponse->successful() && $pastResponse->successful()) {
                $Currentshipments = $currentResponse['data'] ?? [];
                $Pastshipments = $pastResponse['data'] ?? [];

                return view('shipments', compact('Currentshipments', 'Pastshipments'));
            }

            return response()->json(['error' => 'فشل في تحميل بيانات الشحنات.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'استثناء: ' . $e->getMessage()], 500);
        }
    }
    public function getShipmentDetails($id)
    {
        try {
            $token = session('user_token');

            $response = Http::withToken($token)->get("https://admin.tetexexpress.com/api/shipment_details/{$id}");

            if ($response->successful()) {
                $shipment = $response['data'] ?? null;

                if (!$shipment) {
                    return abort(404, 'الشحنة غير موجودة.');
                }

                return view('shipment_details', compact('shipment'));
            }


            return response()->json(['error' => 'فشل في جلب تفاصيل الشحنة.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'استثناء: ' . $e->getMessage()], 500);
        }
    }
    public function cancelShipment($id)
    {
        try {
            $token = session('user_token');

            $response = Http::withToken($token)
                ->post("https://admin.tetexexpress.com/api/cancelled_shipment_status/{$id}");

            if ($response->successful()) {
                return redirect()->back()->with('success', 'تم إرسال طلب الإلغاء بنجاح.');
            } else {
                return redirect()->back()->with('error', 'فشل في إرسال طلب الإلغاء.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء معالجة الطلب: ' . $e->getMessage());
        }
    }
    public function finishShipment($id)
    {
        try {
            $token = session('user_token');

            $response = Http::withToken($token)
                ->post("https://admin.tetexexpress.com/api/change_status/{$id}");

            if ($response->successful()) {
                return redirect()->back()->with('success', 'تم إنهاء الشحنة بنجاح.');
            } else {
                return redirect()->back()->with('error', 'فشل في إنهاء الشحنة.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تنفيذ العملية: ' . $e->getMessage());
        }
    }
}