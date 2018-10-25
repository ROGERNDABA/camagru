<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: functions.php
 *
 */
    function check_error(){
        $msg = base64_decode($_GET['msg']);
                            if(isset($_GET['msg']))
                                echo $msg;
                            unset($_GET['msg']);
    }