<?php

require_once 'connection.php';
try{
    $connection=new mysqli($host, $dbUser, $dbPass, $dbName);
    
    $query = "SELECT * FROM sections";
            
    $result = $connection->query($query);
            
    $row=$result->fetch_assoc();
            
    $count = $result->num_rows;
    $result->free_result();
            
    for($i=1; $i<=$count; $i++){
        $secRes = $connection->query("SELECT * FROM sections WHERE "
            . "idsections='$i'");
                
        $rowSec = $secRes->fetch_assoc();
                
        $tabSec[$i] = $rowSec['name'];
                
        $secRes->free_result();
                
    }
            
            
}  catch (Exception $e) {
    echo $e;
}
$connection->close();

?>
