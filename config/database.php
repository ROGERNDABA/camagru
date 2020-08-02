<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: ./config/database.php
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
            $this->_conn = new PDO("mysql:host=localhost;host=3307;dbname=camagru", 'root', $password);
            $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->_conn;
    }
}

function db_connect() {
    $password = "rooty2";
    
    $db = new Database();
    $conn = $db->getConnection($password);
    return $conn;
}
