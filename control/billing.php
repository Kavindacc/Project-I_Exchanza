<?php
session_start();
$userid = $_POST['userid'];
$total_amount = $_POST['total_amount'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Billing Information</title>
</head>
<body>
    <h2>Billing Information</h2>

    <form action="payment.php" method="POST">
        <!-- Delivery Address -->
        <label for="address">Delivery Address:</label>
        <input type="text" name="delivery_address" id="address" required>

        <!-- Payment Method -->
        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" id="payment_method" required>
            <option value="card">Card</option>
            <option value="cod">Cash on Delivery</option>
        </select>

        <!-- Pass total amount and user ID to the payment processing -->
        <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
        <input type="hidden" name="userid" value="<?php echo $userid; ?>">

        <button type="submit">Proceed to Payment</button>
    </form>
</body>
</html>
