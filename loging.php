<?php

session_start();

if(!isset($_POST['login']) || !isset($_SESSION['pass'])){
    
   header('Location: index.php');
   exit();
   
}


require_once 'connection.php';

$connection = new mysqli($host, $dbUser, $dbPass, $dbName);

if($connection->connect_errno!=0){
    echo 'Error: '.$connection->connect_errno;
}else{
    echo'It works! </br>';
    
    $login = $_POST['login'];
    $password = $_POST['pass'];
    
    
    //zabezpieczenie przed wstrzykiwaniem sql'a
    ///////////////////////////////////////////////
    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    
    if($result = $connection->query(sprintf("SELECT * FROM users "
            . "WHERE userLogin = '$s'",
        mysqli_real_escape_string($connection, $login)))){
       /////////////////////////////////////////////     
            $howManyUsers = $result->num_rows;
            echo 'works2 </br>';
            if($howManyUsers>0){
                 
                $row = $result->fetch_assoc();
                
               if(password_verify($password, $row['usersPass'])){
                    
                    $_SESSION['login'] = $row['userLogin'];
                    
                     
                     unset($_SESSION['error']);
                     
                     $result->free();

                     header('Location: Interface.php');
                    
                } else{
                     $_SESSION['error'] = '<span style="color: red">'
                           . 'Niewłaściwy login lub hasło!</span>';
                     header('Location: logingpre.php');
                }
                
            } else{
                     $_SESSION['error'] = '<span style="color: red">'
                             . 'Niewłaściwy login lub hasło!</span>';
                     header('Location: logingpre.php');
                }
            
        }
 
    $connection->close();
    
}


?>

