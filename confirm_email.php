<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: confirm_email.php
 *
 */

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->IsHTML(true);
    $mail->Username = "camagrurmdaba@gmail.com";
    $mail->Password = "rootyroot";
    $mail->SetFrom("rogerndaba@gmail.com");
    $mail->Subject = "Test";
    $mail->Body = "http://localhost:".$_SERVER['SERVER_PORT']."/camagru/login.phtml?ok=1";
    $confirm = base64_decode($_GET['confirm']);
    $mail->AddAddress($confirm);

     if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
     } else {
        echo "Message has been sent";
     }
     header("location: login.phtml");
?>