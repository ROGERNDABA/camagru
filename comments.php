<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: comments.php
 *
 */
            
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
    include('./config/connect.php');
    session_start();

    $conn = conOpen();
    $headers = getallheaders();
    if ($headers["Content-type"] == "application/json") {
        $_POST = json_decode(file_get_contents("php://input"), true);
        
        $madeby = $_POST['madeby'];
        $comment = $_POST['comment'];
        $id = intval($_POST['id']);
        
        $stmt = $conn->prepare("INSERT INTO `comments` (`madeby`, `comment`, `ID`)
                            VALUES (:madeby, :comment, :id)");
        $stmt->execute(array(   ':madeby' => $madeby,
                                ':comment'=> $comment,
                                'id'      => $id)
                            );
        $stmt = $conn->prepare("SELECT `username` FROM `images` WHERE `ID` = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $row['username'];
        
        $stmt = $conn->prepare("SELECT `email` FROM `accounts` WHERE `username` = :username");
        $stmt->execute(array(':username' => $username));        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $row['email'];
                            
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
        $mail->Subject = "new comment alert";
        $mail->Body = "comment in one of your photos.<br>From: ".$madeby." - <br><i style='color:red'>".$comment."</i><br>";
        $mail->AddAddress($email);

         if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
         } else {
            echo "Message has been sent";
         }
            var_dump($_POST);
        }
 ?>