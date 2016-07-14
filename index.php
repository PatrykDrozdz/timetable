<?php 

session_start();
//sprawdzanie, czy u«ytkownik jest zalogowany
if((isset($_SESSION['loged'])) && ($_SESSION['loged']==TRUE)){
    $flag = $_SESSION['flag'];
    if($flag==0){
        eader('Location: Interface.php');
        exit();
    }else if($flag==1){
        header('Location: adminInterface.php');
       exit();
    }
}



//stałe wartoßci domyslne
///////////////////////
$start=0;//start petli
$end=4*13;//koniec petli
                      
$h=6;//domyslna godzina poczætkowa
$check = 1;//flaga sprawdzjaca minuty - nie zmienia¢
$min = 0; //id minut
///////////////////////////////
//wybør widokøw do panelu administratora
require_once 'connection.php';


try{
    
   $date = date('Y-m-d');
   $day = date('w');

    $valid=true;
    
    $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
    if($connection->connect_errno!=0){
       echo "Error: ".$connection2->connect_errno;
       
    } else {
           
       if($valid==true){
           $query2 = "SELECT DATE_ADD('$date', INTERVAL -'$day' DAY)";
            $connection->query($query2);
        
            $result2 =  $connection->query($query2);
            $row2 = $result2->fetch_assoc();
            
           
            $mon = $row2["DATE_ADD('$date', INTERVAL -'$day' DAY)"];
          
            
           
           for($i=1; $i<=7; $i++){
             
               $res = $connection->query("SELECT DATE_ADD('$mon', INTERVAL +'$i' DAY)");
               
               $row22 = $res->fetch_assoc();
           
               $tab[$i] = $row22["DATE_ADD('$mon', INTERVAL +'$i' DAY)"];

           }
      
         
        } else {
            throw new Exception($connection2->errno);
       }
   
   } 
    
    $connection->close();   
    
    
}catch(Exceptine $e){
    echo $e;
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
                 <h1>Terminarz</h1>
                 <div id="loging">
                     <a href="logingpre.php" class="btn-link">Zaloguj się</a>
                 </div>
                
            </div>
      
            <div id="table">
                
                <table id="trueTable" border="5" width="100%" height=40%"" class="table-active table-responsive">
                   
                    <tr id="cols">
                        
                        
                        <td rowspan="2" colspan="2">
                            <div  id="textHour">
                                Godzina
                            </div>
                            
                        </td>
                       
                       <?php 
                            for($i=1; $i<=7; $i++){
                             echo 
                            '<td>
                                    <div id="date'.$i.'" class="date">'.$tab[$i].'</div>
                            </td>  ';
                            }
                       
                       ?>
                       
                    </tr>
                    <tr id="cols" class="table-active">
                        
                        <td id="dayName"> Pon</td>
                           
                        <td id="dayName"> Wt </td>
                             
                        <td id="dayName"> Śr </td>
                        
                     
                        <td id="dayName"> Czw</td>
                        
                      
                        <td id="dayName"> Pt</td>
                   
                     
                        <td id="dayName"> Sob </td>
                 
                     
                        <td id="dayName"> Nd</td>
                    </tr>
                    <?php 
                     
                     
                    for($i=$start; $i<$end; $i++){

                           echo '<tr id="cols" class="table-active">';
                           
                           if($i%4==0 ){
                               echo '<td rowspan="4">'.$h.'</td>';
                               $h++;
                              
                           }
                           if($i%2==0){
                               if($check%2==0){
                                    echo '<td rowspan="2">30</td>';
                                    $check++;
                               }else{
                                   echo '<td rowspan="2">00</td>';
                                   $check++;
                               }
                           }
                        
                           
                           
                 echo''
                           . ' <td id="'.($h-1).$min.'1" onclick=" click'.($h-1).$min.'1()"> '.($h-1).' '.$min.' 1</td>
                           
                                <td id="'.($h-1).$min.'2" onclick=" click'.($h-1).$min.'2()"> '.($h-1).' '.$min.' 2</td>
                                <td id="'.($h-1).$min.'3" onclick=" click'.($h-1).$min.'3()"> '.($h-1).' '.$min.' 3</td>

                                 <td id="'.($h-1).$min.'4" onclick=" click'.($h-1).$min.'4()"> '.($h-1).' '.$min.' 4</td>

                               <td id="'.($h-1).$min.'5" onclick=" click'.($h-1).$min.'5()"> '.($h-1).' '.$min.' 5</td>
                   
                     
                                <td id="'.($h-1).$min.'6" onclick=" click'.($h-1).$min.'6()"> '.($h-1).' '.$min.' 6</td>
                 
                     
                                 <td id="'.($h-1).$min.'7" onclick=" click'.($h-1).$min.'7()"> '.($h-1).' '.$min.' 7</td>
                       </tr>';
       
                 
                     $min++;
                      if($min%4==0){
                          $min=0;
                      }
                     
                      }
                      
                    
                    ?>
 
               </table> 
             
                    
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
