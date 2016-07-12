<?php 



session_start();

//stałe wartoßci domyslne
///////////////////////
$start=0;//start petli
$end=4*8;//koniec petli
                      
$h=6;//domyslna godzina poczætkowa
$check = 1;//flaga sprawdzjaca minuty - nie zmienia¢
///////////////////////////////
//wybør widokøw do panelu administratora
require_once 'connection.php';

try{
   // $valid=true;
     $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
            
    if($connection->connect_errno!=0){
        echo "Error: ".$connection->connect_errno;
    } else {

        if($valid==true){
            $query = "SELECT * FROM view";
            $result = $connection->query($query);
      
            
            $row = $result->fetch_assoc();
            $count = $result->num_rows;
         
            for($i=1; $i<=$count; $i++){
                $res1 = $connection->query("SELECT * FROM view WHERE idview = '$i'");
                $row12 = fetch_assoc();
            
                $vievs[$i] = $row12['nameOfView'];
         
            
            }
       
        }else{
            throw new Exception($connection->errno);
        }
        
    }
    
        
        
     $connection->close();   
}catch(Exception $e){
    echo $e;
}


try{
    
   $date = date('Y-m-d');
   $day = date('w');

    $valid2=true;
    
    $connection2 = new mysqli($host, $dbUser, $dbPass, $dbName);
        
    if($connection2->connect_errno!=0){
       echo "Error: ".$connection2->connect_errno;
       
    } else {
           
       if($valid2==true){
           $query2 = "SELECT DATE_ADD('$date', INTERVAL -'$day' DAY)";
            $connection2->query($query2);
        
            $result2 =  $connection2->query($query2);
            $row2 = $result2->fetch_assoc();
            
           
            $mon = $row2["DATE_ADD('$date', INTERVAL -'$day' DAY)"];
          
            
           
           for($i=1; $i<=7; $i++){
             
               $res = $connection2->query("SELECT DATE_ADD('$mon', INTERVAL +'$i' DAY)");
               
               $row22 = $res->fetch_assoc();
           
               $tab[$i] = $row22["DATE_ADD('$mon', INTERVAL +'$i' DAY)"];

           }
           
            
         
        } else {
            throw new Exception($connection2->errno);
       }
   
   } 
    
    $connection2->close();   
    
    
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
            <div id="menu">
                   <form method="post">
                    <br/>
                    <br/>
                    <select>
                        <?php    for($i=1; $i<=$count; $i++){
                            echo '<option>opcja'.$vievs[$i].'</option>';
                        }?>
                        
                         
                    </select>
                    
                </form>
            </div>
          
            <div id="table">
                
                <table id="trueTable" border="5" width="100%" height=40%"" class="table-responsive">
                   
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
                        
                        <td id="dayName"> Poniedziałek</td>
                           
                        <td id="dayName"> Wtorek </td>
                             
                        <td id="dayName"> Środa </td>
                        
                     
                        <td id="dayName"> Czwartek</td>
                        
                      
                        <td id="dayName"> Piątek</td>
                   
                     
                        <td id="dayName"> Sobota </td>
                 
                     
                        <td id="dayName"> Niedziela</td>
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

                           
                           
                 echo'<td> 1</td>
                           
                                <td> 2</td>
                                <td> 3 </td>

                                 <td> 4</td>

                                <td> 5</td>
                   
                     
                                <td> 6</td>
                 
                     
                                 <td> 7</td>
                       </tr>';
                     
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
