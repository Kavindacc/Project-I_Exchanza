<?php
require_once 'config.php';
include_once '../model/DbConnector.php';
include_once '../model/addtocart.php';

session_start();

// Set your Stripe API key
//\Stripe\Stripe::setApiKey('YOUR_STRIPE_SECRET_KEY');


$userid = $_POST['userid'];
$total_amount = $_POST['total_amount'] * 100;

// Create a new Stripe Checkout Session
$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => 'Shopping Cart Items',
            ],
            'unit_amount' => $total_amount, // Total amount in cents
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost/Project-I_Exchanza/control/payment_success.php?session_id={CHECKOUT_SESSION_ID}&userid='.$userid.'&total_amount='.$total_amount,
    'cancel_url' => 'http://localhost/Project-I_Exchanza/control/payment_failed.php',
]);

// Redirect to Stripe Checkout page
header("Location: " . $session->url);
exit();
