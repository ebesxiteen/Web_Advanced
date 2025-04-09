<?php
// File: ProductController.php

require_once dirname(__FILE__) . "/../config/DatabaseConnection.php";
require_once dirname(__FILE__) . '/../models/Product.php';

class ProductController {
    private $db;
    private $conn;

    public function __construct() {
        // Khởi tạo kết nối CSDL từ lớp DatabaseConnection
        $this->db = new DatabaseConnection();
        $this->conn = $this->db->getConnection();
    }

    // Lấy danh sách tất cả sản phẩm
    public function getAllProducts() {
        $sql = "SELECT * FROM PRODUCTS";
        $result = $this->conn->query($sql);

        $products = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product = new Product(
                    $row['ID'],
                    $row['RECIPEID'],
                    $row['PRODUCTNAME'],
                    $row['PRICE'],
                    $row['LINKIMAGE'] ?? null, // Nếu có cột LINKIMAGE
                    $row['UNITID']
                );
                $products[] = $product;
            }
        }
        return $products;
    }

    // Lấy thông tin sản phẩm theo id
    public function getProductById($id) {
        $sql = "SELECT * FROM PRODUCTS WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Product(
                $row['ID'],
                $row['RECIPEID'],
                $row['PRODUCTNAME'],
                $row['PRICE'],
                $row['LINKIMAGE'] ?? null,
                $row['UNITID']
            );
        }
        return null;
    }

    // Tìm sản phẩm theo từ khóa (có hỗ trợ tìm kiếm số hoặc chuỗi)
    public function searchProducts($keyword): array {
        $sql = "SELECT * FROM PRODUCTS WHERE PRODUCTNAME LIKE ?";
        $stmt = $this->conn->prepare($sql);

        // Nếu $keyword là số, ta vẫn sử dụng LIKE (không bind kiểu integer)
        $keyword = "%" . $keyword . "%";
        $stmt->bind_param("s", $keyword);
    
        $products = [];
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $product = new Product(
                        $row['ID'],
                        $row['RECIPEID'],
                        $row['PRODUCTNAME'],
                        $row['PRICE'],
                        $row['LINKIMAGE'] ?? null,
                        $row['UNITID']
                    );
                    $products[] = $product;
                }
            }
        }
        return $products;
    }

    // Thêm sản phẩm mới vào CSDL
    public function createProduct($productName, $recipeId, $price,$linkImage, $unitId) {

        $sql = 'INSERT INTO PRODUCTS (RECIPEID, PRODUCTNAME, PRICE, LINKIMAGE, UNITID) VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isdsi", $recipeId, $productName, $price, $linkImage, $unitId);
        $result = $stmt->execute();
        if($result) {
            $productId = $this->conn->insert_id;
            $stmt->close();
            return $productId;
        } else {
        
            $stmt->close();
            return false;
        }
        
    }

    // Cập nhật thông tin sản phẩm
    public function updateProduct($recipeId,$productName, $price,$linkImage, $unitId, $id) {
        $sql = "UPDATE PRODUCTS SET RECIPEID = ?, PRODUCTNAME = ?, PRICE = ?, LINKIMAGE = ?, UNITID = ? WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isdsii",$recipeId,$productName, $price, $linkImage, $unitId, $id);
        $result = $stmt->execute();
        if($result) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    // Xóa sản phẩm theo id (bao gồm xóa các dữ liệu liên quan trong các bảng khác)
    public function deleteProduct($id) {
        $this->conn->begin_transaction();
        try {
            // Xóa đánh giá sản phẩm trong bảng productreviews
            $stmt = $this->conn->prepare("DELETE FROM productreviews WHERE PRODUCTID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
    
            // Xóa sản phẩm khỏi giỏ hàng trong bảng cartdetails
            $stmt = $this->conn->prepare("DELETE FROM cartdetails WHERE PRODUCTID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
    
            // Xóa sản phẩm khỏi đơn hàng trong bảng orderdetails
            $stmt = $this->conn->prepare("DELETE FROM orderdetails WHERE PRODUCTID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
    
            // Cuối cùng, xóa sản phẩm khỏi bảng PRODUCTS
            $stmt = $this->conn->prepare("DELETE FROM PRODUCTS WHERE ID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
    
            // Commit transaction nếu tất cả câu lệnh đều thực hiện thành công
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Nếu có lỗi, rollback transaction
            $this->conn->rollback();
            echo "Lỗi khi xóa sản phẩm: " . $e->getMessage();
            return false;
        }
    }
}
?>