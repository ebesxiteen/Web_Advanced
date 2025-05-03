<?php

class CartProcessor {
    private $cartController;
    private $cartDetailController;
    private $productController;

    public function __construct($cartController, $cartDetailController, $productController) {
        $this->cartController = $cartController;
        $this->cartDetailController = $cartDetailController;
        $this->productController = $productController;
    }

    // Phương thức xử lý giỏ hàng
    public function getCart($userId,) {
        // Lấy thông tin giỏ hàng
        $cart = $this->cartController->getCartByUser($userId);

        if (!$cart) {
            return null; // Không có giỏ hàng
        }
        else return $cart;
    }
    // Lấy thông tin chi tiết giỏ hàng
    public function getCartDetails($userId) {
        $cart = $this->getCart($userId);
        $cartDetail = $this->cartDetailController->getCartDetailByCartId($cart->getId());
        if (!$cartDetail) {
            return null; // Không có chi tiết giỏ hàng
        }
        else return $cartDetail;
    }
    // Lấy thông tin sản phẩm trong giỏ hàng
    public function getProductsInCart($userId) {
        $cartDetail = $this->getCartDetails($userId);
        $products = [];
        foreach ($cartDetail as $detail) {
            $productId = $detail->getProductId();
            $products[] = [
                'product' => $this->productController->getProductById($productId),
                'quantity' => $detail->getQuantity()
            ];
        }
        return $products;
    }
    // Tính tổng tiền
    public function calculateTotalPrice($userId) {
        $products = $this->getProductsInCart($userId);
        $totalPrice = 0;
        foreach ($products as $entry) {
            $item = $entry['product'];
            $totalPrice += $item->getPrice() * $entry['quantity'];
        }
        return $totalPrice;
    }
}
