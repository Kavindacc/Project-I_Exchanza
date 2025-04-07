<?php 
include_once '../model/DbConnector.php';
include_once '../model/User.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $itemid=$_POST['itemid'];
    $dsn=new DbConnector();
    $con=$dsn->getConnection();
    $obj=new RegisteredCustomer();
    $obj->setItemId($itemid);
    if($obj->removeAddToCart($con)){
        header("Location: ../view/addtocart.php?s=1");
        exit();
    }
    

    
    
}?>