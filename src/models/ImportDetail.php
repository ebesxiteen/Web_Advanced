<?php

class ImportDetails {
    private $id;
    private $importId;
    private $ingredientId;
    private $quantity;
    private $price;
    private $total;

    public function __construct($id = null, $importId = null, $ingredientId = null, $quantity = null, $price = null, $total = null) {
        $this->id = $id;
        $this->importId = $importId;
        $this->ingredientId = $ingredientId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->total = $total;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getImportId() {
        return $this->importId;
    }

    public function setImportId($importId) {
        $this->importId = $importId;
    }

    public function getIngredientId() {
        return $this->ingredientId;
    }

    public function setIngredientId($ingredientId) {
        $this->ingredientId = $ingredientId;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }
}
?>