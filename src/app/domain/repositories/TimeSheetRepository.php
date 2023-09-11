<?php

require_once __DIR__.'/../../databases/DatabaseService.php';
require_once __DIR__.'/../models/TimeSheet.php';
require_once 'EmployeeRepository.php';

class TimeSheetRepository {
    private DatabaseService $db;

    public function __construct() {
        $this->db = new DatabaseService();
    }

    public function getLast(): TimeSheet {
        $sql = "SELECT * FROM TimeSheet ORDER BY TimeSheetUUID DESC LIMIT 1";
        $result = $this->db->getConnection()->query($sql);
        $row = $result->fetch_assoc();
        $time = strtotime($row["Date"]);
        $date = new DateTime(date('Y-m-d', $time));
        $employeeRepository = new EmployeeRepository();
        $timeSheet = new TimeSheet(intval($row["TimeSheetUUID"]), $employeeRepository->getById($row["EmployeeUUID"]),$date ,$row["DaysWorked"], $row["VacationDays"], $row["SickDays"]);
        return $timeSheet;
    }

    public function create(TimeSheet $timeSheet): void {
        $sql = "INSERT INTO TimeSheet(EmployeeUUID, DaysWorked, VacationDays, SickDays) VALUES ('".$timeSheet->getEmployee()->getEmployeeUUID()."', ".$timeSheet->getDaysWorked().", ".$timeSheet->getVacationsDays().", ".$timeSheet->getSickDays().")";
        $this->db->getConnection()->query($sql);
    }

    public function getAll(): array {
        $sql = "SELECT * FROM TimeSheet";
        $result = $this->db->getConnection()->query($sql);
        $timeSheets = array();
        $employeeRepository = new EmployeeRepository();
        while ($row = $result->fetch_assoc()) {
            $time = strtotime($row["Date"]);
            $date = new DateTime(date('Y-m-d', $time));
            $timeSheet = new TimeSheet($row["TimeSheetUUID"], $employeeRepository->getById($row["EmployeeUUID"]),$date ,$row["DaysWorked"], $row["VacationDays"], $row["SickDays"]);
            array_push($timeSheets, $timeSheet);
        }
        return $timeSheets;
    }

    public function getById($id): TimeSheet {
        $sql = "SELECT * FROM TimeSheet WHERE TimeSheetUUID = '$id'";
        $result = $this->db->getConnection()->query($sql);
        $row = $result->fetch_assoc();
        $time = strtotime($row["Date"]);
        $date = new DateTime(date('Y-m-d', $time));
        $employeeRepository = new EmployeeRepository();
        $timeSheet = new TimeSheet($row["TimeSheetUUID"], $employeeRepository->getById($row["EmployeeUUID"]),$date ,$row["DaysWorked"], $row["VacationDays"], $row["SickDays"]);
        return $timeSheet;
    }

    public function update(TimeSheet $timeSheet): void {
        $sql = "UPDATE TimeSheet SET EmployeeUUID = '".$timeSheet->getEmployee()->getEmployeeUUID()."', DaysWorked = ".$timeSheet->getDaysWorked().", VacationDays = ".$timeSheet->getVacationsDays().", SickDays = ".$timeSheet->getSickDays()." WHERE TimeSheetUUID = '".$timeSheet->getId()."'";
        $this->db->getConnection()->query($sql);
    }

    public function delete($id): void {
        $sql = "DELETE FROM TimeSheet WHERE TimeSheetUUID = '$id'";
        $this->db->getConnection()->query($sql);
    }

}

?>