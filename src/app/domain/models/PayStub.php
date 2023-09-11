<?php

class PayStub {
    private string $id;
    private TimeSheet $timeSheet;
    private Employee $employee;
    private DateTime $date;
    private float $grossPay;
    private float $netPay;

    public function __construct(string $id, TimeSheet $timeSheet, Employee $employee, DateTime $date, float $grossPay, float $netPay) {
        $this->id = $id;
        $this->timeSheet = $timeSheet;
        $this->employee = $employee;
        $this->date = $date;
        $this->grossPay = $grossPay;
        $this->netPay = $netPay;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getTimeSheet(): TimeSheet {
        return $this->timeSheet;
    }

    public function getEmployee(): Employee {
        return $this->employee;
    }

    public function getDate(): DateTime {
        return $this->date;
    }

    public function getGrossPay(): float {
        return $this->grossPay;
    }

    public function getNetPay(): float {
        return $this->netPay;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function setTimeSheet(TimeSheet $timeSheet): void {
        $this->timeSheet = $timeSheet;
    }

    public function setEmployee(Employee $employee): void {
        $this->employee = $employee;
    }

    public function setDate(DateTime $date): void {
        $this->date = $date;
    }

    public function setGrossPay(float $grossPay): void {
        $this->grossPay = $grossPay;
    }

    public function setNetPay(float $netPay): void {
        $this->netPay = $netPay;
    }
}