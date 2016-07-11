<?php 

require_once 'connection.php';

session_start();

if((isset($_POST['date1']) || isset($_POST['date2']) ||isset($_POST['date3']) || 
        isset($_POST['date4']) || isset($_POST['date5']) || isset($_POST['date6'])
        || isset($_POST['date7'])) && isset($_POST['dayOfweek'])){
            
            $dayOfWeek = $_POST['dayOfWeek'];
            for($i=1; $i<=7; $i++){
                 if($_POST['date'.$i]!=NULL){
                    $date = $_POST['date1'];
                 }
                 $dayOfWeek = $dayOfWeek - 1;
                 echo $date;
                 try{
                    $conncetion = new mysqli($host, $dbName, $dbUser, $dbPass);
                    
                    
                     $query = "SELECT DATE_ADD()";
                     
                     if($conncetion->query($query)){
                         
                     }
                    
                 }catch(Exceptione $e){
                     echo '<span class ="error">'.$e.'</span>';
                     
                    
                 }
            }
          
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
        
        <script type="text/javascript" src="js/timeChecks.js">  
        </script>
     
        
    </head>
    <body onload="checkDay()">
        <div id="container">
            <form method="post">
            <div id="header">
                 <h1>Terminarz</h1>
                 <div id="loging">
                     <a href="logingpre.php" class="btn-link">Zaloguj się</a>
                 </div>
                
            </div>
            
            <div id="table">
                
                <table id="trueTable" border="5" width="100%"  class="table-responsive">
                   
                    <tr id="cols">
                        
                        
                        <td rowspan="2">
                            <div  id="textHour">
                                Godzina
                            </div>
                            
                        </td>
                    
                        <td>
                            <div id="date1" class="date"></div>
                        </td>    
                        <td>
                           <div id="date2" class="date"></div>
                        </td>
                      
                        <td>
                            <div  id="date3" class="date"></div>
                        </td>
                        <td>
                            <div id="date4" class="date"></div>
                        </td>
                        <td >
                            <div id="date5" class="date"></div>
                        </td>
                        <td>
                            <div id="date6" class="date"></div>
                        </td>
                        <td>
                            <div id="date7" class="date"></div>
                        </td>
                        
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
                      
                        $startTable = 0;
                        $endTable = 12;
                        $toSpan = $endTable;
            
                for($i=$startTable; $i<=$endTable; $i++){
                          echo '<tr>';
                             echo '<td>';
                            echo'<div id="hour'.$i.'" class="hour">'.$i.'</div>
                                
                                   <table border="5" width="55%" height="100%" class="minutes">
                                 <tr>
                                     <td>00</td>
                                 </tr>
                                  <tr>
                                     <td>15</td>
                                 </tr>
                                  <tr>
                                     <td>30</td>
                                 </tr>
                                  <tr>
                                     <td>45</td>
                                </tr>
                             </table>
                         
                            </td> ';
                            //echo '<td rowspan="'.$toSpan.'"><td>';
                          
                            
                            //echo '<td><td>';
                           // echo '<td><td>';
                           // echo '<td><td>';
                           // echo '<td><td>';
                            
                          
                            
                           echo' </tr>';
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
                 <div id="dayOfWeek"></div>
            </div>    
            </form>
        </div>
       
    </body>
</html>
