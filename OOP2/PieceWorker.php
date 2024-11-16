<?php

require_once 'Employee.php';

class PieceWorker extends Employee {
    private int $numberItems;
    private float $wagePerItem;

    public function __construct(string $name, string $address, int $age, string $companyName, int $numberItems, float $wagePerItem) {
        parent::__construct($name, $address, $age, $companyName);
        $this->numberItems = $numberItems;
        $this->wagePerItem = $wagePerItem;
    }

    public function calculatePay(): float {
        return $this->numberItems * $this->wagePerItem;
    }

    public function getDetails(): string {
        return parent::getDetails() . "\nType    : Piece Worker";
    }
}

?>
