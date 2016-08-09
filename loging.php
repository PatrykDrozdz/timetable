<?php

session_start();

if(!isset($_POST['login']) || !isset($_POST['pass'])){
    
    header('Location: index.php');
    exit();
   
}

require_once 'connection.php';

$connection = new mysqli($host, $dbUser, $dbPass, $dbName);

if($connection->connect_errno!=0){
    echo 'Error: '.$connection->connect_errno;
}else{
 
    
    $login = $_POST['login'];
    $password = $_POST['pass'];
    
    //zabezpieczenie przed sql injection
    //////////////////////////////////////////
    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
   
    
    if($result = $connection->query(
            sprintf( "SELECT * FROM users WHERE userLogin='%s'", 
            mysqli_real_escape_string($connection, $login)))){
       ////////////////////////////////////////////////////////////// 
        $usersCount = $result->num_rows;
        if($usersCount>0){
            
            $row = $result->fetch_assoc();
            
            if(password_verify($password, $row['usersPass'])){
            
                $_SESSION['loged']=TRUE;
            
            
                $_SESSION['user'] = $row['userLogin'];
                $_SESSION['idusers'] = $row['idusers'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['surname'] = $row['surname'];
                $_SESSION['fullName'] = $row['fullName'];
                $_SESSION['flag'] = $row['flag'];
                $_SESSION['sectionId'] = $row['sections_idsections'];
                $flag = $row['flag'];
                $result->free_result();
            
          
            
                unset($_SESSION['error']);
                if($flag==0){
                    header('Location: Interface.php');
                }else if($flag==1){
                    header('Location: adminInterface.php');
                }
            
            } else {
                $_SESSION['error'] = '<span class="list-group-item list-group-item-danger">'
                        . 'Nieprawidłowy login lub hasło!</span>';
                header('Location: index.php');
            }
        } else {
            $_SESSION['error'] = '<span class="list-group-item list-group-item-danger">'
                    . 'Bład loginu lub hasła!</span>';
            header('Location: index.php');
        }
        
    }
 
    $connection->close();
    
}


?>

