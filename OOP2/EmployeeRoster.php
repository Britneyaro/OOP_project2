<?php

require_once 'Employee.php';
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class EmployeeRoster {
    private array $roster;
    private int $size;

    public function __construct(int $size) {
        $this->size = $size;
        $this->roster = [];
    }

    public function add(Employee $employee) {
        if (count($this->roster) < $this->size) {
            $this->roster[] = $employee;
            echo "Employee added successfully.\n";
        } else {
            echo "Roster is full. Cannot add more employees.\n";
        }
    }

   public function remove(int $index) {
        if (isset($this->roster[$index])) {
            unset($this->roster[$index]);

        } else {
            echo "Invalid employee index.\n";
        }
    }

    public function exists(int $index): bool {
         return isset($this->roster[$index]);
    }
    

    public function availableSpace() {
        return $this->size - count($this->roster);
    }

    public function display() {
        if (empty($this->roster)) {
            echo "No employees in the roster.\n";
        } else {
            foreach ($this->roster as $index => $employee) {
                echo "[" . ($index + 1) . "] " . $employee->getDetails() . "\n";
            }
        }
    }

    public function displayCE() {
        $this->displayByType(CommissionEmployee::class, "No Commission Employees in the roster.");
    }

    public function displayHE() {
        $this->displayByType(HourlyEmployee::class, "No Hourly Employees in the roster.");
    }

    public function displayPE() {
        $this->displayByType(PieceWorker::class, "No Piece Workers in the roster.");
    }

    private function displayByType(string $type, string $emptyMessage) {
        $found = false;
        foreach ($this->roster as $index => $employee) {
            if ($employee instanceof $type) {
                echo "[" . ($index + 1) . "] " . $employee->getDetails() . "\n";
                $found = true;
            }
        }
        if (!$found) {
            echo $emptyMessage . "\n";
        }
    }

    public function count() {
        $count = count($this->roster);
        if ($count === 0) {
            echo "No employees in the roster.\n";
        } else {
            echo "Total employees: " . $count . "\n";
        }
        return $count;
    }
    
    public function countCE() {
        $this->countByType(CommissionEmployee::class, "No Commission Employees in the roster.");
    }
    
    public function countHE() {
        $this->countByType(HourlyEmployee::class, "No Hourly Employees in the roster.");
    }
    
    public function countPE() {
        $this->countByType(PieceWorker::class, "No Piece Workers in the roster.");
    }
    
    private function countByType(string $type, string $emptyMessage) {
        $count = count(array_filter($this->roster, fn($e) => $e instanceof $type));
        if ($count === 0) {
            echo $emptyMessage . "\n";
        } else {
            echo "Total " . basename(str_replace('\\', '/', $type)) . ": " . $count . "\n";
        }
        return $count;
    }
    

    public function payroll() {
        if(!empty($this->roster)){
        foreach ($this->roster as $employee) {
            echo $employee->getDetails() . " - Pay: " . $employee->calculatePay() . "\n";
        }
    }
        else{
            echo "\nNo employee to calculate payroll\n";
        }
        
        
    }
}
?>
