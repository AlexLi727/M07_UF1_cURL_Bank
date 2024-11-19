<?php namespace ComBank\Bank;

use ComBank\Support\Traits\ApiTrait;

class Person{

    use ApiTrait;
    private $name;
    private $IdCard;
    private $email;

    private $password;

    public function __construct($name, $IdCard, $email, $password){
        $this->validatePassword($password);
        if($this->validateEmail($email)){
        $this->name = $name;
        $this->IdCard = $IdCard;
        $this->email = $email;
        }else{
            echo "Not valid email";
        }
    }
}