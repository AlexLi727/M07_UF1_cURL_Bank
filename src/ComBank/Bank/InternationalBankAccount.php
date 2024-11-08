<?php namespace ComBank\Bank;

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\NoOverdraft;

class InternationalBankAccount extends BankAccount
{

    public function __construct($balance, $name, $IdCard, $email){
        $this->balance = $balance;
        $this->status = true;
        $this->overdraft = new NoOverdraft();
        $this->currency = "USD";
        $this->PersonHolder = new Person($name, $IdCard, $email);
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