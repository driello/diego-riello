<?php

class People
{
    private int $age;
    public function getAge(): int
    {
        return $this->age;
    }
    public function setAge(int $age): void
    {
        if ($age < 0 || $age > 130) {
            throw new Exception("L'âge doit être compris entre 0 et 130 ans");

        }
        $this->age = $age;
    }
}

$people = new People();
$people->setAge(42);
echo"". $people->getAge() ."";

?>

