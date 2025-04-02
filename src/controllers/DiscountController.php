<?php

include __DIR__ ."/../config/DatabaseConnection.php";
include __DIR__ ."/../models/Discount.php";

class DiscountController {
    private $connection;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->connection = $db->getConnection();
    }

/*************  ✨ Codeium Command ⭐  *************/
/******  bbac5eed-cb4f-46c3-893c-36547972bd65  *******/
    public function getAllDiscounts() {
        $sql = "SELECT * FROM DISCOUNTS";
        
        $result = $this->connection->query( $sql );

        $discounts = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $discount= new Discount(
                    $row['ID'],
                    $row['DISCOUNTNAME'],
                    $row['DISCOUNTPERCENT'],
                    $row['REQUIREMENT'],
                    $row['STARTDATE'],
                    $row['ENDDATE']
                );
                $discounts[] = $discount;
            }
        }
        return $discounts;
    }

    public function getDiscountById($id) {
        $sql = "SELECT * FROM DISCOUNTS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Discount(
                $row['ID'],
                $row['DISCOUNTNAME'],
                $row['DISCOUNTPERCENT'],
                $row['REQUIREMENT'],
                $row['STARTDATE'],
                $row['ENDDATE']
            );
        }
        return null;
    }

    public function createDiscount(Discount $discount) {
        $sql = "INSERT INTO DISCOUNTS (DISCOUNTNAME, DISCOUNTPERCENT, REQUIREMENT, STARTDATE, ENDDATE) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $discountName = $discount->getDiscountName();
        $discountPercent = $discount->getDiscountPercent();
        $requirement = $discount->getRequirement();
        $startDate = $discount->getStartDate();
        $endDate = $discount->getEndDate();

        $stmt->bind_param("sddss", $discountName, $discountPercent, $requirement, $startDate, $endDate);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateDiscount(Discount $discount) {
        $sql = "UPDATE DISCOUNTS SET DISCOUNTNAME = ?, DISCOUNTPERCENT = ?, REQUIREMENT = ?, STARTDATE = ?, ENDDATE = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $id = $discount->getId();
        $discountName = $discount->getDiscountName();
        $discountPercent = $discount->getDiscountPercent();
        $requirement = $discount->getRequirement();
        $startDate = $discount->getStartDate();
        $endDate = $discount->getEndDate();

        $stmt->bind_param("sddssi", $discountName, $discountPercent, $requirement, $startDate, $endDate, $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteDiscount($id) {
        $sql = "DELETE FROM DISCOUNTS WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }

}

?>