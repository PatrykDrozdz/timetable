
<?php 
    //session_start();
?>

<!DOCTYPE html>

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
                 <h1>Terminarz</h1>
                 <div id="mainPage">
                     <a href="index.php" class="btn-link">Strona główna</a>
       
                 </div>
                
            </div>
            
            <div id="leftLog">
                <form action="loging.php" method="post" name="form_name">
                    
              
                    login:
                    <br/>
                    <input type="text" name="login" id="textfield" 
                           placeholder="login"/>
                    <br/>
                     <br/>
                      <br/>
                    hasło:
                    <br/>
                    <input type="password" name="pass" id="textfield" 
                           placeholder="hasło"/>
                    <br/>
                    <br/>
                    <input class="btn btn-primary active" 
                           type="submit" value="Zaloguj się" id="button"/>
                    
                </form>
                
                <?php 
                
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                }
                
                ?>
                
             </div>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    
                    <div id="rightInfo">
                        Witamy na stronie logowania. <br/>
                        W celu założenia konta skontakyuj się z jednym z administratorów:
                        <br/>
                        <br/>
                        
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


