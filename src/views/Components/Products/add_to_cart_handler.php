<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
require_once(__DIR__ . '/../../../controllers/CartDetailController.php');
require_once(__DIR__ . '/../../../controllers/CartController.php');
require_once(__DIR__ . '/../../../controllers/ProductController.php');
require_once(__DIR__ . '/../../../views/Auth/CartProcessor.php');

header('Content-Type: application/json');
ob_start();
// Lấy dữ liệu từ fetch
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['productId'])) {
    echo json_encode(['success' => false]);
    exit;
}
else {
    $productId = (int)$data['productId'];
    $userId = $_SESSION['userId'] ?? null;
    $quantity = 1;
    $cartController = new CartController();
    $productController = new ProductController();
    $cartDetailController = new CartDetailController();
    $cartProcessor = new CartProcessor($cartController, $cartDetailController, $productController);
    $cartDetailController->addItem($cartProcessor->getCart($userId), $productId, $quantity);
    ob_clean();
    echo json_encode(['success' => true]);
    exit;
    
}