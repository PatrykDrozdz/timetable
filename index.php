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
   $day = date('w');//wczytanie dnia tygodnia

   
    $valid=true;
    
    $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
    if($connection->connect_errno!=0){
       echo "Error: ".$connection->connect_errno;
       
    } else {
           
       if($valid==true){
           $query2 = "SELECT DATE_ADD('$date', INTERVAL -'$day' DAY)";
            $connection->query($query2);
        
            $result2 =  $connection->query($query2);
            $row2 = $result2->fetch_assoc();
            
           
            $mon = $row2["DATE_ADD('$date', INTERVAL -'$day' DAY)"];
          
            $result2->free_result();
           
           for($i=1; $i<=7; $i++){
             
               $res = $connection->query("SELECT DATE_ADD('$mon', INTERVAL +'$i' DAY)");
               
               $row22 = $res->fetch_assoc();
           
               $tab[$i] = $row22["DATE_ADD('$mon', INTERVAL +'$i' DAY)"];
               $res->free_result();

           }
      
           //wczytywanie spotkan na tablice głøwnæł
           /////////////////////////////////////////
           
           $a=0;
           for($i=$start; $i<$end; $i++){
               if($i%4==0 ){     
                        $h++;       
                    }
              
                        
                $tabH[$i]=$h-1;
                $tabMin[$i]=$min;
        
               for($j=1; $j<=7; $j++){
                   $POM = $tabH[$i].$tabMin[$i].$j;//$h.$min.$j; 
                    $resMeeting = $connection->query("SELECT * FROM meetings WHERE "
                        . "idStart = '$POM ' AND day='$tab[$j]'");
               
                    $rowMeeting = $resMeeting->fetch_assoc();
                    $info[$a] = $rowMeeting['info'];
                    $moreInfo[$a] = $rowMeeting['moreInfo'];
                    $idStart[$a] = $rowMeeting['idStart'];
                    $idEnd[$a] = $rowMeeting['idEnd'];
                    $timeLast[$a] = $rowMeeting['timeLast'];
                    
                    $tabId[$a] = $tabH[$i].$tabMin[$i].$j;//id wygenerowanych komørek
                    
                    settype($tabId[$a], 'integer');
                    settype($idStart[$a], 'integer');
                    settype($idEnd[$a], 'integer');
                 if($info[$a]!=NULL){   
             
                    $s = 0;
                    $f=0;
                    $h2 = $tabH[$i];
                    $min2 = $tabMin[$i];
                    $day2 = $j;
               ////////////////////////////////////////////////////////     
               ///przydatne
                        echo'<br/>';
                        echo'<br/>';
                        echo 'Start = '.$a.' '.$idStart[$a];
                        echo'<br/>';
                        echo 'End = '.$a.' '.$idEnd[$a];
                        echo'<br/>';
                        echo 'Time Last = '.$a.' '.$timeLast[$a];
                        echo'<br/>';
                        echo'<br/>';
             ///////////////////////////////////////////////////////
                    for($k=$start; $k<$end; $k++){
                         if($k%4==0 && $k!=0){     
                            $h2++;       
                        }

                         for($l=1; $l<=7; $l++){
                            
                             $unused[$s] = $h2.$min2.$day2;
                              
                             $day2++;
                             if($day2>7){
                                 $day2=1;
                             }
                             if($s%7==0 && $unused[$s]<$idEnd[$a] && 
                                     $unused[$s]>$idStart[$a]){
                                 $trueUnused[$f] = $unused[$s];
                     ////////////////////////////////////////////////////////     
                    ///przydatne
                                echo $f.' '. $trueUnused[$f];
                                echo'<br/>';
                    ///////////////////////////////////////////////////////
                                                  
                            $f++;
                             }      //do poprawy - zbyt długo oblicza
                                    
                                /*for($g=0; $g<$f; $g++){
                                       if($g==$f){
                                        
                                         echo'<style>
                                                 #F'.$trueUnused[$g].'{
                                                  background-Color: #AA0000;
                                                   border-color: #AA0000 white white;
                                                   padding: 1px;
                                                }
                                                </style>';
                                        
                                     }else{
                                         echo'<style>
                                                 #F'.$trueUnused[$g].'{
                                                  background-Color: #AA0000;
                                                   border-bottom-color: #AA0000;
                                                   padding: 1px;
                                                }
                                                </style>';
                                   }
                                 } */
                                 
                                 
                             $s++; 
                         }
                         
                        $min2++;
                        if($min2%4==0){
                            $min2=0;
                        }
                       
                      
                    }
                                       
                    
                 }

               
                    $resMeeting->free_result(); 
                    $a++; 
               }
            
                 
               
                $min++;
                if($min%4==0){
                    $min=0;
                }
           }
        
               
           
           
         
        } else {
            throw new Exception($connection->errno);
       }
   
   } 
    
    $connection->close();   
    
    
}catch(Exception $e){
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
   <?php  //<meta http-equiv="Refresh" content="60"/> ?>
    
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
                
                <?php 
                     
                ?>
                
                <table id="trueTable" border="5" width="100%" height="70%" 
                    class="table-active table-responsive">
                   
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
               
                             echo '
                                  <style> 
                                  #date'.$day.'{
                                       background-Color: #AA0000;
                                   }
                                   </style>';
                            
                            }
                       
                       ?>
                       
                    </tr>
                    <tr id="cols" class="table-active">
                        
                        <td class="dayName" id="pn"> Pon</td>
                           
                        <td class="dayName" id="wt"> Wt </td>
                             
                        <td class="dayName" id="sr"> Śr </td>
                        
                     
                        <td class="dayName" id="czw"> Czw</td>
                        
                      
                        <td class="dayName" id="pt"> Pt</td>
                   
                     
                        <td class="dayName" id="sob"> Sob </td>
                 
                     
                        <td class="dayName" id="nd"> Nd</td>
                        
                        <?php 
                        if($day==1){
                            echo' <style> 
                            #pn{
                                background-Color: #AA0000;
                               }
                                  </style> ';
                            }
                              if($day==2){
                            echo' <style> 
                            #wt{
                                background-Color: #AA0000;
                               }
                                  </style> ';
                            }
                              if($day==3){
                            echo' <style> 
                            #sr{
                                background-Color: #AA0000;
                               }
                                  </style> ';
                            }
                              if($day==4){
                            echo' <style> 
                            #czw{
                                background-Color: #AA0000;
                               }
                                  </style> ';
                            }
                              if($day==5){
                            echo' <style> 
                            #pt{
                                background-Color: #AA0000;
                               }
                                  </style> ';
                            }
                              if($day==6){
                            echo' <style> 
                            #sob{
                                background-Color: #AA0000;
                               }
                                  </style> ';
                            }
                              if($day==7){
                            echo' <style> 
                            #nd{
                                background-Color: #AA0000;
                               }
                                  </style> ';
                            }
                          
                            
                        ?>
                        
                    </tr>
                    <?php 
                    
                    $start=0;//start petli
                    $end=4*13;//koniec petli
                      
                    $h=6;//domyslna godzina poczætkowa
                    $check = 1;//flaga sprawdzjaca minuty - nie zmienia¢
                    $a=0;
                    
                    $f = 0;
                     
                    for($i=$start; $i<$end; $i++){
                          
                           echo '<tr id="cols" class="table-active">';
                           
                           if($i%4==0 ){
                               echo '<td class="hour" rowspan="4">'.$h.'</td>';
                               $h++;
                              
                           }
                           if($i%2==0){
                               if($check%2==0){
                                    echo '<td class="min" rowspan="2">30</td>';
                                    $check++;
                               }else{
                                   echo '<td class="min" rowspan="2">00</td>';
                                   $check++;
                               }
                           }
                        
                           
                     
                        
                           
                                for($j=1; $j<=7; $j++){
                                    if($tabId[$a]!=$trueUnused[$f]){
                                
                                if($info[$a]!=NULL){
                                   
                                echo ' <td class="row"'
                                       //.'rowspan="'.(4*$timeLast[$a]). '"'
                                        . 'id="F'.$tabId[$a].'"'
                                        . '> '
                                        . '<div  id="F'.$tabId[$a].'"  '
                                        . 'class="head">'.
                                        $info[$a] .'</div>'
                                        . '<div  id="Meet'.$tabId[$a].'" 
                                        >
                                            <br/>'.
                                            $moreInfo[$a].'
                                        </div>
                                        </td>';

                                    
                                    echo'<style>
                                     #F'.$tabId[$a].'{
                                            background-Color: #AA0000;
                                            border-color: #AA0000;
                                            border-right-color: white;
                                             padding: 1px;
                                        }
                                        

                                    #Meet'.$tabId[$a].'{
                                            display: none;
                                            color: black;
                                            background-color: #e5eecc;
                                        }
                                        </style>';
                                    
                                     echo '<script> 
                                     $(document).ready(function(){
                                        $("#F'.$tabId[$a].'").click(function(){
                                            $("#Meet'.$tabId[$a].'").slideToggle("slow");
                                        });
                                      });

                                         </script>';
                                    

                                } else { 
                                  
                                    
                                        echo ' <td class="row" '
                                    . 'id="F'.$tabId[$a].'" >'.$tabId[$a].'</td>';
                                    
                                    
                                }
                              
                                $a++;
                                
                               }
                               $f++;
                               if($f==((4*$timeLast[$a])-1)){
                                        $f=0;
                                    }
                               
                            }
                 
                                
                            
                                    
                                    
     
                             echo'    </tr>';

                     
                      }
                      
                        
                    ?>
 
               </table> 
          
                    
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
