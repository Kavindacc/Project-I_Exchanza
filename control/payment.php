<?php
require_once 'config.php';
include_once '../model/DbConnector.php';
include_once '../model/addtocart.php';

session_start();

$userid = $_POST['userid'];
$total_amount = $_POST['total_amount'];
$delivery_address = $_POST['delivery_address'];
$payment_method = $_POST['payment_method'];
$delivery_charge = 500; // Example delivery charge, modify as needed

// Calculate total amount with delivery charge
$total_amount_with_delivery = $total_amount + $delivery_charge;

if ($payment_method === 'cod') {
    // Handle Cash on Delivery (COD)
    // Save order details in the database, mark it as pending or COD
    header("Location: payment_success_cod.php?userid={$userid}&total_amount={$total_amount_with_delivery}&address={$delivery_address}");
    exit();
}

// If payment method is card, proceed with Stripe Checkout

// Set your Stripe API key
//\Stripe\Stripe::setApiKey('YOUR_STRIPE_SECRET_KEY');
$total_amount_in_cents=$total_amount*100;
$total_amount_delivery_in_cents = $total_amount_with_delivery * 100; // Convert to cents for Stripe
$delivery_charge_in_cents = $delivery_charge * 100; // Delivery charge in cents

// Create a new Stripe Checkout Session
$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [
        // Line item for the product total
        [
            'price_data' => [
                'currency' => 'lkr',
                'product_data' => [
                    'name' => 'Shopping Cart Items',
                ],
                'unit_amount' => $total_amount_in_cents, // Product amount in cents
            ],
            'quantity' => 1,
        ],
        // Line item for the delivery charge
        [
            'price_data' => [
                'currency' => 'lkr',
                'product_data' => [
                    'name' => 'Delivery Charge',
                ],
                'unit_amount' => $delivery_charge_in_cents, // Delivery charge in cents
            ],
            'quantity' => 1,
        ],
    ],
    'mode' => 'payment',
    'success_url' => 'http://localhost/Project-I_Exchanza/control/payment_success.php?session_id={CHECKOUT_SESSION_ID}&userid='.$userid.'&total_amount='.$total_amount_with_delivery.'&address='.$delivery_address.'&delivery_charge='.$delivery_charge,
    'cancel_url' => 'http://localhost/Project-I_Exchanza/control/payment_failed.php',
]);

// Redirect to Stripe Checkout page
header("Location: " . $session->url);
exit();
?>
