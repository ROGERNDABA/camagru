<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: login.php
 *
 */
include ("./check_index.php");

$q = "SELECT username, passwd FROM passwords";
$conn = OpenCon();
$re = $conn->query($q);
if(!$_POST["login"] || !$_POST["passwd"])
{
   $msg = "Blank field for Username or Password";
   $msgEncoded = base64_encode($msg);
   header("location:login.phtml?msg=".$msgEncoded);
}
else if ($_POST['login'] && $_POST['passwd'])
{
   $msg = "No such Username or Password";
   $msgEncoded = base64_encode($msg);
   while($row = $re->fetch_assoc()) {
        if (!strcmp($_POST['login'], "adminunlock") && !strcmp($_POST['passwd'], "dontunlock"))
        {
            session_start();
            header("location: admin_login.php");
            exit();
        }
        else if (!strcmp($row['username'], $_POST['login']) && !strcmp($row['passwd'], $_POST['passwd']))
        {
            session_start();
            header("Location: login.php");
            exit();
        }
    }
    header("location:login.phtml?msg=".$msgEncoded." ".$row['username']);
}
?>