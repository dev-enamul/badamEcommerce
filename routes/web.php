<?php

use App\Http\Controllers\Payment\FlutterwavePaymentController;
use App\Http\Controllers\Payment\PaypalPaymentController;
use App\Http\Controllers\Payment\PaystackPaymentController;
use App\Http\Controllers\Payment\PaytmPaymentController;
use App\Http\Controllers\Payment\SSLCommerzPaymentController;
use App\Http\Controllers\Payment\StripePaymentController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\AamarpayController;
use App\Http\Controllers\Payment\RazorpayPaymentController;
use App\Http\Controllers\BkashController;
use App\Http\Controllers\Payment\AamarpayController as PaymentAamarpayController;
use App\Http\Controllers\Payment\NagadController;
use App\Http\Controllers\Payment\UpayController;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/offline', 'HomeController@index')->name('offline');

Route::group(['prefix' => 'payment'], function () {

    Route::any('/{gateway}/pay', [PaymentController::class, 'payment_initialize']);

    // stripe
    Route::any('/stripe/create-session', [StripePaymentController::class, 'create_checkout_session'])->name('stripe.get_token');
    Route::get('/stripe/success', [StripePaymentController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');

    // paypal
    Route::get('/paypal/success', [PaypalPaymentController::class, 'success'])->name('paypal.success');
    Route::get('/paypal/cancel', [PaypalPaymentController::class, 'cancel'])->name('paypal.cancel');

    //sslcommerz
    Route::any('/sslcommerz/success', [SSLCommerzPaymentController::class, 'success'])->name('sslcommerz.success');
    Route::any('/sslcommerz/fail', [SSLCommerzPaymentController::class, 'fail'])->name('sslcommerz.fail');
    Route::any('/sslcommerz/cancel', [SSLCommerzPaymentController::class, 'cancel'])->name('sslcommerz.cancel');

    //paystack
    Route::any('/paystack/callback', [PaystackPaymentController::class, 'return'])->name('paystack.return');

    //paytm
    Route::any('/paytm/callback', [PaytmPaymentController::class, 'callback'])->name('paytm.callback');

    //flutterwave
    Route::any('/flutterwave/callback', [FlutterwavePaymentController::class, 'callback'])->name('flutterwave.callback');

    // razorpay
    Route::post('razorpay/payment', [RazorpayPaymentController::class, 'payment'])->name('razorpay.payment');

    // Aamarpay 
    Route::post('aamarpay/success', [PaymentAamarpayController::class, 'aamarpaySuccess'])->name('aamarpay-success');
    Route::get('nagad/callback', [NagadController::class, 'callback'])->name('nagad.callback');
    Route::post('nagad/success', [NagadController::class, 'nagadSuccess'])->name('nagad-success');
    Route::get('upay/callback', [UpayController::class, 'callback'])->name('upay.callback');
    // Route::get('upay/create-payment', [UpayController::class, 'createUpayPayment'])->name('create-upay-payment');
});

Route::any('/social-login/redirect/{provider}', [LoginController::class, 'redirectToProvider'])->name('social.login');
Route::get('/social-login/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');


Route::get('/product/{slug}', [HomeController::class, 'index'])->name('product');
Route::get('/category/{slug}', [HomeController::class, 'index'])->name('products.category');

Route::get('/blog-details/{slug}', [HomeController::class, 'index'])->name('blog.details');




//Address
Route::resource('addresses', AddressController::class);
Route::controller(AddressController::class)->group(function () {
    Route::post('/get-states', 'getStates')->name('get-state');
    Route::post('/get-cities', 'getCities')->name('get-city');
    Route::post('/addresses/update/{id}', 'update')->name('addresses.update');
    Route::get('/addresses/destroy/{id}', 'destroy')->name('addresses.destroy');
    Route::get('/addresses/set_default/{id}', 'set_default')->name('addresses.set_default');
});

// Route::get('gen-string', function () {
//     return Str::random(30);
// });
// Route::get('generate-password', function () {
//     return bcrypt('BadaMiAuth2022');
// });

Route::get('upay/create-payment', [UpayController::class, 'createUpayPayment']);

// Bkash
Route::get('bkash/callback', [BkashController::class, 'callback']);

Route::get('bkash/cancel-payment', [BkashController::class, 'bkashCancel']);
Route::get('bkash/failed-payment', [BkashController::class, 'bkashFailed']);


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('{slug}', [HomeController::class, 'index'])->where('slug', '.*');

Route::post('/bkash/checkout-url/callback', [BkashController::class, 'callback']);




// Route::get('/demo/cron_1', 'DemoController@cron_1');
// Route::get('/demo/cron_2', 'DemoController@cron_2');
