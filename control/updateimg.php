<?php
include_once '../model/DbConnector.php';
include_once '../model/User.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid'];
    $filePath = null;
    $errors = [];
    if (!empty($userid) && $_FILES['profilepic']) {
        if (filter_var($userid, FILTER_VALIDATE_INT)) {
            $suserid = filter_var($userid, FILTER_VALIDATE_INT);
        } else {
            $errors[]="Invalid Userid.";
        }

        if ($_FILES['profilepic']['error'] === 0) {
            $file = $_FILES['profilepic'];
            $filename = $file['name'];
            $filetmpname = $file['tmp_name'];
            $filesize = $file['size'];
            $fileext = explode('.', $filename); // String convert array
            $fileactualext = strtolower(end($fileext));
            $allowed = ['jpg', 'jpeg', 'png']; //santize
    
            if (in_array($fileactualext, $allowed)) {
                if ($filesize < 1000000) { // 1MB file size limit
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
    }
    else{
        $errors[] = "Input feild required.";
    }

    if ($filePath !== null) {
        $dsn=new DbConnector();
        $con=$dsn->getConnection();

        $user=new RegisteredCustomer($suserid);
        $user->setFilepath($filePath);

        if ($user->updateImg($con)) {
            $_SESSION['success']="Profile Img Change Success.";
            header("Location: ../view/userpage.php"); //userpage page
            exit();
        }
        else{
            $errors[] = "Profile Img not upload.";
        }
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            $_SESSION['error']=$error;
            header("Location: ../view/userpage.php"); //userpage page
            exit();
        }
    }
}
