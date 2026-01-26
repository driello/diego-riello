<?php
class Note
{
    public int $valeur;
    public function estValide(): bool
    {
        return $this->valeur >= 0 && $this->valeur <= 20;
    }
}
$note = new Note();
$note->valeur = 18;

echo $note->estValide() ? "La note est validée" : "La note n'est pas validée";

?>

<?php
class User
{
    private string $name;
    private string $email;

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;

    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}

$user = new User();
$user->setName("Francis");
$user->setEmail("francis@mail.fr");
echo $user->getName();

?>


<?php
class Student
{
    private int $grade;
    public function getGrade(): int
    {
        return $this->grade;
    }
    public function setGrade(int $grade)
    {
        if ($grade < 0 || $grade > 20) {
            throw new Exception("La note doit être comprise entre 0 et 20");
        }
        $this->grade = $grade;
    }
}
$student = new Student();
$student->setGrade(12);
echo $student->getGrade();

?>