<?php
include_once '../model/DbConnector.php';
include_once '../model/Order.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($_POST['orderid'])) {
        if (filter_var($_POST['orderid'], FILTER_VALIDATE_INT)) {
            $orderid = filter_var($_POST['orderid'], FILTER_SANITIZE_NUMBER_INT);
        }

        $trackingnum = random_int(10000000, 99999999);
        $dsn = new DbConnector();
        $con = $dsn->getConnection();

        $obj = new Orders();
        $obj->setOrderId($orderid);
        if($obj->confirmOrder($con, $trackingnum)){
            header("Location:../view/userpage.php?s=1");
            exit();
        }
    }
}
