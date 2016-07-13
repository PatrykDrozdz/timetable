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
///////////////////////////////
//wybør widokøw do panelu administratora
require_once 'connection.php';


try{
    
   $date = date('Y-m-d');
   $day = date('w');

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
          
           
           
           for($i=1; $i<=7; $i++){
             
               $res = $connection->query("SELECT DATE_ADD('$mon', INTERVAL +'$i' DAY)");
               
               $row22 = $res->fetch_assoc();
           
               $tab[$i] = $row22["DATE_ADD('$mon', INTERVAL +'$i' DAY)"];

           }
           /////////////////////////////////////////////
           
           $query = "SELECT * FROM view";
           $result = $connection->query($query);
      
            
            $row = $result->fetch_assoc();
            $count = $result->num_rows;
          
            for($i=1; $i<=$count; $i++){
                $res1 = $connection->query("SELECT * FROM view WHERE idview = '$i'");
                $row12 = $res1->fetch_assoc();
            
                $vievs[$i] = $row12['nameOfView'];
         
            
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
if(isset($_POST['view'])){
     $view = $_POST['view'];
    
try{
 

    $connection2 = new mysqli($host, $dbUser, $dbPass, $dbName);
        
    if($connection2->connect_errno!=0){
       echo "Error: ".$connection2->connect_errno;
       
    } else { 
      if($connection2->query("SELECT * FROM view WHERE nameOfView = '$view'")){          
            $viewResult = $connection2->query("SELECT * FROM view WHERE nameOfView = '$view'");
                
            $rowViews = $viewResult->fecth_assoc();
                
            $_SESSION['startOfView'] = $rowViews['startOfView'];
            $_SESSION['endOfView'] = $rowViews['endOfView'];
            
            $a = $rowViews['startOfView'];
            $b = $rowViews['endOfView'];
            $h = $rowViews['endOfView'];
      }    
    }
     $connection2->close();  

}catch(Exceptione $e){
    echo $e;
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
    <script src="fonts//bootstrap.js"></script>     
    
        <title>Organizator</title>
        
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="paliwo spalanie pojazdy licznik kalkulator baza danych"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>
        
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        
       <?php 
         $start=0;//start petli
         $a = $_SESSION['startOfView'];
         $b = $_SESSION['endOfView'];
         $interval = $b - $a;
         $end=4*$interval;//koniec petli
              
        $SpanCol = ($end/2)+1; 
        $h = $_SESSION['startofView'];//domyslna godzina poczætkowa
        
        echo $a;
        echo '<br/>';
        echo $b;
        echo '<br/>';
        echo $h;
         echo '<br/>';
         echo $_SESSION['endOfView'];
        echo '<br/>';
        echo $_SESSION['startOfView'];
        
       ?>
     
        
    </head>
    <body>
        
        <div id="container">
          
            <div id="header">
                 <h1>Terminarz - panel administartora</h1>
             
                    
                       </div>
           
            <div id='menu'>
                
                  <?php
                        echo 'Witaj '.$_SESSION['name'].'  '
                                . ''.$_SESSION['surename'];
                        
                        
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
                
                <table id="trueTable" border="5" width="100%" 
                       height=40%"" class="table-active table-responsive">
                    <tr>
                          <td colspan="2"> <input class="btn btn-primary active" 
                           type="submit" value="<<" id="buttonDay"/>
                           <input class="btn btn-primary active" 
                           type="submit" value="<" id="buttonDay"/>
                          </td>
                             
                            <td colspan="5">Pole z opisem najbliszego spotkania</td>
                            <td colspan="2"> <input class="btn btn-primary active" 
                                        type="submit" value=">" id="buttonDay"/>
                            <input class="btn btn-primary active" 
                                         type="submit" value=">>" id="buttonDay"/>
                            </td>
                            
                            <?php 
                                       
                    echo '<td rowspan="'. ($SpanCol+1).'"><input class="btn btn-primary active" 
                           type="submit" value="<<" id="buttonHour"
                           onclick="changeHoursInc()" STYLE=height: '.$SpanCol.'</td>';
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
                    
                   
                     
                    function changeHoursInc(){
                        for($i=start; $i<$end; $i++){
                            $tabH[$i] = $tabH[$i] + $interval;
                            echo $tabH[$i];
                        }
                        
                    }




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
                        
                           $tabH[$i] = $h-1;
                           
                           if($tabH[$i]>23){
                               $tabH[$i]=0;
                           }
                           
                 echo''
                     . ' <td id="'.$tabH[$i] .$min.'1" onclick=" click'.$tabH[$i] .$min.'1()"> '.($h-1).' '.$min.' 1</td>
                           
                      <td id="'.$tabH[$i] .$min.'2" onclick=" click'.$tabH[$i] .$min.'2()"> '.($h-1).' '.$min.' 2</td>
                       <td id="'.$tabH[$i] .$min.'3" onclick=" click'.$tabH[$i] .$min.'3()"> '.($h-1).' '.$min.' 3</td>

                       <td id="'.$tabH[$i] .$min.'4" onclick=" click'.$tabH[$i] .$min.'4()"> '.($h-1).' '.$min.' 4</td>

                        <td id="'.$tabH[$i] .$min.'5" onclick=" click'.$tabH[$i] .$min.'5()"> '.($h-1).' '.$min.' 5</td>
                   
                     
                         <td id="'.$tabH[$i] .$min.'6" onclick=" click'.$tabH[$i] .$min.'6()"> '.($h-1).' '.$min.' 6</td>
                        <td id="'.$tabH[$i] .$min.'7" onclick=" click'.$tabH[$i] .$min.'7()"> '.($h-1).' '.$min.' 7</td>';
                                  
                        if($i==$SpanCol-2){
                            echo '<td rowspan="'. $SpanCol.'"><input class="btn btn-primary active" 
                           type="submit" value="<<" id="buttonHour"
                           onclick="changeHoursInc()" STYLE=height: '.$SpanCol.'</td>';
                                    }
                 
               echo       ' </tr>';
            //poni«sze skrypty przydadzæ sie przy dodawaniu wydarzen     
            echo ' <script>
            function click'.$tabH[$i] .$min.'1(){
                document.getElementById("'.$tabH[$i] .$min.'1").innerHTML="click";
            }
            </script>';
            echo ' <script>
            function click'.$tabH[$i] .$min.'2(){
                document.getElementById("'.$tabH[$i] .$min.'2").innerHTML="click";
            }
            </script>';
            echo ' <script>
            function click'.$tabH[$i] .$min.'3(){
                document.getElementById("'.$tabH[$i] .$min.'3").innerHTML="click";
            }
            </script>';
            echo ' <script>
            function click'.$tabH[$i] .$min.'4(){
                document.getElementById("'.$tabH[$i] .$min.'4").innerHTML="click";
            }
            </script>';
             echo ' <script>
            function click'.($h-1).$min.'5(){
                document.getElementById("'.$tabH[$i].$min.'5").innerHTML="click";
            }
            </script>';
            echo ' <script>
            function click'.$tabH[$i] .$min.'6(){
                document.getElementById("'.$tabH[$i] .$min.'6").innerHTML="click";
            }
            </script>';
             echo ' <script>
            function click'.$tabH[$i] .$min.'7(){
                document.getElementById("'.$tabH[$i] .$min.'7").innerHTML="click";
            }
            </script>';
                 
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