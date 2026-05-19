<?php

use App\Http\Controllers\Api\BankServiceController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LearningVideoController;
use App\Http\Controllers\Api\NewsLetterController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ServicePriceController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\UserContactController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->prefix('home')->group(function (){
    Route::get('/','index');
});

Route::controller(BankServiceController::class)->prefix('bank-service')->group(function (){
    Route::get('/','index');
    Route::get('/{slug}','single');
});

Route::controller(BlogController::class)->prefix('blog')->group(function (){
    Route::get('/','index');
    Route::get('/{slug}','single');
});

Route::controller(LearningVideoController::class)->prefix('learning-video')->group(function (){
    Route::get('/','index');
});

Route::controller(ServicePriceController::class)->prefix('service-prices')->group(function (){
    Route::get('/','index');
});

Route::controller(UserContactController::class)->prefix('contact')->group(function (){
    Route::post('/create','create');
});

Route::controller(NewsLetterController::class)->prefix('news-letter')->group(function (){
    Route::post('/subscribe','subscribe');

    Route::post('/un-subscribe','unSubscribe');
});

Route::controller(SearchController::class)->prefix('search')->group(function (){
    Route::get('/','search');
    Route::get('/paginated','searchPaginated');
    Route::get('/limited','searchWithLimit');
});


Route::middleware('auth:sanctum')->controller(SubscriptionController::class)->group(function () {
    Route::get('/subscription', 'index');
    Route::get('/plans', 'plans');
    Route::post('/subscribe', 'subscribe');
    Route::post('/subscription/cancel', 'cancel');
});




