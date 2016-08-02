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
$r = 0;
///////////////////////////////
//wybør widokøw do panelu administratora


require_once 'connection.php';


try{
    
   $date = date('Y-m-d');
   $day = date('w');//wczytanie dnia tygodnia
   
   
   if($day==0){
       $day=7;
   }
   
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
                    ///////////////////////
                    ////nowe
                    $dateOfMeeting[$a] = $rowMeeting['day'];
                    $hourMeetingStarts[$a] = $rowMeeting['hourStart'];
                    $hourMeetingEnds[$a] = $rowMeeting['hourEnd'];
                    ////////////////////////////
                    $idStart[$a] = $rowMeeting['idStart'];
                    $idEnd[$a] = $rowMeeting['idEnd'];
                    $timeLast[$a] = $rowMeeting['timeLast'];
                    
                    $tabId[$a] = $tabH[$i].$tabMin[$i].$j;//id wygenerowanych komørek           
                    
                    settype($tabId[$a], 'integer');
                    settype($idStart[$a], 'integer');
                    settype($idEnd[$a], 'integer');
                    
                    //echo $a.' '.$tabId[$a].' <br/>';
                    
                    
                    
                    if($tabId[$a]==$idEnd[$a]){
                        $trueEnd[$a] = $tabId[($a-7)];
                        echo $trueEnd[$a]. '<br/>';
                        echo $a.' '.$idEnd[$a].' <br/>';
                    }
                    
                    
                    
                 if($info[$a]!=NULL){   
                     /***************************************************
                     echo '  ilosc slow '. str_word_count($info[$a]);
                     $wordsCount = str_word_count($info[$a]);
                     echo '<br/>';
                     echo'ilosc znakow '.strlen($info[$a]).' ';
                     $infoTab[$a] = explode(" ", $info[$a]);
                     print_r($infoTab[$a]);
                     echo '<br/>';
                     *****************************************************/
                     $z=0;
                     $y=0;
                     $z1 = 0;
                     for($m=0; $m<$wordsCount; $m++){
                         $wordsArray[$z] = strlen($infoTab[$a][$m]);
                         if($wordsArray[$z]<10 && strlen($infoTab[$a][$m])<7 && 
                                 $infoTab[$a][$m]!=" " && 
                                (strlen($infoTab[$a][$m])+strlen($infoTab[$a][($m+1)]))<=10){
                             $infoTab[$a][$m] = $infoTab[$a][$m].' '.$infoTab[$a][($m+1)].' ';
                             
                           
                         } else {
                             $infoTab[$a][$m] = $infoTab[$a][$m].' ';
                         }
                        
                         /********************************
                         echo $wordsArray[$z];
                         echo '<br/>';
                         echo $m.' '.$infoTab[$a][$m];
                         echo '<br/>'; 
                          ********************************/
                         
                         if (/*strlen($infoTab[$a][$m])<=10 && $infoTab[$a][$m]!=NULL 
                                 &&*/ ($m%2!=0 || $m==0)) {
                           
                           $trueInfoTab[$a][$z1] = $infoTab[$a][$m];
                           
                           /*****************************************
                           echo $m.' '.$z1.' '.$trueInfoTab[$a][$z1];
                             echo '<br/>';
                            *****************************************/
                            
                             $z1++;
                          // $tabId[$a]=$infoTab[$a][$m];
                         }
                         $z++;    
                     }
                    
                     /////////////////////////////////////////////////////
                    $s = 0;
                    $f=0;
                    $h2 = $tabH[$i];
                    $min2 = $tabMin[$i];
                    $day2 = $j;
               /******************************************************* 
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
                /**********************************************************/
                    $z1=0;
                    for($k=$start; $k<$end; $k++){
                         if($k%4==0 && $k!=0){     
                            $h2++;       
                        }

                         for($l=1; $l<=7; $l++){
                            
                             $unused[$s] = $h2.$min2.$day2;
                             
                             /*********************************
                             echo $unused[$s];
                             echo '<br/>';
                              /**********************************/
                             $day2++;
                             if($day2>7){
                                 $day2=1;
                             }
                             
                             if($s%7==0 && $unused[$s]<$idEnd[$a] && 
                                     $unused[$s]>$idStart[$a]){
                                 $trueUnused[$f] = $unused[$s];
                                  $reserved[$r] = $trueUnused[$f];
                                  
                                  /*************************************
                                  ////////////////////////////////////////
                                  echo $r.' '.$reserved[$r];
                                  echo '<br/>';
                                  //////////////////////////////////
                                 /***************************************/
                                   //$tabId[$a] = $trueInfoTab[$a][$z1];
                                   $z1++;
                                      /*if($f==$trueEnd[$a]){
                                  
                                         echo'<style>
                                                 #F'.$trueUnused[$f].'{
                                                  background-Color: #AA0000;
                                                   border-color: #AA0000 white white;
                                                   padding: 1px;
                                                }
                                                </style>';
                                        
                                      /}else{*/
                                         echo '<style>
                                                 #F'.$trueUnused[$f].'{
                                                  background-Color: #AA0000;
                                                   border-bottom-color: #AA0000;
                                                   padding: 1px;
                                                }
                                                </style>';
                                        
                                     //}  
                     ////////////////////////////////////////////////////////     
                    ///przydatne
                                /*echo $f.' '. $trueUnused[$f];
                                echo'<br/>';*/
                    ///////////////////////////////////////////////////////                     
                            $f++;
                            $r++;
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
            throw new Exception($connection->errno);
       }
   
   } 
    
    $connection->close();   
    
    
}catch(Exception $e){
    echo $e;
}
 

$hd = 0;


for($i =0; $i<$a; $i++){
    for($j=0; $j<$r; $j++){
        if($tabId[$i]!=$reserved[$j]){
            $onlyUsed[$hd] = $tabId[$i];
            $hd++;
        }
    }
}

//echo $hd;
//echo $r;
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


    
        <title>Organizator</title>
        
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="paliwo spalanie pojazdy licznik kalkulator baza danych"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>
        
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        
       
     
        
    </head>
    <body>
        
        <div id="container">
          <?php 
                
               // ni_set('session.gc_maxlifetime', '3600');
          
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                }
                
                ?>
            <div id="header">
                 <h1>Terminarz</h1>
                 <div id="loging">
                                          <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-link btn-lg active" 
  data-toggle="modal" data-target="#log">Zaloguj sie</button>
                                          <br/>
                 </div>
                
            </div>
      
            <div id="table">
 

                        <!-- Modal -->
                        <div class="modal fade" id="log" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" 
                                        data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Logowanie</h4>
                                </div>
                                <div class="modal-body">

                                   <form action="loging.php" method="post" name="form_name">


                                            login:
                                            <br/>
                                            <input type="text" name="login" id="textfield" 
                                                   placeholder="login" class="form-control"/>
                                            <br/>
                                             <br/>

                                            hasło:
                                            <br/>
                                            <input type="password" name="pass" id="textfield" 
                                                   placeholder="hasło" class="form-control"/>
                                            <br/>
                                            <br/>
                                            <input class="btn btn-primary active" 
                                                   type="submit" value="Zaloguj się" id="button"/>

                                        </form>
                
                
                                 </div>
                                     <div class="modal-footer">
                                        <button type="button" class="btn btn-default" 
                                                data-dismiss="modal">Anuluj</button>
                                    </div>
                                 </div>
      
                            </div>
                     </div>

                
                <table id="trueTable" border="5" width="100%" height="20%" 
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
                                        
                                    <style> 
                                        
                                        #date'.$i.'{
                                            color: white;
                                        }
                                    
                                    </style>
                                    
                            </td>  ';
               
                            
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
                                color: white;
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
                    $hd=0;
                    $f = 0;
                    $m=1;
                    
                     
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
                        
                           
                     //      rowspan="'.(4*$timeLast[$a]).'"
                        
                           
                                for($j=1; $j<=7; $j++){
                                    //if($tabId[$a]!=$trueUnused[$f]){
                            
                                if($info[$a]!=NULL){
                                    
                                        echo ' <td class="row" id="F'.$tabId[$a].'"
                                            data-toggle="modal" data-target="#MA'.$tabId[$a].'"
                                       > '.$info[$a].'
                                     </td>';
                                    
        
                    //'.$info[$a].'
                   //maxlegth="" - maksymalna ilosc znakow w input
                    
                    //$usersIdMeeting[$a]                
                                  
                echo '<div class="modal fade" id="MA'.$tabId[$a].'" role="dialog">
                                   <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" 
                                    data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Informacje o spotkaniu</h4>
                                     </div>
                                    <div class="modal-body">
                                    Spotkanie odbedzie sie dnia: '.$dateOfMeeting[$a].'
                                        <br/>
                                        W godzinach: '.$hourMeetingStarts[$a].' - '
                                .$hourMeetingEnds[$a].'
                                                 <br/>
                                    '.$info[$a].'
                                        <br/>
                                        '.$moreInfo[$a].' 
                                    </div>
                                    <div class="modal-footer">
                                <button type="button" class="btn btn-default" 
                                data-dismiss="modal">Zamknij</button>
                                    </div>
                                    </div>
                                    </div>
                                </div>';  
                                  
                                  
                                  //border-right-color: white;
                                  
                                  echo '<style> 
                                          
                                           #F'.$tabId[$a].'{
                                            background-Color: #AA0000;
                                            border-color: #AA0000;
                                            border-right-color: white;
                                           
                                            color: white; 
                                            font-size: 70%;
                                            }

                                        </style>';
                                       /* $m = 1;
                                  $wordCounted = str_word_count($info[$a]);
                                  ;
                                   echo ' <td class="row" id="F'.$tabId[$a] .'" >'
                                                .$tabId[$a].'</td>';
                                       
                                        echo '<style> 
                                             #F'.$tabId[$a] .'{
                                                color: white;
                                                background-Color: #AA0000;
                                                border-color: #AA0000;
                                            }
                                        </style>';
                                  */
                                  
                                   $wordsCount = str_word_count($info[$a]);
                                  
                                  //echo $wordCounted;
                                } else  {
                                   
                                        /***************************
                                        $checking2 = $checking2 + 1;
                                        echo $checking2;
                                        echo '<br/>';
                                         
                                       *****************************/
                                    //
                                            echo ' <td class="row" '
                                    . 'id="F'.$tabId[$a] .'" >'.$tabId[$a] .'</td>';
                                        
                                        echo '<style> 
                                             #F'.$tabId[$a] .'{
                                                color: white;
                                            }
                                        </style>';
                                    
                                } 
                                   
                                  /*if($m==($wordsCount- 1)){
                                      $m=1;
                                   * 
                                   * 
                                      $wordCounted;
                                  } */
                                  
                                  if($m==$r){
                                      $m=0;
                                  }
                                  $m++;
                                
                                $a++;

                               
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
