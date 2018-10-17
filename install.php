<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: install.php
 *
 */
    
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

    $servername = "localhost";
    $username = "root";
    $password = "rooty";

    $db = new Database();
    $conn = $db->getConnection($password);
    
    $conn->query("DROP DATABASE IF EXISTS camagru");
    $sql = "CREATE DATABASE camagru";
    $conn->query($sql);
    $conn->exec("use camagru");

    $conn->query("CREATE TABLE IF NOT EXISTS camagru . accounts (
                username varchar(32) NOT NULL,
                name varchar(32) NOT NULL,
                surname varchar (32) NOT NULL,
                email varchar(30) NOT NULL,
                phone_number varchar(32) NOT NULL,
                ID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                isadmin ENUM('1', '0') NOT NULL)");

    $conn->query("CREATE TABLE IF NOT EXISTS camagru . passwords (username varchar(32) NOT NULL, passwd varchar(32) NOT NULL, usr_exists ENUM('1', '0') NOT NULL, ID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY)");
    $conn->query("INSERT INTO  camagru . passwords (username, passwd, usr_exists) VALUES ('adminunlock', 'dontunlock', '1')");
    $conn->query("INSERT INTO  camagru . accounts (username, name, surname, email, phone_number, isadmin) VALUES ('adminunlock', 'adminunlock', 'adminunlock', 'adminunlock', 'dontunlock', '1')");
    header("Location: index.html");
    $conn->close();
?>