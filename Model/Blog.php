<?php
class Blog{
    public function startBlog(){
        $input=readline("choose by type (1 or 2) for:\n1-Register \n2-Login\n");
        echo "\n\n";
        if($input=="1"){
            $this->register();
        }else if($input=="2"){
            $this->login();
        }else{
            echo ('Invalid input, try again');
            $this->startBlog();
        }
    }
    public function register(){
        //decode json file by using custom method jsonDecode();
        $data=$this->jsonDecode();
        $input=readline("choose userType you want (1 or 2): \n1-Visitor \n2-Author\n");
        echo "\n\n";

        $username=readline('Enter your username:');

            //check for username validity and uniqueness
            for($i=0;$i<count($data["Users"]);$i++){
                if($username==''){
                    echo "username should not be empty\n";
                    $this->register();
                }else if($data["Users"][$i]['username']==$username){
                    echo "Username \"$username\" is already in use, try another\n";
                    $this->register();
                    break;
                }
            }
            $password=readline('Enter your password:');

        if($input=="1"){
            //visitor register...  
            $name=readline('Enter your name:');
            $user=new Visitor($username,$password,'visitor',$name);
            $userArray=array(
                            "username"=>$user->getUsername(),
                            "password"=>$user->getPassword(),
                            "userType"=>$user->getUserType(),
                            "name"=>$user->getName()
                            );
            //assign new user to json file
            $data['Users'][]=$userArray;
            $this->jsonEncode($data);
        }else if($input=="2"){
            //same for author register...
            $fullName=readline('Enter your Full Name:');
            $age=readline('Enter your age:');
            $agency=readline('Enter your agency:');
            $user=new Author($username,$password,'author',$fullName,$age,$agency);
            $userArray=array(
                "username"=>$user->getUsername(),
                "password"=>$user->getPassword(),
                "userType"=>$user->getUserType(),
                "fullName"=>$user->getFullName(),
                "age"=>$user->getAge(),
                "agency"=>$user->getAgency(),
                "posts"=>[]
                );
            //assign new user to json file
            $data['Users'][]=$userArray;
            $this->jsonEncode($data);
        }else{
            echo ("Invalid input.\n");{
                $this->register();
            }
        }
    }
    
    public function login(){
        $data=$this->jsonDecode();
        $username=readline("Enter Username: \n");
        $realUser="";
        $userIndex=null;
        $userNotFound=true;
        foreach($data["Users"] as $i=>$user){
            if($user["username"]==$username){
                $realUser=$username;
                $userIndex=$i;
                $userNotFound=false;
                echo "Welcome back $realUser !!\n";
                break;
            }
        }//if no user found
        if($userNotFound==true){
            echo "Incorrect username, try another one \n\n";
            $this->login();
        }
        //if successfully login, transport to author/visitor interface
        if($data["Users"][$userIndex]["userType"]=="author"){
            $this->publishPostFactory($userIndex);
        }else if($data["Users"][$userIndex]['userType']=="visitor"){
            $this->showAuthors();
        }
    }

    //method for author
    public static function publishPostFactory($userIndex){
        $title=readline("Enter post's title: \n");
        $content=readline("Enter post's content: \n");
        Author::publishPost($title,$content,$userIndex);
        echo "post published successfully!! \n";
    }

    //methods for visitor
    public function showAuthors(){
        echo "Authors: \n";
        echo "______________________\n";
        $authors=[];
        $data=$this->jsonDecode();
        foreach($data["Users"] as $index=>$user){
            if($user["userType"]=='author'){
                echo "\033[34mID: ".$index."\n";
                echo "Full name: ".$user["fullName"]."\n";
                echo "Age: ".$user["age"]."\n";
                echo "Agency: ".$user["agency"]."\n";
                echo "Total posts: ".count($user["posts"])."\033[0m\n";
                echo "_________________________\n";
            }
        }
        echo "_________________________\n";
        $id=readline("Enter ID of Author you want:\n");
        if(!empty($data["Users"][$id]["posts"])){
        $this->showAuthorPosts($id);
        }else{
            echo "\033[31mThis author doesn't have posts yet.\033[0m\n";
            $this->showAuthors();
        }
    }
    public function showAuthorPosts($id){
        echo"\n\n";
        $data=$this->jsonDecode();
        foreach($data["Users"][$id]['posts'] as $index=>$post){
            echo "\033[35mPost ID: ".$index."\n";
            echo "Title: ".$post["title"]."\n";
            echo "Content: ".$post["content"]."\n";
            echo "Publish Date: ".$post["date"]."\n";
            echo "Likes: ".$post["likes"]."\033[0m\n";
            echo "_______________________\n\n";
        }
        $postID=readline("choose the ID of post you likes: \n");
        $this->likePost($postID,$id);
    }
    public function likePost($postID,$id){
        $data=$this->jsonDecode();
        $data["Users"][$id]["posts"][$postID]['likes']++;
        $this->jsonEncode($data);
        echo "Like successfully made!";
        $this->showAuthors();
    }

    //json controller.(serialize)...............
    public function jsonDecode(){
        $json=file_get_contents('./Model/data.json');
        $data=json_decode($json,true);
        return $data;
    }
    public function jsonEncode($data){
        $json=json_encode($data,JSON_PRETTY_PRINT);
        file_put_contents("./Model/data.json",$json);
    }
}

?>