<?php

use App\Http\Controllers\ThemeCheckoutController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use LemonSqueezy\Laravel\Http\Middleware\VerifyWebhookSignature;

Route::view('/', 'home');
Route::view('/editor', 'theme-editor');
Route::view('/legal-notice', 'legal-notice');
Route::view('/privacy-policy', 'privacy-policy');

Route::post('/checkout', [ThemeCheckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/success/{token}', [ThemeCheckoutController::class, 'success'])->name('checkout.success');

Route::post('/webhooks/lemonsqueezy', [ThemeCheckoutController::class, 'webhook'])
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->middleware([VerifyWebhookSignature::class])
    ->name('webhook.lemon-squeezy');
