<?php
class Post{
    private string $title;
    private string $content;
    private $date;
    public function __construct($title,$content){
        $this->title=$title;
        $this->content=$content;
        $this->date=date("d-m-Y");
    }
    public function getTitle(){
        return $this->title;
    }
    public function getContent(){
        return $this->content;
    }
    public function getDate(){
        return $this->date;
    }
}

?>