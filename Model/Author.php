<?php
require_once('User.php');
class Author extends User{
    private string $fullName;
    private int $age;
    private string $agency;
    public function __construct($username,$password,$userType,$fullName,$age,$agency){
        User::__construct($username,$password,'author');
        $this->fullName=$fullName;
        $this->age=$age;
        $this->agency=$agency;
    }
    public function getFullName(){
        return $this->fullName;
    }
    public function getAge(){
        return $this->age;
    }
    public function getAgency(){
        return $this->agency;
    }
    public static function publishPost($title,$content,$userIndex){
        $post=new Post($title,$content);
        $json=file_get_contents('./Model/data.json');
        $data=json_decode($json,true);
        $postArray=array(
                        'title'=>$post->getTitle(),
                        'content'=>$post->getContent(),
                        'date'=>$post->getDate(),
                        'likes'=>0
                        );
        $data["Users"][$userIndex]["posts"][]=$postArray;//here is the trick .... with how i'm gonna use a specific author index 

        $json=json_encode($data,JSON_PRETTY_PRINT);
        file_put_contents('./Model/data.json',$json);

    }
}

?>