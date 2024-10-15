<?php
include_once '../model/DbConnector.php';
include_once '../model/item.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitBid'])) {

    // Retrieving form data
    $itemname = $_POST['itemname'];
    $start_price = $_POST['price'];
    $description = $_POST['description'];
    $start_time = $_POST['bidstarttime'];
    $end_time = $_POST['bitendtime'];
    $userid = $_POST['userid']; // Assuming user ID is available from the session or form

    $errors = [];

    // Basic validation
    if (!empty($itemname) && !empty($start_price) && !empty($description) && !empty($start_time) && !empty($end_time) && !empty($userid)) {
        
        // Sanitizing inputs
        if (is_string($itemname)) {
            $sitemname = filter_var($itemname, FILTER_SANITIZE_STRING);
        }

        if (is_numeric($start_price)) {
            $sprice = filter_var($start_price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        } else {
            $errors[] = "Start price must be a valid number.";
        }

        // Handling cover image upload (required)
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file = $_FILES['image'];
            $filename = $file['name'];
            $filetmpname = $file['tmp_name'];
            $filesize = $file['size'];
            $fileext = explode('.', $filename); 
            $fileactualext = strtolower(end($fileext));
            $allowed = ['jpg', 'jpeg', 'png'];
            
            if (in_array($fileactualext, $allowed)) {
                if ($filesize < 2000000) { // Check file size
                    $fileNewName = uniqid('', true) . "." . $fileactualext;
                    $fileDestination = '../upload/' . $fileNewName;
                    if (move_uploaded_file($filetmpname, $fileDestination)) {
                        $filePath = $fileDestination; // Store file path
                    } else {
                        $errors[] = "Failed to upload cover image.";
                    }
                } else {
                    $errors[] = "Cover image is too large.";
                }
            } else {
                $errors[] = "Cover image must be jpg, jpeg, or png.";
            }
        } else {
            $errors[] = "Cover image is required.";
        }

        // Handling optional other image upload
        if (isset($_FILES['otherimage']) && $_FILES['otherimage']['error'] === 0) {
            $file = $_FILES['otherimage'];
            $filename = $file['name'];
            $filetmpname = $file['tmp_name'];
            $filesize = $file['size'];
            $fileext = explode('.', $filename); 
            $fileactualext = strtolower(end($fileext));
            $allowed = ['jpg', 'jpeg', 'png'];
            
            if (in_array($fileactualext, $allowed)) {
                if ($filesize < 2000000) { // Check file size
                    $fileNewName = uniqid('', true) . "." . $fileactualext;
                    $fileDestination = '../upload/' . $fileNewName;
                    if (move_uploaded_file($filetmpname, $fileDestination)) {
                        $filePatho = $fileDestination; // Store other image path
                    } else {
                        $errors[] = "Failed to upload other image.";
                    }
                } else {
                    $errors[] = "Other image is too large.";
                }
            } else {
                $errors[] = "Other image must be jpg, jpeg, or png.";
            }
        }

    } else {
        $errors[] = "All fields are required.";
    }

    // If no errors, proceed with database operations
    if (empty($errors) && isset($filePath)) {
        $dsn = new DbConnector();
        $con = $dsn->getConnection();

        // Create new Item object and add it for bidding
        $item = new Item($sitemname, $sprice, null, $description, null, null, null, null, $filePath, $filePatho ?? null, 1, $userid);
        if ($item->addItemForBidding($con, $start_time, $end_time, $sprice)) {
            header("Location:../view/bidding.php?success=Item added for bidding successfully.");
            exit();
        } else {
            header("Location:../view/bidding.php?error=Item not added.");
            exit();
        }
    } else {
        // Debugging: Output errors to the browser
        echo "<pre>";
        print_r($errors);
        echo "</pre>";
        exit();
    }
}
?>