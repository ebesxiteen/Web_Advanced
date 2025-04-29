<?php
    session_start();
    require_once __DIR__ . '/../../../config/DatabaseConnection.php';
    require_once __DIR__ . '../../../Auth/CartProcessor.php';
    require_once __DIR__ . '/../../../controllers/CartController.php';
    require_once __DIR__ . '/../../../controllers/CartDetailController.php';
    require_once __DIR__ . '/../../../controllers/ProductController.php';
    $cartController = new CartController();
    $cartDetailController = new CartDetailController();
    $productController = new ProductController();
    $cartDetailController->addItem(11,1,1);
    $cartDetailController->addItem(11,2,1);
    $cartDetailController->addItem(11,4,1);

//     if (isset($_SESSION['userId'])) {
//         echo "User ID tồn tại trong session: " . $_SESSION['userId'];
//     } else {
//         echo "Không tìm thấy userId trong session.";
//     }
//     $userId = $_SESSION['userId'];
    
   
//     $cartProcessor = new CartProcessor($cartController, $cartDetailController, $productController);
//     $products = $cartProcessor->getProductsInCart($userId);
//     $totalPrice = $cartProcessor->calculateTotalPrice($userId);

// print_r($products);
// $productController = new ProductController();
// print_r($totalPrice);
?>
