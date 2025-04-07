<?php
session_start();
require '../model/DbConnector.php';
require '../admin/classes/Admin.php';

// Instantiate the DbConnector class
$dbConnector = new DbConnector();
$admin = new Admin($dbConnector->getConnection());

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Call the banUser function
    if ($admin->banUser($userId)) {
        $_SESSION['message'] = "User has been banned successfully.";
    } else {
        $_SESSION['message'] = "Failed to ban the user.";
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
