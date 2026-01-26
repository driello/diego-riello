<?php
class Product{

    public  string $name;
    public float $price;

    public function getPrice() : float {
        return $this->price;
    }
    public function setPrice(float $price) : void{
        if ($price < 1) {
            throw new Exception("Le prix ne peut pas être infèrieur à 1");
            
}
    }
     public function getName() : float {
        return $this->price;
    }
    public function setName(string $name) : void{
        $this->name = $name;
            
}
    }
$product = new Product();
$product->setName("Bonbons Haribo c'est beau");
$product->setPrice(1.99);
?>