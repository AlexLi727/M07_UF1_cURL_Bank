<?php namespace ComBank\Bank;

use ComBank\Bank\BankAccount;

class NationalBankAccount extends BankAccount{

    public function __construct($balance){
        parent::__construct($balance);
        $this->currency = "EUR";
    }

}