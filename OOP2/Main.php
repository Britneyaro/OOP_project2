<?php

require_once 'EmployeeRoster.php';

class InvalidOptionException extends Exception {}

class Main {
    private EmployeeRoster $roster;
    private int $size;
    private bool $repeat;

    public function start() {
        while (true) {
            $this->clear();
            echo "Enter the size of the roster (must be 1 or more): ";
            $input = readline();
            
            if (is_numeric($input) && (int)$input >= 1) {
                $this->size = (int)$input;
                $this->roster = new EmployeeRoster($this->size);
                $this->repeat = true;
                $this->entrance();
                break;
            } else {
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to retry...");
            }
        }
    }

    private function entrance() {
        while ($this->repeat) {
            $this->clear();
            $this->menu();
            $choice = readline("Select option: ");
            
            try {
                switch ((int)$choice) {
                    case 1:
                        $this->addMenu();
                        break;
                    case 2:
                        $this->deleteMenu();
                        break;
                    case 3:
                        $this->otherMenu();
                        break;
                    case 0:
                        $this->repeat = false;
                        echo "Process terminated.\n";
                        return;
                    default:
                        throw new InvalidOptionException("Invalid input. Please try again.");
                }
            } catch (InvalidOptionException $e) {
                echo $e->getMessage() . "\n";
                readline("Press \"Enter\" key to continue...");
            }
        }
    }

    private function menu() {
        echo "Available Space: " . $this->roster->availableSpace() . "\n";
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    private function addMenu() {
        $this->clear();
        echo "--- Employee Detail ---\n";
        $name = readline("Enter name: ");
        $address = readline("Enter address: ");
        $age = (int)readline("Enter age: ");
        $companyName = readline("Enter company name: ");
        
        $this->empType($name, $address, $age, $companyName);
    }

    private function empType($name, $address, $age, $companyName) {
        while (true) {
            $this->clear();
            echo "--- Employee Type ---\n";
            echo "[1] Commission Employee\n";
            echo "[2] Hourly Employee\n";
            echo "[3] Piece Worker\n";
            $type = readline("Select type of Employee: ");
            
            try {
                switch ((int)$type) {
                    case 1:
                        $this->addOnsCE($name, $address, $age, $companyName);
                        return;
                    case 2:
                        $this->addOnsHE($name, $address, $age, $companyName);
                        return;
                    case 3:
                        $this->addOnsPE($name, $address, $age, $companyName);
                        return;
                    default:
                        throw new InvalidOptionException("Invalid input. Please try again.");
                }
            } catch (InvalidOptionException $e) {
                echo $e->getMessage() . "\n";
                readline("Press \"Enter\" key to retry...");
            }
        }
    }

    private function addOnsCE($name, $address, $age, $companyName) {
        $regularSalary = (float)readline("Enter regular salary: ");
        $itemSold = (int)readline("Enter items sold: ");
        $commissionRate = (float)readline("Enter commission rate: ");

        $employee = new CommissionEmployee($name, $address, $age, $companyName, $regularSalary, $itemSold, $commissionRate);
        $this->roster->add($employee);
        $this->repeat();
    }

    private function addOnsHE($name, $address, $age, $companyName) {
        $hoursWorked = (float)readline("Enter hours worked: ");
        $rate = (float)readline("Enter rate per hour: ");

        $employee = new HourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate);
        $this->roster->add($employee);
        $this->repeat();
    }

    private function addOnsPE($name, $address, $age, $companyName) {
        $numberItems = (int)readline("Enter number of items: ");
        $wagePerItem = (float)readline("Enter wage per item: ");

        $employee = new PieceWorker($name, $address, $age, $companyName, $numberItems, $wagePerItem);
        $this->roster->add($employee);
        $this->repeat();
    }

    private function deleteMenu() {
        $this->clear();
        if ($this->roster->count() === 0) {
            echo "No employees to delete.\n";
            readline("Press \"Enter\" key to return...");
            return;
        }

        echo "*** List of Employees on the current Roster ***\n";
        $this->roster->display();

        $employeeNumber = (int)readline("\nEnter the employee number to delete (or 0 to return): ");
        if ($employeeNumber === 0) return;

        if (!$this->roster->exists($employeeNumber - 1)) {
            echo "Error: Employee does not exist.\n";
            readline("Press \"Enter\" key to retry...");
            return $this->deleteMenu();
        }

        $this->roster->remove($employeeNumber - 1);
        echo "Employee successfully removed.\n";
        readline("Press \"Enter\" key to continue...");
    }

    private function otherMenu() {
        $this->clear();
        echo "[1] Display Employees\n";
        echo "[2] Count Employees\n";
        echo "[3] Payroll\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->roster->display();
                break;
            case 2:
                echo "Total Employees: " . $this->roster->count() . "\n";
                break;
            case 3:
                $this->roster->payroll();
                break;
            case 0:
                return;
            default:
                echo "Invalid input. Please try again.\n";
        }
        readline("Press \"Enter\" key to continue...");
    }

    private function clear() {
        echo "\033[2J\033[;H"; // ANSI clear screen code
    }

    private function repeat() {
        if ($this->roster->count() < $this->size) {
            $c = readline("Add more? (y to continue): ");
            if (strtolower($c) === 'y') {
                $this->addMenu();
            }
        } else {
            echo "Roster is full.\n";
            readline("Press \"Enter\" key to return...");
        }
    }
}

$entry = new Main();
$entry->start();

?>
