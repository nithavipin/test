<?php
// error_reporting(1);

session_start();
// $_SESSION["user_id"]=1;
 if(isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]==true){
    header("Location: index.php");
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="login.php" method ="GET" >
        <input type ="text" name ="user_name"  placeholder="user_name"><br>
        <input type = "password" name ="user_password" placeholder="user_password"><br>
        <input type = "submit" name="loggin" value="Log In">
    
</body>
</html>

<?php


/*if(isset($_GET["user_name"]));{
$user_name= $_GET["user_name"];

    $errors[] = "Enter user name";
}

if(isset($_GET["user_password"]));{
    $user_password= $_GET["user_password"];
    } 
        $errors[] = "Enter password";*/
if(isset($_GET['loggin']))   // it checks whether the user clicked login button or not 
{
 
$errors = array();
require __DIR__ . '/conn.php';


     $user_name = $_GET['user_name'];
     $user_password = $_GET['user_password'];
 

     $sql = "SELECT * FROM `login` WHERE `user_name`= '$user_name' AND `user_password`= '$user_password' " ;

    
     $result = $conn->query($sql);
    
     if($result==true){

       
        if($result->num_rows > 0){
            while($row= $result->fetch_assoc()){
                $user_id = $row["user_id"];
            }
        }else{
            $errors[]="Incorrect Username or Password";
        }
     }
     
 
     if(empty($errors)){
        // die("Here");
       $_SESSION["user_id"]= $user_id;
       $_SESSION["isLoggedIn"]=true;
       $_SESSION["user_name"]=$user_name;
       header("Location: index.php");
     }else{
         echo implode("<br>",$errors);
     }


}else{
    $errors[]="incorrect details";
}
   
?>





