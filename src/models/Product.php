<?php

class Product {
    private $id;
    private $recipeId;
    private $productName;
    private $price;
    private $unitId;

    public function __construct($id = null, $recipeId = null, $productName = null, $price = null, $unitId = null) {
        $this->id = $id;
        $this->recipeId = $recipeId;
        $this->productName = $productName;
        $this->price = $price;
        $this->unitId = $unitId;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getRecipeId() {
        return $this->recipeId;
    }

    public function setRecipeId($recipeId) {
        $this->recipeId = $recipeId;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function setProductName($productName) {
        $this->productName = $productName;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getUnitId() {
        return $this->unitId;
    }

    public function setUnitId($unitId) {
        $this->unitId = $unitId;
    }
}

?>