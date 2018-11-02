<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: comments.php
 *
 */
    include('connect.php');
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
        var_dump($_POST);
    }
 ?>