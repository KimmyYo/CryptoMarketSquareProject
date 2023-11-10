<?php
    require 'includes/db.php';

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $category = $_GET["category"];

        $sql = "SELECT * FROM Product P
                JOIN Category C
                ON C.cName = P.category
                WHERE C.cName='$category'
                ORDER BY pNo DESC";
        
        // response
        $get_all_products = $db->query($sql);
        foreach($get_all_products as $product){
            $pNo = $product["pNo"];
            $pName = $product["pName"];
            $productImage = $product["pImage"];
            $unitPrice = $product["unitPrice"];
            $description = $product["description"];
            $heartNum = $product["heartNum"];
           
        echo '<div class="product_box">';
            echo '<div class="image">';
                echo '<a href="product_info.php?pNo=' . $pNo . '">';
                    echo '<img src="images/' . $productImage . '">';    
                echo '</a>';
            echo '</div>';
            echo '<div class="name">' . $pName . '</div>';     
            echo '<div class="price">$' . $unitPrice . '</div>';
        echo '</div>';

        }
    }
?>