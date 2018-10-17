<?php
    include("connect.php");
    
    $conn = conOpen();
    $name = $_POST['name'];
    $surname  = $_POST['surname'];
    $username = $_POST['login'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];

    $s = "SELECT username, passwd FROM passwords";
    $q2 = "INSERT INTO `passwords`(`username`,  `passwd`) VALUES (\"$username\", \"$passwd\")";

/////////////////////////////////  CHECK IF ALL FIELDS HAVE BEEN ENETERED ///////////////////////////////////////////


    if (!$_POST['name'] || !$_POST['surname'] || !$_POST['login'] || !$_POST['email'] ||
    !$_POST['passwd'] || !$_POST['phone_number']) {
        $msg = "All fields required.";
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

///////////////////////////// MAKE SURE IT'S A VALID SOUTH AFRICAN NUMBER /////////////////////////////////////////

    elseif (!preg_match("/^(\+27|27)?(\()?0?[87][23467](\))?( |-|\.|_)?(\d{3})( |-|\.|_)?(\d{4})/", $phone_number)) {
        $msg = "Uknown phone number type"; 
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
            header("location:new_account.phtml?msg=".$msgEncoded);
            exit();
        }
        elseif (!strcmp($row['email'], $email))
        {
            $msg = "Email alrady exists";
            header("location:new_account.phtml?msg=".$msgEncoded);
            exit();
        }
    }
    $q =    "INSERT INTO `accounts` (`username`, `name`, `surname`, `email`, `phone_number`, `isadmin`)
            VALUES (\"$username\", \"$name\", \"$surname\" , \"$email\", \"$phone_number\", \"0\")";
    $re = $conn->query($q);
    $q = "INSERT INTO `passwords` (`username`, `passwd`, `usr_exists`) VALUES (\"$username\", \"$passwd\", \"0\")";
    $re = $conn->query($q);
    header('Location: confirm_email.php?confirm='.base64_encode($email."1"));
    ?>