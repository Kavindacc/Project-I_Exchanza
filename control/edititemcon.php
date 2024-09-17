<?php
include_once '../model/DbConnector.php';
include_once '../model/item.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['productid'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $current_image = $_POST['current_image'];

    if (!empty($product_id) && !empty($product_name) && !empty($price)) {

        $product_name = filter_var($product_name, FILTER_SANITIZE_STRING);
        $product_id = filter_var($product_id, FILTER_SANITIZE_NUMBER_INT);
        $price = filter_var($price, FILTER_SANITIZE_STRING);


        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

            $target_dir = "../upload/";
            $target_file = $target_dir . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
            $image = $target_file; // Use new image
        } else {
            // No new image uploaded, use the current image
            $image = $current_image;
        }


        $dsn = new DbConnector();
        $con = $dsn->getConnection();


        $item = new Item();
        $item->setItemId($product_id);
        $item->setItemName($product_name);
        $item->setPrice($price);
        $item->setCoverImage($image);

        if ($item->updateitem($con)) {
            $_SESSION['editsuccess'] = "Product updated successfully";
            header("Location: ../view/userpage.php");
            exit();
        } else {
            header("Location: ../view/userpage.php");
            exit();
        }
    }
}
