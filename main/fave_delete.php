<?php
    require 'includes/db.php';
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $pNo = $_GET["pNo"];
        $mId = $_GET["mId"];

        $SQL = "DELETE FROM heartRecord WHERE pNo='$pNo' AND mId='$mId'";
      
        $db -> exec($SQL);
        
    }
?>