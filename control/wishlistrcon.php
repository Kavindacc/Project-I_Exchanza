<?php
session_start();
include_once '../model/DbConnector.php';
include_once '../model/wishlist.php';
if($_SERVER['REQUEST_METHOD']=='POST'){

    $wishlistid=$_POST['wishlistid'];
    if(!empty($wishlistid)){
        if(filter_var($wishlistid,FILTER_VALIDATE_INT)){
            $wishlistid=filter_var($wishlistid,FILTER_SANITIZE_NUMBER_INT);
        }
        $dsn = new DbConnector();
        $con = $dsn->getConnection();

        $obj = new Wishlist();
        $obj->setWishId($wishlistid);
        if($obj->removeItem($con)){
            $_SESSION['rmsg'] = "Product Remove Wishlist.";
            header("Location: ../view/wishlist.php");
            exit();
        }

    }
    
    
    
}

?>