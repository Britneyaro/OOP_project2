<?php

abstract class Employee {
    protected string $name;
    protected string $address;
    protected int $age;
    protected string $companyName;
    

    public function __construct(string $name, string $address, int $age, string $companyName) {
        $this->name = $name;
        $this->address = $address;
        $this->age = $age;
        $this->companyName = $companyName;
    }



    abstract public function calculatePay(): float;

    public function getDetails(): string {
        return "Name    : {$this->name} 
                Address : {$this->address} 
                Age     : {$this->age} 
                Company : {$this->companyName}";
    }
}

?>
