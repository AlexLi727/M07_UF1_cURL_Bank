<?php namespace ComBank\ApiTrait;

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait{
    public function validateEmail(string $email):bool
    {
        return true;
    }

    public function convertBalance(float $balance):float
    {
        $balance *= 1.20;
        return $balance;
    }

    public function detectFraud(BankTransactionInterface $smth):bool
    {
        return true;
    }
}