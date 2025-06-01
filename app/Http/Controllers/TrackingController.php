<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class TrackingController extends Controller
{

    public function index()
    {

        return view('track');
    }
    public function tracking(Request $request)
    {
        // Accept barcodes from request, fallback to default if none provided
        // $barcodes = $request->input('barcodes', [
        //     'ENO30052041EG', // Example default barcode
        //     'ENO30093775EG',
        //     'ENO30093680EG',
        // ]);
         $barcodes = $request->input('barcodes');

        if (empty($barcodes) || !is_array($barcodes)) {
            return response()->json(['error' => 'لم يتم تقديم أي أكواد بريدية'], 400);
        }
        $results = [];

        foreach ($barcodes as $barcode) {
            $response = Http::timeout(60)->get("http://16.170.230.179:3000/track", [
                'barcode' => $barcode,
            ]);


            if ($response->successful()) {
                $html = $response->body();

                // استخرج الـ JSON من داخل الوسم <pre>
                $json = strip_tags($html);

                // حوّله إلى Array
                $decoded = json_decode($json, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    $results[$barcode] = $decoded;
                } else {
                    $results[$barcode] = ['error' => 'خطأ في تحليل بيانات JSON'];
                }
            } else {
                $results[$barcode] = ['error' => 'فشل في جلب البيانات من الخادم'];
            }
        }

        return response()->json($results);
    }
}