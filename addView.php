<?php

require_once 'connection.php';

if(isset($_POST['viewAdd'])){
    
    $newView = $_POST['viewAdd'];
    
    $idAdmin = $_SESSION['idusers'];
    
    $startViewAdd = $_POST['startViewAdd'];
    
    $endViewAdd = $_POST['endViewAdd'];
    
    if($startViewAdd>$endViewAdd){
        $add = $startViewAdd;
        $startViewAdd = $endViewAdd;
        $endViewAdd = $add;
    }
    
    try{
        
        $valid = true;
        
        $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
        $checkViews = $connection->query("SELECT * FROM view WHERE nameOfView = '$newView'");
        
        $viewsCountCheck = $checkViews->num_rows;
        
        if($startViewAdd==$endViewAdd){
            $valid = false;
            $_SESSION['error_addView'] = "<span class='list-group-item "
                . "list-group-item-danger'>Godzina początkowa i końcowa są sobie równe</span>";
        }

        if($viewsCountCheck>0){
            $valid = false;
            $_SESSION['error_addView'] = "<span class='list-group-item "
                . "list-group-item-danger'>Widok o tej nazwie jest w bazie</span>";
        }

        $insertQueryView = "INSERT INTO view(idview, idAdmin, nameOfView, startOfView, endOfView) "
                . "VALUES (NULL, '$idAdmin', '$newView', '$startViewAdd', '$endViewAdd')";
        

        if($valid==true){
            
            if($connection->query($insertQueryView)){
                $_SESSION['addView'] = "<span class='list-group-item "
                         . "list-group-item-success'>Widok został dodany do bazy</span>";
                header('Location: adding.php');
            }
            
        }
        $connection->close();
        
    } catch(Exception $e){
        echo $e;
    }
    
}


?>