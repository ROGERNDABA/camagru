<?php
    include('connect.php');
    session_start();
    $conn = conOpen();
    if (isset($_SESSION) && isset($_SESSION['user'])) {
        $stmt = $conn->prepare("SELECT `comment`, `madeby` FROM `comments` WHERE `ID` = :id ORDER BY `create_date` DESC");
        $id = intval($_GET['id']);
        $stmt->execute(array(':id' => $id));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<ul><li><span style="color:red">'.$row['madeby'].' - </span>'.$row['comment'].'</li></ul>';
        }
    }
?>