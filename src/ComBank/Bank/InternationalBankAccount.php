<?php namespace ComBank\Bank;

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\NoOverdraft;

class InternationalBankAccount extends BankAccount
{

    public function __construct($balance){
        $this->balance = $balance;
        $this->status = true;
        $this->overdraft = new NoOverdraft();
        $this->currency = "USD";
    }

    public function getConvertedBalance():float
    {
        return $this->balance * 1.10;
    }

    public function getConvertedCurrency():string
    {
        return "(Rate: 1 USD = 1.10 €)";
    }
}