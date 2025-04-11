<?php

class Order {
    private $id;
    private $userId;
    private $total;
    private $dateOfOrder;
    private $orderStatus;
    private $discountId;
    private $pricebeforeDiscount;

    public function __construct($id = null, $userId = null, $total = null, $dateOfOrder = null, $orderStatus = null, $discountId = null,$pricebeforeDiscount =null) {
        $this->id = $id;
        $this->userId = $userId;
        $this->total = $total;
        $this->dateOfOrder = $dateOfOrder;
        $this->orderStatus = $orderStatus;
        $this->discountId = $discountId;
        $this->pricebeforeDiscount = $pricebeforeDiscount;
    }

    public function getPricebeforeDiscount() {
        return $this->pricebeforeDiscount;
    }
    public function setPricebeforeDiscount($pricebeforeDiscount) {
        $this->pricebeforeDiscount = $pricebeforeDiscount;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getDateOfOrder() {
        return $this->dateOfOrder;
    }

    public function getOrderStatus() {
        return $this->orderStatus;
    }

    public function getDiscountId() {
        return $this->discountId;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function setDateOfOrder($dateOfOrder) {
        $this->dateOfOrder = $dateOfOrder;
    }

    public function setOrderStatus($orderStatus) {
        $this->orderStatus = $orderStatus;
    }

    public function setDiscountId($discountId) {
        $this->discountId = $discountId;
    }
}

?>