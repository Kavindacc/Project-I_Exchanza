<?php
include_once '../model/DbConnector.php';
include_once '../model/MyOrders.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($_POST['orderid'])) {
        if (filter_var($_POST['orderid'], FILTER_VALIDATE_INT)) {
            $orderid = filter_var($_POST['orderid'], FILTER_SANITIZE_NUMBER_INT);
        }

        $dsn = new DbConnector();
        $con = $dsn->getConnection();

        $obj = new MyOrders();
        $obj->setOrderId($orderid);
        if($obj->confirmReceived($con)){
            header("Location:../view/userpage.php?s=1");
            exit();
        }
    }
}
