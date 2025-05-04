<?php
header('Content-Type: application/json');

session_start();
// Kết nối database
require_once(__DIR__ . '/../../config/DatabaseConnection.php');

// Import các controller và processor
require_once(__DIR__ . '/../../controllers/CartController.php');
require_once(__DIR__ . '/../../controllers/CartDetailController.php');
require_once(__DIR__ . '/../../controllers/ProductController.php');
require_once(__DIR__ . '/../../views/Auth/CartProcessor.php'); 

header('Content-Type: application/json');

$userId = $_SESSION['userId'] ?? null;
if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit;
}

$discountPercent = isset($_POST['discountPercent']) ? floatval($_POST['discountPercent']) : 0;
$discountId = isset($_POST['discountId']) ? intval($_POST['discountId']) : 0;

$cartProcessor = new CartProcessor(new CartController(), new CartDetailController(), new ProductController());
$products = $cartProcessor->getProductsInCart($userId);
$totalBefore = $cartProcessor->calculateTotalPrice($userId);
$totalAfter = $totalBefore * (1 - $discountPercent / 100);

$db = (new DatabaseConnection())->getConnection();
$db->begin_transaction();

try {
    // Insert order
    if ($discountId <= 0) {
        // Nếu không có mã giảm giá, gán discountId là NULL hoặc 0
        $discountId = NULL;
    }
    $stmt = $db->prepare("INSERT INTO ORDERS (USERID, TOTAL, DATEOFORDER, ORDERSTATUS, DISCOUNTID, PRICEBEFOREDISCOUNT) VALUES (?, ?, CURDATE(), 'PENDING', ?, ?)");
    $stmt->bind_param("iddi", $userId, $totalAfter, $discountId, $totalBefore);
    $stmt->execute();
    $orderId = $stmt->insert_id;

    // Insert order details
    foreach ($products as $entry) {
        $product = $entry['product']; // Lấy đối tượng sản phẩm từ mảng
        $productId = $product->getId();
        $quantity = $entry['quantity'];
        $price = $product->getPrice();
        $total = $price * $quantity;

        $stmtDetail = $db->prepare("INSERT INTO ORDERDETAILS (ORDERID, PRODUCTID, QUANTITY, PRICE, TOTAL) VALUES (?, ?, ?, ?, ?)");
        $stmtDetail->bind_param("iiddd", $orderId, $productId, $quantity, $price, $total);
        $stmtDetail->execute();
    }

    // Clear cart after order placed
    $cartProcessor->clearCart($userId);

    $db->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $db->rollback();
    echo json_encode(['success' => false, 'message' => 'Lỗi khi đặt hàng: ' . $e->getMessage()]);
    // Ghi log lỗi để kiểm tra
    error_log($e->getMessage());
}