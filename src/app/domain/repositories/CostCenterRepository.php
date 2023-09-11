<?php

require_once __DIR__.'/../../databases/DatabaseService.php';

class CostCenterRepository {
    private DatabaseService $db;

    public function __construct() {
        $this->db = new DatabaseService();
    }

    public function getAll(): array {
        $sql = "SELECT * FROM CostCenter";
        $result = $this->db->getConnection()->query($sql);
        $costCenters = array();
        while ($row = $result->fetch_assoc()) {
            $costCenter = new CostCenter($row["CostCenterID"], $row["CostCenterName"]);
            array_push($costCenters, $costCenter);
        }
        return $costCenters;
    }

    public function getById($id): CostCenter {
        $sql = "SELECT * FROM CostCenter WHERE CostCenterID = '$id'";
        $result = $this->db->getConnection()->query($sql);
        $row = $result->fetch_assoc();
        $costCenter = new CostCenter($row["CostCenterID"], $row["CostCenterName"]);
        return $costCenter;
    }

    public function insert(CostCenter $costCenter) {
        $sql = "INSERT INTO CostCenter (CostCenterName) VALUES ('" . $costCenter->getCostCenterName() . "')";
        $this->db->getConnection()->query($sql);
    }

    public function update(CostCenter $costCenter) {
        $sql = "UPDATE CostCenter SET CostCenterName = '" . $costCenter->getCostCenterName() . "' WHERE CostCenterID = " . $costCenter->getCostCenterID();
        $this->db->getConnection()->query($sql);
    }

    public function delete($id) {
        $sql = "DELETE FROM CostCenter WHERE CostCenterID = '$id'";
        $this->db->getConnection()->query($sql);
    }
}

?>