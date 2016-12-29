<?php

require_once 'connection.php';

if(isset($_POST['sectionAdd'])){
    
    $newSection = $_POST['sectionAdd'];
    
    try{
        
        $valid = true;
        
        $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
        $getIdCount = $connection->query("SELECT * FROM sections");
        
        $countId = $getIdCount->num_rows;
        
        $checkSections = $connection->query("SELECT * FROM sections WHERE name = '$newSection'");
        
        $sectionCountCheck = $checkSections->num_rows;
        
        if($sectionCountCheck>0){
            $valid = false;
            $_SESSION['error_section'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>Sekcja o tej nazwie jest w bazie "
                             . "jest juz w bazie</span>";
        }
        
        $countId = $countId+1;
        
        $insertQuerySec = "INSERT INTO sections(idsections, name) VALUES ('$countId', '$newSection')";
        
        $alterQuerySec = "ALTER TABLE groups ADD `$newSection` "
                . "INT NOT NULL AFTER meetings_users_idusers";

        if($valid==true){
            
            if($connection->query($insertQuerySec)){
                if($connection->query($alterQuerySec)){
                    $_SESSION['addSection'] = "<span class='list-group-item "
                                        . "list-group-item-success'>Sekcja została dodana do bazy</span>";
                    header('Location: adding.php');
                } 
            }  
            
        }
        $connection->close();
        
    } catch(Exception $e){
        echo $e;
    }
    
}


?>