<?php
require_once __DIR__ . '/../config/DatabaseConnection.php';
require_once __DIR__ . '/../models/Account.php';

class AccountController
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new DatabaseConnection();
        $this->conn = $this->db->getConnection();
    }

    public function getAccountById($id)
    {
        $sql = "SELECT * FROM ACCOUNTS WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return new Account($row['ID'], $row['USENAME'], $row['PASSWORD']);
        }
        $stmt->close();
        return null;
    }

    public function createAccount(Account $account)
    {
        $sql = "INSERT INTO ACCOUNTS (USENAME, PASSWORD) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $account->getUsername(), $account->getPassword());

        if ($stmt->execute()) {
            $id = $this->conn->insert_id;
            $stmt->close();
            return $id;
        }
        $stmt->close();
        return false;
    }

    public function updateAccount(Account $account)
    {
        $sql = "UPDATE ACCOUNTS SET USENAME = ?, PASSWORD = ? WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $account->getUsername(), $account->getPassword(), $account->getId());

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function deleteAccount($id)
    {
        $sql = "DELETE FROM ACCOUNTS WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function getAllAccounts()
    {
        $sql = "SELECT * FROM ACCOUNTS";
        $result = $this->conn->query($sql);
        $accounts = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $accounts[] = new Account($row['ID'], $row['USENAME'], $row['PASSWORD']);
            }
        }
        return $accounts;
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM ACCOUNTS WHERE USENAME = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            error_log("Found user: " . print_r($row, true));

            // Kiểm tra mật khẩu bằng password_verify
            if (password_verify($password, $row['PASSWORD'])) {
                $stmt->close();
                return new Account($row['ID'], $row['USENAME'], $row['PASSWORD']);
            } else {
                error_log("Mật khẩu không khớp.");
            }
        } else {
            error_log("Không tìm thấy user với username: $username");
        }

        $stmt->close();
        return null;
    }


    public function register($username, $password)
    {
        $sql = "SELECT * FROM ACCOUNTS WHERE USENAME = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $stmt->close();
            return "Tài khoản đã tồn tại!";
        }

        // Hash mật khẩu trước khi lưu vào database
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        error_log("Hashed password for $username: $hashedPassword");

        $sql = "INSERT INTO ACCOUNTS (USENAME, PASSWORD) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashedPassword);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }
}