<?php 

    require 'includes/db.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $new_heart_num = $_POST["likes"];
        $pNo = $_POST["pNo"];
        
        if (isset($_COOKIE['CookieUname'])) {
        $user_name = $_COOKIE["CookieUname"];
        $sql = "SELECT mId FROM Member WHERE user_name='$user_name'";
        $mId = $db -> query($sql);
        $mId = $mId -> fetch();
        $mId = $mId[0];
        
        // check whether the user clicked or not 
        $sql = "SELECT * FROM heartRecord WHERE pNo='$pNo' AND mId = '$mId'";
        $check_heart_clicked = $db->query($sql);
        $check_heart_clicked = $check_heart_clicked -> rowCount();

            if($check_heart_clicked == 0){
                $new_heart_num = $new_heart_num + 1;
            
                $sql = "INSERT INTO `heartRecord`(`mId`, `pNo`) VALUES ('$mId','$pNo')";
                $db -> exec($sql);

            }
            else{
                $new_heart_num = $new_heart_num - 1;
                $sql = "DELETE FROM `heartRecord` WHERE mId = '$mId' AND pNo = '$pNo'";
                if($db -> exec($sql)){
                    
                }
            
            }
        $sql = "UPDATE `Product` SET heartNum='$new_heart_num' WHERE pNo='$pNo'";
        $db->exec($sql);
        echo $new_heart_num;

        }
        else {
            echo $new_heart_num;
            echo "<script>";
                echo "var yes = confirm('Please login first!');";
                echo "if (yes)";
                    echo "location.href='logindex.php';";
            echo "</script>";
        }  
    }
    
  
    
    

?>