<?php

class DatabaseConnection {
    private $host = "localhost"; // Thay đổi nếu cần
    private $username = "root"; // Thay đổi bằng tên người dùng MySQL
    private $password = "123456789"; // Thay đổi bằng mật khẩu MySQL
    private $database = "COFFESHOP"; // Tên cơ sở dữ liệu

    protected $connection;

    public function __construct() {
        if (!isset($this->connection)) {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
            // echo"Ket noi thanh cong ";
            if (!$this->connection) {
                echo 'Không thể kết nối đến cơ sở dữ liệu: ' . $this->connection->connect_error;
                exit;
            }
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}

?>