<?php
// C:\xampp\htdocs\onlinephonestore\StripePaymentAdapter.php

// DO NOT require 'vendor/autoload.php'; here! It is loaded in checkout-charge.php

use Stripe\Stripe;
use Stripe\Charge;

class StripePaymentAdapter implements PaymentInterface {
    // Line 9 (now line 10) is where the interface is implemented.
    // This will now work because PaymentInterface.php is loaded first.
    public function __construct() {
        // !!! IMPORTANT: Replace this with your actual Stripe secret key !!!
        Stripe::setApiKey("sk_test_your_secret_key"); 
    }

    public function processPayment($amount, $currency, $description, $source) {
        try {
            $charge = Charge::create([
                "amount" => $amount, // Amount in cents
                "currency" => $currency,
                "description" => $description,
                "source" => $source,
            ]);
            return $charge;
        } catch (\Exception $e) {
            // Re-throw exception to be caught in the main script
            throw new \Exception("Stripe Payment Failed: " . $e->getMessage()); 
        }
    }
}