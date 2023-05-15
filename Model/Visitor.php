<?php

class Visitor extends User{
    private string $name;
    public function __construct($username,$password,$userType,$name){
        User::__construct($username,$password,'visitor');
        $this->name=$name;
    }
    public function getName(){
        return $this->name;
    }
}
?>