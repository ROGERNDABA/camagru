<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: get_pictures.php
 *
 */
    include ('connect.php');
    session_start();
    $conn = conOpen();
    // print_r($_SESSION);
    $i = 1;
    $headers = getallheaders();
    if ($headers["Content-type"] == "application/json") {
        $_POST = json_decode(file_get_contents("php://input"), true);
        if (isset($_SESSION) && isset($_SESSION['user'])) {
            $stmt = $conn->prepare("SELECT `pic`, `likes`, `username`, `ID` FROM `images` ORDER BY `create_date` DESC LIMIT ?, ?");
            if ($_POST['step'] == 1) {
                $start = $_SESSION['start'];
                $end = $start + 1;
                $_SESSION['start'] += 1;
            } else {
                $end = $_SESSION['start'];
                $start = $end - 1;
                $_SESSION['start'] -= 1;
            }
            if ($_SESSION['start'] >= 5) {
                $stmt->bindParam(1, $start, PDO::PARAM_INT);
                $stmt->bindParam(2, $end, PDO::PARAM_INT);
                $stmt->execute();
                while (($row = $stmt->fetch(PDO::FETCH_ASSOC))) {
                    echo '<div class="imge"><img id="'.$row['ID'].'" src="data:image/png;base64,'.$row['pic'].'" style="height:90%;cursor:pointer" alt=""></div>';
                }
            }
        }
    }
?>