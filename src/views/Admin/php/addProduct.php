<?php
include __DIR__ ."/../../../controllers/ProductController.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_name = $_POST['product_name'] ?? '';
    $product_price = $_POST['final_price'] ?? '';
    $product_recipe = $_POST['recipe'] ?? '';
    $product_unit = $_POST['unit'] ?? '';

    $productController = new ProductController();
    
    if( $productController->createProduct($product_name,  $product_recipe,$product_price, $product_unit)) {
        echo '<script>
        alert("Thêm Thanh Cong");
        </script>';
        header("Location: ../../Admin/index.php");
    }
    else {
        echo '<script>
        alert("Thêm Thái Bài");
        </script>';
        header("Location: ../../Admin/index.php");
    }   
}   
?>