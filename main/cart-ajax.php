<?php

require 'includes/db.php';
$row = $db->query("SELECT * FROM Contain");
$rowCount = $row->rowCount();  //全部rowCount筆資料


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

$contain = $db->query("SELECT DISTINCT `mId` FROM Product WHERE pNo IN (SELECT pNo FROM Contain WHERE mId = '$user_id')");
// 篩出有那些賣家的東西

$id=0;  //目前購物車索引

$cart_product = $db->query("SELECT * FROM product WHERE pNo IN (SELECT pNo FROM contain WHERE mId = '$user_id')");

foreach ($contain as $ROWS) {

    $sellerName = $db->query("SELECT * FROM Seller NATURAL JOIN Member  WHERE mId = '$ROWS[mId]'");
    $sellerName = $sellerName->fetch();
    

    // 頭段

    echo "<div class='product_seller_head'>";
        echo "<a style='cursor: pointer;'>";
            echo "<img class='product_seller_head_chat' src='images/$sellerName[mImage]'>";
        echo "</a>";
        echo "<span class='product_seller'>$sellerName[storeName]</span>";
    echo "</div>";
		
    echo "<hr style='background-color: #d9d9d9; height:1px; border:none'>";

    $cart_product = $db->query("SELECT * FROM product WHERE pNo IN (SELECT pNo FROM contain WHERE mId = '$user_id') AND mId = '$sellerName[mId]'");

    //商品段

    foreach ($cart_product as $pROWS) {

        $product_stock = $pROWS['pStock'];
        
        ?>

    <?php
    $cart = $db->query("SELECT * FROM Contain JOIN product ON contain.pNo = product.pNo WHERE product.pNo = '$pROWS[pNo]'");
    $cartf = $cart->fetch();

    $id += 1;

    echo "<div class='cart_product_detail' id='cart_product_detail$id'>";
        // 打勾勾
        echo "<label class='product_check'>";
		echo "<input type='checkbox' class='product_check' id='inputbox$id' onclick=checkbox($id,$pROWS[pNo]) name='$id' value=$pROWS[pNo]>";
        echo "<span class='checkmark'></span>";
        echo "</label>";

        // 圖片片
		echo "<img class='product_img' src='images/$pROWS[pImage]'>";

        // 品名名
	    echo "<span class='product_head'>$pROWS[pName]</span>";

        // 規格子
		echo "<span class='product_head_specs'>Variations:</span>";
        // Variations:<br>$pROWS[pSpecs]

        // 單價子
		echo "<span class='product_unit_price' id='product_unit_price$id'>$$pROWS[unitPrice]</span>";

        // 數量了
		echo "<span class='product_unit_amount'>";
            echo "<span>";
                echo "<button class='product_amount' id='product_amount_minus' onclick=product_amount_minus($id,$pROWS[pNo],$product_stock)>－</button>";
                echo "<span id='product_unit_amount$id'>$cartf[amount]</span>";
                echo "<button class='product_amount' id='product_amount_add' onclick=product_amount_add($id,$pROWS[pNo],$product_stock)>＋</button>";
            echo "</span>";
            echo "<div class='no_stock'>Remain: $product_stock</div>";
        echo "</span>";

        // 小計額
        $totalprice = $cartf['amount'] * $pROWS['unitPrice'];
		echo "<span class='product_unit_tprice' id='product_unit_tprice$id'>$$totalprice</span>";

        // 刪除
		echo "<button class='product_delete' onclick=remove($id,$pROWS[pNo]);location.href=''>Delete</button>";

	echo "</div>";

    }
}
?>