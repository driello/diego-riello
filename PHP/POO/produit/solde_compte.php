<?php

class Account
{
    private float $amount = 0;

    public function getAmount(): float
    {
        return $this->amount;

    }
    public function setAmount(float $amount): void
    {
        if ($amount <= 0) {
            throw new Exception('Le solde est a zéro');
        }
        $this->amount = $amount;

    }
}

$account = new Account();
$account->setAmount(245000);
$account->setAmount(245000);
echo $account->getAmount() 

?>