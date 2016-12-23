<?php
    
    require_once 'connection.php';
    
    require_once 'gettingDatasLoged.php';
    
    $connection = new mysqli($host, $dbUser, $dbPass, $dbName);

    try{
        
        $resultView = $connection->query("SELECT * FROM actualview");
        
        $rowIdView = $resultView->fetch_assoc();
        
        $idView = $rowIdView['view_idview'];
        
        $resultView->free();
        
        
        $resultViews = $connection->query("SELECT * FROM view WHERE idview = '$idView'");
        
        $rowView = $resultViews->fetch_assoc();
        
        $startView = $rowView['startOfView'];//start petli
        $endView=4*$rowView['endOfView'];//koniec petli
                      
        $hStart = $rowView['startOfView'];//domyslna godzina poczætkowa

        
        $resultViews->free();
        
    }catch(Exception $e){
        echo $e;
    }
    
    $connection->close();  
    
?>
