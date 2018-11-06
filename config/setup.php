<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: install.php
 *
 */

    session_start();
    session_destroy();
    unset($_SESSION);
    if(!isset($_GET['login'])) {
        echo '<script type="text/javascript"> 
        var value = prompt("Input a value", "");
        window.location.href = "setup.php?login="+encodeURIComponent(value);
        </script>';
    }
    
    class Database {

        private $_conn = null;

        public function getConnection($password) {
            if (!is_null($this->_conn)) {
                return $this->_conn;
            }
            $this->_conn = false;
            try {
                $this->_conn = new PDO("mysql:host=localhost;", 'root', $password);
                $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            return $this->_conn;
        }
    }

    if (isset($_GET['login'])) {
        $servername = "localhost";
        $username = "root";
    $password = $_GET['login'];
        $database = 'camagru';
        
        $db = new Database();
        $conn = $db->getConnection($password);
        
        $conn->query("DROP DATABASE camagru");
        
        $conn->query('CREATE DATABASE camagru');
        
        $conn->query("use camagru");
        
        $pw = password_hash('dontunlock', PASSWORD_DEFAULT);
        $tok = rand();
        $conn->query("CREATE TABLE IF NOT EXISTS camagru . accounts (
                username varchar(32) NOT NULL,
                name varchar(32) NOT NULL,
                surname varchar (32) NOT NULL,
                email varchar(255) NOT NULL,
                passwd varchar(255) NOT NULL,
                token INT NOT NULL,
                isusr ENUM('1', '0') NOT NULL,
                isadmin ENUM('1', '0') NOT NULL)");
    $conn->query("INSERT INTO  camagru . accounts (username, name, surname, email, passwd, token, isusr, isadmin)
                VALUES ('adminunlock', 'adminunlock', 'adminunlock', 'dontunlock', \"$pw\", $tok, '1', '1')");
    $conn->query("CREATE TABLE IF NOT EXISTS `camagru`. `images` ( `pic` LONGBLOB NULL DEFAULT NULL,
                                                                    `username` varchar(32) NOT NULL,
                                                                    `public` ENUM('1', '0') NOT NULL,
                                                                    `likes` INT NOT NULL, 
                                                                    `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                                                    `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY)ENGINE = InnoDB;");
    $conn->query('CREATE TABLE IF NOT EXISTS `camagru`.`comments` ( `madeby` VARCHAR(30) NULL DEFAULT NULL , 
                                                                    `comment` VARCHAR(200) NULL DEFAULT NULL,
                                                                    `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                                                    `ID` INT NOT NULL) ENGINE = InnoDB;');
    header("Location: ../index.html");
    $conn = null;
}
?>
