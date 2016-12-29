 
<?php
   //zabezpieczenie przed wejßciem z palca
    session_start();

     if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }
    
    require_once 'connection.php';
    
    
    try{
        
        $connection=new mysqli($host, $dbUser, $dbPass, $dbName);
        
        if($connection->connect_errno!=0){
            echo "Error: ".$connection->connect_errno;
        } else {
           $query = "SELECT * FROM sections";
            
            $result = $connection->query($query);
            
             $row=$result->fetch_assoc();
            
            $count = $result->num_rows;
            $result->free_result();
            
            for($i=1; $i<=$count; $i++){
               $secRes = $connection->query("SELECT * FROM sections WHERE "
                        . "idsections='$i'");
                
                $rowSec = $secRes->fetch_assoc();
                
                $tabSec[$i] = $rowSec['name'];
                
                $secRes->free_result();
                
            }
            
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
                            . "Imiemoze miec od 3 do 20 znakow</span>";
               
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
    
    if(isset($_SESSION['error_login'])){
        echo $_SESSION['error_login'];
    }
    
    if(isset($_SESSION['error_pass'])){
        echo $_SESSION['error_pass'];
    }

    if(isset($_SESSION['error_name'])){
        echo $_SESSION['error_name'];
    }
    
    if(isset($_SESSION['error_email'])){
        echo $_SESSION['error_email'];
    }
    
    if(isset($_SESSION['error_login'])){
        echo $_SESSION['error_login'] ;
    }
    
    if(isset($_SESSION['made'])){
        echo $_SESSION['made'];
    }
    
?>
<html lang="pl">
    <head>
    <meta charset="UTF-8">
        
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">     
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="fonts//bootstrap.js"></script>     
    
        <title>Organizator</title>
        
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="paliwo spalanie pojazdy licznik kalkulator baza danych"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>
        
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        

        
    </head>
    <body>
        
        <div id="container2">
          
            <div id="header">
                 <h1>Terminarz - panel administartora</h1>
             
                    
                       </div>
           
            <div id='menu'>
              
                    <br/>
                    <a href='logout.php'>Wyloguj sie</a>
                     <br/>
                     <a href="adminInterface.php">strona główna</a>
                    <br/>
                
                
            </div>
          
             <div id="make">
                <form method="post">
                    <div class="form-group"> 
                        <label for="login">Login:</label>
                        <input type="text" class="form-control" id="login"  name="login">
                    </div>
                    <div class="form-group">    
                        <label for="pass">Hasło:</label>
                        <input type="password" class="form-control" id="pass" name="pass"/>
                    </div>
                    <div class="form-group">    
                        <label for="name">Imię:</label>
                        <input type="text" class="form-control" id="name" name="name"/>
                    </div>
                    <div class="form-group">
                        <label for="surname">Nazwisko:</label>
                        <input type="text" class="form-control" id="surname" name="surname"/>
                    </div>
                    <div class="form-group">    
                        <label for="email">E-mail:</label>
                        <input type="text" class="form-control" id="email" name="email"/>
                    </div>
                    <div class="form-group">    
                        <label for="flagStatus">Status:</label> 
                        <select class="form-control" id="flagStatus" name="flagStatus">
                            <option>admin</option>
                            <option>user</option>
                        </select>
                    </div>
                    <div class="form-group">      
                        <label for="section">Sekcja:</label>
                        <select class="form-control" id="section" name="section">
                            <?php 
                            for($i=1; $i<=$count; $i++){
                                echo '<option>'.$tabSec[$i].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary active" 
                           value="Dodaj użytkownika"/>
                </form>
            </div>
             
        
            <div id="footer">
                <h2>Terminarz &copy; Prawa zastrzeżone</h2>
                 Developed by Patryk Dróżdż
                 <br/>
                 <div id="contact">
                     pdrozdz@onet.eu
                 </div>
                 
            </div>    
            
        </div>
    
       
    </body>
</html>