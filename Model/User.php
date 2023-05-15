<?php
class User {

    protected string $username;
    protected string $password;
    protected string $userType;
    public function __construct($username,$password,$userType){
        $this->username=$username;
        $this->password=$password;
        $this->userType=$userType;
    }
    public function getUsername(){
        return $this->username;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getUserType(){
        return $this->userType;
    }
}

?>