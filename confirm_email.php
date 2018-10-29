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
    
    $ff = base64_encode("please verfy your email address");
    header("location: login.phtml?msgv=".$ff);
    $message = file_get_contents("mail_template.html");
    $link = "http://".$_SERVER['SERVER_NAME']."/camagru/login.phtml?usr=".$_GET['usr']."&ok=".$_GET['user'];

    $message = str_replace("%link%", $link, $message);
    $message = str_replace("%str%", "Thank you for making an account.<br>Please click button below to verify.", $message);
    $message = str_replace("%button%", "verify", $message);
    
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
    $mail->SetFrom("rogerndaba@gmail.com", "Camagru Team");
    $mail->Subject = "Verify email";
    $mail->msgHTML($message);
    $confirm = base64_decode($_GET['confirm']);
    $mail->AddAddress($confirm);

     if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
     } else {
        echo "Message has been sent";
     }
?>