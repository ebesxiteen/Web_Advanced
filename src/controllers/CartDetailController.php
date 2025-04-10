<?php

require_once './../models/CartDetail.php';


class CartDetailController {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->getConnection();
    }

    public function createCartDetail($cartId, $productId, $quantity) {
        $sql = "INSERT INTO CARTDETAILS (CARTID, PRODUCTID, QUANTITY) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iid", $cartId, $productId, $quantity);

        if ($stmt->execute()) {
            return new CartDetail($cartId, $productId, $quantity);
        } else {
            return null;
        }
    }

    public function getCartDetail($cartId, $productId) {
        $sql = "SELECT * FROM CARTDETAILS WHERE CARTID = ? AND PRODUCTID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $cartId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new CartDetail($row['CARTID'], $row['PRODUCTID'], $row['QUANTITY']);
        } else {
            return null;
        }
    }

    // Thêm các phương thức khác như updateCartDetail, deleteCartDetail nếu cần
}

?>