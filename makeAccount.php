 
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
            
            if(isset($_POST['login'])){
                
                $valid = TRUE;
                $login = $_POST['login'];
                 
                if(ctype_alnum($login)==FALSE){
                    $valid = FALSE;
                    $_SESSION['error_login'] = "Login nie moze miec polskich znakow";
                }
             
                if(strlen($login)<3 || strlen($login)>20){
                    $valid = FALSE;
                    $_SESSION['error_login'] = "Login moze miec od 3 do 20 znakow";
               
                }
                
                $pass=$_POST['pass'];
            
                if(strlen($pass)<5 || strlen($pass)>10){
                    $valid=FALSE;
                    $_SESSION['error_pass'] = "Login musi miec od 5 do 10 znakow";
                }
            
                if(ctype_alnum($pass)==FALSE){
                    $valid = FALSE;
                    $_SESSION['error_pass'] = "Login nie moze miec polskich znakow";
                }
                
                //hashowanie hasła
                $pass_hashed = password_hash($pass, PASSWORD_DEFAULT);
                // echo $pass_hashed;
             
                $name = $_POST['name'];
             
                if(ctype_alnum($name)==FALSE){
                    $valid = FALSE;
                    $_SESSION['error_name'] = "Imie nie moze miec polskich znakow";
                }
             
                if(strlen($name)<3 || strlen($login)>20){
                    $valid = FALSE;
                    $_SESSION['error_name'] = "Imiemoze miec od 3 do 20 znakow";
               
                }
                
                $surname = $_POST['surname'];
             
                
            }
        }
        $connection->close();
    }catch(Exception $e){
        echo $e;
    }

?>
<html lang="pl">
    <head>
    <meta charset="UTF-8">
        
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta http-equiv="Refresh" content="60"/>
    
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
        
        <div id="container">
          
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
                    <br/>
                  login: <br/> <input type="text" name="login" id="textfield"/>
                  <br/>
                    <br/>
                 hasło:<br/> <input type="password" name="pass" id="textfield"/>
                      <br/>
                    <br/>
                    imię:<br/> <input type="text" name="name" id="textfield"/>
                       <br/>
                    <br/>
                nazwisko: <br/><input type="text" name="surname" id="textfield"/>
                       <br/>
                    <br/>
                    e-mail: <br/><input type="text" name="email" id="textfield"/>
                       <br/>
                    <br/>
                    status: <br/> <select name="flagStatus" id="textfield">
                        <option>admin</option>
                        <option>user</option>
                            </select>
                       <br/>
                    <br/>
                    sekcja: <br/> <select name="name" id="textfield">
                        
                        <?php 
                        for($i=1; $i<=$count; $i++){
                            echo '<option>'.$tabSec[$i].'</option>';
                        }
                        
                        ?>

                            </select>
                       <br/>
                    <br/>
                    <input type="submit" value="dodaj użytkownika" id="buttonadmin"/>
                </form>
            </div>
             
        
            <div id="footer">
                <h2>LessFuel &copy; Prawa zastrzeżone</h2>
                 Developed by Patryk Dróżdż
                 <br/>
                 <div id="contact">
                     pdrozdz@onet.eu
                 </div>
                 
            </div>    
            
        </div>
    
       
    </body>
</html>