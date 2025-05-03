<?php


include __DIR__ ."/../models/Ingredient.php";

class IngredientController {
    private $connection;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->connection = $db->getConnection();
    }

    public function getAllIngredients() {
        $sql = "SELECT * FROM INGREDIENTS";
        $result = $this->connection->query($sql);

        $ingredients = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ingredient = new Ingredient(
                    $row['ID'],
                    $row['PRODUCERID'],
                    $row['INGREDIENTNAME'],
                    $row['QUANTITY'],
                    $row['UNITID']
                );
                $ingredients[] = $ingredient;
            }
        }
        return $ingredients;
    }

    public function getIngredientById($id) {
        $sql = "SELECT * FROM INGREDIENTS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Ingredient(
                $row['ID'],
                $row['PRODUCERID'],
                $row['INGREDIENTNAME'],
                $row['QUANTITY'],
                $row['UNITID']
            );
        }
        return null;
    }

    public function createIngredient($ingredient) {
        $sql = "INSERT INTO INGREDIENTS (PRODUCERID, INGREDIENTNAME, QUANTITY, UNITID) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $producerId = $ingredient->getProducerId();
        $ingredientName = $ingredient->getIngredientName();
        $quantity = $ingredient->getQuantity();
        $unitId = $ingredient->getUnitId();

        $stmt->bind_param("isdi", $producerId, $ingredientName, $quantity, $unitId);

        if ($stmt->execute()) {
            return $this->connection->insert_id; // Trả về ID của bản ghi vừa tạo
        } else {
            return false;
        }
    }

    public function updateIngredient($ingredient) {
        $sql = "UPDATE INGREDIENTS SET PRODUCERID = ?, INGREDIENTNAME = ?, QUANTITY = ?, UNITID = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $id = $ingredient->getId();
        $producerId = $ingredient->getProducerId();
        $ingredientName = $ingredient->getIngredientName();
        $quantity = $ingredient->getQuantity();
        $unitId = $ingredient->getUnitId();

        $stmt->bind_param("isdii", $producerId, $ingredientName, $quantity, $unitId, $id);

        return $stmt->execute();
    }

    public function deleteIngredient($id) {
        $sql = "DELETE FROM INGREDIENTS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>