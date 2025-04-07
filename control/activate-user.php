<?php
session_start();
require '../model/DbConnector.php';
require '../admin/classes/Admin.php';

// Instantiate the DbConnector class
$dbConnector = new DbConnector();
$admin = new Admin($dbConnector->getConnection());

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Call a new function to activate the user
    if ($admin->activateUser($userId)) {
        $_SESSION['message'] = "User has been activated successfully.";
    } else {
        $_SESSION['message'] = "Failed to activate the user.";
    }

    // Redirect back to the users list
    header("Location: ../admin/users.php");
    exit(0);
} else {
    $_SESSION['message'] = "No user ID provided.";
    header("Location: ../admin/users.php");
    exit(0);
}
?>
