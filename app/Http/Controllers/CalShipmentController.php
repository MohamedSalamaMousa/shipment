<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class CalShipmentController extends Controller
{
    //
    public function index()
    {

        return view('cal_shipment');
    }


    public function track(Request $request)
    {
        $request->validate([
            'barcodes' => 'required|string',
        ]);

        $barcodes = preg_split('/\r\n|\r|\n/', $request->input('barcodes'));
        $barcodes = array_filter(array_map('trim', $barcodes));

        $results = [];

        foreach ($barcodes as $barcode) {
            // استدعاء API من السيرفر
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get("https://egyptpost.gov.eg/ar-eg/TrackTrace/GetShipmentDetails", [
                'barcode' => $barcode
            ]);

            if ($response->successful()) {
                $results[$barcode] = $response->json();
            } else {
                $results[$barcode] = ['error' => 'Failed to fetch data'];
            }
        }

        return response()->json($results);
    }


    public function local_shipment(Request $request)
    {
        $validated = $request->validate([
            'from_governorate' => 'required|string',
            'to_governorate' => 'required|string',
            'weight' => 'required|numeric|min:0',
        ]);

        try {
            $response = Http::post('https://admin.tetexexpress.com/api/cal_price', [
                'sent_by' => $validated['from_governorate'],
                'sent_to' => $validated['to_governorate'],
                'shipping_weight' => $validated['weight'],
            ]);

            if ($response->successful() && $response->json('success')) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json('data'),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'تعذر جلب بيانات السعر، الرجاء المحاولة مرة أخرى.',
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حساب السعر. تأكد من صحة البيانات.',
            ], 500);
        }
    }
    public function global_shipment(Request $request)
    {
        $validated = $request->validate([
            'country' => 'required|string',
            'shipping_weight' => 'required|numeric|min:0',
        ]);

        try {
            // API request to get global price
            $response = Http::post('https://admin.tetexexpress.com/api/cal_globle_price', [
                'country' => $validated['country'],
                'shipping_weight' => $validated['shipping_weight'],
            ]);

            if ($response->successful() && $response->json('success')) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json('data'),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'تعذر جلب بيانات السعر الدولي، الرجاء المحاولة مرة أخرى.',
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حساب السعر الدولي. تأكد من صحة البيانات.',
            ], 500);
        }
    }
}
