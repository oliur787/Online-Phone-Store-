<?php
// C:\xampp\htdocs\onlinephonestore\checkout-charge.php

// 1. Load Composer/Stripe SDK dependencies (must be first)
require 'vendor/autoload.php';

// 2. Load the Interface definition FIRST (Fixes the "Interface not found" error)
require_once 'PaymentInterface.php';    

// 3. Load the Class that implements the interface SECOND
require_once 'StripePaymentAdapter.php'; 

// Validate POST inputs 
if (isset($_POST["stripeToken"]) && isset($_POST["price"])) {
    // Basic sanitization/casting for token and amount
    $token = htmlspecialchars($_POST["stripeToken"]);
    $amount = (float)$_POST["price"]; 
    $currency = "bdt"; // Currency
    $description = "Purchase from Mobile Shop";

    // Use the adapter for Stripe payment
    try {
        // Instantiate the adapter
        $stripePayment = new StripePaymentAdapter(); 
        
        // Stripe requires amount in cents, so multiply by 100
        $charge = $stripePayment->processPayment($amount * 100, $currency, $description, $token); 

        if ($charge && $charge->paid) {
            echo "Payment Successful! Charge ID: " . $charge->id;
        } else {
             // Handle cases where the charge object is created but the payment wasn't successful/paid
             echo "Payment Failed: Charge created but not paid.";
        }
    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Catch specific Stripe API errors
        echo "Stripe API Error: " . $e->getMessage();
    } catch (\Exception $e) { 
        // Catch general errors (like network or constructor errors)
        echo "General Payment Failure: " . $e->getMessage();
    }
} else {
    echo "Invalid payment request. Missing token or price.";
}