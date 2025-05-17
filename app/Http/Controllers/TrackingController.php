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
            $response = Http::timeout(60)->get('https://api.zenrows.com/v1/', [
                'apikey' => '215f715b11ff5ae14e6ea0362d12d5d9302adcbb',
                'url' => "https://egyptpost.gov.eg/ar-eg/TrackTrace/GetShipmentDetails?barcode={$barcode}",
                'js_render' => 'true',
            ]);

            $results[$barcode] = $response->successful()
                ? $response->json()
                : ['error' => 'Failed to fetch data'];
        }

        return response()->json($results);
    }
}