<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles/cart.css">
	<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
	<script src="cart.js"></script>
</head>
<body>
    <?php

	require 'includes/db.php';

	 // identify user_name and insert user_id to product table
	$user_name = $_COOKIE["CookieUname"];
	$sql = "SELECT mId FROM `Member` WHERE `user_name`='$user_name'";
	$user = $db -> query($sql);
	$user = $user->fetch();

    
    $row = $db->query("SELECT * FROM Contain WHERE mId='$user[0]'");
    $rowCount = $row->rowCount();  //全部rowCount筆資料
	if ($rowCount == 0) {
		echo "<script>";
		echo "alert('Shopping cart is empty!');";
		echo "location.href='index.php';";
		echo "</script>";
	}
    ?>

    <script>            //半路js
        $(document).ready(function () {
            load_data();
        });
        var rowCount = <?= $rowCount ?>;
    </script>


    <!-- 大平台 -->
	<div class="cart">


    <!-- 頭段 -->

	<div class="head_sec">
	<span class="logo">
    <a href="index.php">
		<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-coinbase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
		<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
		<path d="M12.95 22c-4.503 0 -8.445 -3.04 -9.61 -7.413c-1.165 -4.373 .737 -8.988 4.638 -11.25a9.906 9.906 0 0 1 12.008 1.598l-3.335 3.367a5.185 5.185 0 0 0 -7.354 .013a5.252 5.252 0 0 0 0 7.393a5.185 5.185 0 0 0 7.354 .013l3.349 3.367a9.887 9.887 0 0 1 -7.05 2.912z"></path>
		</svg>
	</a>
	</span>
	<span class="logo_side">
		|  Shopping Cart
	</span>
	</div>


    <!-- 購物車欄位 -->

	<div class="cart_bar">
		<span class="cart_bar_col1">Product</span>
		<span class="cart_bar_col2">Unit Price</span>
		<span class="cart_bar_col3">Quantity</span>
		<span class="cart_bar_col4">Total Price</span>
		<span class="cart_bar_col5">Actions</span>
	</div>



    <!-- 購物車內商品 -->

    <div class="cart">
        <div id="cart_box"></div>
    </div>



    <!-- 結帳鈕 -->

	<div class="checkout">
		<label class='product_check' id="product_check">
			<input type='checkbox' name="all" id="checkout_all">
			<span class='checkmark'></span>
		</label>
		<span class="checkout_selectall">Select All(<?=$rowCount?>)</span>
		<span class="checkout_total">
			Total <span class="total_text" id="totalclick">0</span> items, 
            Subtotal <span class="total_text" id="totalprice">$0</span>
		</span>
		<button type="submit" id="cart_submit" value="Check Out" onclick=checkout()>Check Out</button>
	</div>


    </div>    <!-- 大平台 -->

</body>
</html>