<?php

    class DatabaseService {
        private string $host;
        private string $db_name;
        private string $username;
        private string $password;
        private $conn;

        public function __construct(){
            $this->host = 'localhost';
            $this->db_name = 'PayRollDB';
            $this->username = 'root';
            $this->password = '4209';
        }

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            } catch (Exception $e){
                echo 'Connection error: ' . $e->getMessage();
            }
            return $this->conn;
        }


    }
?>