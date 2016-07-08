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
            <div id="header">
                 <h1>Terminarz</h1>
                 <div id="loging">
                     <a href="loginpre.php" class="btn-link">Zaloguj się</a>
                 </div>
                
            </div>
            
            <div id="table" class="table-responsive">
                
                <table id="trueTable" border="5" width="100%">
                   
                    <tr id="cols">
                        
                        
                        <td rowspan="2">
                            <div  id="textHour">
                                Godzina
                            </div>
                            
                        </td>
                        <td>
                            <div id="data1"></div>
                        </td>    
                        <td>
                           <div id="data2"></div>
                        </td>
                      
                        <td>
                            <div  id="data3"></div>
                        </td>
                        <td>
                            <div id="data4"></div>
                        </td>
                        <td >
                            <div id="data5"></div>
                        </td>
                        <td>
                            <div id="data6"></div>
                        </td>
                        <td>
                            <div id="data7"></div>
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
                    <tr>
                        <td>
                          <div id="hour1" class="hour"></div>

                          
                           <table border="5" width="55%" height="100%">
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
                           
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                          
                        </td>
                        
                    </tr>
                        <td>
                          <div id="hour2" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                    <tr>
                      <td>
                          <div id="hour3" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                        
                    </tr>
                    
                    <td>
                          <div id="hour4" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                    <tr>
                      <td>
                          <div id="hour5" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                        
                    </tr>
                      <td>
                          <div id="hour6" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                    <tr>
                       <td>
                          <div id="hour7" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                        
                    </tr>
                        <td>
                          <div id="hour8" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                    <tr>
                        <td>
                          <div id="hour9" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                        
                    </tr>
                        <td>
                          <div id="hour10" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                    <tr>
                      <td>
                          <div id="hour11" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                        
                    </tr>
                        <td>
                          <div id="hour12" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                    
                    <tr>
                        <td>
                          <div id="hour13" class="hour"></div>
                          
                            <table border="5" width="55%" height="100%">
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
                         </td>
                         <td>
                          <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                         <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                            <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                             <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         <td>
                           <table border="5" width="100%" height="100%">
                                 <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                                  <tr>
                                     <td></td>
                                 </tr>
                             </table>
                         </td>
                         
                        
           
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
