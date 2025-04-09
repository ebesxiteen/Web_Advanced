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
        $stmt = $this->connection->prepare($sql);
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

    public function createProduct(Product $product) {
        $sql = "INSERT INTO PRODUCTS (RECIPEID, PRODUCTNAME, PRICE, UNITID) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("isdi", $product->getRecipeId(), $product->getProductName(), $product->getPrice(), $product->getUnitId());

        if ($stmt->execute()) {
            return $this->connection->insert_id; // Trả về ID sản phẩm mới tạo
        } else {
            return false;
        }
    }

    public function updateProduct(Product $product) {
        $sql = "UPDATE PRODUCTS SET RECIPEID = ?, PRODUCTNAME = ?, PRICE = ?, UNITID = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("isdii", $product->getRecipeId(), $product->getProductName(), $product->getPrice(), $product->getUnitId(), $product->getId());

        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM PRODUCTS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
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
    public function searchProducts($keyword, $categoryId, $offset, $limit) {
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