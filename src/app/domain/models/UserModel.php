<?php

require_once 'Employee.php';
require_once 'Position.php';

class UserModel {
    private string $userId;
    private string $username;
    private string $password;
    private Employee $employee;

    public function __construct($userId, $username, $password, $employee){
        $this->userId = $userId;
        $this->username = $username;
        $this->password = $password;
        $this->employee = $employee;
    }

    public function getUserId(){
        return $this->userId;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getEmployee(){
        return $this->employee;
    }

    public function setUserId($userId){
        $this->userId = $userId;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setEmployee($employee){
        $this->employee = $employee;
    }

}
?>