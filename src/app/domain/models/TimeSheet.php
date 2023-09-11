<?php

class TimeSheet {
    private int $id;
    private Employee $employee;
    private DateTime $date;
    private int $daysWorked;
    private int $vacationsDays;
    private int $sickDays;

    public function __construct(int $id, Employee $employee, DateTime $date, int $daysWorked, int $vacationsDays, int $sickDays) {
        $this->id = $id;
        $this->employee = $employee;
        $this->date = $date;
        $this->daysWorked = $daysWorked;
        $this->vacationsDays = $vacationsDays;
        $this->sickDays = $sickDays;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getEmployee(): Employee {
        return $this->employee;
    }

    public function getDate(): DateTime {
        return $this->date;
    }

    public function getDaysWorked(): int {
        return $this->daysWorked;
    }

    public function getVacationsDays(): int {
        return $this->vacationsDays;
    }

    public function getSickDays(): int {
        return $this->sickDays;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setEmployee(Employee $employee): void {
        $this->employee = $employee;
    }

    public function setDate(DateTime $date): void {
        $this->date = $date;
    }

    public function setDaysWorked(int $daysWorked): void {
        $this->daysWorked = $daysWorked;
    }

    public function setVacationsDays(int $vacationsDays): void {
        $this->vacationsDays = $vacationsDays;
    }

    public function setSickDays(int $sickDays): void {
        $this->sickDays = $sickDays;
    }

}

?>