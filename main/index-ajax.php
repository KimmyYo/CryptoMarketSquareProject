<?php require 'recommend.php';

// sleep(1);

$id = $_GET['id'];
						
if(isset($_COOKIE["CookieUname"])){
    $sql = "SELECT * FROM `Product` WHERE pNo in ($user_recommend_pNo_formatted) ORDER BY FIELD($field) limit $id, 15";
}
else{
    $sql = "SELECT * FROM `Product` ORDER BY pNo DESC limit $id, 15";
}

$get_all_products = $db->query($sql);


foreach($get_all_products as $product){

    $pNo = $product["pNo"];
    $pName = $product["pName"];
    $productImage = $product["pImage"];
    $unitPrice = $product["unitPrice"];
    $description = $product["description"];
    $heartNum = $product["heartNum"];
        

echo "<div class='product_box'>";
    echo "<div class='image'>";
        echo "<a href='product_info.php?pNo=$pNo'>";
            echo "<img src='images/$productImage' alt=''>";
        echo "</a>";
    echo "</div>";
    echo "<div class='name'>$pName</div>";
    echo "<div class='price'>$$unitPrice</div>";
echo "</div>";

} ?>