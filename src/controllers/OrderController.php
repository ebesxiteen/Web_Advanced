<?php

require_once './../models/Order.php';
require_once '../config/DatabaseConnection.php';

class OrderController {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->getConnection();
    }

    public function createOrder($userId, $total, $dateOfOrder, $discountId,$priceBeforeDiscount) {
        $sql = "INSERT INTO ORDERS (USERID, TOTAL, DATEOFORDER, DISCOUNTID,PRICEBEFOREDISCOUNT) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("idss", $userId, $total, $dateOfOrder, $discountId,$priceBeforeDiscount);

        if ($stmt->execute()) {
            return new Order($this->conn->insert_id, $userId, $total, $dateOfOrder, 'PENDING', $discountId,$priceBeforeDiscount); // Mặc định trạng thái là PENDING
        } else {
            return null;
        }
    }

    public function getOrder($id) {
        $sql = "SELECT * FROM ORDERS WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Order($row['ID'], $row['USERID'], $row['TOTAL'], $row['DATEOFORDER'], $row['ORDERSTATUS'], $row['DISCOUNTID'],$row['PRICEBEFOREDISCOUNT']);
        } else {
            return null;
        }
    }

    public function updateOrderStatus($id, $status) {
        $sql = "UPDATE ORDERS SET ORDERSTATUS = ? WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Thêm các phương thức khác như updateOrder, deleteOrder nếu cần
}

?>