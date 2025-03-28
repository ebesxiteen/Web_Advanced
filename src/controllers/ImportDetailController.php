<?php

require_once 'config/DatabaseConnection.php';
require_once 'models/ImportDetail.php'; // Đảm bảo đường dẫn chính xác

class ImportDetailController {
    private $connection;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->connection = $db->getConnection();
    }

    public function getAllImportDetails() {
        $sql = "SELECT * FROM IMPORTDETAILS";
        $result = $this->connection->query($sql);

        $importDetails = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $importDetail = new ImportDetail(
                    $row['ID'],
                    $row['IMPORTID'],
                    $row['INGREDIENTID'],
                    $row['QUANTITY'],
                    $row['PRICE'],
                    $row['TOTAL'],
                    $row['UNITID']
                );
                $importDetails[] = $importDetail;
            }
        }

        return $importDetails;
    }

    public function getImportDetailById($id) {
        $sql = "SELECT * FROM IMPORTDETAILS WHERE ID = " . $id;
        $result = $this->connection->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new ImportDetail(
                $row['ID'],
                $row['IMPORTID'],
                $row['INGREDIENTID'],
                $row['QUANTITY'],
                $row['PRICE'],
                $row['TOTAL'],
                $row['UNITID']
            );
        }

        return null;
    }

    public function createImportDetail(ImportDetail $importDetail) {
        $sql = "INSERT INTO IMPORTDETAILS (IMPORTID, INGREDIENTID, QUANTITY, PRICE, TOTAL,UNITID) VALUES (
            " . $importDetail->getImportId() . ",
            " . $importDetail->getIngredientId() . ",
            " . $importDetail->getQuantity() . ",
            " . $importDetail->getPrice() . ",
            " . $importDetail->getTotal() . ",
             " . $importDetail->getUnitId() . "

        )";

        if ($this->connection->query($sql) === TRUE) {
            return $this->connection->insert_id; // Trả về ID vừa tạo
        } else {
            return false;
        }
    }

    public function updateImportDetail(ImportDetail $importDetail) {
        $sql = "UPDATE IMPORTDETAILS SET 
            IMPORTID = " . $importDetail->getImportId() . ",
            INGREDIENTID = " . $importDetail->getIngredientId() . ",
            QUANTITY = " . $importDetail->getQuantity() . ",
            PRICE = " . $importDetail->getPrice() . ",
            TOTAL = " . $importDetail->getTotal() . ",
            UNITID = " . $importDetail->getUnitId() . "
            WHERE ID = " . $importDetail->getId();

        if ($this->connection->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteImportDetail($id) {
        $sql = "DELETE FROM IMPORTDETAILS WHERE ID = " . $id;

        if ($this->connection->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}

?>