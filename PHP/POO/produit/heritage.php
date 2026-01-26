<?php
abstract class Employer
{
    protected string $name;
    protected float $salary;

    public function __construct(string $name, float $salary)
    {
        $this->name = $name;
        $this->salary = $salary;
    }
    abstract public function bonus() :float;
}
class Manager extends Employer
{
    public function bonus(): float
    {
        return $this->salary * 1.2;

    }

}
class Technician extends Employer
{
    public function bonus(): float
    {
        return $this->salary * 1.1;
    }
}

class Commercial extends Employer{
    public function bonus():float {
        return $this->salary * 1.05;

    }
}

$manager = new Manager("Brian", 3000);
$technician = new Technician("Pedro", 2000);
$commercial = new Commercial("Georges",2200);
echo $manager->bonus()."\n";
echo $technician->bonus()."\n";
echo $commercial->bonus()."\n";
?>