<?php

// include __DIR__ ."/../config/DatabaseConnection.php";
require_once (dirname(__FILE__) ."/../models/Recipe.php");

class RecipeController {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->getConnection();
    }

    public function createRecipe($recipeName) {
        $sql = "INSERT INTO RECIPES (RECIPENAME) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $recipeName);

        if ($stmt->execute()) {
            return new Recipe($this->conn->insert_id, $recipeName);
        } else {
            return null;
        }
    }

    public function deleteRecipe($recipeName) {
        $sql = "DELETE FROM RECIPES WHERE RECIPENAME = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $recipeName);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getRecipebyName($recipeName) {
        $sql = "SELECT * FROM RECIPES WHERE RECIPENAME = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $recipeName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Recipe($row['ID'], $row['RECIPENAME']);
        } else {
            return null;
        }
    }

    public function getAllRecipes(){
        $sql = 'SELECT * FROM RECIPES';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $recipes = [];
        while ($row = $result->fetch_assoc()) {
            $recipes[] = new Recipe($row['ID'], $row['RECIPENAME']);
        }
        return $recipes;
    }

    
    public function getRecipebyId($id) {
        $sql = "SELECT * FROM RECIPES WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Recipe($row['ID'], $row['RECIPENAME']);
        } else {
            return null;
        }
    }

    // Thêm các phương thức khác như updateRecipe, deleteRecipe nếu cần
}

?>