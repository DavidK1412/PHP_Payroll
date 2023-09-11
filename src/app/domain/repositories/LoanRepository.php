<?php

require_once __DIR__ . '/../../databases/DatabaseService.php';
require_once 'EmployeeRepository.php';
require_once __DIR__.'/../models/Loan.php';

class LoanRepository {
    private DatabaseService $db;

    public function __construct() {
        $this->db = new DatabaseService();
    }

    public function create(Loan $loan): void {
        $isPayed = 0;
        if ($loan->getIsPayed()) {
            $isPayed = 1;
        }
        $sql = "INSERT INTO Loan ( EmployeeUUID, Amount, TotalQuotes, PayedQuotes, PayedOff) VALUES ('".$loan->getUser()->getEmployeeUUID()."', ".$loan->getAmount().", ".$loan->getQuotes().", ".$loan->getPayedQuotes().", ".$isPayed.")";
        $this->db->getConnection()->query($sql);
    }

    public function getAll(): array {
        $sql = "SELECT * FROM Loan";
        $result = $this->db->getConnection()->query($sql);
        $loans = array();
        $employeeRepository = new EmployeeRepository();
        while ($row = $result->fetch_assoc()) {
            $time = strtotime($row["Date"]);
            $date = new DateTime(date('Y-m-d', $time));
            $loan = new Loan($row["LoanUUID"], $employeeRepository->getById($row["EmployeeUUID"]),$date ,$row["Amount"], $row["TotalQuotes"], $row["PayedQuotes"], $row["PayedOff"]);
            array_push($loans, $loan);
        }
        return $loans;
    }

    public function getById($id): Loan {
        $sql = "SELECT * FROM Loan WHERE LoanUUID = '$id'";
        $result = $this->db->getConnection()->query($sql);
        $row = $result->fetch_assoc();
        $time = strtotime($row["Date"]);
        $date = new DateTime(date('Y-m-d', $time));
        $employeeRepository = new EmployeeRepository();
        $loan = new Loan($row["EmployeeUUID"], $employeeRepository->getById($row["EmployeeUUID"]),$date ,$row["Amount"], $row["TotalQuotes"], $row["PayedQuotes"], $row["PayedOff"]);
        return $loan;
    }

    public function update(Loan $loan): void {
        $sql = "UPDATE Loan SET EmployeeUUID = '".$loan->getUser()->getEmployeeUUID()."', Amount = ".$loan->getAmount().", TotalQuotes = ".$loan->getQuotes().", PayedQuotes = ".$loan->getPayedQuotes().", PayedOff = '".$loan->getIsPayed()."' WHERE LoanUUID = '".$loan->getId()."'";
        $this->db->getConnection()->query($sql);
    }

    public function delete($id): void {
        $sql = "DELETE FROM Loan WHERE LoanUUID = '".$id."'";
        $this->db->getConnection()->query($sql);
    }


}

?>