 
<?php

    require_once 'connection.php';
    require_once 'getSections.php';
    
    try{
        
        $connection=new mysqli($host, $dbUser, $dbPass, $dbName);
        
        if($connection->connect_errno!=0){
            echo "Error: ".$connection->connect_errno;
        } else {
            
            if(isset($_POST['login']) && isset($_POST['section'])){
                
                $valid = TRUE;
                $login = $_POST['login'];
                 
                if(ctype_alnum($login)==FALSE){
                    $valid = FALSE;
                    $_SESSION['error_login'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>"
                            . "Login nie moze miec polskich znakow</span>";
                }
             
                if(strlen($login)<3 || strlen($login)>20){
                    $valid = FALSE;
                    $_SESSION['error_login'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>"
                            . "Login moze miec od 3 do 20 znakow</span>";
               
                }
                
                $pass=$_POST['pass'];
            
                if(strlen($pass)<5 || strlen($pass)>10){
                    $valid=FALSE;
                    $_SESSION['error_pass'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>"
                            . "Hasło musi miec od 5 do 10 znakow</span>";
                }
            
                if(ctype_alnum($pass)==FALSE){
                    $valid = FALSE;
                    $_SESSION['error_pass'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>"
                            . "Hasło nie moze miec polskich znakow</span>";
                }
                
                //hashowanie hasła
                $pass_hashed = password_hash($pass, PASSWORD_DEFAULT);
                // echo $pass_hashed;
             
                $name = $_POST['name'];
             
                if(ctype_alnum($name)==FALSE){
                    $valid = FALSE;
                    $_SESSION['error_name'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>"
                            . "Imie nie moze miec polskich znakow</span>";
                }
             
                if(strlen($name)<3 || strlen($login)>20){
                    $valid = FALSE;
                    $_SESSION['error_name'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>"
                            . "Imiemoze miec od 3 do 20 znakow</span>";
               
                }
                
                $surname = $_POST['surname'];
             
             
                if(ctype_alnum($surname)==FALSE){
                    $valid = FALSE;
                    $_SESSION['error_name'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>"
                            . "Imie nie moze miec polskich znakow</span>";
                }
             
                if(strlen($surname)<2 || strlen($surname)>20){
                    $valid = FALSE;
                    $_SESSION['error_name'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>"
                            . "Nazwisko moze miec od 3 do 20 znakow</span>";
               
                }
                
                $email = $_POST['email'];
                
                $email_san = filter_var($email, FILTER_VALIDATE_EMAIL);
                
                if((filter_var($email_san, FILTER_VALIDATE_EMAIL)==FALSE) ||
                        $email_san!=$email){
                            $valid = FALSE;
                            $_SESSION['error_email'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>"
                                    . "Podaj własciwy adres e-mail</span>";
                        }
                        
                 $flagStat=$_POST['flagStatus'];    
                
                 if($flagStat=='admin'){
                     $flag = 1;
                 }else if($flagStat=='user'){
                     $flag=0;
                 }
                 
                 $section = $_POST['section'];
                 
                 $sectionResult = $connection->query("SELECT * FROM sections WHERE name='$section'");

                 $rowSections = $sectionResult->fetch_assoc();
                 
                 $idsections = $rowSections['idsections'];

                 $sectionResult->free_result();
                 
                 $checkRes = $connection->query("SELECT * FROM users WHERE userLogin='$login'");
                 
                 if(!$checkRes){
                     throw new Exception($connection->errno());
                 }
                 
                 $usersCount = $checkRes->num_rows;
                 
                 if($usersCount>0){
                     $valid = FALSE;
                     $_SESSION['error_login'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>Uzytkownik o  podanym loginie "
                             . "jest juz w bazie</span>";
                 }
       
                 $fullName = $name.'_'.$surname;
                 
                 $insertQuery = "INSERT INTO users(idusers, sections_idsections, "
                             . "userLogin, usersPass, name, surname, fullName, email, flag) "
                             . "VALUES (NULL, '$idsections', '$login', '$pass_hashed', "
                             . "'$name', '$surname', '$fullName', '$email', '$flag')";
                 
                 $alterQuery = "ALTER TABLE invited ADD `$login` "
                         . "INT NOT NULL AFTER meetings_users_idusers";
                 
                 if($valid==TRUE){

                     if($connection->query($insertQuery)){
                         
                         if($flag==0){
                            if($connection->query($alterQuery)){
                         
                                $_SESSION['made'] = "<span class='list-group-item "
                                        . "list-group-item-success'>Konto zostało dodane do bazy</span>";
                            
                            } else {
                             
                                throw new Exception($connection->errno);
                            }
                         } else {
                              $_SESSION['made'] = "<span class='list-group-item "
                                        . "list-group-item-success'>Konto zostało dodane do bazy</span>";
                         }
                     } else {
                        throw new Exception($connection->errno);
                     }
                 }
                 
            }
        }
        $connection->close();
    }catch(Exception $e){
        echo $e;
    }

?>
