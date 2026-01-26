<?php
class Movie
{
    private string $title;
    private int $duration;
    public function __construct(string $title, int $duration)
    {
        $this->title = $title;
        $this->setDuration($duration);
    }
    public function setDuration(int $duration): void
    {
        if ($duration <= 0) {
            throw new Exception("Invalid duration");
        }
        $this->duration = $duration;
    }
    public function displayMovie(): string{

        return $this->title ." (". $this->duration." min.)";
    }
}
$movie = new Movie("Inception", 156);
echo $movie->displayMovie();
?>