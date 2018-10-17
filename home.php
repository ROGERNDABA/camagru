<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: home.php
 *
 */
    session_start();
    echo "<pre>";
    print_r($_SESSION);
    echo session_id();
    echo "</pre>";
    header("Location: home.html");

?>