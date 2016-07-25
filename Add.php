
<?php 
     //zabezpieczenie przed wejßciem z palca
    session_start();

     if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }
    
  
    
    require_once 'connection.php';
    
    
    if(isset($_POST['date'])){
        
        try{
        
            $connection=new mysqli($host, $dbUser, $dbPass, $dbName);
        
            if($connection->connect_errno!=0){
                echo "Error: ".$connection->connect_errno;
            } else {
                
                $idUser = $_SESSION['idusers'];
                $flag = $_SESSION['flag'];
                
                $day = $_POST['day'];
                $begHours = $_POST['begHours'];
                $begMinutes = $_POST['begMinutes'];
                
                if($begHours<10){
                    $begHours = '0'.$begHours;
                }
                if($begMinutes<15){
                    $begMinutes = '0'.$begMinutes;
                }
                
                $fulHourBegin = $begHours.':'.$begMinutes.':00';
                
                $hours = $_POST['hours'];
                $minutes = $_POST['minutes'];
                
               
                
                $fulTimeLast = $hours.':'.$minutes.':00';
                
                echo $fulHourBegin ;
                
                echo '<br/>';
                
                echo  $fulTimeLast;
            }
             $connection->close();
        }  catch (Exception $e){
             echo $e;
        }
    }
    
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
    <script src="fonts/bootstrap.js"></script> 
        
        <title>Organizator</title>
        
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="paliwo spalanie pojazdy licznik kalkulator baza danych"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>
        
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <script type="text/javascript">
                    $('#date').datepicker({ dateFormat: 'yy-mm-dd' });
                </script>
        
    </head>
    <body>
        <div id="container2">

            <div id="header">
                 <h1>Terminarz</h1>
            </div>
                         
            <div id="leftLog">
     <form method="post">
                  <p>Data</p>
             <br/>
                <input type="text" name="date" id="date" 
           class="form-control"/>
                
                
                <br/>
           <br/>
                <p>Godzina</p>
             <br/>
           godziny:
            <input type="number" name="begHours" min="00" max="23"/>
           minuty:
           <input type="number" name="begMinutes" min="00" max="45" step="15"/>
           <br/>
           <br/>

            <p>Czas spotkania</p>
            <br/>
           godziny:
            <input type="number" name="hours" min="00" max="23" />
           minuty:
           <input type="number" name="minutes" min="00" max="45" step="15"/>
              <br/>
           <br/>     
           <input type="text" name="info" id="textfield" 
            placeholder="temat" class="form-control"/>
           <br/>
           <br/>
           <input type="text" name="moreInfo" id="textfield" 
            placeholder="wiecej informacji" class="form-control"/>
           <br/>
           <br/>
            
            <input class="btn btn-primary active" 
                           type="submit" value="Dodaj" id="button"/>
      </form>
                
                <?php 
                
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                }
                
                ?>
                
        </div>
                   
                    <div id="rightInfo">
                         
                        
                       
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
