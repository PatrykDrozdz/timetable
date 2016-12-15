
<?php
   
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

$wordsCount=0;
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
        
         /*******************************/
           //pobieranie sekcji z bazy
           
           $querySections = "SELECT * FROM sections";
                          
           $resSec = $connection->query($querySections);
           $sectionCount = $resSec->num_rows;
            
           //echo $sectionCount.' <br/>';
           
           for($i=1; $i<=$sectionCount; $i++){
               $resSecInc = $connection->query("SELECT * FROM sections "
                       . "WHERE idsections = '$i'");
               
               $rowSecInc = $resSecInc->fetch_assoc();
               
               $tabSections[$i] = $rowSecInc['name'];
               
               //echo $tabSections[$i].'<br/>';
               
               $resSecInc->free();
           }
               
           
           /******************************/
           /////////////////////////////////////////////////////////////
           /*******************************/
           //pobieranie uzytkownikow z bazy
           
           $queryUsers = "SELECT * FROM users";
           
           $resUsers = $connection->query($queryUsers);
           $countUsers = $resUsers->num_rows;
           
           //echo $countUsers. '<br/>';
           $countOfUsers = 1;
 
           for($i=1; $i<=$countUsers; $i++){
               $resUsersInc = $connection->query("SELECT * FROM users "
                       . "WHERE idusers = '$i'");
               
               $rowUsersInc = $resUsersInc->fetch_assoc();
                            
               $tabFlag[$i] = $rowUsersInc['flag'];
              
               
               if($tabFlag[$i]==0){
                $tabUsers[$countOfUsers] = $rowUsersInc['fullName'];
                $tabUsersLogin[$countOfUsers] = $rowUsersInc['userLogin'];
                $countOfUsers++;
               }
               
               $resUsersInc->free();
           }
           
           /*********************************/
        
           
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
                    
                    
                    $idMeeting[$a] = $rowMeeting['idmeetings'];
                    
                    $idUsersMade[$a] = $rowMeeting['users_idusers'];
                    
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
                        //echo $trueEnd[$a]. '<br/>';
                        //echo $a.' '.$idEnd[$a].' <br/>';
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
                     /*****************************************************/
                     
                     /*****************************************************/
                     //pobieranie organizatora spotkania

                     $resultUsersMade = $connection->query("SELECT * FROM users");
                     
                     $usersCount = $resultUsersMade->num_rows;
                     
                     
                     for($usersMade=1; $usersMade<=$usersCount; $usersMade++){
                         $usersResultIncMade = $connection->query("SELECT * "
                                 . "FROM users WHERE idusers='$usersMade'");
                         
                         $rowUsersMade = $usersResultIncMade->fetch_assoc();
                         
                         if($usersMade==$idUsersMade[$a]){
                             $NameUsersMade[$a] = $rowUsersMade['fullName'];
                             
                             //echo $idUsersMade[$a].' '.$NameUsersMade[$a].'<br/>';
                         }
                         
                         $usersResultIncMade->free();
                     }
                     
                     /*****************************************************/
                     
                     /**************************************************/
                     //wczytywanie sekcji zaproszonych na spotkanie
                     
                     $resSecView = $connection->query("SELECT * FROM groups "
                       . "WHERE meetings_idmeetings = '$idMeeting[$a]'");
                    
                    $rowSecView = $resSecView->fetch_assoc();
                     
                       $secCount[$a] = 0;
                    for($sect=1; $sect<=$sectionCount; $sect++){
                        //$tabSections[$sect];
                        $nameSec = $tabSections[$sect];
                        $tabSecNum[$sect] = $rowSecView [$nameSec];
                        //echo $idMeeting[$a].'-'.$nameSec.'-'.$tabSecNum[$sect].' <br/>';
                        
                        if($tabSecNum[$sect]==1){
                            $secSeen[$a][$secCount[$a]] = $nameSec;
                            $secCount[$a] = $secCount[$a] + 1;
                        }
                    }
                    
                    $resSecView->free();
                     /********************************************************/
                    
                    /*****************************************/
                    //pobieranie zaproszonych użytkowników
                    
                    $resUsersView = $connection->query("SELECT * FROM invited "
                            . "WHERE meetings_idmeetings = '$idMeeting[$a]'");
                    
                    $rowUsersView = $resUsersView->fetch_assoc();
                    
                    $useCount[$a]=0;
                    for($user=1; $user<$countOfUsers; $user++){
                        
                        $nameUser = $tabUsersLogin[$user];
                        $tabUsersNum[$user] = $rowUsersView[$nameUser];
                        
                        if($tabUsersNum[$user] == 1){
                            $usersSeen[$a][$useCount[$a]] = $tabUsers[$user];
                            $useCount[$a] = $useCount[$a] + 1;
                        }
                        
                    }
                    
                    $resUsersView->free();
                    /*****************************************/
                    
                     
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
                        /********************************/
                         
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
} ?>