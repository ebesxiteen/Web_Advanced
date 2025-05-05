<?php
session_start();
require_once __DIR__ . '/../../config/DatabaseConnection.php';
require_once __DIR__ . '/../../controllers/CartController.php';
require_once __DIR__ . '/../../controllers/CartDetailController.php';
require_once __DIR__ . '/../../controllers/ProductController.php';
require_once __DIR__ . '../../Auth/CartProcessor.php';
require_once __DIR__ .'/../config/head.php';

$userId = $_SESSION['userId'];
$cartProcessor = new CartProcessor(new CartController(), new CartDetailController(), new ProductController());
$products = $cartProcessor->getProductsInCart($userId);
$totalBeforeDiscount = $cartProcessor->calculateTotalPrice($userId);
?>

<div class="container mt-5">
    <h3 class="text-center mb-4">Xác nhận đơn hàng</h3>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $entry):
                    $item = $entry['product'];
                    $quantity = $entry['quantity'];
                    $subtotal = $item->getPrice() * $quantity;
                ?>
                <tr>
                    <td>
                        <img src="<?= htmlspecialchars($item->getLinkImage()) ?>"
                            alt="<?= htmlspecialchars($item->getProductName()) ?>" style="width: 60px;"
                            class="img-fluid rounded">
                    </td>
                    <td><?= htmlspecialchars($item->getProductName()) ?></td>
                    <td><?= number_format($item->getPrice(), 0, ',', '.') ?>₫</td>
                    <td><?= $quantity ?></td>
                    <td><?= number_format($subtotal, 0, ',', '.') ?>₫</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="row mt-4">
        <!-- Discount Section -->
        <div class="col-12 col-lg-6 mb-4 mb-lg-0">
            <div class="card shadow-sm p-4 h-100 text-dark">
                <h5 class="mb-3">Áp dụng mã giảm giá</h5>
                <label for="discountCode" class="form-label">Mã giảm giá</label>
                <input type="text" id="discountCode" class="form-control" placeholder="Nhập mã...">
                <button class="btn btn-success mt-3 w-100" id="applyDiscount">Áp dụng</button>
                <div id="discountMessage" class="text-danger mt-2"></div>
            </div>
        </div>

        <!-- Total Summary -->
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm p-4 bg-light text-dark h-100 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="mb-3">Tóm tắt đơn hàng</h5>
                    <p class="mb-1">Tổng trước giảm: <strong
                            id="totalBefore"><?= number_format($totalBeforeDiscount, 0, ',', '.') ?>₫</strong></p>
                    <p class="mb-1">Phần trăm giảm: <strong id="discountPercent">0%</strong></p>
                    <p class="mb-3">Tổng thanh toán: <strong
                            id="totalFinal"><?= number_format($totalBeforeDiscount, 0, ',', '.') ?>₫</strong></p>
                </div>
                <button class="btn btn-primary w-100 mt-3" id="confirmOrder">Xác nhận thanh toán</button>
            </div>
        </div>

    </div>


</div>

<script>
let totalBefore = <?= $totalBeforeDiscount ?>;
let appliedDiscountId = null;
let discountPercent = 0;

document.getElementById('applyDiscount').addEventListener('click', function() {
    const code = document.getElementById('discountCode').value;

    fetch('http://localhost/Web_Advanced_Project/src/views/Payment/applyDiscount.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'code=' + encodeURIComponent(code)
        })
        .then(res => res.json())
        .then(data => {
            const messageDiv = document.getElementById('discountMessage');
            if (data.success) {
                discountPercent = data.discountPercent;
                appliedDiscountId = data.discountId;

                const discountAmount = totalBefore * discountPercent / 100;
                const totalAfter = totalBefore - discountAmount;

                document.getElementById('discountPercent').innerText = discountPercent + '%';
                document.getElementById('totalFinal').innerText = new Intl.NumberFormat('vi-VN').format(
                    totalAfter) + '₫';
                messageDiv.innerText = '';
            } else {
                messageDiv.innerText = data.message || 'Mã giảm giá không hợp lệ.';
            }
        })
        .catch(error => {
            console.error("Lỗi áp mã:", error);
            document.getElementById('discountMessage').innerText = 'Đã xảy ra lỗi.';
        });
});

document.getElementById('confirmOrder').addEventListener('click', function() {
    fetch('http://localhost/Web_Advanced_Project/src/views/Payment/createOrder.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `discountPercent=${discountPercent}&discountId=${appliedDiscountId ?? 0}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Đặt hàng thành công!');
                window.location.href = '../Pages/Home.php';
            } else {
                alert('Đặt hàng thất bại: ' + (data.message || 'Đã có lỗi xảy ra.'));
            }
        })
        .catch(error => {
            console.error("Lỗi đặt hàng:", error);
            alert('Lỗi không xác định.');
        });
});
</script>