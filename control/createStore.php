<?php
session_start();
include_once '../model/DbConnector.php'; // Database connection logic

// Check if the form is submitted
if (isset($_POST['createstore'])) {

    // Get the form inputs
    $store_name = $_POST['storename'];
    $slogan = $_POST['slogan'];

    // Check if user is logged in
    if (!isset($_SESSION['userid'])) {
        header("Location: ../view/login_user.php");
        exit();
    }

    $user_id = $_SESSION['userid'];

    // Handle image uploads (Profile Picture and Cover Picture)
    $profile_pic_path = NULL;
    $cover_pic_path = NULL;

    // Define upload directory
    $upload_dir = '../upload/';

    // Handle profile picture upload
    if (isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] === UPLOAD_ERR_OK) {
        $profile_pic_name = uniqid() . '.' . pathinfo($_FILES['profilepic']['name'], PATHINFO_EXTENSION);
        $profile_pic_path = $upload_dir . $profile_pic_name;

        // Move uploaded file to the specified directory
        move_uploaded_file($_FILES['profilepic']['tmp_name'], $profile_pic_path);
    }

    // Handle cover picture upload
    if (isset($_FILES['coverpic']) && $_FILES['coverpic']['error'] === UPLOAD_ERR_OK) {
        $cover_pic_name = uniqid() . '.' . pathinfo($_FILES['coverpic']['name'], PATHINFO_EXTENSION);
        $cover_pic_path = $upload_dir . $cover_pic_name;

        // Move uploaded file to the specified directory
        move_uploaded_file($_FILES['coverpic']['tmp_name'], $cover_pic_path);
    }

    try {
        // Database connection using PDO
        $dsn = new DbConnector();
        $con = $dsn->getConnection(); // Assuming this returns a PDO instance

        // SQL Query to insert data into the 'stores' table
        $sql = "INSERT INTO stores (user_id, store_name, slogan, profile_pic, cover_pic) 
                VALUES (:user_id, :store_name, :slogan, :profile_pic, :cover_pic)";

        // Prepare the statement
        $stmt = $con->prepare($sql);

        // Bind the parameters
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':store_name', $store_name, PDO::PARAM_STR);
        $stmt->bindParam(':slogan', $slogan, PDO::PARAM_STR);
        $stmt->bindParam(':profile_pic', $profile_pic_path, PDO::PARAM_STR);
        $stmt->bindParam(':cover_pic', $cover_pic_path, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            header("Location: ../view/store_created.php?success=Store created successfully");
            exit();
        } else {
            header("Location: ../view/create_store.php?error=Error creating store. Please try again.");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../view/create_store.php");
    exit();
}
