<?php

require_once 'connection.php';

$idUser = $_SESSION['idusers'];

$fullName = $_SESSION['fullName'];

$nameSurname = explode("_", $fullName);

if(isset($_POST['editLogin'])){
    
    $newLogin = $_POST['editLogin'];
    
    try{
        
        $valid=true;
        
        $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
        if(ctype_alnum($newLogin)==FALSE){
            $valid = FALSE;
            $_SESSION['error_login_change'] = "<span class='list-group-item "
                 . "list-group-item-danger'>"
            . "Login nie moze miec polskich znakow</span>";
        }
             
        if(strlen($newLogin)<3 || strlen($newLogin)>20){
            $valid = FALSE;
             $_SESSION['error_login_change'] = "<span class='list-group-item "
                    . "list-group-item-danger'>"
            . "Login moze miec od 3 do 20 znakow</span>";
               
        }
        
        $checkRes = $connection->query("SELECT * FROM users WHERE userLogin='$newLogin'");
                 
        if(!$checkRes){
            throw new Exception($connection->errno());
        }
                 
        $usersCount = $checkRes->num_rows;
                 
        if($usersCount>0){
            $valid = FALSE;
            $_SESSION['error_login_change'] = "<span class='list-group-item "
                . "list-group-item-danger'>Uzytkownik o  podanym loginie "
            . "jest juz w bazie</span>";
        }
        
        $updateQuery = "UPDATE users SET userLogin = '$newLogin' WHERE idusers = '$idUser'";
        
        if($valid==TRUE){
            if($connection->query($updateQuery)){
                $_SESSION['edit'] = "<span class='list-group-item "
                         . "list-group-item-success'>Twój logi został zmieniony</span>";
                header('Location: adding.php');
            }
            
            
        }

    }  catch (Exception $e){
        echo $e;
    }
    
    $connection->close();
}

if(isset($_POST['editPass'])){
    
    $newPass = $_POST['editPass'];
    
    try{
        
        $valid=true;
        
        $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
        if(strlen($newPass)<5 || strlen($pass)>10){
            $valid=FALSE;
            $_SESSION['error_pass_change'] = "<span class='list-group-item "
                . "list-group-item-danger'>"
            . "Hasło musi miec od 5 do 10 znakow</span>";
        }
            
        if(ctype_alnum($newPass)==FALSE){
            $valid = FALSE;
            $_SESSION['error_pass_change'] = "<span class='list-group-item "
                . "list-group-item-danger'>"
            . "Hasło nie moze miec polskich znakow</span>";
        }
        
        $pass_hashed = password_hash($newPass, PASSWORD_DEFAULT);
        
        $updateQuery = "UPDATE users SET usersPass = '$pass_hashed' WHERE idusers = '$idUser'";
        
        if($valid==TRUE){
            if($connection->query($updateQuery)){
                $_SESSION['edit'] = "<span class='list-group-item "
                         . "list-group-item-success'>Twoje hasło zostało zmienione</span>";
                header('Location: adding.php');
            }
            
            
        }

    }  catch (Exception $e){
        echo $e;
    }
    
    $connection->close();
}

if(isset($_POST['editName'])){
    
    $newName = $_POST['editName'];
    
    try{
        
        $valid=true;
        
        $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
        if(ctype_alnum($newName)==FALSE){
            $valid = FALSE;
            $_SESSION['error_name_change'] = "<span class='list-group-item "
                 . "list-group-item-danger'>"
            . "Imie nie moze miec polskich znakow</span>";
        }
             
        if(strlen($newName)<3 || strlen($newName)>20){
            $valid = FALSE;
             $_SESSION['error_name_change'] = "<span class='list-group-item "
                    . "list-group-item-danger'>"
            . "Imię moze miec od 3 do 20 znakow</span>";
               
        }
        
        $fullNameEdit = $newName.'_'.$nameSurname[1];
        
        $updateQuery = "UPDATE users SET name = '$newName', fullName = "
                . "'$fullNameEdit' WHERE idusers = '$idUser'";
        
        if($valid==TRUE){
            if($connection->query($updateQuery)){
                $_SESSION['edit'] = "<span class='list-group-item "
                         . "list-group-item-success'>Twoje imię zostało zmienione</span>";
                header('Location: adding.php');
            }

        }

    }  catch (Exception $e){
        echo $e;
    }
    
    $connection->close();
}

if(isset($_POST['editSurename'])){
    
    $newSurename = $_POST['editSurename'];
    
    try{
        
        $valid=true;
        
        $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
        if(ctype_alnum($newSurename)==FALSE){
            $valid = FALSE;
            $_SESSION['error_surename_change'] = "<span class='list-group-item "
                 . "list-group-item-danger'>"
            . "Nazwisko nie moze miec polskich znakow</span>";
        }
             
        if(strlen($newSurename)<3 || strlen($newSurename)>20){
            $valid = FALSE;
             $_SESSION['error_surename_change'] = "<span class='list-group-item "
                    . "list-group-item-danger'>"
            . "Nazwisko moze miec od 3 do 20 znakow</span>";
               
        }
        
        $fullNameEdit = $nameSurname[0].'_'.$newSurename;
        
        $updateQuery = "UPDATE users SET surname = '$newSurename', fullName = "
                . "'$fullNameEdit' WHERE idusers = '$idUser'";
        
        if($valid==TRUE){
            if($connection->query($updateQuery)){
                $_SESSION['edit'] = "<span class='list-group-item "
                         . "list-group-item-success'>Twoje nazwisko zostało zmienione</span>";
                header('Location: adding.php');
            }

        }

    }  catch (Exception $e){
        echo $e;
    }
    
    $connection->close();
}

if(isset($_POST['editEmail'])){
    
    $newEmail= $_POST['editEmail'];
    
    try{
        
        $valid=true;
        
        $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
        $email_san = filter_var($newEmail, FILTER_VALIDATE_EMAIL);
                
        if((filter_var($email_san, FILTER_VALIDATE_EMAIL)==FALSE) ||
                        $email_san!=$newEmail){
             $_SESSION['error_email_change'] = "<span class='list-group-item "
                    . "list-group-item-danger'>"
            . "Podaj właściwy e-mail</span>";    
        }

        $updateQuery = "UPDATE users SET email = '$newEmail' WHERE idusers = '$idUser'";
        
        if($valid==TRUE){
            if($connection->query($updateQuery)){
                $_SESSION['edit'] = "<span class='list-group-item "
                         . "list-group-item-success'>Twój e-mail zostało zmienione</span>";
                header('Location: adding.php');
            }

        }

    }  catch (Exception $e){
        echo $e;
    }
    
    $connection->close();
}

if(isset($_POST['editSection'])){
    
    $newSection= $_POST['editSection'];
    
    try{
        
        $valid=true;
        
        $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
        $result = $connection->query("SELECT * FROM sections WHERE name = '$newSection'");
        
        $row = $result->fetch_assoc();
        
        $idSection = $row['idsections'];
        
        $result->free();

        $updateQuery = "UPDATE users SET sections_idsections = '$idSection' WHERE idusers = '$idUser'";

        if($valid==TRUE){
            if($connection->query($updateQuery)){
                $_SESSION['edit'] = "<span class='list-group-item "
                         . "list-group-item-success'>Zmieniono Twój dział w pracy</span>";
                header('Location: adding.php');
            }

        }

    }  catch (Exception $e){
        echo $e;
    }
    
    $connection->close();
}


?>

