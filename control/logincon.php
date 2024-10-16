<?php
include_once '../model/DbConnector.php';
include_once '../model/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usertype = trim(htmlspecialchars($_POST['usertype']));
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = [];
    if (!empty($email) && !empty($password)) {

        if($usertype == 'user'){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $semail = filter_var($email, FILTER_SANITIZE_EMAIL);
            } 
    
            $dsn = new DbConnector();
            $con = $dsn->getConnection();
    
            $user = new User();
            $user->setEmail($semail);
            $user->setPassword($password);
            if ($user->userAuthentication($con)) {
                header("Location:../index.php");
                exit();
                
            } else {
                header("Location:../view/login_user.php?error=Invalid email and password");
                exit();
               
            }
        }
        else if($usertype == 'admin'){

        }

      
    }
}
