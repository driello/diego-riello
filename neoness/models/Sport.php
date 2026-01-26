<?php
class Sport extends Model
{
    public function __construct()
    {
        $this->table = "sports";
        $this->getConnection();
    }
}