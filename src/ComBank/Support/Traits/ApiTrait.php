<?php namespace ComBank\Support\Traits;

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait{
    public function validateEmail(string $email):bool
    {
        return true;
    }

    public function convertBalance(float $balance):float
    {
        $ch = curl_init();
        $url = 'https://api.vatcomply.com/rates';
        curl_setopt($ch, CURLOPT_URL, $url);
        $value = curl_exec($ch);
        curl_close($ch);
        $balance *= $value["USD"];
        return $balance;
    }

    public function detectFraud(BankTransactionInterface $smth):bool
    {
        return true;
    }
}