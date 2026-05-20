<?php

class Database {

    private string $host = "localhost";
    private string $dbname = "preesync";
    private string $username = "root";
    private string $password = "";

    private PDO $conn;

    public function connect(): PDO
    {
        try {

            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $this->conn;

        } catch (PDOException $e) {

            die("Connection failed : " . $e->getMessage());
        }
    }
}