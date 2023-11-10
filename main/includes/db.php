<?php
    // require config database parameters
    require 'config.php';
    $db = new PDO("mysql:dbname=$dbname", $username, $password);
    
    // detect wrong connection
    if(!$db){
        die("Error: Failed to connect to database!");
    }

?>