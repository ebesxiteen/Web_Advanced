<?php

require_once (dirname(__FILE__) ."/../config/DatabaseConnection.php");
require_once (dirname(__FILE__)). '/../models/Unit.php';// Đảm bảo rằng bạn đã bao gồm tệp Unit.php

class UnitController {
    private $connection;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->connection = $db->getConnection();
    }

    public function getAllUnits() {
        $sql = "SELECT * FROM UNITS";
        $result = $this->connection->query($sql);

        $units = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $units[] = new Unit($row['ID'], $row['TYPE']);
            }
        }

        return $units;
    }

    public function getUnitById($id) {
        $sql = "SELECT * FROM UNITS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Unit($row['ID'], $row['TYPE']);
        }

        return null;
    }

    public function createUnit($unit) {
        $sql = "INSERT INTO UNITS (TYPE) VALUES (?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $unit->getType());

        if ($stmt->execute()) {
            return $this->connection->insert_id; // Trả về ID của đơn vị mới được tạo
        }

        return false;
    }

    public function updateUnit($unit) {
        $sql = "UPDATE UNITS SET TYPE = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("si", $unit->getType(), $unit->getId());

        return $stmt->execute();
    }

    public function deleteUnit($id) {
        $sql = "DELETE FROM UNITS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>