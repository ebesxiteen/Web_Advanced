<?php
    include __DIR__ ."/../../../controllers/ProductController.php";

    $productController = new ProductController();

    // Chỉ xử lý nếu form được submit bằng POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
    // Lấy id sản phẩm từ form
    $id = $_POST['id'];


    $result = $productController->deleteProduct($id);

    
    if ($result) {
        echo "<script>console.log('Xóa thanh cong')</script>";
    } else {
        echo "<script>console.log('Xóa khong thanh cong')</script>";
    }

    // Chuyển hướng về trang danh sách sản phẩm sau khi xóa thành công
    header("Location: ../../Admin/index.php");
    // exit();

}
?>