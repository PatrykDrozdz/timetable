<?php
  //zabezpieczenie przed wejßciem z palca
    session_start();
    
    if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }
    
    //stałe wartoßci domyslne
///////////////////////
$start=0;//start petli
$end=4*3;//koniec petli
                      
$h=14;//domyslna godzina poczætkowa
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
           /////////////////////////////////////////////
           /*
           $query = "SELECT * FROM view";
           $result = $connection->query($query);
      
            
            $row = $result->fetch_assoc();
            $count = $result->num_rows;
         
            for($i=1; $i<=$count; $i++){
                $res1 = $connection->query("SELECT * FROM view WHERE idview = '$i'");
                $row12 = fetch_assoc();
            
                $vievs[$i] = $row12['nameOfView'];
         
            
            }
           */
           ////////////////////////////////////////// 
         
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
        
          <?php 
         $start=0;//start petli
         $interval = 10;
         $end=4*$interval;//koniec petli
                    
        $SpanCol = ($end/2)+1; 
        $h=14;//domyslna godzina poczætkowa
       ?>
     
     
        
    </head>
    <body>
        
        <div id="container">
          
            <div id="header">
                 <h1>Terminarz</h1>
   
            </div>
            <div id='menu'>
                
                  <?php
                        echo 'Witaj '.$_SESSION['name'].'  '
                                .$_SESSION['surname'];
                         ?>
                    
                <a href='logout.php'>wylogowanie</a>
                    <br/>
                
                
            </div>
          
            <div id="table">
                
             <table id="trueTable" border="5" width="100%" height="50%" 
                    class="table-active table-responsive">
                    <tr>
                          <td> <input class="btn btn-primary active" 
                           type="submit" value="<<" id="buttonDay"/></td>
                             <td> <input class="btn btn-primary active" 
                           type="submit" value="<" id="buttonDay"/></td>
                            <td colspan="5">Pole z opisem najbliszego spotkania</td>
                            <td> <input class="btn btn-primary active" 
                                        type="submit" value=">" id="buttonDay"/></td>
                             <td colspan="2"> <input class="btn btn-primary active" 
                                         type="submit" value=">>" id="buttonDay"/></td>
                    </tr>
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
                       
                          
                    echo '<td rowspan="'. $SpanCol.'"><input class="btn btn-primary active" 
                           type="submit" value="<<" id="buttonHour"
                           onclick="changeHoursInc()" STYLE=height: '.$SpanCol.'</td>';
                                
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

                    $start=0;//start petli
                    $end=4*13;//koniec petli
                      
                    $h=6;//domyslna godzina poczætkowa
                    $check = 1;//flaga sprawdzjaca minuty - nie zmienia¢
                    $min = 0; //id minut
                    $a=0;
                     
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
                        
                            $tabH[$i]=$h-1;
                            $tabMin[$i]=$min;
                            
                            for($j=1; $j<=7; $j++){
                                $tabId[$a] = $tabH[$i].$tabMin[$i].$j;//id wygenerowanych wierszy
                                echo ' <td class="row"> '
                                        . '<div  id="F'.$tabH[$i].$tabMin[$i].$j.'">'.$tabH[$i].$tabMin[$i].$j.'aaaaaaaaaaaaaaaa</div>'
                                        . '<div  id="Meet'.$tabH[$i].$tabMin[$i].$j.'">
                                            '.$info[$a].
                                            '<br/>'.
                                            $moreInfo[$a].'
                                        </div>'
                                        . '</td>';
                             
                                
                                echo '<script> 
                                     $(document).ready(function(){
                                        $("#F'.$tabH[$i].$tabMin[$i].$j.'").click(function(){
                                            $("#Meet'.$tabH[$i].$tabMin[$i].$j.'").slideToggle("slow");
                                        });
                                      });
                                         </script>';
                                
                                if($info[$a]!=NULL){
                                    echo'<style>
                                     #F'.$tabH[$i].$tabMin[$i].$j.'{
                                            background-Color: #AA0000;
                                        }
                                        </style>';
                                }
                                
                                echo'<style>
                                       
                                        
                                        #Meet'.$tabH[$i].$tabMin[$i].$j.'{
                                            display: none;
                                            color: black;
                                            background-color: #e5eecc;
                                        }
                                    </style>';
                                
                                $a++;
                            }
                            
                  
     
                   echo'    </tr>';

                 
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