<?php namespace ComBank\Bank;

use ComBank\Support\Traits\ApiTrait;

class Person{

    use ApiTrait;
    private $name;
    private $IdCard;
    private $email;

    public function __construct($name, $IdCard, $email){
        if($this->validateEmail($email)){
        $this->name = $name;
        $this->IdCard = $IdCard;
        $this->email = $email;
        }else{
            echo "Not valid email";
        }
    }
}