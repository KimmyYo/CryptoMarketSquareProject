<?php
    require 'includes/db.php';
    
    function get_userId(){
        $user_name = $_COOKIE["CookieUname"];
        if(empty($user_name)){
            echo "no user";
        }
        $sql = "SELECT mId FROM `Member` WHERE `user_name`='$user_name'";
        $users = $db -> query($sql);
        foreach($users as $user_id){
            return $user_id;
        }
    }

    function count_time($orderTime){
        $currentTime = time() + 6 * 60 * 60;
        $deltaTime = $currentTime - strtotime($orderTime);
        // minutes
        $days = floor($deltaTime / (3600 * 24));
        $seconds = floor($deltaTime);
        $minutes = floor($deltaTime % 3600 /  60);
        $hours = floor($deltaTime / 3600);
        
       
        // echo $orderTime;
        if($days > 0){

            return $days . "  days ago";

        } else if ($hours > 0){

            return $hours . "  hours ago";

        }  else if($minutes > 0){

            return $minutes . "  minutes ago";

        }  else if($seconds > 0){

            return $seconds . "  seconds ago";
        }
       
    }

    function sales_data(){
        $user_name = $_COOKIE["CookieUname"];
        // select sales data within current week
       
        // separate data to day
        // $weekly_data = array();
        // for($i = 6; $i >= 0; $i--){
        //     array_push($weekly_data, $week_sales[$i]);
        // }
        // // return y values in array
        // echo $weekly_data;
        // return 0;
       
    }
   
?>