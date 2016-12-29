<?php

require_once 'connection.php';

if(isset($_POST['sectionAdd'])){
    
    $newSection = $_POST['sectionAdd'];
    
    try{
        
        $valid = true;
        
        $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
        $checkSections = $connection->query("SELECT * FROM sections WHERE name = '$newSection'");
        
        $sectionCountCheck = $checkSections->num_rows;
        
        if($sectionCountCheck>0){
            $valid = false;
            $_SESSION['error_section'] = "<span class='list-group-item "
                                        . "list-group-item-danger'>Sekcja o tej nazwie jest w bazie "
                             . "jest juz w bazie</span>";
        }
        
        $insertQuery = "INSERT INTO sections(idsections, name) VALUES (NULL, '$newSection')";
        
        $alterQuery = "ALTER TABLE groups ADD `$newSection` "
                . "INT NOT NULL AFTER meetings_users_idusers";

        if($valid==true){
            
            if($connection->query($insertQuery)){
                //if($connection->query($alterQuery)){
                    $_SESSION['addSection'] = "<span class='list-group-item "
                                        . "list-group-item-success'>Sekcja została dodana do bazy</span>";
                //}
            } 
            
        }
        
    } catch(Exception $e){
        echo $e;
    }
    
}


?>