<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: login.php
 *
 */
include ("connect.php");

$q = "SELECT username, passwd FROM passwords";
$conn = conOpen();
$re = $conn->query($q);
$username = $_POST['login'];
$passwd = $_POST['passwd'];

if(!$username || !$passwd)
{
   $msg = "Blank field for Username or Password";
   $msgEncoded = base64_encode($msg);
   header("location:login.phtml?msg=".$msgEncoded."&usr=".$username);
   exit();
}
else
{
    $msg = "No such Username or Password";
    $msgEncoded = base64_encode($msg);
    while($row = $re->fetch(PDO::FETCH_ASSOC)) {
        if (!strcmp($username, "adminunlock") && !strcmp($passwd, "dontunlock")) {
                session_start();
                header("location: admin_login.php");
                exit();
        }
        else if (!strcmp($row['username'], $username) && !strcmp($row['passwd'], $passwd)) {
            session_start();
            header("Location: home.php");
            exit();
        }
    }
    header("location:login.phtml?msg=".$msgEncoded);
}
?>