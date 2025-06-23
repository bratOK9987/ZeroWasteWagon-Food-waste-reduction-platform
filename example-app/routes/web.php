<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\FoodOfferController;
use App\Http\Controllers\GoogleTranslateController;
use App\Http\Controllers\Auth\PartnerAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\SetLocale;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\UserController;




Route::get('locale/{locale}', [GoogleTranslateController::class, 'changeLocale']) -> name('locale'); 
Route::middleware([SetLocale::class]) -> group(function () {
// Route for landing page
Route::get('/', function () {
    return view('landing');
});


// Routes for User registration

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/user/login', [LoginController::class, 'create'])->name('login');

Route::post('/user/login', [LoginController::class, 'store']);


// Route::view('/user/dashboard', 'user_dashboard')->middleware('auth')->name('dashboard');
Route::middleware(['auth:web'])->group(function () {
    Route::get('/user/dashboard', [LoginController::class, 'finish'])->name('dashboard');
});
// Route::get('/user/dashboard', [LoginController::class, 'finish'])->name('dashboard');



Route::middleware(['auth:web'])->group(function () {
    Route::get('/user/list_of_offers', [FoodOfferController::class, 'allData'])->name('offers.list');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('/user/list_of_venues', [FoodOfferController::class, 'venuesList'])->name('venues.list');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('/user/smth', [FoodOfferController::class, 'getFoodOffersByPartner'])->name('smth');
});


Route::get('/partner-registration-step1', function() {
    return view('step1-partner-registration'); 
})->name('partner.registration.step1');

// POST routes for handling form submissions at each step, now with names added
Route::post('/partner-registration-step1', [PartnerController::class, 'validateInvitation'])->name('partner.registration.step1.post');
Route::get('/partner-registration-step2', [PartnerController::class, 'showStep2Form'])->name('partner.registration.step2');
Route::post('/partner-registration-step2', [PartnerController::class, 'registerStep2'])->name('partner.registration.step2.post');
Route::get('/partner-registration-step3', [PartnerController::class, 'showStep3Form'])->name('partner.registration.step3');
Route::post('/partner-registration-step3', [PartnerController::class, 'registerStep3'])->name('partner.registration.step3.post');





// Partner login form route
Route::get('/partner/login', [PartnerAuthController::class, 'showLoginForm'])->name('partner.login.form');
// Partner authenticate route
Route::post('/partner/login', [PartnerAuthController::class, 'login'])->name('partner.login');
//Partner doasboard route
Route::middleware(['auth:partner'])->group(function () {
    Route::get('/partner/dashboard', function () {
        return view('partner_dashboard'); 
    })->name('partner.dashboard');
});
// Partner offer creation and authentication route
Route::middleware(['auth:partner'])->group(function () {
    Route::get('/partner/offer/create', [FoodOfferController::class, 'create'])->name('offers.create');
    Route::post('/partner/offer/store', [FoodOfferController::class, 'store'])->name('offers.store');
// Routes for managing offers
Route::get('/partner/offers', [FoodOfferController::class, 'index'])->name('offers.index');
Route::get('/partner/offers/{offer}/edit', [FoodOfferController::class, 'edit'])->name('offers.edit');
Route::put('/partner/offers/{offer}', [FoodOfferController::class, 'update'])->name('offers.update');
Route::delete('/partner/offers/{offer}', [FoodOfferController::class, 'destroy'])->name('offers.destroy');

});

// Route::name('user.')->group(function(){

// });

Route::middleware(['auth:web'])->group(function () {
    Route::get('/user/dashboard', [FoodOfferController::class, 'dashboard'])->name('dashboard');
});

//this it the add to cart route


Route::post('/user/add-to-cart', [CartController::class, 'addToCart'])->middleware('auth');
//Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show')->middleware('auth');


Route::post('/create-intent', [PaymentController::class, 'createIntent'])->name('create.intent');
Route::post('/confirm-payment', [PaymentController::class, 'confirmPayment'])->name('confirm.payment');
Route::post('/handle-payment', [PaymentController::class, 'handlePayment'])->name('handle.payment');


Route::get('/payment/checkout', [PaymentController::class, 'createCheckoutSession'])->name('payment.checkout');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/create-checkout-session', [PaymentController::class, 'createCheckoutSession'])->name('payment.create-checkout-session');




Route::get('/partner/orders', [PartnerController::class, 'viewOrders'])->name('partner.orders')->middleware('auth:partner');





Route::get('/offers/latest', [FoodOfferController::class, 'getLatestOffers'])->name('offers.latest');

Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart']);

Route::get('/user/order-history', [UserOrderController::class, 'index'])->name('user.order-history')->middleware('auth');
//routes for user account info
Route::middleware(['auth:web'])->group(function () {
Route::get('/user/account', [UserController::class, 'account'])->name('user.account');
Route::post('/user/account/update-password', [UserController::class, 'updatePassword'])->name('user.update-password');
});

//routes for partner account info
Route::middleware(['auth:partner'])->group(function () {
    Route::get('/partner/account', [PartnerController::class, 'account'])->name('partner.account');
    Route::post('/partner/account/update-password', [PartnerController::class, 'updatePassword'])->name('partner.update-password');
    Route::post('/partner/account/update-info', [PartnerController::class, 'updateAccountInfo'])->name('partner.update-account-info');
});


Route::middleware(['auth:partner'])->group(function () {
    Route::get('/partner/account', [PartnerController::class, 'account'])->name('partner.account');
    Route::post('/partner/account/update-pickup-times', [PartnerController::class, 'updatePickupTimes'])->name('partner.update-pickup-times');
});
//route for users being able to see pickup times
Route::get('/pickup-times-today', [PartnerController::class, 'getPickupTimesForToday']);

//new routes for ability to pubish and unpublish offer  for partners
Route::middleware(['auth:partner'])->group(function () {
    Route::get('offers', [FoodOfferController::class, 'index'])->name('offers.index');
    Route::post('offers/{offer}/unpublish', [FoodOfferController::class, 'unpublish'])->name('offers.unpublish');
    Route::post('offers/{offer}/publish', [FoodOfferController::class, 'publish'])->name('offers.publish');
    Route::get('offers/{offer}/edit', [FoodOfferController::class, 'edit'])->name('offers.edit');
    Route::put('offers/{offer}', [FoodOfferController::class, 'update'])->name('offers.update');
});

    // Google Translate routes
    // Route::get('google/translate',[GoogleTranslateController::class,'googleTranslate'])->name('google.translate');
    // Route::get('google/translate/change',[GoogleTranslateController::class,'googleTranslateChange'])->name('google.translate.change');
});




