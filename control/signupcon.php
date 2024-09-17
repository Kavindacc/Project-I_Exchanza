<?php
include_once '../model/DbConnector.php';
include_once '../model/User.php';
include_once '../model/Otp.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $phonenum = $_POST['pnum'];
    $password = $_POST['password'];
    $rpassword = $_POST['rpassword'];
    $errors = [];
    
    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($gender) && !empty($country) && !empty($phonenum) && !empty($password) && !empty($rpassword)) {

        echo $fname;
        // Validate first name
        if (is_string($fname)) {
            // Only allow a-z and A-Z
            if (preg_match("/^[a-zA-Z]+$/", $fname)) {
                $sfname = filter_var($fname, FILTER_SANITIZE_STRING);
            } else {
                $errors[] = "First Name can only contain letters (A-Z).";
            }
        } else {
            $errors[] = "Enter a valid First Name.";
        }

        // Validate last name
        if (is_string($lname)) {
            // Only allow a-z and A-Z
            if (preg_match("/^[a-zA-Z]+$/", $lname)) {
                $slname = filter_var($lname, FILTER_SANITIZE_STRING);
            } else {
                $errors[] = "Last Name can only contain letters (A-Z).";
            }
        } else {
            $errors[] = "Enter a valid Last Name.";
        }

        // Validate email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $semail = filter_var($email, FILTER_SANITIZE_EMAIL);
        } else {
            $errors[] = "Enter a valid Email Address.";
        }

        // Validate phone number based on country
        switch ($country) {
            case 'uk':
                if (preg_match('/^(\+44|0)\d{10}$/', $phonenum) && strlen($phonenum) == '11') {
                    $sphonenum = filter_var($phonenum, FILTER_SANITIZE_STRING);
                } else {
                    $errors[] = "Enter a valid UK Phone Number.";
                }
                break;

            case 'sl':
                if (preg_match('/^(\+94|0)\d{9}$/', $phonenum) && strlen($phonenum) == '10') {
                    $sphonenum = filter_var($phonenum, FILTER_SANITIZE_STRING);
                } else {
                    $errors[] = "Enter a valid Sri Lanka Phone Number.";
                }
                break;

            default:
                $errors[] = "Select a valid country.";
                break;
        }

        // Validate password
        if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', $password)) {
            if ($password === $rpassword) {
                $spassword = password_hash($password, PASSWORD_DEFAULT); // Hash password for security
            } else {
                $errors[] = "Passwords do not match.";
            }
        } else {
            $errors[] = "Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, one number, and one special character.";
        }

        
    }else{
        $errors[]="Input feild required.";
    }
    if (empty($errors)) {
        $dsn = new DbConnector();
        $con = $dsn->getConnection();
       
        $user = new User($sfname, $slname, $semail, $gender, $country, $sphonenum, $spassword);
        if (!$user->checkEmail($con)) {
            //otp sent user email
            $otp_str = str_shuffle("0123456789");
            $otp = substr($otp_str, 0, 5);
            //insert data usertable
            $user->setOtpnum($otp);
            if ($user->userRegister($con)) {
                $obj = new Otp($semail, $otp);
                if ($obj->otpsent()) {
                    header("Location:../view/verification.php?email=$semail&success=Check your Email.");
                    exit();
                }
            }
        } else {
            header("Location:../view/signup.php?error=Already use this email.");
            exit();
        }
    } else {
        foreach ($errors as $error) {
            header("Location:../view/signup.php?error=$error");
            exit();
        }
    }
}
