<?php

require_once (dirname(__FILE__) ."/../config/DatabaseConnection.php");
require_once (dirname(__FILE__)). '/../models/Product.php'; // Đảm bảo bạn đã include file Product.php

class ProductController {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new DatabaseConnection();
        $this->conn = $this->db->getConnection();
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM PRODUCTS";
        
        $result = $this->conn->query($sql);

        $products = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product = new Product(
                    $row['ID'],
                    $row['RECIPEID'],
                    $row['PRODUCTNAME'],
                    $row['PRICE'],
                    $row['UNITID']
                );
                $products[] = $product;
            }
        }
        return $products;
    }

    public function getProductById($id) {
        $sql = "SELECT * FROM PRODUCTS WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Product(
                $row['ID'],
                $row['RECIPEID'],
                $row['PRODUCTNAME'],
                $row['PRICE'],
                $row['UNITID']
            );
        }
        return null;
    }

    public function searchProducts($keyword): array {
        $sql = 'SELECT * FROM PRODUCTS WHERE PRODUCTNAME LIKE ?';
        $stmt = $this->conn->prepare($sql);
    
        if (is_numeric($keyword)) {
            // Nếu $keyword là số, sử dụng kiểu 'i' (integer)
            $stmt->bind_param('i', $keyword);
        } else {
            // Nếu $keyword là chuỗi, sử dụng kiểu 's' (string)
            $keyword = "%" . $keyword . "%"; // Thêm ký tự % cho tìm kiếm LIKE
            $stmt->bind_param('s', $keyword);
        }
    
        if ($stmt->execute()) {
            $result = $stmt->get_result();
    
            $products = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $product = new Product(
                        id: $row['ID'],
                        recipeId: $row['RECIPEID'],
                        productName: $row['PRODUCTNAME'],
                        price: $row['PRICE'],
                        unitId: $row['UNITID']
                    );
                    $products[] = $product;
                }
            }
            
            return $products;
        } else {
            // Xử lý lỗi nếu câu lệnh SQL không thực thi thành công
            return []; 
        }
    }
    public function createProduct($productName,$recipeId,$price,$unitId) {
        try {
            $query = "INSERT INTO PRODUCTS (RECIPEID,PRODUCTNAME,  PRICE, UNITID) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("isdi", $recipeId,$productName,  $price, $unitId);
            // Thực thi truy vấn
            // if ($stmt->execute()) {
            //     echo "Sản phẩm mới đã được tạo thành công.";
            // } else {
            //     echo "Lỗi khi tạo sản phẩm: " . $stmt->error;
            // }

            $result = $stmt->execute();

            // Đóng statement và kết nối
            $stmt->close();

            return $result;
        } catch (PDOException $e) {
            // Ghi log lỗi nếu cần: error_log($e->getMessage());
            echo($e->getMessage());
            return false;
        }
    }

    public function updateProduct(Product $product) {
        $sql = "UPDATE PRODUCTS SET RECIPEID = ?, PRODUCTNAME = ?, PRICE = ?, UNITID = ? WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isdii", $product->getRecipeId(), $product->getProductName(), $product->getPrice(), $product->getUnitId(), $product->getId());

        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $this->conn->begin_transaction();
        try {
            // Xóa các đánh giá sản phẩm trong bảng productreviews
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
    
            // Cuối cùng, xóa sản phẩm khỏi bảng products
            $stmt = $this->conn->prepare("DELETE FROM products WHERE ID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
    
            // Commit transaction nếu tất cả các câu lệnh đều thực hiện thành công
            $this->conn->commit();

            echo "Xóa thanh cong";
            
            return true;
        
        } catch (Exception $e) {
            // Nếu có lỗi xảy ra, rollback toàn bộ transaction
            $this->conn->rollback();
            
            echo "Lỗi khi xóa sản phẩm: " . $e->getMessage();

            return false;
        }
    }
}

?>