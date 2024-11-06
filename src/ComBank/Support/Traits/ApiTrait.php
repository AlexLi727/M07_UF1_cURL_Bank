<?php namespace ComBank\ApiTrait;

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait{
    public validateEmail(string $email):bool
    {
        echo $email;
        return true;
    }

    public convertBalance(float $balance):float
    {
        return $balance;
    }

    public detectFraud(new BankTransactionInterface $smth):bool
    {
        echo $smth;
        return true;
    }
}