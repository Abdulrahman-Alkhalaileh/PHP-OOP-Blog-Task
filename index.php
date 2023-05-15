<?php
// $json=file_get_contents('./Model/data.json');
// $data=json_decode($json,true);
// $postArray=array(
//     'title'=>'hello',
//     'content'=>'i love the movie john wick',
//     'date'=>date('d/m/y')
//     );
// $data["Users"][1]["posts"][]=$postArray;
// print_r($data["Users"][1]["posts"]);
// $json=json_encode($data,JSON_PRETTY_PRINT);
// file_put_contents('./Model/data.json',$json);

require './Model/User.php';
require './Model/Blog.php';
require './Model/Author.php';
require './Model/Visitor.php';
require './Model/Post.php';


$blog=new Blog();
$blog->startBlog();
?>