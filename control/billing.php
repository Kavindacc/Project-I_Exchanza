<?php
include_once '../model/User.php';
include_once '../model/DbConnector.php';
$userid = $_POST['userid'];
$total_amount = $_POST['total_amount'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Billing Information</title>
    <link rel="stylesheet" href="../css/billing.css">
</head>

<body>
    <div>
        <h2>Billing Information</h2>
        <?php

        $user = new RegisteredCustomer();
        $user->setUserid($userid);

        $pdo = new DbConnector();
        $con = $pdo->getConnection();

        $row = $user->accountDetails($con)

        ?>
        <form action="payment.php" method="POST">
            <label>Name</label>
            <input type="text" value="<?php echo $row['firstname'] . " " . $row['lastname']; ?>" readonly>
            <label>Phone no</label>
            <input type="tel" value="<?php echo $row['phonenum']; ?>" />
            <label>Email Address</label>
            <input type="email" value="<?php echo $row['email']; ?>" readonly />
            <label>Total Amount</label>
            <input type="text" name="total_amount" value="<?php echo $total_amount; ?>" readonly>
            <label for="address">Delivery Address:</label>
            <input type="text" name="delivery_address" id="address" required>
            <label for="payment_method">Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="card">Card</option>
                <option value="cod">Cash on Delivery</option>
            </select>

            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
            <button type="submit">Proceed to Payment</button>
        </form>
    </div>
</body>

</html>