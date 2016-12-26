<?php

require_once 'connection.php';

if(isset($_POST['updateView'])){
    $newView = $_POST['updateView'];

    try{
        
        $connection = new mysqli($host, $dbUser, $dbPass, $dbName);
        
        $result = $connection->query("SELECT * FROM view WHERE nameOfView = '$newView'");
      
        $row = $result->fetch_assoc();
        
        $idViewUpdate = $row['idview'];
        
        $result->free();
        
        if($connection->query("UPDATE actualview SET view_idview = '$idViewUpdate' "
                . "WHERE idactualView = 1")){
            
            $_SESSION['editView'] = '<span class="list-group-item list-group-item-success">
                       Widok zostal edytowany</span>';
            header('Location: adding.php');
            
        } else {
            $_SESSION['editView'] = '<span class="list-group-item list-group-item-danger">
                       Blad</span>';
        }
        

    } catch(Exception $e){
        echo $e;
    }

}
?>

