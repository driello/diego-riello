 <?php
    class Message {
        private string $content;
        private string $author;
        public function __construct(string $content, string $author) {
            $this->content = $content;
            $this->author = $author;
        }
        public function getContent(): string {
            return $this->content;
        }
        public function getAuthor(): string {
            return $this->author;
        }
    }
    $message1 = new Message("Bonjour", "Roger");
    echo $message1->getContent() . ", un texte de ". $message1->getAuthor();
 
?>
 