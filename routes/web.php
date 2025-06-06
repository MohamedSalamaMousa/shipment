<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalShipmentController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\SendShipmentController;
use App\Http\Controllers\ShipmentsController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/terms&conditions', function () {
    return view('terms_conditions');
})->name('terms');

Route::get('/contact', function () {
    return view('contactus');
})->name('contact');

Route::get('/about', function () {
    return view('about-us');
})->name('about');

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::get('/register',  'view')->name('register.view');
    Route::post('/register-external',  'register')->name('external.register');
    Route::post('/login',  'performLogin')->name('login.perform');
    Route::post('/logout', 'logout')->name('logout')->middleware('check.token');
});

Route::prefix('calculate_shipment')->controller(CalShipmentController::class)->group(function () {
    Route::get('/',  'index')->name('calculate.shipment');
    Route::post('/calculate-local-shipping',  'local_shipment')->name('local_shipment');
    Route::post('/global_shipment',  'global_shipment')->name('global_shipment');
    // routes/web.php

});

Route::prefix('send/shipment')->controller(SendShipmentController::class)->group(
    function () {
        Route::get('/',  'index')->name('send_shipment.index')->middleware('check.token');
        Route::post('/create',  'create')->name('send_shipment.create')->middleware('check.token');
    }

);

Route::prefix('shipments')->controller(ShipmentsController::class)->group(
    function () {
        Route::get('/current',  'getShipments')->name('shipments.current')->middleware('check.token');

        Route::get('/details/{id}',  'getShipmentDetails')->name('shipments.details')->middleware('check.token');
        Route::post('/cancel/{id}', 'cancelShipment')->name('shipment.cancel')->middleware('check.token');
        Route::post('/finish/{id}',  'finishShipment')->name('shipment.finish')->middleware('check.token');
    }
);
Route::prefix('complaint')->controller(ComplaintController::class)->group(
    function () {
        Route::get('/',  'index')->name('complaint.index')->middleware('check.token');
        Route::get('/create',  'create')->name('complaint.create')->middleware('check.token');
        Route::post('/send',  'sendComplaint')->name('complaint.store')->middleware('check.token');
    }
);
Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/tracking/show', [TrackingController::class, 'tracking'])->name('tracking.show');
