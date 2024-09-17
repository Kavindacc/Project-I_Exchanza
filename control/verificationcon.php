<?php
include_once '../model/DbConnector.php';
include_once '../model/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['vcode'])) {
        $code = trim(htmlspecialchars(htmlentities($_POST['vcode'])));
    } else {
        header("Location: ../view/verification.php?error=Enter Verification Code");
        exit();
    }
    $email = $_POST['email'];
    $dsn = new DbConnector();
    $con = $dsn->getConnection();


    if (is_numeric($code)) {
        $user = new User();
        $user->setEmail($email);
        $otp = $user->checkOtp($con);
        if ($otp == $code) {
            $status = "active";
            if ($user->userActive($con, $status)) {
                header("Location: ../view/login_user.php");
                exit();
            }
        } else {
            header("Location: ../view/verification.php?error=Verification Code incorrect");
            exit();
        }
    } else {
        header("Location: ../view/verification.php?error=Verification Code incorrect");
        exit();
    }
}
