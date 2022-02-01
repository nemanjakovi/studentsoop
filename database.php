<?php
include_once "config.php";
class Database
{
    public $conn;

    public function __construct()
    {

        $this->connection();
    }
    // Connection method
    private function connection()
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_errno) {
            echo "Faild to connect";
            exit();
        } else {
            return $this->conn;
        }
    }
}
$db = new Database();
