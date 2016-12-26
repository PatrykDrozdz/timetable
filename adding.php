<?php

session_start();

if(!isset($_POST['login']) || !isset($_POST['pass'])){
    
    header('Location: index.php');
    exit();
  
}
$myFlag = $_SESSION['flag'];
echo $myFlag;
if($myFlag==0){
    header('Location: Interface.php');
} else if ($myFlag==1) {
    header('Location: adminInterface.php');
}
?>

