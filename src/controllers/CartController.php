<?php

require_once './../models/Cart.php';


class CartController {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->getConnection();
    }

    public function createCart($userId, $quantity) {
        $sql = "INSERT INTO CARTS (USERID, QUANTITY) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("id", $userId, $quantity);

        if ($stmt->execute()) {
            return new Cart($this->conn->insert_id, $userId, $quantity);
        } else {
            return null;
        }
    }

    public function getCart($id) {
        $sql = "SELECT * FROM CARTS WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Cart($row['ID'], $row['USERID'], $row['QUANTITY']);
        } else {
            return null;
        }
    }

    // Thêm các phương thức khác như updateCart, deleteCart nếu cần
}

?>