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
///////////////////////////////
//wybør widokøw do panelu administratora
require_once 'connection.php';


try{
   //pobieranie daty
   $date = date('Y-m-d');
   $day = date('w');
   

   
    $valid=true;
    
    $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
    if($connection->connect_errno!=0){
       echo "Error: ".$connection->connect_errno;
       
    } else {
           
       if($valid==true){
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
         
           /////////////////////////////////////////////
           //selekcja widokøw
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
            //ustawianie widokøw(godzin)
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
            

           ////////////////////////////////////////// 
         
        } else {
            throw new Exception($connection->errno);
       }
   
   } 
    
    $connection->close();   
    
    
}catch(Exceptione $e){
    echo $e;
}

    $start=0;//start petli
    $a = $_SESSION['startOfView'];
    $b = $_SESSION['endOfView'] + 1;
    $interval = $b - $a;
    $end=4*$interval;//koniec petli
              
    $SpanCol = ($end/2)+1; 
    $h = $a;//domyslna godzina poczætkowa

    
    //////////////////////////////////////////////////////
    
    
    
    
    /////////////////////////////////////////////////////
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
                
             <table id="trueTable" border="5" width="100%" height="50%" 
                    class="table-active table-responsive">
                    <tr>
                      <?php  //wrtzuci¢ do zwykłego u«ytkownika
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
                             
                            <td colspan="5">Pole z opisem najbliszego 
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
                        <?php  //////////////////////////////////////////////////// ?>      
                            <?php 
                                       
                    echo '<td rowspan="'. ($SpanCol+1).'"><input 
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
                            for($i=1; $i<=7; $i++){
                             echo 
                            '<td>
                                    <div id="date'.$i.'" '
                                     . 'class="date">'.$tab[$i].'</div>
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