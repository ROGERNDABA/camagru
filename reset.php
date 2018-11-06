<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: reset.php
 *
 */
include ("./config/database.php");
session_start();

    $conn = db_connect();

    if (isset($_POST) && isset($_GET)) {
        $username = base64_decode($_GET['usr']);
        $token = base64_decode($_GET['tok']);
        $passwd = $_POST['passwd1'];

        $q = "SELECT `username`, `isusr`, `token`, `passwd` FROM `accounts`";
        $re = $conn->query($q);
        while ($row = $re->fetch(PDO::FETCH_ASSOC)) {

            if ($username = $row['username'] && hash("whirlpool", $row['token']) === $token &&
                $row['isusr'] == '1') {
                    if ($passwd === $row['passwd']) {
                        header("location: reset.phtml?usr=".$_GET['usr']."&tok=".$_GET['tok']."&msg=".base64_encode('password can\'t be the same as old password'));
                        exit;
                    }
                    $hash = password_hash($passwd, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE `accounts` SET `passwd`= :passwd");
                    $stmt->execute(array(':passwd' => $hash));
                    if ($stmt) {
                        if (isset($_SESSION))
                            session_destroy();
                        header("location: login.phtml?msgv=".base64_encode("password successfuly changed :)"));
                    }
            }
        }
    }

?>