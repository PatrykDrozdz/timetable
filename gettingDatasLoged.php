<?php
       //stałe wartoßci domyslne
///////////////////////
require_once 'getView.php';

if(isset($_SESSION['idusers'])){
    $idUsers = $_SESSION['idusers'];
} else {
    $idUsers = NULL;
}
    //echo $_SESSION['fullName'];
if(isset($_SESSION['fullName'])){    
    $myFullName = $_SESSION['fullName'];
}
if(isset($_SESSION['sectionId'])){
    $mySectionId =  $_SESSION['sectionId'];
} else {
    $mySectionId = NULL;
}    
    

//echo $startView.'<br/>'.$endView.'<br/>'.$tableIndex ;

/*************************************/
$start=0;//start petli
if(isset($_SESSION['tableIndex']) && isset($_SESSION['startView'])){                      
    $end = $_SESSION['tableIndex'];//koniec petli
    $h = $_SESSION['startView'];//domyslna godzina poczætkowa
} else {
    $end = NULL;
    $h = NULL;
}
/***********************************/
$a=0;
$hd=0;
$f = 0;
$m=1;
$check = 1;//flaga sprawdzjaca minuty - nie zmienia¢
$min = 0; //id minut - stała nie do zmiany

$monthCount = 1;
$weekCount = 1;

$sec=0;
$r = 0;//zmienna do zarezerwowanych(indeksy)
///////////////////////////////
//wybør widokøw do panelu administratora
require_once 'connection.php';


try{
   //pobieranie daty i numeru dnia tygodnia
    //////////////////////////////
   $date = date('Y-m-d');
   $day = date('w');
   
   if($day==0){
       $day=7;
   }
   //////////////////////////////////////
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
               
               if($i==$mySectionId && $mySectionId!=NULL){
                   $mySection = $tabSections[$i];
                   //echo $mySectionId.' '.$mySection;
               }

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
           $countOfUsersView = 1;
           if(isset($_SESSION['idusers'])){
            $myId =  $_SESSION['idusers'];
           } else {
            $myId = NULL;
           }
           for($i=1; $i<=$countUsers; $i++){
               $resUsersInc = $connection->query("SELECT * FROM users "
                       . "WHERE idusers = '$i'");
               
               $rowUsersInc = $resUsersInc->fetch_assoc();
                            
               $tabFlag[$i] = $rowUsersInc['flag'];
              
               
               if($tabFlag[$i]==0 && $i!=$myId && $myId!=NULL){
                     $tabUsers[$countOfUsers] = $rowUsersInc['fullName'];
                     $tabUsersLogin[$countOfUsers] = $rowUsersInc['userLogin'];
                     $countOfUsers++;
               }
               
               if($tabFlag[$i]==0){
                   $tabUsersView[$countOfUsersView] = $rowUsersInc['fullName'];
                   $tabUsersLoginView[$countOfUsersView] = $rowUsersInc['userLogin'];
                   $countOfUsersView++;
               }
               
               $resUsersInc->free();
           }
           
           /*********************************/
           /////////////////////////////////////////////////////////////
           //pobieranie dat i zapisywanie do tablicy
           $query2 = "SELECT DATE_ADD('$date', INTERVAL -'$day' DAY)";

        
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
         ////////////////////////////////////////////////////////
         //selekcja widokøw
           /////////////////////////////////////////////
           $query = "SELECT * FROM view";
           $result = $connection->query($query);
      
            
            $row = $result->fetch_assoc();
            $countView = $result->num_rows;
          
            for($i=1; $i<=$countView; $i++){
                $res1 = $connection->query("SELECT * FROM view WHERE idview = '$i'");
                $row12 = $res1->fetch_assoc();
            
                $vievs[$i] = $row12['nameOfView'];
                
                
                
                $res1->free_result();
                
            }
            /******************************************************************************/
            //do dokonczenia
            //////////////////////////////////////////////////////////////////
            //ustawianie widokøw(godzin)
            /////////////////////////////////////////////////////////
            //dekrementacja miesiæca
            ////////////////////////////////////////////////////////////////////
            if(isset($_POST['decMonthValue'])){
                
                $monthCount = $_POST['decMonthValue'];
                
                $qDecMonth= "SELECT DATE_ADD('$date', INTERVAL -'$monthCount' MONTH)";
                $decMonth = $connection->query($qDecMonth);
                $rowDecMonth = $decMonth->fetch_assoc();
                
                if(isset($_POST['decMonth'])){
                
                    $DM = $rowDecMonth["DATE_ADD('$date', INTERVAL -'$monthCount' MONTH)"];
                    //echo '<br/>'.$DM;
                    $date = $DM;
                }
                $decMonth->free_result();
                
                $qDWD = "SELECT DAYOFWEEK('$DM')";
                $resDW = $connection->query($qDWD );
                $rowDWD = $resDW->fetch_assoc();
                
                $DW = $rowDWD["DAYOFWEEK('$DM')"]-1;
                
                if($DW==0){
                    $DW = 7;
                }
                $resDW->free_result();
                
                $qMD = "SELECT DATE_ADD('$DM', INTERVAL -'$DW' DAY)";
                $resMD =  $connection->query($qMD);
                $rowMD = $resMD->fetch_assoc();
            
           
                $monDEC = $rowMD["DATE_ADD('$DM', INTERVAL -'$DW' DAY)"];
                $resMD->free_result();
                
                for($i=1; $i<=7; $i++){
             
                    $resUltDM= $connection->query("SELECT DATE_ADD('$monDEC', INTERVAL +'$i' DAY)");
               
                    $rowUltDM= $resUltDM->fetch_assoc();
           
                    $tab[$i] = $rowUltDM["DATE_ADD('$monDEC', INTERVAL +'$i' DAY)"];
               
                    $resUltDM->free_result();

                }
                
                
            }
            //////////////////////////////////////////////////////////////////
            //inkrementacja miesiæca
            /////////////////////////////////////////////////////////////////
            
            if(isset($_POST['incMonthValue'])){
               
                $monthCount = $_POST['incMonthValue'];
                
                $qIncMonth= "SELECT DATE_ADD('$date', INTERVAL '$monthCount' MONTH)";
                $incMonth = $connection->query($qIncMonth);
                $rowIncMonth = $incMonth->fetch_assoc();
                
                $IM = $rowIncMonth["DATE_ADD('$date', INTERVAL '$monthCount' MONTH)"];
                $date = $IM;
                $incMonth->free_result();
               
                $qIWI = "SELECT DAYOFWEEK('$IM')";
                $resIW = $connection->query($qIWI);
                $rowIW = $resIW->fetch_assoc();
                
                $IW = $rowIW["DAYOFWEEK('$IM')"]-1;
                
                if($IW==0){
                    $IW = 7;
                }
              
                $resIW->free_result();
                
                $qMI = "SELECT DATE_ADD('$IM', INTERVAL -'$IW' DAY)";
                $resMI =  $connection->query($qMI);
                $rowMI = $resMI->fetch_assoc();

                $monINC = $rowMI["DATE_ADD('$IM', INTERVAL -'$IW' DAY)"];
                $resMI->free_result();
                
                for($i=1; $i<=7; $i++){
             
                    $resUltIM= $connection->query("SELECT DATE_ADD('$monINC', "
                            . "INTERVAL +'$i' DAY)");
               
                    $rowUltIM=  $resUltIM->fetch_assoc();
           
                    $tab[$i] = $rowUltIM["DATE_ADD('$monINC', INTERVAL +'$i' DAY)"];
               
                    $resUltIM->free_result();

                }
                //$incMon++;
            }
            /////////////////////////////////////////////////////////////////////
            //dekrementacja tygodnia
            ////////////////////////////////////////////////////////////////////
            
            if(isset($_POST['decWeekValue'])){
               
                $weekCount = $_POST['decWeekValue'];
                
                $qDM = "SELECT DATE_ADD('$mon', INTERVAL -'$weekCount' WEEK)";
                $resDM = $connection->query($qDM);
                $rowDM = $resDM->fetch_assoc();
                
                $monD = $rowDM["DATE_ADD('$mon', INTERVAL -'$weekCount' WEEK)"];
                
                //echo $monD;
                
                $resDM->free_result();
                
                for($i=1; $i<=7; $i++){
                    
                    $resWD = $connection->query
                            ("SELECT DATE_ADD('$monD', INTERVAL +'$i' DAY)");
                   
                    $rowWD = $resWD->fetch_assoc();
                    
                    $tab[$i] = $rowWD["DATE_ADD('$monD', INTERVAL +'$i' DAY)"];
               
                    $resWD->free();
                    
                }
                
            }
        ////////////////////////////////////////////////////////////////////
        //inkrementacja miesiąca    
        ////////////////////////////////////////////////////////////////////    
        if(isset($_POST['incWeekValue'])){
                
                $weekCount = $_POST['incWeekValue'];
                 
                $qIM = "SELECT DATE_ADD('$mon', INTERVAL +'$weekCount' WEEK)";
                $resIM = $connection->query($qIM);
                $rowIM = $resIM->fetch_assoc();
                
                $monD = $rowIM["DATE_ADD('$mon', INTERVAL +'$weekCount' WEEK)"];
                
                //echo $monD;
                
                $resIM->free_result();
                
                for($i=1; $i<=7; $i++){
                    
                    $resWI = $connection->query
                            ("SELECT DATE_ADD('$monD', INTERVAL +'$i' DAY)");
                   
                    $rowWI = $resWI->fetch_assoc();
                    
                    $tab[$i] = $rowWI["DATE_ADD('$monD', INTERVAL +'$i' DAY)"];
               
                    $resWI->free();
                    
                }
                
            }
            
            

         /*************************************************************************/
           ///////////////////////////////////////////////////////////////
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
                    ////dodane
                    $idMeeting[$a] = $rowMeeting['idmeetings'];
                    $idUsersMade[$a] = $rowMeeting['users_idusers'];
                    /////
                    $info[$a] = $rowMeeting['info'];
                    $moreInfo[$a] = $rowMeeting['moreInfo'];
                    $idStart[$a] = $rowMeeting['idStart'];
                    $idEnd[$a] = $rowMeeting['idEnd'];
                    $timeLast[$a] = $rowMeeting['timeLast'];
                    
                    $usersIdMeeting[$a] = $rowMeeting['users_idusers'];
                    
                    $dateOfMeeting[$a] = $rowMeeting['day'];
                    $hourMeetingStarts[$a] = $rowMeeting['hourStart'];
                    $hourMeetingEnds[$a] = $rowMeeting['hourEnd'];
                    
                    $tabId[$a] = $tabH[$i].$tabMin[$i].$j;//id wygenerowanych komørek
                    
                    settype($tabId[$a], 'integer');
                    settype($idStart[$a], 'integer');
                    settype($idEnd[$a], 'integer');
                    
                    /*******************************
                    if($tabId[$a]==$idEnd[($a-7)]){
                        $trueEnd[$a] = $tabId[$a];
                        echo $trueEnd[$a].' <br/>';
                    }
                    /********************************/
                    
                    
                 if($info[$a]!=NULL){   
                     
                     /***********************************/
                     //pobieranie czasu spotkania do edycji
                     
                     $timesExplodedPre = explode(":", $timeLast[$a]);
                     //echo $timeLast[$a].'<br/>';
                     //print_r($timesExplodedPre). '<br/>';
                     $timesExploded[$a][0] = $timesExplodedPre[0];
                     $timesExploded[$a][1] = $timesExplodedPre[1];
                     /**********************************/
                     
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
                     
                     /************************************/
                     //pobieranie sekcji i wpisywanie do tablicy
                    //pobieranie sekcji
                    //'$idMeeting[$a]'
                    //echo $idMeeting[$a] .'<br/>';
                     
                    $resSecView = $connection->query("SELECT * FROM groups "
                       . "WHERE meetings_idmeetings = '$idMeeting[$a]'");
                    
                    $rowSecView = $resSecView->fetch_assoc();
                    
                    $secCount[$a] = 0;
                    for($sect=1; $sect<=$sectionCount; $sect++){
                        //$tabSections[$sect];
                        $nameSec = $tabSections[$sect];
                        $tabSecNum[$sect] = $rowSecView[$nameSec];
                        $secNum[$a][$sec] =  $tabSecNum[$sect];
                        //echo $idMeeting[$a].'-'.$nameSec.'-'.$tabSecNum[$sect].' <br/>';
                        
                        if($tabSecNum[$sect]==1){
                            $secSeen[$a][$secCount[$a]] = $nameSec;
                            $secCount[$a] = $secCount[$a] + 1;
                        }
                    }
                    
                    $resSecView->free();
                    
                    /*****************************************/
                    //pobieranie zaproszonych użytkowników
                    
                    $resUsersView = $connection->query("SELECT * FROM invited "
                            . "WHERE meetings_idmeetings = '$idMeeting[$a]'");
                    
                    $rowUsersView = $resUsersView->fetch_assoc();
                    
                    $useCount[$a]=0;
                    for($user=1; $user<$countOfUsersView; $user++){
                        
                        $nameUser = $tabUsersLoginView[$user];
                        $tabUsersNum[$user] = $rowUsersView[$nameUser];
                        $usersNum[$a][$user] = $tabUsersNum[$user];
                       
                        if($tabUsersNum[$user] == 1){
                            $usersSeen[$a][$useCount[$a]] = $tabUsersView[$user];
                            //echo $usersSeen[$a][$useCount[$a]].'<br/>';
                            $useCount[$a] = $useCount[$a] + 1;
                        }
                        
                    }
                    
                    $resUsersView->free();
                    /*****************************************/
                     
                    
                    
                    /*****************************************/
                        //echo $a.' '.strlen($info[$a]).' '.$info[$a];
                     
                    
                        if(strlen($info[$a])>21){
                     
                            $tabInfo = explode(" ", $info[$a]);
                                
                             /********************************
                              echo str_word_count($info[$a]);
                    
                            echo '<br/>';
                            
                            print_r($tabInfo);
                            echo '<br/>';
                            /***********************************/
                        }
                        
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
                             /* echo $s.' '.$unused[$s];
                              echo '<br/>';*/
                             $day2++;
                             if($day2>7){
                                 $day2=1;
                             }
                                 if($s%7==0 && $unused[$s]<$idEnd[$a] && 
                                         $unused[$s]>$idStart[$a]){
                                 $trueUnused[$f] = $unused[$s];
                                   $reserved[$r] = $trueUnused[$f];
                                   
                                 /////////////////////////////////////////////
                                 /*echo $r.' '. $reserved[$r];
                                echo'<br/>';*/
                                //////////////////////////////////////////////////////////

                                  /*if($f==$trueEnd[$a] && !empty($trueEnd[$a])){
                                  
                                         echo'<style>
                                                 #F'.$trueUnused[$f].'{
                                                  background-Color: #AA0000;
                                                   border-color: #AA0000 white white white;
                                                   padding: 1px;
                                                }
                                                </style>';
                                        
                                     }else{*/
                                         echo '<style>
                                                 #F'.$trueUnused[$f].'{
                                                  background-Color: #AA0000;
                                                   border-bottom-color: #AA0000;
                                                   padding: 1px;
                                                }
                                                </style>';
                                        
                                     //}  

                              $r++;
            
                          }

                              $f++;
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
           ///////////////////////////////////////////////////////////////
           //dodawanie spotkania
        //////////////////////////////////////////////////////////////////   
        if(isset($_POST['date'])){
            
            $dateMeet = $_POST['date'];  
    
            $dayOfWeek = date('N', strtotime($dateMeet));//sprawdzanie dnia tygodnia z konkretnej daty
 
            $begHours = $_POST['begHours'];
            $begMinutes = $_POST['begMinutes'];
            
            $idBegHour = $begHours ;
           if($begHours==NULL){
                $begHours=0;
            }
            
            if($begMinutes==NULL){
                $begMinutes=0;
            }
            
            if($begHours<10){
                $begHours = '0'.$begHours;
            }
            
            if($begMinutes<10){
                $begMinutes = '0'.$begMinutes;
            }
            
            $FullHourStart = $begHours.':'.$begMinutes.':'.'00';
             
            /*echo $FullHourStart;
            echo '<br/>';*/
            
            $hours = $_POST['hours'];
            $minutes = $_POST['minutes'];
            
            if($hours==NULL){
                $hours=0;
            }
            
            if($minutes==NULL){
                $minutes=0;
            }
          
            $timeOfMeeting = $hours.':'.$minutes;
            
            /*echo $timeOfMeeting;
            echo '<br/>';*/
            
            $hourEnd = $begHours + $hours;
           
            $minuteEnd = $begMinutes + $minutes;
              
            if($minuteEnd>=60){
                $minuteEnd = $minuteEnd - 60;
                $hourEnd = $hourEnd+1;
            }
             $idEndHour = $hourEnd;
            
            if($hourEnd<10){
                $hourEnd = '0'.$hourEnd;
            }
            
            if($minuteEnd<10){
                $minuteEnd = '0'.$minuteEnd;
            }
            
            $FullHourEnd = $hourEnd.':'.$minuteEnd.':'.'00';
            
            /*echo $FullHourEnd;
            echo'<br/>';*/
            
           
            
            if($minuteEnd==0){
                $minEndId=0;
            }
            
            if($minuteEnd==15){
                $minEndId=1;
            }
            
            if($minuteEnd==30){
                $minEndId=2;
            }
            
            if($minuteEnd==45){
                $minEndId=3;
            }
            
            
            if($begMinutes==0){
                $minBegId=0;
            }
            
            if($begMinutes==15){
                $minBegId=1;
            }
            
            if($begMinutes==30){
                $minBegId=2;
            }
            
            if($begMinutes==45){
                $minBegId=3;
            }
   
            $StartId = $idBegHour.$minBegId.$dayOfWeek;
            $EndId =  $idEndHour.$minEndId.$dayOfWeek;
            
            /*echo $StartId;
            echo '<br/>';
              echo $EndId;
            echo '<br/>';*/
            
             $infoRead = $_POST['info'];
            
            $moreInfoRead = $_POST['moreInfo'];
            
            $usersId = $_SESSION['idusers'];
            /*echo $usersId;
            echo '<br/>';*/
            $validAdd = TRUE;
            //////////////////////////////////////////
            //zabezpieczenie
            $resChechAdd = $connection->query("SELECT * FROM meetings WHERE day='$dateMeet' "
                    . "AND hourStart BETWEEN '$FullHourStart' AND '$FullHourEnd' "
                    . "AND hourEnd BETWEEN '$FullHourStart' AND '$FullHourEnd'");
            
            if(!$resChechAdd){
                throw new Exception(mysqli_connect_errno());
            }
            
            $countEvents = $resChechAdd->num_rows;
            
            
            if($countEvents>0){
                $validAdd=FALSE;
                $_SESSION['error_add'] = '<span class="list-group-item list-group-item-danger">'
                    . 'Wydarzenie w tym terminie zostało ju« dodane do bazy danych!</span>';
            }
            /*******************************************/
            //liczenie wszystkich wydarzeń
            $resEvents = $connection->query("SELECT * FROM meetings");
            $countAllEvents = $resEvents->num_rows;
            //echo $countAllEvents.'<br/>';
            /********************************************/
            if($validAdd==TRUE){
                
                $addMeetingQuerry = "INSERT INTO `meetings` (idmeetings, users_idusers, "
                        . "info, moreInfo, day, hourStart, hourEnd, timeLast, idStart, idEnd) "
                        . "VALUES (NULL, '$usersId', '$infoRead', '$moreInfoRead', '$dateMeet', "
                        . "'$FullHourStart', '$FullHourEnd', '$timeOfMeeting', '$StartId', "
                        . "'$EndId')";
                
              
                /****************************************/
                //ustawianie sekcji, zaproszona i nie zaproszona
                for($i=1; $i<=$sectionCount; $i++){
                    
                    if(isset($_POST['sec'.$i])){
                        $tabIdMeeting[$i] = 1;
                    } else if(!isset($_POST['sec'.$i])){
                        $tabIdMeeting[$i] = 0;
                    }
                   
                    //echo $tabIdMeeting[$i].$tabSections[$i].'<br/>';
                }
                /****************************************/
                /****************************************/
                //ustawianie użytkownikó, zaproszony i nie zaproszony
                for($i=1; $i<$countOfUsers; $i++){
                    if(isset($_POST['per'.$i])){
                        $tabPersonsInvited[$i] = 1;
                    } else if(!isset($_POST['per'.$i])){
                        $tabPersonsInvited[$i] = 0;
                    }
                }
                /****************************************/   
                
                if($connection->query($addMeetingQuerry)){
                    /********************************************/       
                    //liczenie wszystkich wydarzeń
                    $resEvents = $connection->query("SELECT * FROM meetings");
                    $countAllEvents = $resEvents->num_rows;
                    //echo $countAllEvents.'<br/>';
                    /********************************************/
                    
                    /*******************************************************/
                    //dodawanie zaproszonych sekcji do spotkan
                    $connection->query("INSERT INTO groups (idgroups, meetings_idmeetings, "
                            . "meetings_users_idusers) VALUES(NULL, '$countAllEvents', '$idUsers')");
                    
                    
                    
                    for($i=1; $i<=$sectionCount; $i++){
                       $connection->query("UPDATE `groups` SET `$tabSections[$i]` = $tabIdMeeting[$i] "
                                . "WHERE `meetings_idmeetings` = '$countAllEvents'");
     
                    }
                    /********************************************************************************/
                    /********************************************************************************/
                    //dodawanie danych u«ytkownikow do spotkan
                    $connection->query("INSERT INTO invited (idinvited, meetings_idmeetings, "
                            . "meetings_users_idusers) VALUES(NULL, '$countAllEvents', '$idUsers')");
                    for($i=1; $i<$countOfUsers; $i++){
                   
                         $connection->query("UPDATE `invited` SET `$tabUsersLogin[$i]` =  $tabPersonsInvited[$i] "
                                . "WHERE `meetings_idmeetings` = '$countAllEvents'");
                             
                               
                    }
                    /********************************************************************************/
                    $_SESSION['added'] = '<span class="list-group-item list-group-item-success">
                       Dodano wydazenie do terminarza</span>';
                    
                    header('Location: adding.php');
                    
                } else {
                    echo 'Error no. '.$connection->errno;
                }
            }
            
        }
        ////////////////////////////////////////////////////////////////////////
        //usuwanie spotkania
        ////////////////////////////////////////////////////////////////////////
        if(isset($_POST['dateDel'])){
            
            $idStartDel = '2501';
            $idEndDel = '2601';
            
            $dateDel = $_POST['dateDel'];
            $begHoursDel = $_POST['begHoursDel'];
            $begMinutesDel = $_POST['begMinutesDel'];
            
            /*echo $dateDel;
            echo '<br/>';
            echo $begHoursDel;
            echo '<br/>';
            echo $begMinutesDel;
            echo '<br/>';*/
            
            if($begHoursDel<10){
                $begHoursDel = '0'.$begHoursDel;
            }
            
            if($begMinutesDel<10){
                $begMinutesDel = '0'.$begMinutesDel;
            }
            
            $fullHourDel = $begHoursDel.':'.$begMinutesDel.':00';
            //echo $fullHourDel;
            
            $resIdDel = $connection->query("SELECT * FROM meetings WHERE "
                    . "day='$dateDel' AND hourStart='$fullHourDel'");
            
            $rowDel = $resIdDel->fetch_assoc();
            
            $idmeetingsDel = $rowDel['idmeetings'];
            
            $resIdDel->free();
            
            $queryDel = "UPDATE meetings SET idStart='$idStartDel', idEnd='$idEndDel' "
                    . "WHERE idmeetings='$idmeetingsDel'";
            
            if($connection->query($queryDel)){
                $_SESSION['delete'] = '<span class="list-group-item list-group-item-success">
                       Usunieto wydazenie z terminarza</span>';
                
                header('Location: adding.php');
            } else {
                throw new Exception($connection->erno);
            }
        }
        ///////////////////////////////////////////////////////////////////////////////  
        //edytowanie spotkania
        //////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['dateEdit'])){
            
            $dateOld = $_POST['dateOld'];
            $begHoursOld = $_POST['begHoursOld'];
            $endHoursOld = $_POST['endHoursOld'];
            
            /*echo $dateOld.'<br/>';
            echo $begHoursOld '<br/>';
            echo $endHoursOld.'<br/>';*/
            
            $dateEdit = $_POST['dateEdit'];
            
            $begHoursEdit = $_POST['begHoursEdit'];
            $begMinutesEdit = $_POST['begMinutesEdit'];
            
            $hoursEdit = $_POST['hoursEdit'];
            $minutesEdit = $_POST['minutesEdit'];
            
            $infoEdit = $_POST['infoEdit'];
            $moreInfoEdit = $_POST['moreInfoEdit'];
            
            $dayOfWeekEdit = date('N', strtotime($dateEdit));//sprawdzanie dnia tygodnia z konkretnej daty
            
            /*echo $dayOfWeekEdit.'<br/>';
            echo $dateEdit.'<br/>';
  
            echo $begHoursEdit.'<br/>';
            echo $begMinutesEdit.'<br/>';
            echo $hoursEdit.'<br/>';
            echo $minutesEdit. '<br/>';
            echo $infoEdit. '<br/>';
            echo $moreInfoEdit. '<br/>';*/
            
            $idBegHourEdit = $begHoursEdit;
            
            if($begHoursEdit<10){
                $begHoursEdit = '0'.$begHoursEdit;
            }
            
            if($begMinutesEdit<10){
                $begMinutesEdit = '0'.$begMinutesEdit;
            }
            
            $FulHourStartEdit = $begHoursEdit.':'.$begMinutesEdit.':00';
           // echo $FulHourStartEdit.''.'<br/>';
            
            
             if($hoursEdit==NULL){
                $hoursEdit=0;
            }
            
            if($minutesEdit==NULL){
                $minutesEdit=0;
            }
            
            $timeOfMeetingEdit = $hoursEdit.':'.$minutesEdit;
           //echo $timeOfMeetingEdit.'<br/>';
            
            $hourEndEdit = $begHoursEdit + $hoursEdit;
            
            $minutesEndEdit = $begMinutesEdit + $minutesEdit;
            
            if($minutesEndEdit>=60){
                $minutesEndEdit = $minutesEndEdit - 60;
                $hourEndEdit = $hourEndEdit + 1; 
            }
            
            $idEndHourEdit = $hourEndEdit;
            
            if($hourEndEdit<10){
                $hourEndEdit = '0'.$hourEndEdit;
            }
            
            if($minutesEndEdit<10){
                $minutesEndEdit = '0'.$minutesEndEdit;
            }
            
            $FullHourEndEdit = $hourEndEdit.':'.$minutesEndEdit.':00';
            
            //echo $FullHourEndEdit.'<br/>';
            
             if($begMinutesEdit==0){
                $minBegIdEdit=0;
            }
            
            if($begMinutesEdit==15){
                $minBegIdEdit=1;
            }
            
            if($begMinutesEdit==30){
                $minBegIdEdit=2;
            }
            
            if($begMinutesEdit==45){
                $minBegIdEdit=3;
            }
            
            //echo $minBegIdEdit.'<br/>';
            
             if($minutesEndEdit==0){
                $minEndIdEdit=0;
            }
            
            if($minutesEndEdit==15){
                $minEndIdEdit=1;
            }
            
            if($minutesEndEdit==30){
                $minEndIdEdit=2;
            }
            
            if($minutesEndEdit==45){
                $minEndIdEdit=3;
            }
            //echo $minEndIdEdit.'<br/>';
            
             
            $StartIdEdit = $idBegHourEdit.$minBegIdEdit.$dayOfWeekEdit ;
            $EndIdEdit =  $idEndHourEdit.$minEndIdEdit.$dayOfWeekEdit;
            
            
            $resEdit = $connection->query("SELECT * FROM meetings WHERE day='$dateOld' "
                    . "AND hourStart='$begHoursOld' AND hourEnd='$endHoursOld'");
            
            $rowEdit = $resEdit->fetch_assoc();
            
            $idmeetingsEdit = $rowEdit['idmeetings'];
            
            $resEdit->free_result();
            
            /****************************************/
                //ustawianie sekcji, zaproszona i nie zaproszona
                for($i=1; $i<=$sectionCount; $i++){
                    
                    if(isset($_POST['secEdit'.$i])){
                        $tabIdMeetingEdit[$i] = 1;
                    } else if(!isset($_POST['sec'.$i])){
                        $tabIdMeetingEdit[$i] = 0;
                    }
                   
                    //echo $tabIdMeetingEdit[$i].$tabSections[$i].'<br/>';
                }
                /****************************************/
                /****************************************/
                //ustawianie użytkownikó, zaproszony i nie zaproszony
                for($i=1; $i<$countOfUsers; $i++){
                    if(isset($_POST['perEdit'.$i])){
                        $tabPersonsInvitedEdit[$i] = 1;
                    } else if(!isset($_POST['per'.$i])){
                        $tabPersonsInvitedEdit[$i] = 0;
                    }
                }
                /****************************************/
            

            $queryEdit = "UPDATE meetings SET info='$infoEdit', moreInfo='$moreInfoEdit', "
                    . "day='$dateEdit', hourStart='$FulHourStartEdit', "
                    . "hourEnd='$FullHourEndEdit', timeLast='$timeOfMeetingEdit', "
                    . "idStart='$StartIdEdit', idEnd='$EndIdEdit' WHERE "
                    . "idmeetings='$idmeetingsEdit'";
            
                    /********************************************************************************/
               
            
            
            if($connection->query($queryEdit)){
                /*******************************************************/
                //edytowanie zaproszonych grup
                for($i=1; $i<=$sectionCount; $i++){
                     $connection->query("UPDATE `groups` SET `$tabSections[$i]` = "
                             . "$tabIdMeetingEdit[$i] "
                                . "WHERE `meetings_idmeetings` = '$idmeetingsEdit'");
                }
                /*******************************************************/
                 /*******************************************************/
                //
                for($i=1; $i<$countOfUsers; $i++){
                       $connection->query("UPDATE `invited` SET `$tabUsersLogin[$i]` =  "
                               . "$tabPersonsInvitedEdit[$i] "
                                . "WHERE `meetings_idmeetings` = '$idmeetingsEdit'");
                }
                 /*******************************************************/
                $_SESSION['edit'] = '<span class="list-group-item list-group-item-success">
                       Wydazenie zostalo edytowane</span>';
                
                header('Location: adding.php');
                
            } else {
                throw new Exception($connection->errno);
            }
            
            
        }
        //////////////////////////////////////////////////////////////////////
        
        $connection->close();  
   
   } 
   
     
    
    
}catch(Exception $e){
    echo $e;
}

$SpanCol = ($end/2)+1; 
    $h = $a;//domyslna godzina poczætkowa

?>