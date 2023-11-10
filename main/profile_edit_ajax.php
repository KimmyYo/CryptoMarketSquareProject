<?php
    require 'includes/db.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
       
        $public_key = $_POST["public_key"];
        $new_store_name = $_POST["store_name"];

        $user_name = $_COOKIE["CookieUname"];
        

        $SQL = "SELECT mId FROM Member WHERE user_name = '$user_name'";
        
        $mId = $db -> query($SQL);
        $mId = $mId -> fetch();
        
        $SQL = "UPDATE `Seller` SET `storeName`=" .'"'. $new_store_name.'"'. ", `publicKey`='$public_key' WHERE mId = '$mId[0]'";
        echo $SQL;
        $db -> exec($SQL);
    }

?>