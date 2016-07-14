 
<?php
   //zabezpieczenie przed wejßciem z palca
    session_start();

     if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
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
                  login:  <input type="text" name="login" id="textfield"/>
                  <br/>
                    <br/>
                 hasło: <input type="password" name="login" id="textfield"/>
                      <br/>
                    <br/>
                    imię: <input type="text" name="name" id="textfield"/>
                       <br/>
                    <br/>
                nazwisko: <input type="text" name="email" id="textfield"/>
                       <br/>
                    <br/>
                    status: <select name="flagStatus" id="textfield">
                        <option>admin</option>
                        <option>user</option>
                            </select>
                       <br/>
                    <br/>
                    sekcja: <select name="name" id="textfield">
                        <option>q</option>
                        <option>u2</option>
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