<?php namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Support\Traits\ApiTrait;

class BankAccount implements BankAccountInterface
{
    protected $PersonHolder;
    protected $balance;
    protected $status;
    protected $overdraft;
    protected $currency;

    use ApiTrait;
    use AmountValidationTrait;

    public function __construct($balance){
            $this->validateAmount($balance);
            $this->balance = $balance;
            $this->status = true;
            $this->overdraft = new NoOverdraft();    
    }

    public function transaction(BankTransactionInterface $transaction){
        if($this->status == true){
            $newAmount = $transaction->applyTransaction($this);
            $this->setBalance($newAmount);
        }else{
            throw new BankAccountException("Bank account is closed");
        }
    }

    public function openAccount():bool{
        return $this-> status;
    }

    public function reopenAccount(){      
        if($this->status == false){
            $this->status = true;
        }else{
            throw new BankAccountException("The account is already opened");
        }
    }

    public function closeAccount(){
        if($this->status == true){
            $this->status = false;
        }else{
            throw new BankAccountException("The account is already closed");
        }
    }

    public function getBalance():float{
        return $this->balance;
    }

    public function getOverdraft():OverdraftInterface{
        return $this->overdraft;
    }

    public function applyOverdraft(OverdraftInterface $overdraft){
        $this->overdraft = $overdraft;
    }

    public function setBalance(float $amount){
        $this->balance = $amount;
    }

    public function getPerson(){
        return $this->PersonHolder;
    }

    public function setPerson(Person $person){
        $this->PersonHolder = $person;
    }
    }
