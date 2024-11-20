<?php namespace ComBank\Support\Traits;

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait{
    public function validateEmail(string $email):bool
    {
        $ch = curl_init();
        $url = "https://www.disify.com/api/email/".$email;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $status = json_decode(curl_exec($ch), true);
        curl_close($ch);
        if(!$status["format"]){
            return false;
        }
        if($status["disposable"]){
            return false;
        }
        if(!$status["dns"]){
            return false;
        }
        return true;
    }

    public function convertBalance(float $balance):float
    {
        $ch = curl_init();
        $url = 'https://api.vatcomply.com/rates';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $value = json_decode(curl_exec($ch), true);
        // var_dump($value);
        // echo '<pre>' , var_dump($value) , '</pre>';
        
        $newValue = $balance * $value["rates"]["USD"];
        
        curl_close($ch);
        return $newValue;
    }

    public function detectFraud(BankTransactionInterface $smth):bool
    {
        $ch = curl_init();
        $url = 'https://67377c97aafa2ef22233ff1a.mockapi.io/Fraude';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $value = json_decode(curl_exec($ch), true);
        // echo '<pre>' , var_dump($value) , '</pre>';
        $allow = true;
        $risk = 0;
        
        foreach($value as $a => $b){
            if($smth->getTransactionInfo() == "DEPOSIT_TRANSACTION"){
                if($smth->getAmount() >= $value[$a]["Balance"] && $value[$a]["Transaction"] == "Deposit"){
                    $allow = $value[$a]["Allow"];
                    $risk = $value[$a]["Risk"];
                    break;
                } 
            }else{
                if($smth->getAmount() >= $value[$a]["Balance"] && $value[$a]["Transaction"] == "Withdraw"){
                    $allow = $value[$a]["Allow"];
                    $risk = $value[$a]["Risk"];
                    break;
                } 
            } 
        }
        pl("Transaction Risk Score: ". $risk);
        echo ("<br> Transaction Fraud Detect Result: ");
        if($allow)
            echo "Allowed <br>";
        else
            echo "Blocked <br>";

        return $allow;
    }

    public function createPassword():string{
        
        $ch = curl_init();
        $url = "https://api.genratr.com/?length=16&uppercase&lowercase&numbers";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $value = json_decode(curl_exec($ch), true);

        return $value["password"];
    }
}