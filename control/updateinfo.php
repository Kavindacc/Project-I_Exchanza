<?php
include_once '../model/DbConnector.php';
include_once '../model/User.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $userid = $_POST['userid'];
    $firstname = ucfirst($_POST['fname']);
    $lastname = ucfirst($_POST['lname']);
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];

    $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
    $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $phoneno = filter_var($phoneno, FILTER_SANITIZE_STRING);


$obj=new RegisteredCustomer($userid);
$obj->setFirstname($firstname);
$obj->setLastname($lastname);
$obj->setEmail($email);
$obj->setPhonenum($phoneno);

$dsn=new DbConnector();
$con=$dsn->getConnection();

if($obj->updateinfomation($con)){
    $_SESSION['u'] = "Personal information update successfully.";
    header("Location: ../view/userpage.php?u=1");
    exit();
}
else{
    header("Location: ../view/userpage.php");
    exit();
}

}?>