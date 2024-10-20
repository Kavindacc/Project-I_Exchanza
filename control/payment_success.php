<?php
// payment_success.php
require_once 'config.php';
include_once '../model/DbConnector.php';
include_once '../model/addtocart.php';

session_start();

$session_id = $_GET['session_id'];
$userid = $_GET['userid'];
$total_amount = $_GET['total_amount'] / 100;


$session = \Stripe\Checkout\Session::retrieve($session_id);
$payment_status = $session->payment_status;

if ($payment_status == 'paid') {
    $dsn = new DbConnector();
    $con = $dsn->getConnection();
    $sql_order = "INSERT INTO orders (user_id, order_status, order_date, trackingnum, confirm) 
                  VALUES (?, '0', NOW(), 0, 0)";
    $stmt = $con->prepare($sql_order);
    $stmt->bindValue(1, $userid);
    if ($stmt->execute()) {

        $order_id = $con->lastInsertId();
        $obj = new Cart();
        $obj->setUserId($userid);
        $cart_items = $obj->cartItemDetails($con);

        foreach ($cart_items as $item) {
            $item_id = $item['itemid'];
            $quantity = 1;
            $price = $item['price'];

            $sql_order_items = "INSERT INTO order_item (item_id, order_id, quantity, price) 
                                VALUES (?, ?, ?, ?)";
            $stmt_items = $con->prepare($sql_order_items);
            $stmt_items->bindValue(1, $item_id);
            $stmt_items->bindValue(2, $order_id);
            $stmt_items->bindValue(3, $quantity);
            $stmt_items->bindValue(4, $price);
            $stmt_items->execute();

            $sql = "UPDATE item SET status = ? WHERE itemid=?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1,1);
            $pstmt->bindValue(2,$item_id);
            $pstmt->execute();
        }

        $sql_clear_cart = "DELETE FROM addtocart WHERE user_id = ?";
        $stmt_clear = $con->prepare($sql_clear_cart);
        $stmt_clear->bindValue(1, $userid);
        $stmt_clear->execute();

        header("Location:../view/payment_done.php");
        exit();
        echo "Order placed successfully!";
    } else {
        echo "Failed to insert order into orders table.";
    }
} else {
    echo "Payment not successful.";
}
