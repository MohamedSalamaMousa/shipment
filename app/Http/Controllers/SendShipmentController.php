<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SendShipmentController extends Controller
{
    //
    public function index()
    {
        return view('send_shipment');
    }

    public function create(Request $request) {}


    public function cal_pricing($sent_by, $sent_to, $shipping_weight, $collection_value, $is_collection_included, $collection)
    {
        $response = Http::withToken(session('user_token'))
            ->asMultipart()
            ->post('https://admin.tetexexpress.com/api/add_shipping_costs', [
                [
                    'name'     => 'sent_by',
                    'contents' => $sent_by
                ],
                [
                    'name'     => 'sent_to',
                    'contents' => $sent_to
                ],
                [
                    'name'     => 'shipping_weight',
                    'contents' => $shipping_weight
                ],
                [
                    'name'     => 'collection_value',
                    'contents' => $collection_value
                ],
                [
                    'name'     => 'is_collection_included',
                    'contents' => $is_collection_included ? 'true' : 'false'
                ],
                [
                    'name'     => 'collection',
                    'contents' => $collection
                ],
            ]);

        return $response->body(); // or ->json() if you want decoded response
    }
}