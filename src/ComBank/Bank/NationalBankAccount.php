<?php namespace ComBank\Bank;

use ComBank\Bank\BankAccount;

class NationalBankAccount extends BankAccount{

    public function __construct($balance, $name, $IdCard, $email){
        parent::__construct($balance, $name, $IdCard, $email);
        $this->currency = "EUR";
    }

}