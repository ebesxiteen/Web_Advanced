<?php
require_once(__DIR__ . '/../../../controllers/ProductController.php');
require_once(__DIR__ . '/../../../models/Category.php');

$controller = new ProductController();

// Lấy tham số từ URL
$keyword = $_GET['search'] ?? '';
$categoryId = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$pg = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
$limit = 6;
$offset = ($pg - 1) * $limit;

// Lấy danh sách danh mục
$categories = $controller->getAllCategories();

// Xử lý lọc/tìm kiếm/phân trang
if (!empty($keyword)) {
    $products = $controller->searchProducts($keyword, $categoryId, $offset, $limit);
    $totalProducts = $controller->countSearchProducts($keyword, $categoryId);
} elseif ($categoryId > 0) {
    $products = $controller->getProductsByCategory($categoryId, $offset, $limit);
    $totalProducts = $controller->countProductsByCategory($categoryId);
} else {
    $products = $controller->getProductsByPage($offset, $limit);
    $totalProducts = $controller->getTotalProducts();
}

$totalPages = ceil($totalProducts / $limit);
?>

<div class="spacing">
    <div class="container text-dark text-center">
        <div class="text-center">
            <h1 class="menu-div-h1 fs-1 mb-3">MENU HÔM NAY</h1>
            <h5 class="menu-div-h5 fs-4 mb-4 fw-bold text-dark">Xem món hôm nay</h5>
        </div>

        <!-- Tìm kiếm -->
        <form method="GET" action="" class="search-container mb-4">
            <input type="hidden" name="pg" value="<?= $pg ?? 1 ?>">
            <input type="hidden" name="category" value="<?= $categoryId ?? 0 ?>">
            <input type="text" name="search" class="search-input" placeholder="Tìm kiếm sản phẩm"
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit" class="search-icon"><i class="fas fa-search"></i></button>
        </form>


        <!-- Lọc danh mục -->
        <div class="btn-phantrang d-lg-flex justify-content-center m-5 gap-2">
            <a href="?category=0" class="custom-btn <?= $categoryId == 0 ? 'active' : '' ?>">Tất cả</a>
            <?php foreach ($categories as $cat): ?>
            <a href="?category=<?= $cat->getId() ?>"
                class="custom-btn <?= $cat->getId() == $categoryId ? 'active' : '' ?>">
                <?= htmlspecialchars($cat->getCategoryName()) ?>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="row row-cols-4 d-flex justify-content-center">
            <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
            <?php
echo $product->getLinkImage();
                ?>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card__image">
                        <img src="./../../../views/layout/assets/images/b2.jpg" />
                        <div class="card__addtocard text-white">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <h1>ADD TO CART</h1>
                        </div>
                    </div>
                    <div class="card__content">
                        <h1><?= $product->getProductName(); ?></h1>
                        <div class="card__content__line"></div>
                        <h1><?= number_format($product->getPrice(), 0, ',', '.') . 'Đ'; ?></h1>
                    </div>
                    <p class="mt-3 card__content_desc">Mô tả sản phẩm...</p>
                    <div class="text-center">
                        <a href="?page=product-details&id=<?= $product->getId(); ?>" class="card__details-btn">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="text-muted">Không có sản phẩm để hiển thị.</p>
            <?php endif; ?>
        </div>

        <!-- Phân trang -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination-summary d-flex justify-content-center align-items-center gap-3 mt-4">
            <!-- Nút trước -->
            <?php if ($pg > 1): ?>
            <a href="?pg=<?= $pg - 1 ?>&category=<?= $categoryId ?>&search=<?= urlencode($keyword) ?>"
                class="nav-circle-btn">
                &#8249;
                <!-- hoặc dùng icon ← -->
            </a>
            <?php else: ?>
            <span class="nav-circle-btn disabled">&#8249;</span>
            <?php endif; ?>

            <!-- Trang hiện tại / Tổng trang -->
            <span class="page-info">
                <span class="text-success fw-bold"><?= $pg ?></span> / <?= $totalPages ?> trang
            </span>

            <!-- Nút sau -->
            <?php if ($pg < $totalPages): ?>
            <a href="?pg=<?= $pg + 1 ?>&category=<?= $categoryId ?>&search=<?= urlencode($keyword) ?>"
                class="nav-circle-btn">
                &#8250;
                <!-- hoặc dùng icon → -->
            </a>
            <?php else: ?>
            <span class="nav-circle-btn disabled">&#8250;</span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.nav-circle-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 32px;
    height: 32px;
    border: 2px solid #28a745;
    /* Màu viền xanh */
    border-radius: 50%;
    color: #28a745;
    font-size: 16px;
    text-decoration: none;
    transition: 0.3s;
}

.nav-circle-btn:hover {
    background-color: #28a745;
    color: white;
}

.nav-circle-btn.disabled {
    border-color: #ccc;
    color: #ccc;
    pointer-events: none;
}

.page-info {
    font-size: 16px;
    color: #6c757d;
}

.custom-btn {
    background-color: white;
    color: #FFC107;
    border: 2px solid #FFC107;
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}

.custom-btn.active,
.custom-btn:hover {
    background-color: #FFC107;
    color: white;
}
</style>