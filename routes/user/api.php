<?php

use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\BankServiceController;
use App\Http\Controllers\Api\BankServiceRequestController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LearningVideoController;
use App\Http\Controllers\Api\LoanAdController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\NewsLetterController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ServicePriceController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\UserContactController;
use App\Http\Middleware\CheckSubscription;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->prefix('home')->group(function () {
    Route::get('/', 'index');
});

Route::controller(ProfileController::class)
    ->prefix('profile')->middleware('auth:sanctum')->group(function () {
    Route::get('/', 'getProfile');
    Route::post('/', 'updateProfile');

    Route::get('/loans', 'loans');
});

Route::controller(BankServiceController::class)->prefix('bank-service')->group(function () {
    Route::get('/', 'index');
    Route::get('/{slug}', 'single');
});

Route::controller(BlogController::class)->prefix('blog')->group(function () {
    Route::get('/', 'index');
    Route::get('/{slug}', 'single');
});

Route::controller(LearningVideoController::class)->prefix('learning-video')->group(function () {
    Route::get('/', 'index');
});

Route::controller(ServicePriceController::class)->prefix('service-prices')->group(function () {
    Route::get('/', 'index');
});

Route::controller(UserContactController::class)->prefix('contact')->group(function () {
    Route::post('/create', 'create');
});

Route::controller(NewsLetterController::class)->prefix('news-letter')->group(function () {
    Route::post('/subscribe', 'subscribe');

    Route::post('/un-subscribe', 'unSubscribe');
});

Route::controller(SearchController::class)->prefix('search')->group(function () {
    Route::get('/', 'search');
    Route::get('/paginated', 'searchPaginated');
    Route::get('/limited', 'searchWithLimit');
});


Route::middleware('auth:sanctum')->controller(SubscriptionController::class)->group(function () {
    Route::get('/subscription', 'index');
    Route::get('/plans', 'plans')->withoutMiddleware('auth:sanctum');
//    Route::post('/subscribe', 'subscribe');
    Route::post('/subscription/cancel', 'cancel');
});

Route::controller(LoanAdController::class)->prefix('loan')->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'single')->middleware(['auth:sanctum', CheckSubscription::class]);
    Route::post('/', 'store')->middleware(['auth:sanctum']);
});

Route::controller(LocationController::class)->prefix('location')->group(function () {
    Route::get('/provinces', 'provinces');
    Route::get('/cities', 'cities');
});

Route::controller(BankController::class)->prefix('bank')->group(function () {
    Route::get('/', 'index');
});

Route::controller(OrderController::class)->middleware('auth:sanctum')->prefix('order')->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/', 'create')->middleware(['auth:sanctum']);
});

Route::controller(PaymentController::class)->prefix('payment')->group(function () {
    Route::post('/zarinpal/callback', 'callbackZarinpalGateway')->name('payment.zarinpal.callback');
    Route::post('/omidpay/callback', 'callbackOmidPay')->name('payment.omidpay.callback');
});

Route::controller(CategoryController::class)->prefix('categories')->group(function () {
    Route::get('/', 'index');
    Route::get('/{category}', 'show');
});

Route::controller(BankServiceRequestController::class)->middleware('auth:sanctum')
    ->prefix('bank-service-request')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');

    });



