<?php namespace ComBank\Bank;

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Support\Traits\ApiTrait;


class InternationalBankAccount extends BankAccount
{
    use ApiTrait;

    public function __construct($balance){
        parent::__construct($balance);
        $this->currency = "USD";
    }
    
    public function getConvertedBalance():float
    {
        return $this->convertBalance($this->balance);
    }

    public function getConvertedCurrency():string
    {
        return "€";
    }
}