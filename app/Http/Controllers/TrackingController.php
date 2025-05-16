<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class TrackingController extends Controller
{
    public function showForm()
    {
        return view('track');
    }

    public function track(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $barcode = $request->input('barcode');
        $scriptPath = base_path('resources/js/trackShipment.js');

        $command = ['C:\Program Files\nodejs\node.exe', $scriptPath, $barcode];
       ;
        $process = new Process($command);
        dd( $process);
        $process->setTimeout(60);

        try {

           $process->mustRun();

            $output = $process->getOutput();
            $data = json_decode($output, true);

            return redirect()->route('track.form')->with('trackingData', $data['trackingData'] ?? 'No tracking info found');
        } catch (ProcessFailedException $exception) {
            $errorOutput = $process->getErrorOutput();
            Log::error('Shipment tracking failed', [
                'barcode' => $barcode,
                'error' => $errorOutput,
                'exitCode' => $process->getExitCode(),
            ]);
            $error = json_decode($errorOutput, true)['error'] ?? 'Failed to track shipment';
            return redirect()->route('track.form')->with('error', $error);
        }
    }
}