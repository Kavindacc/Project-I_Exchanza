<?php
include_once '../model/DbConnector.php';
include_once '../model/User.php';
include_once '../model/addtocart.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid'];
    $itemid = $_POST['itemid'];
    $quantity = 1;
    if (!empty($userid) && !empty($itemid)) {
        if (filter_var($userid, FILTER_VALIDATE_INT)) {
            $userid = filter_var($userid, FILTER_SANITIZE_NUMBER_INT);
        }
        if (filter_var($itemid, FILTER_VALIDATE_INT)) {
            $itemid = filter_var($itemid, FILTER_SANITIZE_NUMBER_INT);
        }
    }

    $dsn = new DbConnector();
    $con = $dsn->getConnection();

    $user = new Cart();
    $user->setUserId($userid);
    $itemids = $user->getCartId($con);


    if (!in_array($itemid, $itemids)) {
        $obj = new RegisteredCustomer($userid);
        $obj->setItemId($itemid);
        if ($obj->addToCart($con)) {
            header("Location: ../view/wishlist.php?s=1");
            exit();
        } else {
            header("Location: ../view/wishlist.php?s=0");
            exit();
        }
    } else {
        header("Location: ../view/wishlist.php?s=2");
        exit();
    }
}
