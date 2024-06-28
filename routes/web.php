<?php

use App\CmiClass\CustomCmiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
});

Route::post('/cmi_pyement', function (Request $request) {
    $base_url = env('APP_URL');
    $client = new CustomCmiClient([
        // 'storekey' => '', // STOREKEY
        // 'clientid' => '', // CLIENTID
        'oid' => $request->facture, // COMMAND ID IT MUST BE UNIQUE
        'shopurl' => $base_url, // SHOP URL FOR REDIRECTION
        'okUrl' => $base_url . '/okFail', // REDIRECTION AFTER SUCCEFFUL PAYMENT
        'failUrl' => $base_url . '/fail', // REDIRECTION AFTER FAILED PAYMENT
        'email' => 'elmliki.hicham@gmail.com', // YOUR EMAIL APPEAR IN CMI PLATEFORM
        'BillToName' => 'el mliki hicham', // YOUR NAME APPEAR IN CMI PLATEFORM
        'BillToCompany' => 'devti tecknologie', // YOUR COMPANY NAME APPEAR IN CMI PLATEFORM
        'BillToStreet12' => 'technopark tanger N°105', // YOUR ADDRESS APPEAR IN CMI PLATEFORM NOT REQUIRED
        'BillToCity' => 'tanger', // YOUR CITY APPEAR IN CMI PLATEFORM NOT REQUIRED
        'BillToStateProv' => 'tanger-tetouan/', // YOUR STATE APPEAR IN CMI PLATEFORM NOT REQUIRED
        'BillToPostalCode' => '91000', // YOUR POSTAL CODE APPEAR IN CMI PLATEFORM NOT REQUIRED
        'BillToCountry' => '504', // YOUR COUNTRY APPEAR IN CMI PLATEFORM NOT REQUIRED (504=MA)
        'tel' => '0604514325', // YOUR PHONE APPEAR IN CMI PLATEFORM NOT REQUIRED
        'amount' => $request->amount, // RETRIEVE AMOUNT WITH METHOD POST
        'CallbackURL' => "http://127.0.0.1:8100/api/callback", // CALLBACK
    ]);
    $encodeUrl = json_encode(['redirect_url' => $client->redirect_post()]);
    // $client->redirect_post();
    return response()->json([
        'status' => true,
        'link' => $encodeUrl
    ]);
})->name('cmi_pyement');

Route::post('/fail', function (Request $request) {
    return response()->json([
        'status' => 'failed',
        'message' => 'payment failed',
    ]);
});

Route::get('/okFail', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'message' => 'payment success',
    ]);
});
