<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Support\Traits\ApiTrait;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{
    public function applyTransaction(BankAccountInterface $account):float{
        $newBalance = $account->getBalance() - $this->amount;

        if ($account->getOverdraft()->isGrantOverdraftFunds($newBalance)) {
            if($this->detectFraud(new DepositTransaction($this->amount))){
                return $newBalance;
            }
            else{
                pl("Risk detected in transaction");
            }  
        }
        if($account->getOverdraft() == new NoOverdraft){
            throw new InvalidOverdraftFundsException('Withdrawing below 0 is not allowed');
        }else{
            throw new FailedTransactionException("Withdrawing below -100 is not allowed");
        }
        
    }

    public function getTransactionInfo():string{
        return "WITHDRAW_TRANSACTION";
    }

    public function getAmount():float{
        return $this->amount;
    }
   
}
