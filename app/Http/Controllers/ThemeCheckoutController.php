<?php

namespace App\Http\Controllers;

use App\Models\ThemeConfiguration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ThemeCheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'configuration' => 'required|array',
            'license_type' => 'required|in:business,unlimited',
            'email' => 'required|email',
            'name' => 'sometimes|string|max:255',
        ]);

        // Create theme configuration record
        $themeConfig = ThemeConfiguration::create([
            'purchase_token' => Str::random(32),
            'configuration' => $request->configuration,
            'license_type' => $request->license_type,
            'email' => $request->email,
            'name' => $request->name ?? $request->email,
            'payment_status' => 'pending',
        ]);

        try {
            // Determine variant ID based on license type
            $variantId = $request->license_type === 'unlimited' ? '943307' : '943306';
            $successUrl = route('checkout.success', $themeConfig->purchase_token);

            Log::info('Starting checkout creation', [
                'variant_id' => $variantId,
                'success_url' => $successUrl,
                'store_id' => config('lemon-squeezy.store'),
                'purchase_token' => $themeConfig->purchase_token,
                'app_url' => config('app.url'),
                'customer_email' => $themeConfig->email,
            ]);

            // Create checkout with customer details and configuration
            $checkout = $themeConfig
                ->checkout($variantId, custom: [
                    'purchase_token' => $themeConfig->purchase_token,
                    'license_type' => $request->license_type,
                ])
                ->redirectTo($successUrl)
                ->withButtonColor('#f97316');

            Log::info('Checkout created successfully', [
                'checkout_id' => $checkout,
            ]);

            return response()->json([
                'checkout_url' => $checkout->url(),
                'purchase_token' => $themeConfig->purchase_token,
            ]);

        } catch (Exception $e) {
            // Log the full error for debugging
            Log::error('Checkout creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'variant_id' => $variantId ?? 'unknown',
                'store_id' => config('lemon-squeezy.store'),
                'api_key_present' => ! empty(config('lemon-squeezy.api_key')),
            ]);

            // Clean up theme config if checkout creation fails
            $themeConfig->delete();

            return response()->json([
                'error' => 'Failed to create checkout: ' . $e->getMessage(),
                'debug_info' => [
                    'variant_id' => $variantId ?? 'unknown',
                    'store_configured' => ! empty(config('lemon-squeezy.store')),
                    'api_key_configured' => ! empty(config('lemon-squeezy.api_key')),
                ],
            ], 500);
        }
    }

    public function success(string $token)
    {
        $themeConfig = ThemeConfiguration::where('purchase_token', $token)->first();

        if (! $themeConfig) {
            abort(404);
        }

        $hasCompletedOrder = $themeConfig->payment_status === 'completed';

        if (! $hasCompletedOrder) {
            return view('checkout.pending', compact('themeConfig'));
        }

        return view('checkout.success', compact('themeConfig'));
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();

        Log::info('LemonSqueezy webhook received', [
            'event_name' => $payload['meta']['event_name'] ?? 'unknown',
            'payload' => $payload,
        ]);

        $eventName = $payload['meta']['event_name'] ?? null;

        // Handle order_created events
        if ($eventName !== 'order_created') {
            return response()->json();
        }

        $customData = $payload['meta']['custom_data'] ?? [];
        $purchaseToken = $customData['purchase_token'] ?? null;

        if (! $purchaseToken) {
            Log::warning('No purchase token found in webhook payload', [
                'custom_data' => $customData,
            ]);

            return response()->json();
        }

        $themeConfig = ThemeConfiguration::where('purchase_token', $purchaseToken)->first();

        if (! $themeConfig) {
            Log::warning('Theme configuration not found for purchase token', [
                'purchase_token' => $purchaseToken,
            ]);

            return response()->json();
        }

        // Update payment status to completed
        $themeConfig->update(['payment_status' => 'completed']);

        Log::info('Theme configuration payment status updated', [
            'purchase_token' => $purchaseToken,
            'status' => 'completed',
        ]);

        return response()->json();
    }
}
