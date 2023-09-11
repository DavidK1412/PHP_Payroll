<?php

require_once __DIR__.'/../../databases/DatabaseService.php';
require_once __DIR__.'/../models/Employee.php';
require_once __DIR__.'/../models/Position.php';
require_once __DIR__.'/../models/CostCenter.php';
require_once 'PositionRepository.php';
require_once 'CostCenterRepository.php';

class EmployeeRepository {

    private DatabaseService $db;

    public function __construct() {
        $this->db = new DatabaseService();
    }

    public function getAll(): array {
        $sql = "SELECT * FROM Employee";
        $result = $this->db->getConnection()->query($sql);
        $employees = array();
        $positionRepository = new PositionRepository($this->db);
        $costCenterRepository = new CostCenterRepository($this->db);
        while ($row = $result->fetch_assoc()) {
            $employee = new Employee($row["EmployeeUUID"], $row["EmployeeID"], $row["EmployeeName"], $row["Email"], $positionRepository->getById($row['PositionID']), $costCenterRepository->getById($row["CostCenterID"]), $row["Wage"]);
            array_push($employees, $employee);
        }
        return $employees;
    }

    public function getById($id): Employee {
        $sql = "SELECT * FROM Employee WHERE EmployeeUUID = '$id'";
        $result = $this->db->getConnection()->query($sql);
        $row = $result->fetch_assoc();
        $positionRepository = new PositionRepository();
        $costCenterRepository = new CostCenterRepository();
        $employee = new Employee($row["EmployeeUUID"], $row["EmployeeID"], $row["EmployeeName"], $row["Email"], $positionRepository->getById($row['PositionID']), $costCenterRepository->getById($row['CostCenterID'])  , $row["Wage"]);
        return $employee;
    }

    public function insert(Employee $employee) {
        $sql = "INSERT INTO Employee (EmployeeID, EmployeeName, Email, PositionID, CostCenterID, Wage) VALUES ( '" . $employee->getEmployeeId() . "', '" . $employee->getEmployeeName() . "', '" . $employee->getEmployeeEmail() . "', " . $employee->getPosition()->getPositionID() . ", '".$employee->getCostCenter()->getCostCenterID()."', ". $employee->getEmployeeWage() .")";
        $this->db->getConnection()->query($sql);
    }

    public function update(Employee $employee) {
        $sql = "UPDATE Employee SET EmployeeID = '" . $employee->getEmployeeId() . "', EmployeeName = '" . $employee->getEmployeeName() . "', Email = '" . $employee->getEmployeeEmail() . "', PositionID = " . $employee->getPosition()->getPositionID() . ", CostCenterID = " . $employee->getCostCenter()->getCostCenterID() . ", Wage = " . $employee->getEmployeeWage() . " WHERE EmployeeUUID = '" . $employee->getEmployeeUUID() . "'";
        $this->db->getConnection()->query($sql);
    }

    public function delete($id) {
        $sql = "DELETE FROM Employee WHERE EmployeeUUID = '$id'";
        $this->db->getConnection()->query($sql);
    }

}

?>