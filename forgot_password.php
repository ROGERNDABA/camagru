<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: forgot_password.php
 *
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("connect.php");
require 'vendor/autoload.php';

$conn = conOpen();
$email = $_POST['email'];

if(!$email)
{
   $msg = "blank emails are impossible :(";
   $msgEncoded = base64_encode($msg);
   header("location:forgot_password.phtml?msg=".$msgEncoded);
   exit();
}
else
{
    $message = file_get_contents("mail_template.html");
    $q = "SELECT `username`, `isusr`, `email`, `token` FROM `accounts`";
    $re = $conn->query($q);
    while($row = $re->fetch(PDO::FETCH_ASSOC)) {
        if ($row['email'] === $email && $row['isusr'] == 1) {

            header("location: checkmailbox.html");
            $s = "usr=".base64_encode($row['username'])."&tok=".base64_encode(hash('whirlpool', $row['token']));


            $link = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/camagru/reset.phtml?".$s;
            $message = str_replace("%link%", $link, $message);
            $message = str_replace("%str%", "You are getting this email because you requested<br>a password reset.", $message);
            $message = str_replace("%button%", "reset", $message);


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
            $mail->Subject = "Camagru password reset";
            $mail->msgHTML($message);
            $mail->AddAddress($row['email']);
            $mail->Send();
            exit;
        }
    }
}
header("location: forgot_password.phtml?msg=".base64_encode("no such email in our records"));

?>