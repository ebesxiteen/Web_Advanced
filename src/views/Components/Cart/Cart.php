<?php
    session_start();
    require_once __DIR__ . '/../../../config/DatabaseConnection.php';
    require_once __DIR__ . '/../../../controllers/CartController.php';
    require_once __DIR__ . '/../../../controllers/CartDetailController.php';
    require_once __DIR__ . '/../../../controllers/ProductController.php';
    require_once __DIR__ . '../../../Auth/CartProcessor.php';
    $userId = $_SESSION['userId'];
    $cartController = new CartController();
    $cartDetailController = new CartDetailController();
    $productController = new ProductController();
    $cartProcessor = new CartProcessor($cartController,$cartDetailController, $productController);
    $cart = $cartProcessor->getCart($userId);
    $products = $cartProcessor->getProductsInCart($userId);
    $totalPrice = $cartProcessor->calculateTotalPrice($userId);
?>


<div class="container cart-container">
    <table class="table table-bordered align-middle">
        <thead class="table-light text-center">
            <tr>
                <th>Hình ảnh</th>
                <th>Thông tin sản phẩm</th>
                <th class="col-price">Đơn giá</th>
                <th class="col-quantity">Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($products as $entry):
                $item = $entry['product'];
                $total= $entry['quantity'] * $item->getPrice();
            ?>
            <tr class="text-center" id="item-<?= $item->getId(); ?>">
                <td>
                    <img src="<?= htmlspecialchars($item->getLinkImage()); ?>"
                        alt="<?= htmlspecialchars($item->getProductName()); ?>" class="product-image">
                </td>
                <td>
                    <div>
                        <span class="cart-product-name"><?= htmlspecialchars($item->getProductName()); ?></span>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-sm btn-delete-item" data-product-id="<?= $item->getId(); ?>">Xóa</button>
                    </div>
                </td>
                <td class="price-text"><?= number_format($item->getPrice(), 1, ',', '.'); ?>₫</td>
                <td>
                    <div class="cart-quantity-box">
                        <?= $entry['quantity']; ?>
                    </div>
                </td>
                <td class="price-text"><?= number_format($total, 1, ',', '.'); ?>₫</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <button class="btn btn-primary btn-continue-shopping">Tiếp tục mua hàng</button>
        <div class="d-flex align-items-center">
            <span class="me-2 cart-product-name">Tổng tiền thanh toán:</span>
            <span class="total-price-text me-3" id="totalPrice"><?= number_format($totalPrice, 1, ',', '.'); ?>₫</span>
            <button class="btn btn-payment">Tiến hành thanh toán</button>
        </div>
    </div>
</div>
<script>
// Tiếp tục mua hàng
document.querySelector('.btn-continue-shopping').addEventListener('click', function() {
    window.location.href = '../Pages/home.php';
});

// Tiến hành thanh toán
document.querySelector('.btn-payment').addEventListener('click', function() {
    window.location.href = '/Web_Advanced/src/views/Payment/Payment.php';
});

// Xóa sản phẩm khỏi giỏ
document.querySelectorAll('.btn-delete-item').forEach(function(button) {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const itemRow = document.querySelector(`#item-${productId}`);

        fetch('http://localhost/Web_Advanced/src/views/api/deleteCartDetail.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `productId=${productId}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (itemRow) itemRow.remove();
                    updateCartQuantityInHeader();

                    // ✅ Cập nhật lại tổng tiền nếu có
                    document.querySelector('#totalPrice').innerText = `${data.totalPrice}₫`;
                }
            });
    });
});
</script>