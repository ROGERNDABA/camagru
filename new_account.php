<?php
    include("connect.php");
    
    $conn = conOpen();
    $name = stripslashes($_POST['name']);
    $surname  = stripslashes($_POST['surname']);
    $username = stripslashes($_POST['login']);
    $email = stripslashes($_POST['email']);
    $passwd = stripslashes($_POST['passwd']);



    $secret = '6LeaWnYUAAAAABENDEFXRz_h1YtQ7Mg_ErEH10sA';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $response = json_decode($verifyResponse);
   
    if ($response->success == false) {
		$msg = "you must be a robot";
        $msgEncoded = base64_encode($msg);
        header("location:new_account.phtml?msg=".$msgEncoded);
        exit;
    }

    $s = "SELECT username, passwd FROM accounts";
    $q2 = "INSERT INTO `accounts`(`username`,  `passwd`) VALUES (\"$username\", \"$passwd\")";

/////////////////////////////////  CHECK IF ALL FIELDS HAVE BEEN ENETERED ///////////////////////////////////////////


    if (!$_POST['name'] || !$_POST['surname'] || !$_POST['login'] || !$_POST['email'] ||
    !$_POST['passwd']) {
        $msg = "All fields required.";
        $msgEncoded = base64_encode($msg);
        header("location:new_account.phtml?msg=".$msgEncoded);
        exit;
    }
    elseif (strlen($passwd) <= 6) {
            $msg = "password short";
            $msgEncoded = base64_encode($msg);
            header("location:new_account.phtml?msg=".$msgEncoded);
            exit;
    }

/////////////////////////////////  VLAIDATE THE USER EMAIL  /////////////////////////////////////////////////////////


    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email format";
        $msgEncoded = base64_encode($msg);
        header("location:new_account.phtml?msg=".$msgEncoded);
        exit;
    }

/////////////////////////////// MAKE SURE ONLY ALPHABETS AND NUMBERS ///////////////////////////////////////////////

    elseif (!preg_match("/^[a-zA-Z ]*$/", $name) ||
            !preg_match("/^[a-zA-Z ]*$/", $surname) ||
            !preg_match("/^[a-zA-Z ]*$/", $username)) {
        $msg = "Only letters and whitespaces allowed in names or username fields";
        $msgEncoded = base64_encode($msg);
        header("location:new_account.phtml?msg=".$msgEncoded);
        exit;
    }
    else {
        $re = $conn->query($s);
        $msg = "Sorry! Username already taken";
        $msgEncoded = base64_encode($msg);
        while($row = $re->fetch( PDO::FETCH_ASSOC )) {
            if (!strcmp($_POST['login'], "adminunlock")) {
                header("location:new_account.phtml?msg=".$msgEncoded);
                exit();
            }
            else if (!strcmp($row['username'], $username)) {
                header("location:new_account.phtml?msg=".$msgEncoded);
                exit();
            }
        }
    }
    $phone_check = "SELECT username, email FROM accounts";
    $re = $conn->query($phone_check);
    while($row = $re->fetch( PDO::FETCH_ASSOC )) {
        if (!strcmp($row['username'], $username))
        {
            $msg = "Username alrady exists";
            $msgEncoded = base64_encode($msg);
            header("location:new_account.phtml?msg=".$msgEncoded);
            exit();
        }
        elseif (!strcmp($row['email'], $email))
        {
            $msg = "Email alrady exists";
            $msgEncoded = base64_encode($msg);
            header("location:new_account.phtml?msg=".$msgEncoded);
            exit();
        }
    }
    $rand = rand();
    $hash = password_hash($passwd, PASSWORD_DEFAULT);
    $q =    "INSERT INTO `accounts` (`username`, `name`, `surname`, `email`, `passwd`, `token`,`isusr`, `isadmin`)
            VALUES (\"$username\", \"$name\", \"$surname\" , \"$email\", \"$hash\", $rand, '0', \"0\")";
    $re = $conn->query($q);
    $re = null;
    $conn = null;
    header('Location: confirm_email.php?confirm='.base64_encode($email)."&user=".hash('whirlpool', $rand)."&usr=".base64_encode($username));
    ?>