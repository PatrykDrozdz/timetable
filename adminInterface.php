<?php
    //zabezpieczenie przed wejßciem z palca
    session_start();

     if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }

    require_once 'gettingDatasLoged.php';
    require_once 'getView.php';
    require_once 'setView.php';
    //echo $startView.'<br/>'.$endView.'<br/>'.$tableIndex ;
    //echo $newView;
    //echo $idViewUpdate;

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
    
    $a2=$a;
    
    $allHours = $endView;

    
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

        <script src="js/jquery_1.js"></script>

        <script src="js/jquery-ui.js"></script>
        <link href="css/jquery-ui.min.css" rel="stylesheet">
        
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <title>Organizator</title>

        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        
        <link href="css/jquery.datepick.css" rel="stylesheet">
        <script src="js/jquery.plugin.js"></script>
        <script src="js/jquery.datepick.js"></script>
        <script src="js/jquery.datepick-pl.js"></script>
        
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
                if(isset($_SESSION['editView'])){
                    echo $_SESSION['editView'];
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
                    <select id="view" name="updateView">
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

          
            <div class="table-responsive">
   
             <table id="trueTable" border="5" width="100%" height="20%" 
                    class="table-active">
                 
                  <tr>
                        
                        <td colspan="2" class="tabHead" id="logo">
                         <form method="post">
                                    <input class="btn btn-primary active" 
                                 type="submit" value="Odśwież" id="buttonDay" name="refresh"/>
                        </form>
                         
                     </td>
                         <td colspan="5" class="tabHead">1</td>
                         <td class="tabHead">
                             Dzień:
                             <br/>
                             Godzina:
                         </td>
                         <td class="tabHead"></td>
                        
                  
                    </tr>
                 
                    <tr>
                      <?php//////////////////////////////////////////////////
                      //klawisze inkrementacji i dekrementacji
                        ///////////////////////////////////////////////// ?>
                          <td colspan="3"> 
                            <form method="post">
                                <div class="changes">
                                    <input type="number" class="form-control" name="decMonthValue" 
                                           value="1" min="1" title="O ile miesięcy przesunąć">
                                    <br/>
                                    <input class="btn btn-primary active" 
                                    type="submit" value="<<" id="buttonDay" name="decMonth"
                                    title="Przesuń miesiąc do tyłu"/>
                                </div>
                            </form>
                            
                         
                          </td>
                          <td colspan="2">
                           <form method="post">
                               <div class="changes">
                                    <input type="number" class="form-control" name="decWeekValue" 
                                           value="1" min="1" title="O ile tygodni przesunąć">
                                    <br/>
                                    <input class="btn btn-primary active" 
                                    type="submit" value="<" id="buttonDay" name="decWeek"
                                    title="Przesuń tydzień do tyłu"/>
                               </div>
                            </form>
                          </td>
                          <td colspan="2">
                                <form method="post"> 
                                    <div class="changes">
                                        <input type="number" class="form-control" name="incWeekValue" 
                                           value="1" min="1" title="O ile tygodni przesunąć">
                                        <br/>
                                        <input class="btn btn-primary active" 
                                            type="submit" value=">" id="buttonDay" 
                                            name="incWeek" title="Przesuń tydzień do przodu"/>
                                    </div>
                                </form>
                          </td>
                            
                            <td colspan="2"> 
                                <form method="post"> 
                                    <div class="changes">
                                        <input type="number" class="form-control" name="incMonthValue" 
                                           value="1" min="1" title="O ile miesięcy przesunąć">
                                        <br/>
                                        <input class="btn btn-primary active" 
                                             type="submit" value=">>" id="buttonDay" 
                                             name="incMonth" title="Przesuń miesiąc do przodu"/>
                                    </div>
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
                                    <div id="subject'.$tabId[$a].'">
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
                         
                             echo'    </div>
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
                                          
                                    #F'.$tabId[$a].'{
                                            background-Color: #AA0000;
                                            border-color: #AA0000;
                                            border-right-color: white;
                                           
                                            color: white; 
                                            font-size: 100%;
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
                                    <h4 class="modal-title">Czy na pewno chcesz usunąć to spotkanie?</h4>
                                     </div>
                                    <div class="modal-body">
                                    <form method="post">
                                    <div id="dateView'.$tabId[$a].'">
                                      <label for="dateDel">Data spotkania</label> 
                                      <input type="text"  name="dateDel" id="dateDel"
                                          value="'.$dateOfMeeting[$a].'"  
                                              readonly="readonly"/>
                                    </div>
                                    <div class="dateView">
                                    <label for="hourDel">Godzina rozpoczecia</label>
                                        <div id="hourDel"> godzina:
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
                                            </div>
                                            </div>
                                        <div class="subject">    
                                        <input type="text" name="infoDel" id="textfield" 
                                            value="'.$info[$a].'" class="form-control" 
                                                readonly="readonly"/>
                                            <br/>
                                            <br/>
                                            <textarea type="text" name="moreInfoDel" id="textfield" 
                                                " class="form-control" cols="30" rows="10"
                                                readonly="readonly">
                                                '.$moreInfo[$a].'</textarea>
                                     </div>';
                                                 
                                 echo '<div class="sections">
                             
                             <label>Sekcje zaproszone:</label>';
                         for($sections=0; $sections<$secCount[$a]; $sections++){
                            echo '<label>'. $secSeen[$a][$sections]. '</label> '
                                    . '<br/>';
                            
                         }
                           echo'      </div>';
                         echo '<div class="persons">
                                
                                <label>Osoby zaproszone:</label>';
                                
                           for($users=0; $users< $useCount[$a]; $users++){
                             echo '<label>'. $usersSeen[$a][$users]. '</label> '
                                    . '<br/>';
                         }
                         
                             echo'      </div>
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
/////////////////////////////////////////////////////////////////////////////////////////
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
                                       <div class="dateView">
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
                                              </div>
                                        <div id="dateView'.$tabId[$a].'"> 
                                            <label for="datepicker'.$a.'">Data spotkania</label>
                                            <input type="text" id="datepicker'.$a.'" name="dateEdit"
                                                value="'.$dateOfMeeting[$a].'" class="form-control date-picker"
                                                    readonly="readonly"/>
                                        </div>
                                        <div class="dateView"> 
                                        <label for="hour">Godzina rozpoczecia</label>
                                         <div id="hour">godzina:
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
                                        value="'.$minut.'"/></div>
                                        </div>    
                                        <div class="dateView">
                                        <label for="time-last">Czas spotkania</label>
                                         <div id="time-last">
                                        godziny:
                                        <input type="number" name="hoursEdit" min="0" max="7"
                                        value="'.$timesExploded[$a][0].'"/>
                                         minuty:
                                        <input type="number" name="minutesEdit" min="0" 
                                        max="45" step="15" value="'.$timesExploded[$a][1].'"/></div>
                                        </div> 
                                        <div class="subject">
                                        <input type="text" name="infoEdit" id="textfield" 
                                            value="'.$info[$a].'" class="form-control"/>
                                                </div>

                                            <div id="info'.$tabId[$a].'">
                                            <textarea type="text" name="moreInfoEdit" 
                                            id="textfield" 
                                                " class="form-control" cols="30" rows="10">
                                                '.$moreInfo[$a].'</textarea>
                                      </div>';
                                           /**********************************************/
                                //sekcje
                                echo '<div class="sections">
                                <label>Sekcje zaproszone:</label> ';
                                
                                $sections=0;
                                for($k=1; $k<=$sectionCount; $k++){
                                   
                                    if($secSeen[$a][$sections]==$tabSections[$k]){
                                        echo ' <label>
                                        <input type="checkbox" 
                                        name="secEdit'.$k.'" checked="checked"/> '. 
                                            $tabSections[$k].
                                        '</label>';
                                        echo '<br/>';
                                        $sections++;
                                    } else {
                                        echo ' <label>
                                        <input type="checkbox" 
                                        name="secEdit'.$k.'"/> '. 
                                            $tabSections[$k].
                                        '</label>';
                                        echo '<br/>';
                                    }
                                    
                                    if($sections==$secCount[$a]){
                                        $sections=0;
                                    }
                                }
                                echo '</div>';
                                 /**********************************************/   
                                 /**********************************************/
                                //osoby
                                echo '<div class="persons">
                                 <label>Osoby zaproszone:</label>       ';
                                $users=0;
                                for($k=1; $k<$countOfUsers; $k++){
                                    
                                     if($usersSeen[$a][$users]==$tabUsers[$k]){
                                        echo ' <label>
                                        <input type="checkbox" 
                                        name="perEdit'.$k.'" checked="checked"/> '. 
                                            $tabUsers[$k].
                                        '</label>';
                                        echo '<br/>';
                                        $users++;
                                    } else {
                                        echo ' <label>
                                        <input type="checkbox" 
                                        name="perEdit'.$k.'"/> '. 
                                            $tabUsers[$k].
                                        '</label>';
                                        echo '<br/>';
                                    }
                                  
                                    
                                    
                                    if($useCount[$a]==$users){
                                        $users=0;
                                    }
                                }
                                echo '</div>';
                                 /**********************************************/ 
                                        
                               echo'  <input class="btn btn-primary active" 
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
                                            $( "#datepicker'.$a.'" ).
                                                datepicker({dateFormat: "yy-mm-dd"});
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
                                    $r1=0;
                                  /* if($tabId[$a]!=$reserved[$r1]){
                                    
                                    echo ' <td class="row" id="F'.$tabId[$a].'"
                                            data-toggle="modal" data-target="#M'.$tabId[$a].'">
                                     </td>';
                                     echo '<style> 
                                             #F'.$tabId[$a].'{
                                                color: white;
                                            }
                                        </style>';
                                     $r1++;
////////////////////////////////////////////////////////////////////////////////////////////                                     
                                     
                                   } else if($tabId[$a]==$reserved[$r1]) {*/
                                       echo ' <td class="row" id="F'.$tabId[$a].'">
                                              '.$tabId[$a].' </td>';
                                     echo '<style> 
                                             #F'.$tabId[$a].'{
                                                color: white;
                                            }
                                        </style>';
                                   //} 
                                }
                              
                                 $a++;
                                 
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