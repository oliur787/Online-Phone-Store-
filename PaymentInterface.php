<?php
// C:\xampp\htdocs\onlinephonestore\PaymentInterface.php

interface PaymentInterface { 
    public function processPayment($amount, $currency, $description, $source); 
}