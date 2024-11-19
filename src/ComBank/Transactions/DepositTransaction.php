<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\BankAccountException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Support\Traits\ApiTrait;

class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{
    public function applyTransaction(BankAccountInterface $account):float{
        if($this->detectFraud(new DepositTransaction($this->amount))){
            return $account->getBalance() + $this->amount;
        }  
        else{
            pl("Risk detected in transaction");
        }
    }

    public function getTransactionInfo():string{
        return "DEPOSIT_TRANSACTION";
    }

    public function getAmount():float{
        return $this->amount;
    }


   
}
