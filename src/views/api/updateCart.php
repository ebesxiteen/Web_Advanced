<?php
error_reporting(0);
ini_set('display_errors', 0);

session_start();
header('Content-Type: application/json');
ob_start();

require_once __DIR__ . '/../../config/DatabaseConnection.php';
require_once __DIR__ . '/../../controllers/CartController.php';
require_once __DIR__ . '/../../controllers/CartDetailController.php';
require_once __DIR__ . '/../../controllers/UserController.php';
require_once __DIR__ . '/../../controllers/ProductController.php';
require_once __DIR__ . '/../../views/Auth/CartProcessor.php';

$userId = $_SESSION['userId'] ?? null;

// Kiểm tra nếu thiếu dữ liệu
if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Chưa có userId trong session']);
    exit;
}

try {
    // Tạo các đối tượng cần thiết
    $cartController = new CartController();
    $cartDetailController = new CartDetailController();
    $productController = new ProductController();
    $cartProcessor = new CartProcessor($cartController, $cartDetailController, $productController);
    $cart = $cartProcessor->getCart($userId);
    $totalQuantity = $cart->getQuantity();
    // Trả về kết quả JSON hợp lệ
    $debugOutput = ob_get_clean();
if (!empty($debugOutput)) {
    file_put_contents('debug_output.txt', $debugOutput);
}
    echo json_encode([
        'success' => true,
        'totalQuantity' => $totalQuantity
    ]);
} catch (Exception $e) {
    // Xử lý lỗi trong trường hợp có ngoại lệ
    echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
}
?>