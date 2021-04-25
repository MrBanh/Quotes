<?php
  class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $dsn;
    private $conn;

    public function __construct(){
        $this->host = getenv('SQL_HOST') ? getenv('SQL_HOST') : 'localhost';
        $this->dbname = getenv('SQL_DB') ? getenv('SQL_DB') : 'quotesdb';
        $this->username = getenv('SQL_USER') ? getenv('SQL_USER') : 'root';
        $this->password = getenv('SQL_PW') ? getenv('SQL_PW') : '';
        $this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
    }

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO($this->dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}