<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: insert.php
 *
 */
    include('./resizeClass.php');
    include('./config/database.php');
    session_start();

    $s    = $_POST['src'];
    $sx   = intval($_POST['x']);
    $sy   = intval($_POST['y']);
    $sw   = intval($_POST['w']);
    $sh   = intval($_POST['h']);
    $dh   = intval($_POST['dh']);
    $dw    =intval($_POST['dw']);
    $d      = str_replace("data:image/png;base64,","",$_POST['dst']);

    $src = imagecreatefromstring(resizeImage($s, $sw,$sh));
    $dst = imagecreatefromstring(resizeImage( $_POST['dst'], $dw, $dh));
    imagecopyresampled($dst, $src, $sx, $sy, 0, 0,  imagesx($src), imagesy($src), imagesx($src), imagesy($src));
    ob_start();
        imagepng($dst);
        $img_data = ob_get_contents();
    ob_end_clean();
    
    $conn = db_connect();
    $image = base64_encode($img_data);
    $likes = 0;
    $public = '0';
    $username = $_SESSION['user'];
    $stmt = $conn->prepare("INSERT INTO `images` (`pic`, `likes`, `public`, `username`)
                            VALUES (:pic, :likes, :public, :username)");
    $stmt->execute(array(
                        ':pic'=> $image,
                        ':likes'=> $likes,
                        ':public'=> $public,
                        ':username'=> $username)
                        );

    imagedestroy($dst);
    
    ?>