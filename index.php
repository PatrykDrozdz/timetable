<?php 

session_start();
//sprawdzanie, czy u«ytkownik jest zalogowany
if((isset($_SESSION['logedUser'])) && ($_SESSION['logedUser']==TRUE)){
    header('Location: Interface.php');
    exit();
}
if((isset($_SESSION['logedAdmin'])) && ($_SESSION['logedAdmin']==TRUE)){
    header('Location: adminInterface.php');
    exit();
}

require_once 'gettingDatas.php';
require_once 'getView.php';

//echo $startView.'<br/>'.$endView.'<br/>'.$tableIndex ;

/*************************************/
$start=0;//start petli
                      
$end=$tableIndex;//koniec petli
$h=$startView;//domyslna godzina poczætkowa
/***********************************/
$check = 1;//flaga sprawdzjaca minuty - nie zmienia¢
$a=0;
$hd=0;
$f = 0;
$m=1;

?>


<!DOCTYPE html>

<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>
        <?php  //<meta http-equiv="Refresh" content="60"/> ?>

        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">     
        <script src="js/jquery.js"></script>
        <script src="js/jquery_1.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <title>Organizator</title>

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
                          
                                  <button type="button" 
                                          class="btn btn-link btn-lg active" 
                                data-toggle="modal" data-target="#log"
                                >Zaloguj sie</button>
                    </div>
            </div>
            

            <div class="table-responsive">
 

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
                                <div class="modal-body" id="fieldsText">

                                   <form action="loging.php" method="post" name="form_name">

                                            <div class="form-group"> 
                                                <label for="login">Login:</label>
                                                <input type="text" name="login" id="login" 
                                                   placeholder="login" class="form-control"/>
                                            </div>
                                            <br/>
                                            
                                            <div class="form-group"> 
                                                <label for="pass">Hasło:</label>
                                                <input type="password" name="pass" id="pass" 
                                                   placeholder="hasło" class="form-control"/>
                                            </div>
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

                
                <table id="trueTable" border="5"
                    class="table-active table-responsive">
                   
                    
                    <tr id="cols">
                        
                        
                        <td rowspan="2" colspan="2">
                            <div  id="textHour">
                                Godzina
                                <br/>
                                
                            </div>
                            
                        </td>
                       
                       <?php 
                            for($i=1; $i<=7; $i++){ ?>
                            
                            <td>
                                    <div class="date"><?php echo $tab[$i];?></div>

                                    
                            </td> 
               
                            
                      <?php      }
                       
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
                                    
                                    if(strlen($info[$a])>21){
                                            echo ' <td class="row infoOnTab"
                                                
                                            data-toggle="modal" data-target="#MA'.$tabId[$a].'">
                                            '.$tabInfo[0].'</td>';
                                       
                                        }else{
                                            echo ' <td class="row infoOnTab"
                                                
                                            data-toggle="modal" data-target="#MA'.$tabId[$a].'">
                                            '.$info[$a].'</td>';  
                                        }
                                    
        
                    //'.$info[$a].'
                   //maxlegth="" - maksymalna ilosc znakow w input
                    
                    //$usersIdMeeting[$a]                
                 /*******************************************************************/
                  //wyswietlanie spotkania                      
                echo '<div class="modal fade" id="MA'.$tabId[$a].'" role="dialog">
                                   <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" 
                                    data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Informacje o spotkaniu</h4>
                                     </div>
                                    <div class="modal-body">
                                    <div class="subject">
                                    <label>'.$info[$a].'</label>
                                    </div>
                                    <div class="info">
                                        '.$moreInfo[$a].' 
                                    </div>
                                <div class="dateView">
                                    Spotkanie odbedzie sie dnia: '.$dateOfMeeting[$a].'
                                        <br/>
                                      W godzinach: '.$hourMeetingStarts[$a].' - '
                                .$hourMeetingEnds[$a].' 
                                    <br/>
                                     Organizator: '.$NameUsersMade[$a].'
                                    </div>
                                    
                                    ';
                echo '<div class="sections">';
                             if($secSeen[$a][0]!=NULL){
                                echo'    <label>Sekcje zaproszone:</label> <br/>';
                             }
                         for($sections=0; $sections<$secCount[$a]; $sections++){
                            echo $secSeen[$a][$sections]. '<br/>';
                            
                         }
                           echo'      </div>';
                         echo '<div class="persons">';
                            
                                if($usersSeen[$a][0]!=NULL){
                                    echo'<label>Osoby zaproszone:</label> <br/>';
                                }
                           for($users=0; $users< $useCount[$a]; $users++){
                             echo  $usersSeen[$a][$users]. '<br/>';
                         }
                         
                             echo'   </div>   </div>
                                  <div class="modal-footer">
                                <button type="button" class="btn btn-default" 
                                data-dismiss="modal">Zamknij</button>
                                    </div>
                                    </div>
                                    </div>
                                </div>';  
                                  
                                  
                                  //border-right-color: white;

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
                                    //'.$tabId[$a] .'
                                            echo ' <td class="row neutral-tab" '
                                    . 'id="F'.$tabId[$a] .'" ></td>';

                                    
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
