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

    public function create(Request $request)
    {
        $validated = $request->validate([
            'sender_governorate' => 'required|string',
            'recipient_governorate' => 'required|string',
            'shipment_weight' => 'required|numeric',
            'collection_value' => 'nullable|numeric',
            'is_collection_included' => 'nullable',
            'collection' => 'required|string',
            'shipment_details' => 'required|string',
            'collection_method' => 'nullable|string',
            'recipient_apartment_number' => 'required|string',
            'recipient_floor_number' => 'required|string',
            'recipient_House_number' => 'required|string',
            'sender_House_number' => 'required|string',
            'sender_floor_number' => 'required|string',
            'sender_apartment_number' => 'required|string',
            'sender_name' => 'required|string',
            'sender_phone' => 'required|string',
            'sender_address' => 'required|string',
            'recipient_name' => 'required|string',
            'recipient_phone' => 'required|string',
            'recipient_address' => 'required|string',
            'additional_phone_sender' => 'nullable|string',
            'additional_phone_recipient' => 'nullable|string',
        ]);

        $validated['is_collection_included'] = filter_var(
            $request->input('is_collection_included', false),
            FILTER_VALIDATE_BOOLEAN
        );

        $validated['collection_value'] = $validated['collection_value'] ?? 0;
        $validated['collection_method'] = $validated['collection_method'] ?? 0;
        $collectionMap = [
            'add' => 'اضافة مصاريف الشحن',
            'include' => 'شامل مصاريف الشحن',
            'only' => 'مصاريف الشحن فقط',
            'none' => 'بدون تحصيل و بدون مصاريف شحن',
        ];


        if (isset($collectionMap[$validated['collection']])) {
            $validated['collection'] = $collectionMap[$validated['collection']];
        }
        $response = $this->cal_pricing(
            $validated['sender_governorate'],
            $validated['recipient_governorate'],
            $validated['shipment_weight'], // تم تصحيح الاسم هنا
            $validated['collection_value'],
            $validated['is_collection_included'],
            $validated['collection']
        );
        $responseArray = json_decode($response, true);
        // Now access:

        $finalData = array_merge($validated, [
            'shipping_value' => $responseArray['data']['total_shipping_price'],
            'user_collection_value' => $responseArray['data']['total'],
        ]);


        $response = Http::withToken(session('user_token'))
            ->asMultipart()
            ->post('https://admin.tetexexpress.com/api/shipment', $finalData);

        if ($response->json() == null) {

            return redirect()->back()->with('error', 'فشل في إرسال الشحنة.');
        }

        return redirect()->route('home')->with('success_send_shipment', 'تم ارسال الشحنة بنجاح');
    }


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