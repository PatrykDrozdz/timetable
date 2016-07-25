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

   if($day==0){
       $day=7;
   }
   
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
                                            if($s%7==0 && $unused[$s]<$idEnd[$a] && 
                                     $unused[$s]>$idStart[$a]){
                                 $trueUnused[$f] = $unused[$s];

                                      if($f==$idEnd[$a]){
                                  
                                         echo'<style>
                                                 #F'.$trueUnused[$f].'{
                                                  background-Color: #AA0000;
                                                   border-color: #AA0000 white white;
                                                   padding: 1px;
                                                }
                                                </style>';
                                        
                                     }else{
                                         echo '<style>
                                                 #F'.$trueUnused[$f].'{
                                                  background-Color: #AA0000;
                                                   border-bottom-color: #AA0000;
                                                   padding: 1px;
                                                }
                                                </style>';
                                   }
                                  
                                 
                     ////////////////////////////////////////////////////////     
                    ///przydatne
                               /* echo $f.' '. $trueUnused[$f];
                                echo'<br/>';*/
                    ///////////////////////////////////////////////////////
                                                  
                            $f++;
                             } 
                                                  
                             $f++;
                             }
                            
                                
                                
                             
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
            throw new Exception($connection2->errno);
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
                            <td colspan="5" class="head">Pole z opisem najbliszego spotkania</td>
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
                                        
                                    <style> 
                                        
                                        #date'.$i.'{
                                            color: white;
                                        }
                                    
                                    </style>
                            </td>  ';
  
                            }
                       
                          
                    echo '<td rowspan="'. $SpanCol.'" class="changeHour">
                        <input class="btn btn-primary active" 
                           type="submit" value="<<" id="buttonHour"
                           onclick="changeHoursInc()" STYLE=height: '.$SpanCol.'</td>';
                                
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
                        $allHours = 13;
                       $end=4*$allHours;//koniec petli
                      $SpanCol = ($end/2)+1; 
                    $h=6;//domyslna godzina poczætkowa
                    $check = 1;//flaga sprawdzjaca minuty - nie zmienia¢
                    $a=0;
                    
                    $f = 1;
                     
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

                                
                                if($info[$a]!=NULL){
                                   
                                 echo ' <td class="row"'
                                       //.'rowspan="'.(4*$timeLast[$a]). '"'
                                        . 'id="F'.$tabId[$a].'"'
                                        . '> '
                                        . '<div  id="F'.$tabId[$a].'"  '
                                        . 'class="head P'.$tabId[$a].'" 
                                        data-toggle="popover"
                                        data-placement="right" 
                                        data-content="'.$moreInfo[$a].'"'
                                        . ' title="tytułerhytbdfgynbgufvfdbtghv">'
                                        .$info[$a].'
                                        </div>
                                        
                                        <script> 
                                            $(".P'.$tabId[$a].'").popover();
                                        </script>
                                        </td>';
                                   echo ' <td class="row"'
                                     
                                        . 'id="F'.$tabId[($a+1)].'"'
                                        . '>'.$tabId[($a+1)].' 
                                        </td>';
                                    
                                    
                                    echo'<style>
                                     #F'.$tabId[$a].'{
                                            background-Color: #AA0000;
                                            border-color: #AA0000;
                                            border-right-color: white;
                                             padding: 1px;
                                        }';
                                    
                                    

                                } else { 
                                   
                                    //if($tabId[$a]!=$trueUnused[$f]){
                                    
                                        echo ' <td class="row" '
                                    . 'id="F'.$tabId[$a].'" >'.$tabId[$a].'</td>';
                                         echo '<style> 
                                             #F'.$tabId[$a].'{
                                                color: white;
                                            }
                                        </style>';
                                    //}  
                                    $f++;
                                    
                                    if($f==((4*$timeLast[$a])-1)){
                                        $f=1;
                                    }
                                }
                              
                                 $a++;
                            
                            }
                           if(((2*$allHours)-1)==$i){
                                echo '<td rowspan="'. ($SpanCol).'" class="changeHour"><input 
                                        class="btn btn-primary active" 
                                        type="submit" value="<<" id="buttonHour"
                                    </td>';
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