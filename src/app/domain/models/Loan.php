<?php

require_once __DIR__.'/../models/Employee.php';

class Loan {
    private string $id;
    private Employee $user;
    private DateTime $date;
    private float $amount;
    private int $quotes;
    private int $payedQuotes;
    private bool $isPayed;

    public function __construct(string $id, Employee $user, DateTime $date, float $amount, int $quotes, int $payedQuotes, bool $isPayed) {
        $this->id = $id;
        $this->user = $user;
        $this->date = $date;
        $this->amount = $amount;
        $this->quotes = $quotes;
        $this->payedQuotes = $payedQuotes;
        $this->isPayed = $isPayed;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getUser(): Employee {
        return $this->user;
    }

    public function getDate(): DateTime {
        return $this->date;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function getQuotes(): int {
        return $this->quotes;
    }

    public function getPayedQuotes(): int {
        return $this->payedQuotes;
    }

    public function getIsPayed(): bool {
        return $this->isPayed;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function setUser(Employee $user): void {
        $this->user = $user;
    }

    public function setDate(DateTime $date): void {
        $this->date = $date;
    }

    public function setAmount(float $amount): void {
        $this->amount = $amount;
    }

    public function setQuotes(int $quotes): void {
        $this->quotes = $quotes;
    }

    public function setPayedQuotes(int $payedQuotes): void {
        $this->payedQuotes = $payedQuotes;
    }

    public function setIsPayed(bool $isPayed): void {
        $this->isPayed = $isPayed;
    }

}

?>