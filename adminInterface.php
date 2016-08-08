<?php
    //zabezpieczenie przed wejßciem z palca
    session_start();

     if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }

    //stałe wartoßci domyslne
///////////////////////

$check = 1;//flaga sprawdzjaca minuty - nie zmienia¢
$min = 0; //id minut - stała nie do zmiany

$monthCount = 1;
$weekCount = 1;

$start=0;//start petli
$end=4*13;//koniec petli
                      
$h=6;//domyslna godzina poczætkowa

$r = 0;//zmienna do zarezerwowanych(indeksy)
 $f=0;
 $r1=0;
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
           $myId =  $_SESSION['idusers'];
           for($i=1; $i<=$countUsers; $i++){
               $resUsersInc = $connection->query("SELECT * FROM users "
                       . "WHERE idusers = '$i'");
               
               $rowUsersInc = $resUsersInc->fetch_assoc();
                            
               $tabFlag[$i] = $rowUsersInc['flag'];
              
               
               if($tabFlag[$i]==0 && $i!=$myId){
                     $tabUsers[$countOfUsers] = $rowUsersInc['fullName'];
                     $tabUsersLogin[$countOfUsers] = $rowUsersInc['userLogin'];
                     $countOfUsers++;
               }
               
               $resUsersInc->free();
           }
           
           /*********************************/
           
       if($valid==true){
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
            $count = $result->num_rows;
          
            for($i=1; $i<=$count; $i++){
                $res1 = $connection->query("SELECT * FROM view WHERE idview = '$i'");
                $row12 = $res1->fetch_assoc();
            
                $vievs[$i] = $row12['nameOfView'];
                
                if($vievs[$i]=='basic'){
                    $_SESSION['startOfView'] = $row12['startOfView'];
                    $_SESSION['endOfView'] = $row12['endOfView'];
                }
                
                $res1->free_result();
                
            }
            /******************************************************************************/
            //do dokonczenia
            //////////////////////////////////////////////////////////////////
            //ustawianie widokøw(godzin)
            /////////////////////////////////////////////////////////
            if(isset($_POST['view'])){
                    
                $view = $_POST['view'];
                    
                $viewResult= $connection->query("SELECT * FROM view WHERE nameOfView = '$view'");
            
            
                if($connection->query("SELECT * FROM view WHERE nameOfView = '$view'")){          
                    
                    
                    $rowViews = $viewResult->fetch_assoc();
                
                    $_SESSION['startOfView'] = $rowViews['startOfView'];
                    $_SESSION['endOfView'] = $rowViews['endOfView'];
            

                    $viewResult->free_result(); 
                          
                }
                    
            }
            //////////////////////////////////////////////////////////////////
            //dekrementacja miesiæca
            ////////////////////////////////////////////////////////////////////
            if(isset($_POST['decMonth'])){
                
            
                $qDecMonth= "SELECT DATE_ADD('$date', INTERVAL -'$monthCount' MONTH)";
                $decMonth = $connection->query($qDecMonth);
                $rowDecMonth = $decMonth->fetch_assoc();
                
                $DM = $rowDecMonth["DATE_ADD('$date', INTERVAL -'$monthCount ' MONTH)"];
                $date = $DM;
               
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
            
            if(isset($_POST['incMonth'])){
               
                
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
                $incMon++;
            }
            /////////////////////////////////////////////////////////////////////
            //dekrementacja tygodnia
            ////////////////////////////////////////////////////////////////////
            
            if(isset($_POST['decWeek'])){
               
                
                $qDM = "SELECT DATE_ADD('$mon', INTERVAL -'$weekCount' WEEK)";
                $resDM = $connection->query($qDM);
                $rowDM = $resDM->fetch_assoc();
                
                $monD = $rowDM["DATE_ADD('$mon', INTERVAL -'$weekCount' WEEK)"];
                
                echo $monD;
                
                $resDM->free_result();
                
                for($i=1; $i<=7; $i++){
                    
                    $resWD = $connection->query
                            ("SELECT DATE_ADD('$monD', INTERVAL +'$i' DAY");
                   
                  // $rowWD = $resWD->fetch_assoc();
                    
                }
                
                
            }
            

         /*************************************************************************/
           ///////////////////////////////////////////////////////////////
            //wczytywanie spotkan na tablice głøwnæł
           /////////////////////////////////////////
  
           $a=0;
           $s = 0;
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
                    
                    ////
                    $idMeeting[$a] = $rowMeeting['idmeetings'];
                    
                    /////
                    $info[$a] = $rowMeeting['info'];
                    $moreInfo[$a] = $rowMeeting['moreInfo'];
                    $idStart[$a] = $rowMeeting['idStart'];
                    $idEnd[$a] = $rowMeeting['idEnd'];
                    $timeLast[$a] = $rowMeeting['timeLast'];
                    
                    $dateOfMeeting[$a] = $rowMeeting['day'];
                    $hourMeetingStarts[$a] = $rowMeeting['hourStart'];
                    $hourMeetingEnds[$a] = $rowMeeting['hourEnd'];
                    
                    $tabId[$a] = $tabH[$i].$tabMin[$i].$j;//id wygenerowanych komørek
                    /*echo $tabId[$a].' ';
                    if($a%7==0){
                        echo '<br/>';
                    }*/
                    settype($tabId[$a], 'integer');
                    settype($idStart[$a], 'integer');
                    settype($idEnd[$a], 'integer');
                 if($info[$a]!=NULL){   
             
                     /*echo $s.' '.$unused[$s];
                              echo '<br/>';*/
                     
                      /////////////////////////////////////////////
                                 /*echo $r.' '. $reserved[$r];
                                echo'<br/>';*/
                                //////////////////////////////////////////////////////////
                     
                     /************************************/
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
                        $tabSecNum[$sect] = $rowSecView [$nameSec];
                        //echo $idMeeting[$a].'-'.$nameSec.'-'.$tabSecNum[$sect].' <br/>';
                        
                        if($tabSecNum[$sect]==1){
                            $secSeen[$a][$secCount[$a]] = $nameSec;
                            $secCount[$a] = $secCount[$a] + 1;
                        }
                    }
                    
                    $resSecView->free();
                    
                    /*****************************************/   
                     
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
                                   $reserved[$r] = $trueUnused[$f];
                                   
                                

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
            
            if($validAdd==TRUE){
                $addMeetingQuerry = "INSERT INTO `meetings` (idmeetings, users_idusers, "
                        . "info, moreInfo,day, hourStart, hourEnd, timeLast, idStart, idEnd) "
                        . "VALUES (NULL, '$usersId', '$infoRead', '$moreInfoRead', '$dateMeet', "
                        . "'$FullHourStart', '$FullHourEnd', '$timeOfMeeting', '$StartId', "
                        . "'$EndId')";
                if($connection->query($addMeetingQuerry)){
                    $_SESSION['added'] = '<span class="list-group-item list-group-item-success">
                       Dodano wydazenie do terminarza</span>';
                } else{
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
            } else {
                throw new Exception($connection->erno);
            }
        }
        ///////////////////////////////////////////////////////////////////////////////  
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
            
           // echo $StartIdEdit.'<br/>'.$EndIdEdit;
             /*$queryDel = "UPDATE meetings SET idStart='$idStartDel', idEnd='$idEndDel' "
                    . "WHERE idmeetings='$idmeetingsDel'";*/
        
            
            $queryEdit = "UPDATE meetings SET info='$infoEdit', moreInfo='$moreInfoEdit', "
                    . "day='$dateEdit', hourStart='$FulHourStartEdit', "
                    . "hourEnd='$FullHourEndEdit', timeLast='$timeOfMeetingEdit', "
                    . "idStart='$StartIdEdit', idEnd='$EndIdEdit' WHERE "
                    . "idmeetings='$idmeetingsEdit'";
            
            if($connection->query($queryEdit)){
                $_SESSION['edit'] = '<span class="list-group-item list-group-item-success">
                       Wydazenie zostalo edytowane</span>';
            } else {
                throw new Exception($connection->errno);
            }
            
            
        }
        //////////////////////////////////////////////////////////////////////
         
        } else {
            throw new Exception($connection->errno);
       }
   
   } 
   
    $connection->close();   
    
    
}catch(Exception $e){
    echo $e;
}

    $start=0;//start petli
    $a = $_SESSION['startOfView'];
    $b = $_SESSION['endOfView'] + 1;
    $interval = $b - $a;
    $end=4*$interval;//koniec petli
              
    $SpanCol = ($end/2)+1; 
    $h = $a;//domyslna godzina poczætkowa

?>

             

<!DOCTYPE html>

<html lang="pl">
    <head>
        <meta charset="UTF-8">

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- The above 3 meta tags *must* come first in the head; 
        any other head content must come *after* these tags -->
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">     
        <script src="js/jquery.js"></script>
        <script src="js/jquery_1.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-ui.js"></script>

        <link href="css/jquery-ui.css" rel="stylesheet">

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
                if(isset($_SESSION['added'])){
                    echo $_SESSION['added'];
                }
             
                if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete'];
                }
                
                if(isset($_SESSION['error_add'])){
                    echo $_SESSION['error_add'];
                }
                
                if(isset($_SESSION['edit'])){
                    echo $_SESSION['edit'];
                }
                
                ?>
             
        
            <div id="header">
                 <h1>Terminarz - panel administartora</h1>
             
                    
                       </div>
           
            <div id='menu'>
                
                  <?php
                        echo 'Witaj '.$_SESSION['name'].'  '
                                .$_SESSION['surname'];
                        
                        
                         ?>
                    <br/>
                    <a href='logout.php'>Wyloguj sie</a>
                     <br/>
                     <a  href="makeAccount.php">załóż konto</a>
                    <br/>
                    <form method="post">
                    <select id="view" name="view">
                        <?php 
                        for($i=1; $i<=$count; $i++){
                            echo '<option>'.$vievs[$i].'</option>';
                        }
                        
                        ?>
                   
                    </select>
                         <br/>
                        <br/>
                        <input type="submit" value="ustaw widok" id="buttonadmin"/>
                    </form>
                
            </div>
          
            <div id="table">
   
             <table id="trueTable" border="5" width="100%" height="20%" 
                    class="table-active table-responsive">
                    <tr>
                      <?php//////////////////////////////////////////////////
                      //klawisze inkrementacji i dekrementacji
                        ///////////////////////////////////////////////// ?>
                          <td colspan="2"> 
                              <form method="post">
                              <input class="btn btn-primary active" 
                           type="submit" value="<<" id="buttonDay" name="decMonth"/>
                              </form>
                              <form method="post">
                           <input class="btn btn-primary active" 
                           type="submit" value="<" id="buttonDay" name="decWeek"/>
                           </form>
                         
                          </td>
                             
                            <td colspan="5" class="head">Pole z opisem najbliszego 
                                spotkania</td>
                    
                            <td colspan="2"> 
                                <form method="post"> 
                                    <input class="btn btn-primary active" 
                                         type="submit" value=">>" id="buttonDay" 
                                         name="incMonth"/>
                                </form>
                                <form method="post"> 
                                    <input class="btn btn-primary active" 
                                        type="submit" value=">" id="buttonDay" 
                                        name="incWeek"/>
                                </form>
                            </td>
                <?php  ////////////////////////////////////////////////////////
                //zmaina godziny
                //////////////////////////////////////////////////////////////
                        
                        
                                       
                    echo '<td rowspan="'. ($SpanCol+1).'" class="changeHour"><input 
                            class="btn btn-primary active" 
                           type="submit" value="<<" id="buttonHour"
                        </td>';
                    
                     ?>
                            
                             
                    </tr>
                    <tr id="cols">
                        
                        
                        <td rowspan="2" colspan="2">
                            <div  id="textHour">
                                Godzina
                            </div>
                            
                        </td>
                       
                       <?php
                       ////////////////////////////////////////////////////
                       //wyßwietlanie dat
                       //////////////////////////////////////////////////
                            for($i=1; $i<=7; $i++){
                             echo 
                            '<td>
                                    <div id="date'.$i.'" '
                                     . 'class="date">'.$tab[$i].'</div>
                                         

                                     <style> 
                                        
                                        #date'.$i.'{
                                            color: white;
                                        }
                                    
                                    </style>
                            </td>  ';
                             
                            }
                       ////////////////////////////////////////////////////
                            
                             $f=0;   
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
                        ///////////////////////////////////////
                        //kolorowanie nazw dni tygodni
                        ///////////////////////////////////////
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
                          ///////////////////////////////////////////////////////////////
                          
                              
                        ?>
                        
                    </tr>
                    <?php 
                    $a2=$a;
                    $start=0;//start petli
                    $allHours = 13;
                    $end=4*$allHours;//koniec petli
                      
                    $h=6;//domyslna godzina poczætkowa
                    $check = 1;//flaga sprawdzjaca minuty - nie zmienia¢
                    $a=0;
                    
                    $f = 0;
                     
                    for($i=$start; $i<$end; $i++){
                          ////////////////////////////////////////////////
                          //
                        /////////////////////////////////////////////////
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
//////////////////////////////////////////////////////////////////////////
                           
                            for($j=1; $j<=7; $j++){

        //obsługa tablicy ze spotkaniami                        
                                if($info[$a]!=NULL){
                                   
                                       echo ' <td class="row" id="F'.$tabId[$a].'"
                                            data-toggle="modal" data-target="#MA'.$tabId[$a].'">
                                     '.$info[$a].'</td>';  
 //////////////////////////////////////////////////////////////////////////
 //wyßwietlanie informacji o spotkaniu                                      
                                echo'<div class="modal fade" id="MA'.$tabId[$a].'" role="dialog">
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
                                            <br/>
                                            <br/>
                                            

                                    </div>';
                                 echo '<div id="sections'.$tabId[$a].'">
                             
                             <p>sekcje zaproszone:</p>';
                         for($sections=0; $sections<$secCount[$a]; $sections++){
                            echo '<label>'. $secSeen[$a][$sections]. '</label> '
                                    . '<br/>';
                            
                         }
                           echo'      </div>';
                         echo '<div id="persons'.$tabId[$a].'">
                                
                                <p>osoby zaproszone:</p>';
                                
                           for($users=0; $users< $useCount[$a]; $users++){
                             echo '<label>'. $usersSeen[$a][$users]. '</label> '
                                    . '<br/>';
                         }
                         
                             echo'      </div>
                                  <div class="modal-footer">
                                    <input type="submit" value="Edytuj"
                                                class="btn btn-link"
                                                data-toggle="modal" data-target="#Edit'.$tabId[$a].'"/>
                                    
                                            <input type="submit" value="usun wydarzenie"
                                                class="btn btn-danger active" 
                                                    data-toggle="modal" 
                                                data-target="#Del'.$tabId[$a].'"/>
                                            
                                <button type="button" class="btn btn-default" 
                                data-dismiss="modal">Zamknij</button>
                                    </div>
                                    </div>
                                    </div>
                                                    </div>';  
                              
                                      echo '<style>
                                    #sections'.$tabId[$a].'{
                                        float: left;
                                        width: 50%;
                                        font-size: 80%;
                                    }
                                    
                                    #persons'.$tabId[$a].'{
                                        float: left;
                                        width: 50%;
                                        font-size: 80%;
                                        height: 40%;
                                    }
                                    
                                    #foot'.$tabId[$a].'{
                                        clear: both;
                                    }
                                </style>';
                              
////////////////////////////////////////////////////////////////////

//okno słu«æce do usuwania spotkania
///////////////////////////////////////////////////////////////////
                        echo       '<div class="modal fade" id="Del'.$tabId[$a].'" role="dialog">
                                   <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" 
                                    data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Czy na pewno chcesz usunæc to spotkanie?</h4>
                                     </div>
                                    <div class="modal-body">
                                    <form method="post">
                                        <p>Data spotkania</p>
                                        <br/>
                                       
                                            
                                      <input type="text"  name="dateDel"
                                          value="'.$dateOfMeeting[$a].'"  
                                              readonly="readonly"/>
                                         <br/>
                                        <br/>
                                        <p>Godzina rozpoczecia</p>
                                        <br/>
                                         godzina:
                                        <input type="number" name="begHoursDel" min="0" max="23"
                                        value="'.($h-1).'" readonly="readonly"/>';
                                        
                                         if($tabMin[$i]==0){
                                           $minut=0;
                                       } 
                                         if($tabMin[$i]==1){
                                           $minut=15;
                                       } 
                                         if($tabMin[$i]==2){
                                           $minut=30;
                                       } 
                                         if($tabMin[$i]==3){
                                           $minut=45;
                                       }
                                        

                                        echo'                 minuta:
                                        <input type="number" name="begMinutesDel" min="0" max="45" step="15"
                                        value="'.$minut.'"  readonly="readonly"/>
                                        <br/>
                                        <br/>
                               
                                        <input type="text" name="infoDel" id="textfield" 
                                            value="'.$info[$a].'" class="form-control" 
                                                readonly="readonly"/>
                                            <br/>
                                            <br/>
                                            <textarea type="text" name="moreInfoDel" id="textfield" 
                                                " class="form-control" cols="30" rows="10"
                                                readonly="readonly">
                                                '.$moreInfo[$a].'</textarea>
                                     
                                            <br/>
                                            <br/>
                                        
                                    <input class="btn btn-danger active" 
                                        type="submit" value="Usun" id="button"/>
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                <button type="button" class="btn btn-default" 
                                data-dismiss="modal">Anuluj</button>
                                    </div>
                                    </div>
                                    </div>
                                    </div>';                                     
////////////////////////////////////////////////////////////////////////////////////////
                  
//okno słu«æce do edycji spotkania                  
/////////////////////////////////////////////////////////////////////////////////////////
                            echo'<div class="modal fade" id="Edit'.$tabId[$a].'" 
                                    role="dialog">
                                   <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" 
                                    data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edytuj spotkanie</h4>
                                    
                                     </div>
                                    <div class="modal-body">
                                    <form method="post" >
                                       
                                     <h6>Stare dane</h6>
                                    <h6> Data: <input type="text"  name="dateOld"
                                          value="'.$dateOfMeeting[$a].'" class="text" 
                                              readonly="readonly"/></h6>

                                       <h6> Czas trwania: <input type="text"  name="begHoursOld"
                                          value="'.$hourMeetingStarts[$a].'" class="text" 
                                              readonly="readonly"/> - 
                                          <input type="text"  name="endHoursOld"
                                          value="'.$hourMeetingEnds[$a].'" class="text" 
                                              readonly="readonly"/></h6>
                                                                             </br>
                                        <br/>
                                         <p>Data spotkania</p>
                                         <br/>
                                        <br/> 
                                      <input type="text" id="datepicker'.$a.'" name="dateEdit"
                                          value="'.$dateOfMeeting[$a].'"/>
                                         <br/>
                                        <br/>
                                        <p>Godzina rozpoczecia</p>
                                        <br/>
                                         godzina:
                                        <input type="number" name="begHoursEdit" min="0" max="23"
                                        value="'.($h-1).'"/>';
                                        
                                         if($tabMin[$i]==0){
                                           $minut=0;
                                       } 
                                         if($tabMin[$i]==1){
                                           $minut=15;
                                       } 
                                         if($tabMin[$i]==2){
                                           $minut=30;
                                       } 
                                         if($tabMin[$i]==3){
                                           $minut=45;
                                       }
                                        

                                        echo' minuta:
                                        <input type="number" name="begMinutesEdit" min="0" 
                                        max="45" step="15"
                                        value="'.$minut.'"/>
                                        <br/>
                                        <br/>
                               
                                        <p>Czas spotkania</p>
                                         <br/>
                                        godziny:
                                        <input type="number" name="hoursEdit" min="0" max="7"/>
                                         minuty:
                                        <input type="number" name="minutesEdit" min="0" 
                                        max="45" step="15"/>
                                        <br/>
                                        <br/>
                                        <input type="text" name="infoEdit" id="textfield" 
                                            value="'.$info[$a].'" class="form-control"/>
                                            <br/>
                                            <br/>
                                            <textarea type="text" name="moreInfoEdit" 
                                            id="textfield" 
                                                " class="form-control" cols="30" rows="10">
                                                '.$moreInfo[$a].'</textarea>
                                     
                                            <br/>
                                            <br/>
                                        
                                            <input class="btn btn-primary active" 
                                                type="submit" value="Edytuj" id="button"/>
                                            </form>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-default" 
                                                data-dismiss="modal">Anuluj</button>
                                            </div>
                                            </div>
                                            </div>
                                            </div>';  
       
/////////////////////////////////////////////////////////
//datapicker - okienko z kalendarzem
                                     echo '<script>
                                        $( function() {
                                            $( "#datepicker'.$a.'" ).datepicker
                                                ({dateFormat: "yy-mm-dd"});
                                                    } );
                                            </script>';
/////////////////////////////////////////////////////////////////////////////






                                    echo'<style>
                                        #F'.$tabId[$a].'{
                                            background-Color: #AA0000;
                                            border-color: #AA0000;

                                            color: white; 
                                              font-size: 70%;
                                              border-right-color: white;
                                             
                                            }
                                        </style>';

/**************************************************************************************/
//obsłua pustych pol
                                } else { 
                                   if($tabId[$a]!=$reserved[$r1]){
                                    
                                    echo ' <td class="row" id="F'.$tabId[$a].'"
                                            data-toggle="modal" data-target="#M'.$tabId[$a].'">
                                     '.$tabId[$a].'</td>';
                                     echo '<style> 
                                             #F'.$tabId[$a].'{
                                                color: white;
                                            }
                                        </style>';
/////////////////////////////////////////////////////////////////////////////////////////////
//okienko dodajæce spotkanie                              
                    echo       '<div class="modal fade" id="M'.$tabId[$a].'" role="dialog">
                                   <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" 
                                    data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Dodaj spotkanie</h4>
                                     </div>
                                    <div class="modal-body">
                                    <form method="post" >
                                        <p>Data spotkania</p>
                                        <br/>
                                        <input type="text" id="datepicker'.$a.'" name="date"
                                            value="'.$tab[$j].'"/>
                                         <br/>
                                        <br/>
                                        <p>Godzina rozpoczecia</p>
                                        <br/>
                                         godzina:
                                        <input type="number" name="begHours" min="0" max="23"
                                        value="'.($h-1).'"/>';
                                        ///obsługa minut
                                       if($tabMin[$i]==0){
                                           $minut=0;
                                       } 
                                         if($tabMin[$i]==1){
                                           $minut=15;
                                       } 
                                         if($tabMin[$i]==2){
                                           $minut=30;
                                       } 
                                         if($tabMin[$i]==3){
                                           $minut=45;
                                       } 
 
 
                                echo' minuta:
                                        <input type="number" name="begMinutes" min="0" max="45" step="15"
                                        value="'.$minut.'"/>
                                        <br/>
                                        <br/>
                                        
                                        <p>Czas spotkania</p>
                                         <br/>
                                        godziny:
                                        <input type="number" name="hours" min="0" max="7"/>
                                         minuty:
                                        <input type="number" name="minutes" min="0" max="45" step="15"/>
                                        <br/>
                                        <br/>
                                        <input type="text" name="info" id="textfield" 
                                            placeholder="temat" class="form-control"/>
                                            <br/>
                                            <br/>
                                      
                                         <textarea type="text" name="moreInfo" id="textfield" 
                                                " class="form-control" placeholder="wiecej informacji" 
                                                cols="30" rows="10"></textarea>
                                            <br/>
                                            <br/>
                                        
                                    <input class="btn btn-primary active" 
                                        type="submit" value="Dodaj" id="button"/>
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                <button type="button" class="btn btn-default" 
                                data-dismiss="modal">Anuluj</button>
                                    </div>
                                    </div>
                                    </div>
                                    </div>'; 
 ///////////////////////////////////////////////////////////////////////////////////
//datapicker - kalendarz rozwijany                                
 /////////////////////////////////////////////////////////////////////////////////////                               
                                echo '<script>
                                    $( function() {
                                        $( "#datepicker'.$a.'" ).
                                            datepicker({dateFormat: "yy-mm-dd"});
                                    } );
                                </script>';
////////////////////////////////////////////////////////////////////////////////////////////                                     
                                     
                                   } else if($tabId[$a]==$reserved[$r1]){
                                       echo ' <td class="row" id="F'.$tabId[$a].'"></td>';
                                     echo '<style> 
                                             #F'.$tabId[$a].'{
                                                color: white;
                                            }
                                        </style>';
                                   }
                                }
                              
                                 $a++;
                                 $r1++;
                                 if($r1==$r){
                                     $r1=1;
                                 }

                            }
                            //////////////////////////////////////////////////////
                            //przewijanie godzin
                            if(((2*$allHours)-1)==$i){
                                echo '<td rowspan="'. ($SpanCol).'" class="changeHour"><input 
                                        class="btn btn-primary active" 
                                        type="submit" value="<<" id="buttonHour"
                                    </td>';
                            }
                             echo'    </tr>';
                              /////////////////////////////////////////////
                     
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