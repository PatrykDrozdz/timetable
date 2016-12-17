<?php 

session_start();
//sprawdzanie, czy u«ytkownik jest zalogowany
if((isset($_SESSION['loged'])) && ($_SESSION['loged']==TRUE)){
    $flag = $_SESSION['flag'];
    if($flag==0){
        header('Location: Interface.php');
        exit();
    }else if($flag==1){
        header('Location: adminInterface.php');
       exit();
    }
}

require_once 'gettingDatas.php';

//echo $hd;
//echo $r;
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
                    
                    <tr>
                        
                        <td colspan="4" class="tabHead" id="logo"></td>
                         <td colspan="3" class="tabHead">1</td>
                         <td class="tabHead">
                             Dzień:
                             <br/>
                             Godzina:
                         </td>
                         <td class="tabHead"></td>
                        
                  
                    </tr>
                   
                    
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
                                    
                                    <style>
                                        .date {
                                            color: white;
                                            height: 3%;
                                        }
                                    </style>
                                    
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
                                    <div id="subject'.$tabId[$a].'">
                                    <label>'.$info[$a].'</label>
                                    </div>
                                    <div id="info'.$tabId[$a].'">
                                        '.$moreInfo[$a].' 
                                    </div>
                                <div id="dateView'.$tabId[$a].'">
                                    Spotkanie odbedzie sie dnia: '.$dateOfMeeting[$a].'
                                        <br/>
                                      W godzinach: '.$hourMeetingStarts[$a].' - '
                                .$hourMeetingEnds[$a].' 
                                    <br/>
                                     Organizator: '.$NameUsersMade[$a].'
                                    </div>
                                    
                                    ';
                echo '<div id="sections'.$tabId[$a].'">';
                             if($secSeen[$a][0]!=NULL){
                                echo'    <label>sekcje zaproszone:</label>';
                             }
                         for($sections=0; $sections<$secCount[$a]; $sections++){
                            echo $secSeen[$a][$sections]. '<br/>';
                            
                         }
                           echo'      </div>';
                         echo '<div id="persons'.$tabId[$a].'">';
                            
                                if($usersSeen[$a][0]!=NULL){
                                    echo'<label>osoby zaproszone:</label> <br/>';
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
                                  
                                  echo '<style> 
                                          
                                    #F'.$tabId[$a].'{
                                            background-Color: #AA0000;
                                            border-color: #AA0000;
                                            border-right-color: white;
                                           
                                            color: white; 
                                            font-size: 70%;
                                    }
                                            
                                    
                                    #sections'.$tabId[$a].'{
                                        float: left;
                                        width: 50%;
                                        font-size: 80%;
                                        background-color: #CCFFFF;
                                    }
                                    
                                    #persons'.$tabId[$a].'{
                                        float: left;
                                        width: 50%;
                                        font-size: 80%;
                                        
                                       background-color: #99FF99;
                                    }
                                    
                                    #foot'.$tabId[$a].'{
                                        clear: both;
                                    }
                              
                                    #dateView'.$tabId[$a].'{
                                        width: 100%;
                                       
                                        padding: 1%;
                                        background-color: #99FFFF;
                                        font-size: 60%;
                                    }
                                    
                                    #subject'.$tabId[$a].'{
                                       width: 100%;
                                       
                                       padding: 1%;
                                       background-color: #669999
                                    }
                                    
                                    #info'.$tabId[$a].'{
                                        width: 100%;
                                        
                                        padding: 4%;
                                        background-color: #00CCCC;
                                        font-size: 80%;
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
