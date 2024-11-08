<?php namespace ComBank\Bank;

class Person{
    private $name;
    private $IdCard;
    private $email;

    public function __construct($name, $IdCard, $email){
        $this->name = $name;
        $this->IdCard = $IdCard;
        $this->email = $email;
    }
}