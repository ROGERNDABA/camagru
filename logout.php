<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: logout.php
 *
 */

    session_start();
    session_destroy();
    unset($_SESSION);
    header("location: public.phtml?bye=good bye");
 ?>