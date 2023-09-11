<?php

class LoanPayment {
    private string $id;
    private Loan $loan;
    private DateTime $date;
    private float $amount;

    public function __construct(string $id, Loan $loan, DateTime $date, float $amount) {
        $this->id = $id;
        $this->loan = $loan;
        $this->date = $date;
        $this->amount = $amount;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getLoan(): Loan {
        return $this->loan;
    }

    public function getDate(): DateTime {
        return $this->date;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function setLoan(Loan $loan): void {
        $this->loan = $loan;
    }

    public function setDate(DateTime $date): void {
        $this->date = $date;
    }

    public function setAmount(float $amount): void {
        $this->amount = $amount;
    }
}

?>