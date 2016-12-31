<?php
    //zabezpieczenie przed wejßciem z palca
    session_start();

    if(!isset($_SESSION['logedUser'])){
        header('Location: index.php');
        exit();
    }
    

    require_once 'gettingDatasLoged.php';
    require_once 'getView.php';
    require_once 'editAccount.php';
    require_once 'getSections.php';
 
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
    $a2=$a;
    
    $allHours = $endView;
    $r1=1;
    $SpanCol = $tableIndex/2;
    //echo $SpanCol;
    
    //daty
    /*for($i=1; $i<=7; $i++){ 
        
        echo $tab[$i].'<br/>';

       }
            
       echo $mon;*/
                       

    //echo $sectionCount.'<br/>'.$countOfUsers;
    
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
                
                if(isset($_SESSION['error_login_change'])){
                    echo $_SESSION['error_login_change'];
                }
                
                if(isset($_SESSION['error_pass_change'])){
                    echo $_SESSION['error_pass_change'];
                }
                
                if(isset($_SESSION['error_name_change'])){
                    echo $_SESSION['error_name_change'];
                }
                
                if(isset($_SESSION['error_surename_change'])){
                    echo $_SESSION['error_surename_change'];
                }
                
                if(isset($_SESSION['error_email_change'])){
                    echo $_SESSION['error_email_change'];
                }
                
                ?>
             
        
            <div id="header">
                 <h1>Terminarz - panel uzytkownika</h1>
                      <div id="loging">
                        <?php
                            echo 'Witaj '.$_SESSION['name'].'  '
                                    .$_SESSION['surname'];
                         ?>
                        <br/>
                        <button class="btn btn-link" >
                        <a data-toggle="modal" href="#yourDatas">Twoje dane</a></button>
                        <button class="btn btn-link" >
                        <a data-toggle="modal" href="#editAccount">Edytuj swoje konto</a></button>
                        <button class="btn btn-link" >
                        <a href="index.php">Odśwież</a></button>
                        <button class="btn btn-link" >
                        <a href='logout.php'>Wyloguj sie</a></button>
                    </div>
            </div>
    
            <div class="table-responsive">
                
            <!----dane twojego konta------------------------------>
            
            <div class="modal fade" id="yourDatas" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Twoje dane</h4>
                    </div>
                    <div class="modal-body">
                            <div class="form-group"> 
                                <label for="login">Twój login</label>
                                <div id="login"><?php echo $_SESSION['user']; ?></div>
                            </div>
                            <div class="form-group"> 
                                  <label for="nameSurename">Twoje imie i nazwisko</label>
                                <div id="nameSurename"><?php echo $_SESSION['name'].'  '
                                    .$_SESSION['surname']; ?></div>
                            </div>
                            <div class="form-group"> 
                                <label for="email">Twój e-mail</label>
                                <div id="email"><?php echo $_SESSION['email']; ?></div>
                            </div>
                            <div class="form-group"> 
                                <label for="section">Twój dział</label>
                                <div id="section"><?php echo $tabSec[$_SESSION['sectionId']]; ?></div>
                            </div>
                            <div class="form-group"> 
                                <label for="status">Twój status</label>
                                <div id="status"><?php 
                                    if($_SESSION['flag']==1){
                                        echo 'admin';
                                    } else if ($_SESSION['flag']==0) {
                                        echo 'uzytkownik';
                                    }
                                    ?></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>    
                
                
                <!----edytowanie konta------------------------------>
            
            <div class="modal fade" id="editAccount" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edytuj dane swojego konta</h4>
                    </div>
                    <div class="modal-body">
                            <div class="form-group"> 
                                 <button type="button" class="btn btn-primary btn-lg" 
                                         data-toggle="modal" data-target="#editLogin">
                                     Edytuj login</button>
                        
                            </div>
                            <div class="form-group"> 
                                   <button type="button" class="btn btn-primary btn-lg" 
                                         data-toggle="modal" data-target="#editPass">
                                       Edytuj hasło</button>
                            </div>
                            <div class="form-group"> 
                                <button type="button" class="btn btn-primary btn-lg" 
                                         data-toggle="modal" data-target="#editName">
                                       Edytuj imię</button>
                            </div>
                            <div class="form-group"> 
                                <button type="button" class="btn btn-primary btn-lg" 
                                         data-toggle="modal" data-target="#editSurename">
                                       Edytuj nazwisko</button>

                            </div>
                            <div class="form-group"> 
                                <button type="button" class="btn btn-primary btn-lg" 
                                         data-toggle="modal" data-target="#editEmail">
                                       Edytuj e-mail</button>
                            </div>
                            <div class="form-group"> 
                                <button type="button" class="btn btn-primary btn-lg" 
                                         data-toggle="modal" data-target="#editSection">
                                       Edytuj swoją sekcję w pracy</button>
                            </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
            
            
            <!-- edytuj login -->
            <div class="modal fade" id="editLogin" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edytuj login</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="editLogin">Nowy login</label>
                                <input type="text" class="form-control" id="editLogin" 
                                       name="editLogin" placeholder="login"/>
                            <br/>
                            <input type="submit" value="Edytuj" class="btn btn-primary btn-lg" />   
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
            
            
             <!-- edytuj hasło -->
            <div class="modal fade" id="editPass" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edytuj hasło</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="editPass">Nowe hasło</label>
                                <input type="password" class="form-control" id="editPass" 
                                       name="editPass" placeholder="hasło"/>
                            <br/>
                            <input type="submit" value="Edytuj" class="btn btn-primary btn-lg" />   
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>
            
             <!-- edytuj imię -->
            <div class="modal fade" id="editName" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Zmień swoje imię</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="editName">Nowe imię</label>
                                <input type="text" class="form-control" id="editName" 
                                       name="editName" placeholder="imie"/>
                            <br/>
                            <input type="submit" value="Edytuj" class="btn btn-primary btn-lg" />   
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div> 
             
             
             <!-- edytuj nazwisko-->
            <div class="modal fade" id="editSurename" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Zmień swoje nazwisko</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="editSurename">Nowe nazwisko</label>
                                <input type="text" class="form-control" id="editSurename" 
                                       name="editSurename" placeholder="nazwisko"/>
                            <br/>
                            <input type="submit" value="Edytuj" class="btn btn-primary btn-lg" />   
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div> 
             
             
             <!-- edytuj email-->
             <div class="modal fade" id="editEmail" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Zmień swój e-mail</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="editEmail">Nowy e-mail</label>
                                <input type="text" class="form-control" id="editEmail" 
                                       name="editEmail" placeholder="e-mail"/>
                            <br/>
                            <input type="submit" value="Edytuj" class="btn btn-primary btn-lg" />   
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div> 
             
             
            <!-- edytuj sekcje-->
             <div class="modal fade" id="editSection" role="dialog">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Zmień swoją sekcję</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="editSection">Nowa sekcja</label>
                                <select class="form-control" id="editSection" name="editSection">
                                <?php 
                                for($i=1; $i<=$count; $i++){
                                    echo '<option>'.$tabSec[$i].'</option>';
                                }
                                ?>
                                </select>
                            <br/>
                            <input type="submit" value="Edytuj" class="btn btn-primary btn-lg" />   
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    </div>
                  </div>
                </div>
            </div>  

                
                
   
            <table id="trueTable" border="5" width="100%"
                    class="table-active">
                
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

                                for($j=1; $j<=7; $j++){

                                    // rowspan="'.(4*$timeLast[$a]).'"
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
                                 Organizator: <label id="meetMaker'.$tabId[$a].'">'.
                                $NameUsersMade[$a].'<label>
                                    </div>';
                        $nameOrganizator = $_SESSION['fullName'];
                        
                        if($NameUsersMade[$a]==$nameOrganizator){
                            echo'<style>
                                #meetMaker'.$tabId[$a].'{
                                    color: red;
                                }
                            </style>';
                        } else {
                           echo'<style>
                                #meetMaker'.$tabId[$a].'{
                                    color: black;
                                }
                            </style>';  
                        }
                        
                echo '<div class="sections">';
                             if($secSeen[$a][0]!=NULL){
                                echo'    <label>Sekcje zaproszone:</label> <br/>';
                             }
                         for($sections=0; $sections<$secCount[$a]; $sections++){
                            echo $secSeen[$a][$sections]. '<br/>';
                            
                       
                          if($mySection==$secSeen[$a][$sections]){
                                
                                 echo ' 
                                     <style> 
                                        #sec'.$sections.'{
                                            color: red;
                                        }
                                        
                                     </style>
                                 ';
                                
                            } else if($mySection!=$secSeen[$a][$sections]){
                                 
                                 echo ' 
                                     <style> 
                                        #sec'.$sections.'{
                                            color: black;
                                        }
                                        
                                     </style>
                                 ';
                            }
                            
                         }
                           echo'      </div>';
                         echo '<div class="persons">';
                            
                                if($usersSeen[$a][0]!=NULL){
                                    echo'<label>Osoby zaproszone:</label> <br/>';
                                }
                           for($users=0; $users< $useCount[$a]; $users++){
                             echo  $usersSeen[$a][$users]. '<br/>';
                                  if($myFullName==$usersSeen[$a][$users]){
                                 echo ' 
                                     <style> 
                                        #users'.$users.'{
                                            color: red;
                                        }
                                        
                                     </style>
                                 ';
                             } else if($myFullName!=$usersSeen[$a][$users]){
                                 echo ' 
                                     <style> 
                                        #users'.$users.'{
                                            color: black;
                                        }
                                        
                                     </style>
                                 ';
                             }
                         }
                         
                             echo'     </div>';
                    
                      
                       
                                        if($idUsers==$usersIdMeeting[$a]){
                                                $key = 'active';
                                                 echo' </div>
                                                <div class="modal-footer" 
                                                id="foot'.$tabId[$a].'"> 
                                                <input type="submit" value="Edytuj"
                                                class="btn btn-link '.$key.'"
                                                data-toggle="modal" 
                                                data-target="#Edit'.$tabId[$a].'"/>
                                   
                                                <input type="submit" value="usun wydarzenie"
                                                class="btn btn-danger '.$key.'" 
                                                    data-toggle="modal" 
                                                data-target="#Del'.$tabId[$a].'"/>
                                           
                                                <button type="button" class="btn btn-default" 
                                                data-dismiss="modal">Zamknij</button>
                                                </div>
                                                </div>
                                                </div>
                                                </div>';  
                                                 
                          
                                               
                                        }else{
                                                 $key = 'disabled';
                                                  echo'</div>
                                                  <div class="modal-footer" 
                                                  id="foot'.$tabId[$a].'">
                                                  <input type="submit" value="Edytuj"
                                                              class="btn btn-link '.$key.'" />

                                                   <input type="submit" value="usun wydarzenie"
                                                    class="btn btn-danger '.$key.'" />

                                              <button type="button" class="btn btn-default" 
                                              data-dismiss="modal">Zamknij</button>
                                                  </div>
                                                  </div>
                                                  </div>
                                                  </div>';   
                                            }

 ///////////////////////////////////////////////////////////////////

//okno służące do usuwania spotkania
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
                                    <div class="dateView">
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
                                         </div>
                                         <div class="info"> 
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
                             
                             
                             
////////////////////////////////////////////////////////////////////////////////////////
//okno służącce do edycji spotkania                  
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
                                        <div class="dateView"> 
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

                                            <div class="info">
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
                                        
                                 echo'           <input class="btn btn-primary active" 
                                                type="submit" value="Edytuj" id="button" onclick="reLoad()"/>
                                            </form>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-default" 
                                                data-dismiss="modal">Anuluj</button>
                                            </div>
                                            </div>
                                            </div>
                                            </div>';  
                                     echo '<script>
                                        $( function() {
                                            $( "#datepicker'.$a.'" ).
                                                datepicker({dateFormat: "yy-mm-dd"});
                                        } );
                                    </script>';


                                    echo'<style>
                                        #F'.$tabId[$a].'{
                                            background-Color: #AA0000;
                                            
                                            border-color:  #AA0000 white;
                                            color: white; 
                                            font-size: 70%;
                                            }
                                        </style>';


                                } else { 
                                    
                                    
                                    
                                    
                                        if($tabId[$a]!=$reserved[$r1]){
                                    //'.$tabId[$a].'
                                    echo ' <td class="row" id="F'.$tabId[$a].'"
                                            data-toggle="modal" data-target="#M'.$tabId[$a].'">
                                     </td>';
                                     echo '<style> 
                                             #F'.$tabId[$a].'{
                                                color: white;
                                                border-right-color: white;
                                            }
                                        </style>';
                                     $m++;
/////////////////////////////////////////////////////////////////////////////////////////////
                                //okienko dodajæce spotkanie                              
                         echo '<div class="modal fade" id="M'.$tabId[$a].'" role="dialog">
                                   <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" 
                                    data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Dodaj spotkanie</h4>
                                     </div>
                                    <div class="modal-body">
                                    <form method="post" >
                                     <div>
                                        <div class="dateView">
                                        <label for="datepicker'.$a.'">Data spotkania</label>
                                        <input type="text" id="datepicker'.$a.'" name="date"
                                            value="'.$tab[$j].'" class="form-control date-picker"
                                              readonly="readonly"/>
                                              </div>
                                        <div class="dateView">
                                        <label for="hour">Godzina rozpoczecia</label>
                                         <div  id="hour">godzina:
                                        <input type="number"name="begHours" min="0" max="23"
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
                                            </div>
                                            </div>
                                       
                                        <div class="dateView">
                                        <label for="time-last">Czas spotkania</label>
                                         
                                        <div id="time-last">godziny:
                                        <input type="number" name="hours" min="0" max="7"/>
                                         minuty:
                                        <input type="number" name="minutes" min="0" max="45" step="15"/>
                                        </div>
                                            </div>
                                        <div class="subject">    
                                        <input type="text" name="info" id="textfield" 
                                            placeholder="temat" class="form-control"/>
                                        </div>
                                      <div class="info">  
                                         <textarea type="text" name="moreInfo" id="textfield" 
                                                " class="form-control" placeholder="wiecej informacji" 
                                                cols="30" rows="10"></textarea>
                                        </div>
                                            </div>';
                                /**********************************************/
                                //sekcje
                                echo '<div class="sections">
                                <p>Sekcje zaproszone:</p> ';
                                
                                for($k=1; $k<=$sectionCount; $k++){
                                    echo ' <label>
                                    <input type="checkbox" 
                                    name="sec'.$k.'"/> '. 
                                            $tabSections[$k].
                                        '</label>';
                                    echo '<br/>';
                                }
                                echo '</div>';
                                 /**********************************************/   
                                 /**********************************************/
                                //osoby
                                echo '<div class="persons">
                                 <p>Osoby zaproszone:</p>       ';
                                
                                for($k=1; $k<$countOfUsers; $k++){
                                    echo ' <label>
                                    <input type="checkbox" 
                                    name="per'.$k.'"/> '. 
                                            $tabUsers[$k].
                                        '</label>';
                                    echo '<br/>';
                                }
                                echo '</div>';
                                 /**********************************************/ 
                                echo'<br/>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <div class="make">
                                    <input class="btn btn-primary active" 
                                        type="submit" value="Dodaj" id="button" onclick="reLoad()"/>
                                     </div>   
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
//////////////////////////////////////////////////////////////////////////////////////////// ///////////
                                    } else {

                                          echo ' <td class="row" id="F'.$tabId[$a].'"
                                            data-toggle="modal">
                                     </td>';
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