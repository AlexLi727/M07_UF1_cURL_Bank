<?php namespace ComBank\Bank;

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Support\Traits\ApiTrait;


class InternationalBankAccount extends BankAccount
{
    use ApiTrait;

    public function __construct($balance, $name, $IdCard, $email, $password){
        if($this->validateEmail($email)){
        $this->balance = $balance;
        $this->status = true;
        $this->overdraft = new NoOverdraft();
        $this->currency = "USD";
        $this->PersonHolder = new Person($name, $IdCard, $email, $password);
        }else{
            echo "Not valid email";
        }
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