<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Bank\BankAccount;
use ComBank\Bank\InternationalBankAccount;
use ComBank\Bank\NationalBankAccount;
use ComBank\Bank\Person;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\ZeroAmountException;

require_once 'bootstrap.php';
try{
    pl('--------- Start testing national account (No conversion) --------');
    $bankAccountTest = new NationalBankAccount(500);
    $bankAccountTest->setPerson(new Person("Alex", "1", "cookiezi@gmail.com"));
    pl("My balance: ". $bankAccountTest->getBalance(). " €");
}catch(BankAccountException $e){
    pl($e->getMessage());
}

try{
    pl('--------- Start testing international account (Dollar conversion) --------');
    $bankAccountInternational1 = new InternationalBankAccount(300);
    $bankAccountInternational1->setPerson(new Person("Alex", "1", "cookiezi@gmail.com"));
    pl("My balance: ". $bankAccountInternational1->getBalance(). " €");
    pl("Converting balance to Dollars");
    pl("Converted balance: ". $bankAccountInternational1->getConvertedBalance(). $bankAccountInternational1->getConvertedCurrency());
}catch(BankAccountException $e){
    pl($e->getMessage());
}

try{
    pl('--------- Start testing national account --------');
    $emailTest = "cookiezi@gmail.com";
    pl("Validating email: $emailTest");
    $bankAccountNational2 = new NationalBankAccount(500);
    $bankAccountNational2->setPerson(new Person("Alex", "1", $emailTest));
    if($bankAccountNational2){
        pl("Email is valid");
    }
}catch(BankAccountException $e){
    pl($e->getMessage());
}

try{
    pl('--------- Start testing international account --------');
    $emailTest2 = "AlexAlabau@correofalso.com";
    pl("Validating email: $emailTest2");
    $bankAccountNational2 = new NationalBankAccount(500);
    $bankAccountNational2->setPerson(new Person("Alex", "1", $emailTest2));
    if(empty($bankAccountNational2)){
        pl("Email is valid");
    }
}catch(BankAccountException $e){
    pl($e->getMessage());
}


pl('--------- Risk / Amount test --------');
try{
    pl('Doing transaction deposit (+10000) with current balance ' .  $bankAccountNational2->getBalance());
    $bankAccountNational2->transaction(new DepositTransaction(10000));
    pl('My new balance after deposit (+10000) : ' . $bankAccountNational2->getBalance());
    
    echo "<br>";

    pl('Doing transaction deposit (+25000) with current balance ' .  $bankAccountNational2->getBalance());
    $bankAccountNational2->transaction(new DepositTransaction(25000));
    pl('My new balance after deposit (+25000) : ' . $bankAccountNational2->getBalance());
}catch(BankAccountException $e){
    pl($e->getMessage());
}

try{
    echo "<br>";

    pl('Doing transaction withdraw (+1500) with current balance ' .  $bankAccountNational2->getBalance());
    $bankAccountNational2->transaction(new WithdrawTransaction(1500));
    pl('My new balance after withdraw (+1500) : ' . $bankAccountNational2->getBalance());
    
    echo "<br>";

    pl('Doing transaction withdraw (+7500) with current balance ' .  $bankAccountNational2->getBalance());
    $bankAccountNational2->transaction(new WithdrawTransaction(7500));
    pl('My new balance after withdraw (+7500) : ' . $bankAccountNational2->getBalance());
}catch(BankAccountException $e){
    pl($e->getMessage());
}

try{
    pl('--------- Free function --------');
    $bankAccountFree = new NationalBankAccount(500);
    $bankAccountFree->setPerson(new Person("Alex", "1", "cookiezi@gmail.com"));
    pl("Your password: ".$bankAccountFree->getPerson()->getPassword());
    $bankAccountFree->getPerson()->setPassword($bankAccountFree->getPerson()->getPassword(), "QWERTY12345");
    pl("Password changed correctly");

    $bankAccountFree->getPerson()->setPassword("Alex Alabau Garcia", "QWERTY12345");
    pl("Password changed correctly");
}catch(BankAccountException $e){
    pl($e->getMessage());
}


//---[Bank account 1]---/



$bankAccount1 = new BankAccount(400);
$bankAccount1->applyOverdraft(new NoOverdraft());
pl('--------- [Start testing bank account #1, No overdraft] --------');
try {
    $bankAccount1->getBalance();

    $bankAccount1->closeAccount();

    $bankAccount1->reopenAccount();


    // deposit +150
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new DepositTransaction(150.0));
    pl('My new balance after deposit (+150) : ' . $bankAccount1->getBalance());

    // withdrawal -25
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(25.0));
    pl('My new balance after withdrawal (-25) : ' . $bankAccount1->getBalance());

    // withdrawal -600
    pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(600));

} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (InvalidOverdraftFundsException $e){
    pl($e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount1->getBalance());




//---[Bank account 2]---/
$bankAccount2 = new BankAccount(100);
$bankAccount2->applyOverdraft(new SilverOverdraft());
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    
    // show balance account
    $bankAccount2->getBalance();
   
    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new DepositTransaction(100));
    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());

    // withdrawal -300
    pl('Doing transaction deposit (-300) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(300));
    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50
    pl('Doing transaction deposit (-50) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(50));
    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(120));
    
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (InvalidOverdraftFundsException $e){
    pl($e->getMessage());
}

pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(20));
    
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (InvalidOverdraftFundsException $e){
    pl($e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance());

try {
   
} catch (BankAccountException $e) {
    pl($e->getMessage());
}
