<?php
include_once '../model/DbConnector.php';
include_once '../model/item.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitBid'])) {

    $itemname = $_POST['itemname'];
    $price = $_POST['price'];
    $color = isset($_POST['colour']) ? $_POST['colour'] : null;
    $description = $_POST['description'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $condition = $_POST['condition'];
    $size = isset($_POST['size']) ? $_POST['size'] : null;
    $start_time = $_POST['bidstarttime'];
    $end_time = $_POST['bidendtime'];
    $start_price = $_POST['start_price'];
    $userid = $_SESSION['userid'];

    $errors = [];

    // Input validation
    if (!empty($itemname) && !empty($price) && !empty($description) && !empty($category) && !empty($subcategory) && !empty($condition) && !empty($start_time) && !empty($end_time) && !empty($start_price)) {

        if (is_string($itemname)) {
            $itemname = filter_var($itemname, FILTER_SANITIZE_STRING);
        }
        if (is_numeric($price)) {
            $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        } else {
            $errors[] = "Price must be a number.";
        }
        if (is_numeric($start_price)) {
            $start_price = filter_var($start_price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        } else {
            $errors[] = "Start price must be a number.";
        }

        // File upload handling
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file = $_FILES['image'];
            $filename = $file['name'];
            $filetmpname = $file['tmp_name'];
            $filesize = $file['size'];
            $fileext = explode('.', $filename);
            $fileactualext = strtolower(end($fileext));
            $allowed = ['jpg', 'jpeg', 'png'];

            if (in_array($fileactualext, $allowed)) {
                if ($filesize < 2000000) { // 2MB file size limit
                    $fileNewName = uniqid('', true) . "." . $fileactualext;
                    $fileDestination = '../upload/' . $fileNewName;
                    if (move_uploaded_file($filetmpname, $fileDestination)) {
                        $filePath = $fileDestination;
                    } else {
                        $errors[] = "Failed to move uploaded file.";
                    }
                } else {
                    $errors[] = "File is too big.";
                }
            } else {
                $errors[] = "Please upload a jpg, jpeg, or png file.";
            }
        }

        if (empty($errors) && isset($filePath)) {
            // Initialize database connection
            $dsn = new DbConnector();
            $con = $dsn->getConnection();

            // Create new Item object for bidding
            $item = new Item($itemname, $price, $color, $description, $category, $subcategory, $condition, $size, $filePath, null, $userid);

            // Call the method to add item for bidding
            if ($item->addItemForBidding($con, $start_time, $end_time, $start_price)) {
                header("Location: ../view/bidding.php?success=Item added successfully for bidding.");
                exit();
            } else {
                header("Location: ../view/bidding.php?error=Failed to add item for bidding.");
                exit();
            }
        } else {
            foreach ($errors as $error) {
                header("Location: ../view/bidding.php?error=$error");
                exit();
            }
        }
    } else {
        $errors[] = "All input fields are required.";
        foreach ($errors as $error) {
            header("Location: ../view/bidding.php?error=$error");
            exit();
        }
    }
}
?>
