<?php
require '../model/usern.php';
require '../model/dbconnection.php';
session_start();
if (isset($_POST['submit'])) {

    $productname = ucfirst($_POST['itemname']);
    $price = $_POST['price'];
    $colour = $_POST['colour'];
    $description = $_POST['description'];
    $category = strtolower($_POST['category']);
    $subcategory = strtolower($_POST['subcategory']);
    $size = isset($_POST['size']) ? $_POST['size'] : null; // Use ternary operator
    $condition = $_POST['condition'];
    $userid = $_SESSION['userid'];

    $errors = [];
    $filePath = null; // File upload start
    $filePatho = null; // Initialize other image path

    // Handling the main image upload
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
                $fileDestination = '../upload/' . $fileNewName;
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

    if ($filePath !== null || $filePatho !== null) {
        $obj = new Seller();
        if ($obj->additemforthrifting($productname, $price, $colour, $description, $category, $subcategory, $size, $condition, $filePath, $filePatho, $userid, Dbh::connect())) {
            header("Location: ../view/thrift.php?s=1"); //thrift page
            exit();
        }
    } else {
        $errors[] = "File upload failed or no file uploaded.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            header("Location: ../view/thrift.php?s=0"); //thrift page
            exit();
        }
    }
}
