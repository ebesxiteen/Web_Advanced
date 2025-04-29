<?php
require_once(__DIR__ . '/../config/DatabaseConnection.php');
require_once(__DIR__ . '/../models/Product.php');


class ProductController {
    private $connection;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->connection = $db->getConnection();
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM PRODUCTS";
        $result = $this->connection->query($sql);

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
        $stmt = $this->connection->prepare($sql);
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
        $stmt = $this->connection->prepare($sql);

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
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("isdsi", $recipeId, $productName, $price, $linkImage, $unitId);
        $result = $stmt->execute();
        if($result) {
            $productId = $this->connection->insert_id;
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
        $stmt = $this->connection->prepare($sql);
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
        $this->connection->begin_transaction();
        try {
            // Xóa đánh giá sản phẩm trong bảng productreviews
            $stmt = $this->connection->prepare("DELETE FROM productreviews WHERE PRODUCTID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
    
            // Xóa sản phẩm khỏi giỏ hàng trong bảng cartdetails
            $stmt = $this->connection->prepare("DELETE FROM cartdetails WHERE PRODUCTID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
    
            // Xóa sản phẩm khỏi đơn hàng trong bảng orderdetails
            $stmt = $this->connection->prepare("DELETE FROM orderdetails WHERE PRODUCTID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
    
            // Cuối cùng, xóa sản phẩm khỏi bảng PRODUCTS
            $stmt = $this->connection->prepare("DELETE FROM PRODUCTS WHERE ID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
    
            // Commit transaction nếu tất cả câu lệnh đều thực hiện thành công
            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            // Nếu có lỗi, rollback transaction
            $this->connection->rollback();
            echo "Lỗi khi xóa sản phẩm: " . $e->getMessage();
            return false;
        }
    }

    // Phân trang
    public function getProductsByPage($offset, $limit) {
        $sql = "SELECT * FROM PRODUCTS LIMIT ?, ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
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

        return $products;
    }


    public function getTotalProducts() {
        $sql = "SELECT COUNT(*) as total FROM PRODUCTS";
        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    // Tìm kiếm theo từ khóa
    public function searchProduct($keyword, $categoryId, $offset, $limit) {
        $keyword = '%' . $keyword . '%';

        if ($categoryId == 0) {
            $sql = "SELECT * FROM PRODUCTS WHERE PRODUCTNAME LIKE ? LIMIT ?, ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("sii", $keyword, $offset, $limit);
        } else {
            $sql = "SELECT * FROM PRODUCTS WHERE PRODUCTNAME LIKE ? AND CATEGORYID = ? LIMIT ?, ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("siii", $keyword, $categoryId, $offset, $limit);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
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

        return $products;
    }


    public function countSearchProducts($keyword, $categoryId) {
        $keyword = '%' . $keyword . '%';

        if ($categoryId == 0) {
            $sql = "SELECT COUNT(*) as total FROM PRODUCTS WHERE PRODUCTNAME LIKE ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("s", $keyword);
        } else {
            $sql = "SELECT COUNT(*) as total FROM PRODUCTS WHERE PRODUCTNAME LIKE ? AND CATEGORYID = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("si", $keyword, $categoryId);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }


    // Lọc theo danh mục
    public function getProductsByCategory($categoryId, $offset, $limit) {
        if ($categoryId == 0) {
            return $this->getProductsByPage($offset, $limit);
        }

        $sql = "SELECT * FROM PRODUCTS WHERE CATEGORYID = ? LIMIT ?, ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("iii", $categoryId, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
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
        return $products;
    }

    public function countProductsByCategory($categoryId) {
        if ($categoryId == 0) {
            return $this->getTotalProducts();
        }

        $sql = "SELECT COUNT(*) as total FROM PRODUCTS WHERE CATEGORYID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function getAllCategories() {
        require_once(__DIR__ . '/../models/Category.php');
        $sql = "SELECT * FROM CATEGORIES";
        $result = $this->connection->query($sql);

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $category = new Category($row['ID'], $row['CATEGORYNAME']);
            $categories[] = $category;
        }
        return $categories;
    }

    // Lấy danh sách đánh giá theo ID
    public function getReviewsByProductId($productId) {
        $sql = "SELECT * FROM PRODUCTREVIEWS WHERE PRODUCTID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAverageRating($productId) {
        $sql = "SELECT AVG(RATING) as average FROM PRODUCTREVIEWS WHERE PRODUCTID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return round($result['average'] ?? 0, 1);
    }

}

?>