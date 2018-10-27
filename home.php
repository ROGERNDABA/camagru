<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: home.php
 *
 */
    session_destroy();
    session_start();
    print_r($_SESSION);
    header("Location: home.phtml");

?>