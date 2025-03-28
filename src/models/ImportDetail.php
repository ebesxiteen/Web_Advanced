<?php

class ImportDetail {
    private $id;
    private $importId;
    private $ingredientId;
    private $quantity;
    private $price;
    private $total;
    private $unitId;
    public function __construct($id = null, $importId = null, $ingredientId = null, $quantity = null, $price = null, $total = null,$unitId=null) {
        $this->id = $id;
        $this->importId = $importId;
        $this->ingredientId = $ingredientId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->total = $total;
        $this->unitId=$unitId;
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

    public function getUnitId(){
        return $this->unitId;
    }
    public function setUnitId($unitId){
        $this->unitId=$unitId;
    }
}

?>