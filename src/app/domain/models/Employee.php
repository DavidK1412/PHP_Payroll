<?php

require_once 'Position.php';
require_once 'CostCenter.php';

class Employee {
    private string $employeeUUID;
    private string $employeeId;
    private string $employeeName;
    private string $employeeEmail;
    private Position $position;
    private CostCenter $costCenter;
    private float $employeeWage;

    public function __construct($employeeUUID, $employeeId, $employeeName, $employeeEmail, $position, $costCenter, $employeeWage){
        $this->employeeUUID = $employeeUUID;
        $this->employeeId = $employeeId;
        $this->employeeName = $employeeName;
        $this->employeeEmail = $employeeEmail;
        $this->position = $position;
        $this->costCenter = $costCenter;
        $this->employeeWage = $employeeWage;
    }

    public function getEmployeeUUID(){
        return $this->employeeUUID;
    }

    public function getEmployeeId(){
        return $this->employeeId;
    }

    public function getEmployeeName(){
        return $this->employeeName;
    }

    public function getEmployeeEmail(){
        return $this->employeeEmail;
    }

    public function getPosition(){
        return $this->position;
    }

    public function getCostCenter(){
        return $this->costCenter;
    }

    public function getEmployeeWage(){
        return $this->employeeWage;
    }

    public function setEmployeeUUID($employeeUUID){
        $this->employeeUUID = $employeeUUID;
    }

    public function setEmployeeId($employeeId){
        $this->employeeId = $employeeId;
    }

    public function setEmployeeName($employeeName){
        $this->employeeName = $employeeName;
    }

    public function setEmployeeEmail($employeeEmail){
        $this->employeeEmail = $employeeEmail;
    }

    public function setPosition($position){
        $this->position = $position;
    }

    public function setCostCenter($costCenter){
        $this->costCenter = $costCenter;
    }

    public function setEmployeeWage($employeeWage){
        $this->employeeWage = $employeeWage;
    }

}

?>