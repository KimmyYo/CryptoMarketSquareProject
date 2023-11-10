<?php
        require 'includes/db.php';

        if($_SERVER["REQUEST_METHOD"] == "GET"){

            $weekday = $_GET["day"];


            $username = $_COOKIE["CookieUname"];
            $sql = "SELECT mId FROM Member WHERE `user_name`='$username'";
            $user = $db -> query($sql);
            $user = $user->fetch();
            $SQL = "SELECT * FROM dailycheckin NATURAL JOIN member M WHERE M.user_name = '$username'";
            $is_check_in = $db -> query($SQL);
            $is_table = $is_check_in -> rowCount();
            // date_default_timezone_set('Asia/Taipei');
            // $weekday = date("l");
            // $weekday = strtolower($weekday);
            if($is_table == 0)
            {
               
                $SQL = "INSERT INTO `dailycheckin`(`mId`, `sunday`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`) VALUES ('$user[0]','0','0','0','0','0','0','0')";
                $db -> exec($SQL);
            }
            $SQL = "UPDATE dailycheckin SET $weekday=1";
            $db -> exec($SQL);
        }
      
        
    ?>