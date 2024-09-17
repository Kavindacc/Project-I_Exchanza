<?php

session_start();
include_once '../model/DbConnector.php';
include_once '../model/item.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemid = $_POST['productid'];
    if (!empty($itemid)) {
        if (filter_var($itemid, FILTER_VALIDATE_INT)) {
            $itemid = filter_var($itemid, FILTER_SANITIZE_NUMBER_INT);
        }
        $dsn = new DbConnector();
        $con = $dsn->getConnection();

        $item = new Item();
        $item->setItemId($itemid);
        if ($item->delete($con)) {
            $_SESSION['deletesuccess'] = 'Product Deleted.';
            header("Location: ../view/userpage.php");
            exit();
        }
    }
}
