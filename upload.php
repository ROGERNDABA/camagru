<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: upload.php
 *
 */

    include("./config/connect.php");
    

    $conn = conOpen();

    if (isset($_POST['upload'])) {
        // Get image name
        $image = $_FILES['image']['name'];
        // Get text
        // $image_text = $conn->quote($_POST['image_text']);
  
        // image file directory
        $target = "uploads/".basename($image);
  
        $sql = "INSERT INTO images (`pics`) VALUES (?)";
        // execute query
        $re = $conn->prepare($sql);
        $re->bindParam(1, $image, PDO::PARAM_STR);
        $re->execute();
  
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
        }
    }
    header("location: home.phtml");

 ?>