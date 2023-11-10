<?php 
    require 'includes/db.php';

    if($_SERVER["REQUEST_METHOD"] == "GET"){
       
        $pNo = $_GET["pNo"];
        $amount = $_GET["amount"];
        // get user id 
        $user_name = $_GET["user_name"];


        // 確認是否有在購物車裡
        $sql = "SELECT * FROM Contain C 
                NATURAL JOIN Member M 
                WHERE C.pNo = '$pNo' AND M.user_name = '$username'";
        $check_inCart = $db->prepare($sql);
        $check_inCart->execute();
        

        $inCart = $check_inCart -> rowCount();

        if($inCart >= 1){
            echo "in your cart";
        } 
        else{ // not in the chart
           
            $sql = "SELECT mId FROM Member WHERE `user_name`='$user_name'";  
            $user = $db -> query($sql);
            $user = $user -> fetch();


            // add to cart
            $sql = "INSERT INTO `Contain`(`mId`, `cartTime`, `pNo`, `amount`) VALUES ('$user[0]', NOW(),'$pNo', '$amount')";
           
            $db->exec($sql);

        }
        
       
    }
?>