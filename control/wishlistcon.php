<?php
include_once '../model/DbConnector.php';
include_once '../model/wishlist.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $productid = htmlspecialchars(trim($_POST['productid']));
    $userid = htmlspecialchars(trim($_POST['userid']));
    $cat=htmlspecialchars(trim($_POST['cat']));
    $sub=htmlspecialchars(trim($_POST['sub']));

    if (!empty($productid) && !empty($userid) && !empty($cat) && !empty($sub)) {
        //add wishlish table
        //check already add
        $dsn = new DbConnector();
        $con = $dsn->getConnection();

        $item = new wishlist();
        $item->setUserId($userid);
        $item->setItemId($productid);

        $itemids = $item->getwishlistid($con);
        if (in_array($productid, $itemids)) {
            $_SESSION['amsg'] = "Product already add to Wishlist.";
            header("Location: ../view/item_template.php?cat=$cat&sub=$sub");
            exit();
        } else {
            if ($item->addtoWishlist($con)) {
                $_SESSION['msg'] = "Add Product Wishlist.";
                header("Location: ../view/item_template.php?cat=$cat&sub=$sub");
                exit();
            } else {
                $_SESSION['wmsg'] = "Not Product Add to Wishlist.";
                header("Location: ../view/item_template.php?cat=$cat&sub=$sub");
                exit();
            }
        }
    }
}



