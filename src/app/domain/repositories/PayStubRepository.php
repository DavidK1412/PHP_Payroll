<?php

require_once __DIR__.'/../../databases/DatabaseService.php';
require_once __DIR__.'/../models/PayStub.php';
require_once 'EmployeeRepository.php';
require_once 'PayStubRepository.php';


class PayStubRepository {
    private DatabaseService $db;

    public function __construct() {
        $this->db = new DatabaseService();
    }

    public function getAll(): array {
        $timeSheetRepository = new TimeSheetRepository();
        $employeeRepository = new EmployeeRepository();
        $sql = "SELECT * FROM PayStub";
        $result = $this->db->getConnection()->query($sql);
        $payStubs = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $time = strtotime($row['Date']);
                $date = new DateTime(date('Y-m-d', $time));
                $payStub = new PayStub($row['PayStubUUID'], $timeSheetRepository->getById($row['TimeSheetUUID']), $employeeRepository->getById($row['EmployeeUUID']), $date, $row['GrossPay'], $row['NetPay']);
                array_push($payStubs, $payStub);
            }
        }
        return $payStubs;
    }

    public function getPayStubsByEmployeeId($employeeId): array {
        $timeSheetRepository = new TimeSheetRepository();
        $employeeRepository = new EmployeeRepository();
        $sql = "SELECT * FROM PayStub WHERE EmployeeUUID = '$employeeId'";
        $result = $this->db->getConnection()->query($sql);
        $payStubs = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $time = strtotime($row['Date']);
                $date = new DateTime(date('Y-m-d', $time));
                $payStub = new PayStub($row['PayStubUUID'], $timeSheetRepository->getById($row['TimeSheetUUID']), $employeeRepository->getById($row['EmployeeUUID']), $date, $row['GrossPay'], $row['NetPay']);
                array_push($payStubs, $payStub);
            }
        }
        return $payStubs;
    }

    public function getPayStubById($id): PayStub {
        $timeSheetRepository = new TimeSheetRepository();
        $employeeRepository = new EmployeeRepository();
        $sql = "SELECT * FROM PayStub WHERE PayStubUUID = '$id'";
        $result = $this->db->getConnection()->query($sql);
        $row = $result->fetch_assoc();
        $time = strtotime($row['Date']);
        $date = new DateTime(date('Y-m-d', $time));
        $payStub = new PayStub($row['PayStubUUID'], $timeSheetRepository->getById($row['TimeSheetUUID']), $employeeRepository->getById($row['EmployeeUUID']), $date, $row['GrossPay'], $row['NetPay']);
        return $payStub;
    }

    public function createPayStub(PayStub $payStub): void {
        $sql = "INSERT INTO PayStub(TimeSheetUUID, EmployeeUUID, Date, GrossPay, NetPay) VALUES ('".$payStub->getTimeSheet()->getId()."', '".$payStub->getEmployee()->getEmployeeUUID()."', '".$payStub->getDate()->format('Y-m-d')."', ".$payStub->getGrossPay().", ".$payStub->getNetPay().")";
        $this->db->getConnection()->query($sql);
    }
}