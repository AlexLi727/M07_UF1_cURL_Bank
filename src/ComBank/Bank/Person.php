<?php namespace ComBank\Bank;

use ComBank\Exceptions\BankAccountException;
use ComBank\Support\Traits\ApiTrait;

class Person{

    use ApiTrait;
    private $name;
    private $IdCard;
    private $email;

    private $password;

    public function __construct($name, $IdCard, $email){
        if($this->validateEmail($email)){
        $this->name = $name;
        $this->IdCard = $IdCard;
        $this->email = $email;
        $this->password = $this->createPassword();
        }else{
            throw new BankAccountException("Incorrect Email");
        }
    }

    public function setPassword(string $oldPassword, string $newPassword){
        if($oldPassword == $this->password){
            $this->password = $newPassword;
        }
    }

    public function setEmail(string $password, string $newEmail){
        if($password == $this->password && $this->validateEmail($newEmail)){
            $this->email = $newEmail;
        }else{
            throw new BankAccountException("Incorrect Email");
        }
    }

    public function setName(string $password, string $newName){
        if($password == $this->password){
            $this->name = $newName;
        }else{
            throw new BankAccountException("Incorrect Email");
        }
    }

    public function getPassword(){
        return $this->password;
    }
}