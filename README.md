# Laravel Stripe Integration Tutorial

This tutorial explains how to integrate the Stripe payment gateway into a Laravel application using the Stripe PHP SDK. This will enable Stripe's payment processing capabilities within your PHP-based e-commerce or shopping cart application.

## Prerequisites

- PHP environment with Composer installed
- Laravel framework set up
- Stripe account for API keys

## Steps

### 1. Install Stripe PHP SDK

Use Composer to install the Stripe PHP SDK. Run the following command in your project directory:


composer require stripe/stripe-php

bash
2. Obtain API Keys
Log into your Stripe dashboard and navigate to the "Developers" section to obtain your API keys.

3. Configure API Keys in Laravel
Add your Stripe API keys to your Laravel application's .env file:

plaintext
Copy code
STRIPE_SECRET_KEY=your_secret_key
STRIPE_PUBLISHABLE_KEY=your_publishable_key
4. Create Stripe Configuration
Create a stripe.php file in your config directory with the following content:

php
Copy code
<?php

return [
    'stripe_publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
    'stripe_secret_key' => env('STRIPE_SECRET_KEY'),
    'product' => [
        'name' => 'Classic Quartz Watch',
        'description' => 'Water resistant, Stop watch, Alarm features.',
        'price' => 1000,
    ],
];
5. Design Laravel Views
Create two blade templates: one for the payment page and another for the thank you page.

Payment Page: resources/views/stripe.blade.php
Thank You Page: resources/views/success.blade.php
6. Implement Stripe Checkout
Implement the checkout logic in a Laravel controller app/Http/Controllers/StripePaymentController.php:

php
Copy code
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Stripe\StripeClient;

class StripePaymentController extends Controller
{
    public function stripe()
    {
        $product = Config::get('stripe.product');
        return view('stripe', compact('product'));
    }

    public function stripeCheckout(Request $request)
    {
        $stripe = new StripeClient(Config::get('stripe.stripe_secret_key'));
        $response = $stripe->checkout->sessions->create([
            'success_url' => route('stripe.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'product_data' => ['name' => $request->product],
                    'unit_amount' => 100 * $request->price,
                    'currency' => 'USD',
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
        ]);

        return redirect($response['url']);
    }

    public function stripeCheckoutSuccess(Request $request)
    {
        $stripe = new StripeClient(Config::get('stripe.stripe_secret_key'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);
        $successMessage = "We have received your payment request and will let you know shortly.";

        return view('success', compact('successMessage'));
    }
}
7. Define Routes
Define routes in routes/web.php:

php
Copy code
use App\Http\Controllers\StripePaymentController;

Route::get('/', [StripePaymentController::class, 'stripe'])->name('stripe.index');
Route::get('stripe/checkout', [StripePaymentController::class, 'stripeCheckout'])->name('stripe.checkout');
Route::get('stripe/checkout/success', [StripePaymentController::class, 'stripeCheckoutSuccess'])->name('stripe.checkout.success');
Conclusion
This tutorial provides a basic framework for integrating Stripe into a Laravel application. Modify and expand upon this example to fit the needs of your specific application.

csharp
Copy code

You can now save this as `README.md` in your GitHub repository for your Laravel project. This README provides a comprehensive guide for users on how to set up Stripe payment integration in a Laravel application.
