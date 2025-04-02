<?php

require_once 'config/DatabaseConnection.php';
require_once 'models/User.php'; // Đảm bảo bạn đã định nghĩa model User

class UserController {
    private $connection;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->connection = $db->getConnection();
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM USERS";
        $result = $this->connection->query($sql);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = new User(
                    $row['ID'],
                    $row['ACCOUNTID'],
                    $row['FULLNAME'],
                    $row['ADDRESS'],
                    $row['PHONE'],
                    $row['EMAIL'],
                    $row['DATEOFBIRTH']
                );
                $users[] = $user;
            }
        }
        return $users;
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM USERS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new User(
                $row['ID'],
                $row['ACCOUNTID'],
                $row['FULLNAME'],
                $row['ADDRESS'],
                $row['PHONE'],
                $row['EMAIL'],
                $row['DATEOFBIRTH']
            );
        }
        return null;
    }

    public function createUser(User $user) {
        $sql = "INSERT INTO USERS (ACCOUNTID, FULLNAME, ADDRESS, PHONE, EMAIL, DATEOFBIRTH) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("isssss", $user->getAccountId(), $user->getFullName(), $user->getAddress(), $user->getPhone(), $user->getEmail(), $user->getDateOfBirth());

        if ($stmt->execute()) {
            return $this->connection->insert_id; // Trả về ID của user vừa tạo
        } else {
            return false;
        }
    }

    public function updateUser(User $user) {
        $sql = "UPDATE USERS SET ACCOUNTID = ?, FULLNAME = ?, ADDRESS = ?, PHONE = ?, EMAIL = ?, DATEOFBIRTH = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("isssssi", $user->getAccountId(), $user->getFullName(), $user->getAddress(), $user->getPhone(), $user->getEmail(), $user->getDateOfBirth(), $user->getId());

        return $stmt->execute();
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM USERS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function __destruct() {
        $this->connection->close();
    }
}

?>