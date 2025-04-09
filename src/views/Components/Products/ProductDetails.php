<?php
require_once(__DIR__ . '/../../../controllers/ProductController.php');
$controller = new ProductController();

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = $controller->getProductById($productId);

if (!$product) {
    echo "<div class='text-center mt-5'>Không tìm thấy sản phẩm.</div>";
    return;
}
else {
    $reviews = $controller->getReviewsByProductId($productId);
    $averageRating = $controller->getAverageRating($productId);
}
?>

<div class="container-detail-product-div">
    <div class="container-div-child-detail-product">
        <div class="row coffeeHavenBox">
            <!-- Product Image -->
            <div class="col-md-6 text-center">
                <div class="div-left-image-details">
                    <img src="https://s3-alpha-sig.figma.com/img/9b31/09fe/a3f7dde1ca708f2c4ff41c40e89a8ada?Expires=1743984000&Key-Pair-Id=APKAQ4GOSFWCW27IBOMQ&Signature=sXinrfh~ykVnshcd7ya7kV3jGptZUi40kpL2Da~p2hj7ccMVOdccy5RLFvnZUvvVxixTV~q~NR4iCNLeaD1M2zF64mpktpDEOF5w2tv0kxjeYq0urQDG-zYZzFkXshaQFmBvnxp-rfFvgeRbs4mgt-qkiHhNzYUUygT6DW1QZUk-VNl0Hl1jBBKI1KWeZQSLyjNx1omNJbwcqekauJbp~R~sxNs5El613UoGl9t2hSLkhrI5zOKpWfIkQZ6yvzo5rJvm~xmFe6ynYIZVsmVf2aRkyAZQy4bdgxyvJvi1iGX7qHX3XURe5D6YOkjEdwSLt6Opfzn3c10PKB4BtwjfZg__"
                        alt="<?= htmlspecialchars($product->getProductName()) ?>" class="beanSnap">
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <h1 class="brewMasterTitle"><?= htmlspecialchars($product->getProductName()) ?></h1>

                <div class="starBrew mb-3">
                    <?php
                        $fullStars = floor($averageRating);
                        $halfStar = ($averageRating - $fullStars >= 0.5) ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;

                        for ($i = 0; $i < $fullStars; $i++) echo '<i class="fas fa-star"></i>';
                        if ($halfStar) echo '<i class="fas fa-star-half-alt"></i>';
                        for ($i = 0; $i < $emptyStars; $i++) echo '<i class="far fa-star"></i>';
                        ?>
                    <span class="ms-2"><?= count($reviews) ?> Đánh giá</span>
                </div>


                <!-- Coffee Type Selection -->
                <div class="mb-3">
                    <span class="fw-bold">Tùy chọn</span><br>
                    <button class="flavorTwist active">Thêm sữa</button>
                    <button class="flavorTwist">Đá thêm</button>
                    <button class="flavorTwist">Size</button>
                </div>

                <!-- Quantity Selector -->
                <div class="mb-3">
                    <span class="fw-bold">Số lượng</span><br>
                    <div class="cupCounter" style="display: flex; align-items: center; gap: 5px;">
                        <button
                            style="padding: 4px 10px; font-size: 16px; border: 1px solid #ccc; background-color: #f0f0f0; border-radius: 4px; cursor: pointer;">-</button>
                        <input type="text" value="1" readonly
                            style="width: 40px; text-align: center; font-size: 16px; padding: 4px; border: 1px solid #ccc; border-radius: 4px;">
                        <button
                            style="padding: 4px 10px; font-size: 16px; border: 1px solid #ccc; background-color: #f0f0f0; border-radius: 4px; cursor: pointer;">+</button>
                    </div>
                </div>


                <!-- Tabs -->
                <div class="coffeeTabs">
                    <div class="tabSip active">Mô tả</div>
                    <div class="tabSip">Chi tiết sản phẩm</div>
                    <div class="tabSip">Đánh giá</div>
                </div>

                <!-- Description -->
                <div class="description mb-4">
                    <p><?= nl2br(htmlspecialchars("DATABASE THIẾU PHẦN MÔ TẢ SẢN PHẨM????")) ?></p>
                </div>

                <!-- Price and Add to Cart -->
                <div class="d-flex align-items-center mb-3">
                    <span class="oldBrewPrice">$<?= number_format($product->getPrice() * 1.2, 2) ?></span>
                    <span class="freshBrewPrice">$<?= number_format($product->getPrice(), 2) ?></span>
                </div>

                <div class="d-flex align-items-center">
                    <button class="cartRoast me-3"><i class="fas fa-plus me-2"></i>Thêm vào giỏ hàng</button>
                    <button class="wishSip"><i class="fa-solid fa-heart"></i></button>
                </div>

                <!-- Shipping Info -->
                <div class="deliveryPerk mt-3">
                    <i class="fas fa-truck me-2"></i> Giao hàng
                </div>
            </div>
        </div>
    </div>
</div>