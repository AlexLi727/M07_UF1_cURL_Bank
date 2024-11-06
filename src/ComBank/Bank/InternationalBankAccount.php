<?php namespace ComBank\Bank;

use ComBank\Bank\BankAccount;

class InternationalBankAccount extends BankAccount
{

    public function getConvertedBalance():float
    {
        return 0;
    }

    public function getConvertedCurrency():string
    {
        return "smth";
    }
}