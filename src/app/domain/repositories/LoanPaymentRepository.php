<?php

require_once __DIR__ . '/../../databases/DatabaseService.php';
require_once __DIR__.'/../models/LoanPayment.php';
require_once __DIR__.'/../models/Loan.php';
require_once 'LoanRepository.php';

class LoanPaymentRepository
{

    private DatabaseService $db;

    public function __construct(DatabaseService $db) {
        $this->db = $db;
    }

    public function getAll(): array {
        $sql = 'SELECT * FROM LoanPayments';
        $rows = $this->db->getConnection()->query($sql);
        $loanPayments = [];
        $loanRepository = new LoanRepository();
        while ($row = $rows->fetch_assoc()) {
            $time = strtotime($row["Date"]);
            $date = new DateTime(date('Y-m-d', $time));
            $loanPayment = new LoanPayment($row["LoanPaymentUUID"], $loanRepository->getById($row["LoanUUID"]), $date, $row["Amount"]);
            array_push($loanPayments, $loanPayment);
        }
        return $loanPayments;
    }

    public function getById($id): LoanPayment {
        $sql = "SELECT * FROM LoanPayments WHERE LoanUUID = '$id'";
        $result = $this->db->getConnection()->query($sql);
        $row = $result->fetch_assoc();
        $time = strtotime($row["Date"]);
        $date = new DateTime(date('Y-m-d', $time));
        $loanRepository = new LoanRepository();
        $loanPayment = new LoanPayment($row["LoanPaymentUUID"], $loanRepository->getById($row["LoanUUID"]), $date, $row["Amount"]);
        return $loanPayment;
    }

    public function create(LoanPayment $loanPayment): void {
        $sql = "INSERT INTO LoanPayments(LoanUUID, Date, Amount) VALUES ('".$loanPayment->getLoan()->getId()."', '".$loanPayment->getDate()->format('Y-m-d')."', ".$loanPayment->getAmount().")";
        $this->db->getConnection()->query($sql);
    }

    public function update(LoanPayment $loanPayment): void {
        $sql = "UPDATE LoanPayments SET LoanUUID = '".$loanPayment->getLoan()->getId()."', Date = '".$loanPayment->getDate()->format('Y-m-d')."', Amount = ".$loanPayment->getAmount()." WHERE LoanPaymentUUID = '".$loanPayment->getId()."'";
        $this->db->getConnection()->query($sql);
    }

    public function delete($id): void {
        $sql = "DELETE FROM LoanPayments WHERE LoanUUID = '$id'";
        $this->db->getConnection()->query($sql);
    }
}