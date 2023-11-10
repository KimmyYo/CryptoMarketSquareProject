

<script src="script.js"></script>
<style>
    #edit_button{
        border: none;
        background-color: #fff;
    }
    #edit_button:hover svg{
        color: #eca123;
        transition: .2s;
    }
    #delete_button{
        border: none;
        background-color: rgb(255, 255, 255);
        margin-bottom: 20px;
       
    }
    #delete_button svg{
        color: #e63535;
    }
    #delete_button:hover svg{
        color: #eca123;
        transition: .2s;
    }
</style>

<?php
    require 'includes/db.php';
   
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        
        $find_category = $_GET["category"];
        $find_pName = $_GET["pName"];
        $find_hashtag = $_GET["hashtag"];
        // echo $find_category, $find_hashtag, $find_pName;

        // identify user_name and insert user_id to product table
        $user_name = $_COOKIE["CookieUname"];
        if(empty($user_name)){
            echo "no user";
        }
        $sql = "SELECT mId FROM `Member` WHERE `user_name`='$user_name'";
        $users = $db -> query($sql);
        foreach($users as $user_id){
            $user_id = $user_id[0];
        }

        // echo "here";
        $all_empty_flag = FALSE;
        // $not_found_flag = FALSE;
        // three null
        if(empty($find_pName) && $find_category == 'All' && $find_hashtag == 'All'){
            // echo "<script>";
            // echo "alert('No condition is filled!')";
            // echo "</script>";
            $sql = "SELECT * FROM Product WHERE mId = '$user_id'";
            $all_empty_flag = TRUE;

        }
        // two null :  
        else if ($find_category == 'All' && $find_hashtag == 'All'){
            $sql = "SELECT * FROM Product 
                    WHERE mId = '$user_id'
                    AND pName LIKE '%$find_pName%'
                    ";

        }
        else if (empty($find_pName) && $find_hashtag == 'All'){
            $sql = "SELECT * FROM Product 
                    WHERE mId = '$user_id'
                    AND category = '$find_category'
                    ";

        }
        else if (empty($find_pName) && $find_category == 'All'){
            $sql = "SELECT * FROM Product 
                    WHERE mId = '$user_id'
                    AND hashtag LIKE '%$find_hashtag%'";


        }
        // one null
        else if (empty($find_pName)){
            $sql = "SELECT * FROM Product 
                    WHERE mId = '$user_id'
                    AND hashtag LIKE '%$find_hashtag%'
                    AND category = '$find_category'";
 
        }
        else if ($find_category == 'All'){
            $sql = "SELECT * FROM Product 
                    WHERE mId = '$user_id'
                    AND hashtag LIKE '%$find_hashtag%'
                    AND pName LIKE '%$find_pName%'";

        }
        else if ($find_hashtag == 'All'){
            $sql = "SELECT * FROM Product 
                    WHERE mId = '$user_id'
                    AND category = '$find_category'
                    AND pName LIKE '%$find_pName%'";

        }
        else{
            // find pName and category 
          
            $sql = "SELECT * FROM `Product`     
                    WHERE `category` = '$find_category' 
                    AND  pName LIKE '%$find_pName%'
                    AND hashtag LIKE '%$find_hashtag%' 
                    AND `mId` = '$user_id'
                    ";

        }
  
        $desc_order_sql = " ORDER BY pNo DESC";
        $sql = $sql.$desc_order_sql;
       
        $filtered = $db -> prepare($sql);
        $filtered->execute();
        
        $count_rows = $filtered -> rowCount();
        echo '<link rel="stylesheet" href="styles/product/product.css">';
        $edit_svg = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
        <path d="M13.5 6.5l4 4"></path>
     </svg>';
   
        $delete_svg = '  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M4 7l16 0"></path>
        <path d="M10 11l0 6"></path>
        <path d="M14 11l0 6"></path>
        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
     </svg>';
        if($count_rows > 0){
            if($all_empty_flag){
                echo "<div class='title'>YOUR PRODUCT</div>";
            }
            else{
                echo "<div class='title'>Found Product</div>";
            }
            foreach($filtered as $filter){
                
                echo "<div class='table_row'>";
                echo "<div class='row_cell'><input type='checkbox'></div>";
                echo "<div class='row_cell'><img src='images/".$filter['pImage']."'/></div>";
                echo "<div class='row_cell'>".$filter['pName']."</div>";
                echo "<div class='row_cell'>".$filter['pNo']."</div>";
                echo "<div class='row_cell'>$".$filter['unitPrice']."</div>";
                echo "<div class='row_cell'><span>".$filter['category']."</span></div>";
                echo "<div class='row_cell'>";
                echo "</div>";
                echo "<button id='edit_button' onclick=" . "get_edit(".$filter['pNo'] . "," . "'edit');" . ">".$edit_svg."</button>";
                echo "<div class='row_cell'>";
                echo "<button id='delete_button' onclick=" . "get_edit(".$filter['pNo'] . "," . "'delete');" . ">.".$delete_svg."</button>";
                echo "</div></div>";
                echo " <div id='edit_area' style='display: none;'></div>   
                        <div id='delete_area' style='display: none;'></div>";
    
            }
        }
        else{ // not found data
            $sql = "SELECT * FROM `Product` WHERE mId = '$user_id' ORDER BY `pNo` DESC";
            $all = $db->prepare($sql);
            $all->execute();
          
            echo "<div class='title'>Sorry not found:(</div>";
            
            foreach($all as $product){
                echo "<div class='table_row'>";
                echo "<div class='row_cell'><input type='checkbox'></div>";
                echo "<div class='row_cell'><img src='images/".$product['pImage']."'/></div>";
                echo "<div class='row_cell'>".$product['pName']."</div>";
                echo "<div class='row_cell'>".$product['pNo']."</div>";
                echo "<div class='row_cell'>$".$product['unitPrice']."</div>";
                echo "<div class='row_cell'><span>".$product['category']."</span></div>";
                echo "<div class='row_cell'>";
                echo "<button id='edit_button' onclick=" . "get_edit(".$product['pNo'] . "," . "'edit');" . ">".$edit_svg."</button>";
                echo "</div>";
                echo "<div class='row_cell'>";
                echo "<button id='delete_button' onclick=" . "get_edit(".$product['pNo'] . "," . "'delete');" . ">".$delete_svg."</button>";
                echo "</div></div>";
                echo " <div id='edit_area' style='display: none;'></div>   
                        <div id='delete_area' style='display: none;'></div>";

            }
        }  

    }
?>

