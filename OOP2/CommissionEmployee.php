<?php

require_once 'Employee.php';

class CommissionEmployee extends Employee {
    private float $regularSalary;
    private int $itemSold;
    private float $commissionRate;

    public function __construct(string $name, string $address, int $age, string $companyName, float $regularSalary, int $itemSold, float $commissionRate) {
        parent::__construct($name, $address, $age, $companyName);
        $this->regularSalary = $regularSalary;
        $this->itemSold = $itemSold;
        $this->commissionRate = $commissionRate;
    }

    public function calculatePay(): float {
        return $this->regularSalary + ($this->itemSold * $this->commissionRate);
    }

    public function getDetails(): string {
        return parent::getDetails() . "\nType    : Commission Employee";
    }
}

?>
