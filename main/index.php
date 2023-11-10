<?php include "includes/db.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Crypto Market Square</title>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="styles/reset.css">
	<link rel="stylesheet" href="styles/main_page/main_page.css">
	<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
	<script src="script.js"></script>
	
</head>
<body>

<!-- whole box -->
<div class="whole_box">
<?php
	// session_start();
    if(!isset($_COOKIE["CookieUname"])) {
		
    ?>
		<!-- header section -->
		<div class="main_header">
			<!-- header -->
			<div class="logo">
				<a href="index.php">
					<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-coinbase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
						<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
						<path d="M12.95 22c-4.503 0 -8.445 -3.04 -9.61 -7.413c-1.165 -4.373 .737 -8.988 4.638 -11.25a9.906 9.906 0 0 1 12.008 1.598l-3.335 3.367a5.185 5.185 0 0 0 -7.354 .013a5.252 5.252 0 0 0 0 7.393a5.185 5.185 0 0 0 7.354 .013l3.349 3.367a9.887 9.887 0 0 1 -7.05 2.912z"></path>
					</svg>
				</a>
			</div>
			<div class="top_nav">
				<div class="left_nav">
					<div class="crumb">Welcome to Crypto Market Square</div>
				</div>
				<div class="right_nav">
					<!-- Google Translate API start -->
					<!-- <div id="google_translate_element"></div> -->
					<!-- <script type="text/javascript">
					function googleTranslateElementInit() {
						new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
					}
					</script> -->
					<!-- Google Translate API end -->
					<!-- <div class="search">Search</div> -->
					<div class="user_head" id="user_head">
						<a href="login.php">
							Login
							<!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
								<path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
								<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
							</svg> -->
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
    else{
	?>	
		<div class="toast position-fixed" id="toast_block" data-bs-autohide="false" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">CryptoMarketSquare</strong>
                <small>Just Now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" id="close_toast"></button>
            </div>
            <div class="toast-body">
                COME AND BUY ! 
            </div>
        </div>
		<!-- header section -->

		<div class="checkhere">
   
			<button id="checkin_go" onclick="$('#show_checkIn').toggle()">
				<img src="images/bitcoin.png">
			</button>
			
			<!-- <span> Check in </span> -->
		</div>
		
	<?php 
		require 'main_header.php';
	}
	?>
	<div class="content_section">
			<!-- left section -->
			<div class="left_side_menu">
				<div class="menu_box">
					<?php // get all category
						$sql = "SELECT * FROM `Category`";
						$all_categories = $db -> query($sql);
						foreach($all_categories as $category){
					?>
							<div class="category" onclick="get_category(this, '<?=$category['cName'];?>');"><?=$category["cName"]?></div>
					<?php
						}
					?>
					
				</div>
			</div>
			<!-- right product section  -->
			<div class="right_side">
				
				<div class="hashtag_section">
					<!-- 推薦 hasgtag -->
					<!-- 全部 hastag -->
				</div>
				<!-- products -->
				<div class="products_section">
					<!-- read products information  -->
				
					<?php 
						// echo $user_recommend_pNo_formatted;
						
						if(isset($_COOKIE["CookieUname"])){
							require 'recommend.php';
							$sql = "SELECT * FROM `Product` WHERE pNo in ($user_recommend_pNo_formatted) ORDER BY FIELD($field)";
						}
						else{
							$sql = "SELECT * FROM `Product` ORDER BY pNo DESC";
						}


						$get_all_products = $db->query($sql);
						$rowCount = $get_all_products->rowCount();
						?>
						<script>var limit = <?=$rowCount?>;</script>
						
				
				</div>
				<div id="product_loading"><img src="images/loading.gif" alt=""></div>
						<div class='reach_bottom'>Has reached the bottom!</div>
			</div>
		</div>
</div>
	<div id="show_checkIn">
		<i class="uil uil-times close-icon" onclick="$('#show_checkIn').toggle()"></i>
		<?php require 'daily_check_in.php'?>
	</div>
</body>
</html>	