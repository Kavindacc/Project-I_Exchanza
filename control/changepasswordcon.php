<?php
include_once '../model/DbConnector.php';
include_once '../model/User.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $currentpw = $_POST['currentPassword'];
    $newpw = $_POST['newPassword'];
    $confirmpw = $_POST['confirmNewPassword'];
    $userid = $_POST['userid'];

    $errors = [];
    if (!empty($currentpw) && !empty($newpw) && !empty($confirmpw)) {
        $scurrentpw = htmlspecialchars(stripslashes($currentpw));
        $snewpw = htmlspecialchars(stripslashes($newpw));
        $sconfirmpw = htmlspecialchars(stripslashes($confirmpw));
        if (filter_var($userid, FILTER_VALIDATE_INT)) {
            $userid = filter_var($userid, FILTER_SANITIZE_NUMBER_INT);
        } else {
            $errors[] = "Invalid Userid.";
        }
        

        $dsn = new DbConnector();
        $con = $dsn->getConnection();

        $user = new RegisteredCustomer($userid);
        $user->setPassword($scurrentpw);
        if ($user->verifyPassword($con)) {
            if ($snewpw == $sconfirmpw) {
                if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', $newpw)) {
                    
                    $errors[] = "Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, one number, and one special character.";
                } 
                
            }
            else{
                $errors[] = "New password and confirm password not match.";
            } 
        }
        else {
            $errors[] = "Current Password Incorrect.";
        }
    }
    else {
        $errors[] = "Input feild required.";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($newpw, PASSWORD_DEFAULT); //hash password
        $user->setPassword($hashedPassword);
        if ($user->changepassword($con)) {
            $_SESSION['psuccess'] = "Password updated successfully.";
            header("Location: ../view/userpage.php");
            exit();
        } else {
            $errors[] = "Failed to update password. Please try again.";
        }
    } else {
        foreach ($errors as $error) {
            $_SESSION['perror'] = $error;
            header("Location: ../view/userpage.php"); //userpage page
            exit();
        }
    }
}
