<?php
include_once '../model/DbConnector.php';
include_once '../model/User.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['productid'];
    $user_id = $_POST['userid'];
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];
    $cat=htmlspecialchars(trim($_POST['cat']));
    $sub=htmlspecialchars(trim($_POST['sub']));

    if (!empty($product_id) && !empty($user_id) && !empty($review_text) && !empty($rating)) {
        if (filter_var($product_id, FILTER_VALIDATE_INT)) {
            $product_id = filter_var($product_id, FILTER_SANITIZE_NUMBER_INT);
        }
        if (filter_var($user_id, FILTER_VALIDATE_INT)) {
            $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
        }
        if (is_string($review_text)) {
            $review_text = filter_var($review_text, FILTER_SANITIZE_STRING);
        }

        $dsn = new DbConnector();
        $con = $dsn->getConnection();

        $user = new GeneralCustomer($user_id, $product_id, $review_text, $rating);
        if ($user->giveRating($con)) {
            header("Location: ../view/item_template.php?cat=$cat&sub=$sub&s=1");
            exit();
        }
        else{
            header("Location: ../view/item_template.php?cat=$cat&sub=$sub&s=0");
            exit(); 
        }
    }
}
