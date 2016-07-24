
<?php 



    if(isset($_POST['pass'])){
        
        $pass = $_POST['pass'];
        
        $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
        
    }
    
    echo $hash_pass;

?>



<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="post">
             <input type="text" name="pass" id="textfield" />
             <br/>
             <br/>
            <input type="submit" value="haszuj" id="button"/>
            </form>
    </body>
</html>
