<?php

class Otp{

    private $email;
    private $otp;

    function __construct($email,$otp){
        $this->email=$email;
        $this->otp=$otp;
    }

    function otpsent(){
        
        $mail =include_once 'Mailer.php';

        $mail->setFrom("exchanza7@gmail.com"); //myemail
        $mail->addAddress($this->email);
        $mail->Subject = "OTP Code";
        $mail->Body = "your Verification code {$this->otp}";

        try {
            $mail->send();
            return true;

        } catch (Exception $e) {
            
            echo "Message could not be sent.Mailer error:{$mail->ErrorInfo}";
        }
    }
}




?>