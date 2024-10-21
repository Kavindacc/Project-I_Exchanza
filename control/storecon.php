<?php
include_once '../model/DbConnector.php';
include_once '../model/item.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $itemname = $_POST['itemname'];
    $price = $_POST['price'];
    $color = $_POST['colour'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $size = isset($_POST['size']) ? $_POST['size'] : null;
    $userid = $_POST['userid'];
    $errors = [];

    if (!empty($itemname) && !empty($price) && !empty($color) && !empty($description) && !empty($category) && !empty($subcategory) && !empty($userid)) {

        if (is_string($itemname)) {
            $sitemname = filter_var($itemname, FILTER_SANITIZE_STRING);
        }
        if (is_numeric($price)) {
            $sprice = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
        } else {
            $errors[] = "Price can only number.";
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file = $_FILES['image'];
            $filename = $file['name'];
            $filetmpname = $file['tmp_name'];
            $filesize = $file['size'];
            $fileext = explode('.', $filename); // String convert array
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
                $errors[] = "Please upload jpg, jpeg, or png type.";
            }
        }

        // Handling the other image upload
        if (isset($_FILES['otherimage']) && $_FILES['otherimage']['error'] === 0) {
            $file = $_FILES['otherimage'];
            $filename = $file['name'];
            $filetmpname = $file['tmp_name'];
            $filesize = $file['size'];
            $fileext = explode('.', $filename); // String convert array
            $fileactualext = strtolower(end($fileext));
            $allowed = ['jpg', 'jpeg', 'png'];

            if (in_array($fileactualext, $allowed)) {
                if ($filesize < 2000000) { // 2MB file size limit
                    $fileNewName = uniqid('', true) . "." . $fileactualext;
                    $fileDestination = '../uploadStore/' . $fileNewName;
                    if (move_uploaded_file($filetmpname, $fileDestination)) {
                        $filePatho = $fileDestination;
                    } else {
                        $errors[] = "Failed to move uploaded file.";
                    }
                } else {
                    $errors[] = "File is too big.";
                }
            } else {
                $errors[] = "Please upload jpg, jpeg, or png type.";
            }
        }
        $scategory = filter_var($category, FILTER_SANITIZE_STRING);
        $ssubcategory = filter_var($subcategory, FILTER_SANITIZE_STRING);
    } else {
        $errors[] = "Input feild required.";
    }

    if (empty($errors) && $filePath !== null) {
        $dsn = new DbConnector();
        $con = $dsn->getConnection();

        $item = new Item($sitemname, $sprice,  $color, $description, $scategory, $ssubcategory, $scondition, $size, $filePath, $filePatho, $userid);
        if ($item->addItemForStore($con)) {
            header("Location:../view/StoreTem.php?success=Item Add Successfully.");
            exit();
        } else {
            header("Location:../view/StoreTem.php?error=Item Not added.");
            exit();
        }
    } else {

        foreach ($errors as $error) {
            header("Location: ../view/StoreTem.php?error=$error");
            exit();
        }
    }
}
