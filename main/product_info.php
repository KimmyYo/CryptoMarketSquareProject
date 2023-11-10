<?php  require 'includes/db.php'?>
<link rel="stylesheet" href="styles/product_info/product_info.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="script.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

<?php
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $pNo = $_GET["pNo"];
        if(!empty($_COOKIE["CookieUname"])){
        $user_name = $_COOKIE["CookieUname"];
        
        $sql = "SELECT mId FROM Member WHERE `user_name`='$user_name'";
        $user_id = $db -> query($sql);
        $user_id = $user_id -> fetch();

        

        // 儲存瀏覽資料：沒有瀏覽過 -> 新增; 有瀏覽過 -> 增加次數
        $sql = "SELECT * FROM BrowseRecord B
                WHERE pNo='$pNo' AND mId='$user_id[0]'";
        $browse_record = $db->query($sql);
        $browse_count  = $browse_record -> rowCount();
        // $user_id = $browse_record['mId'];
        
        
            if($browse_count == 0){
                
                // 新增會員瀏覽資料
                $sql = "INSERT INTO `BrowseRecord`(`pNo`, `mId`, `browseTime`, `freq`) 
                        VALUES ('$pNo','$user_id[0]', NOW(), 1)";
                       
                $db -> exec($sql);
               
            } 
            else{
                // 增加同商品瀏覽次數
                foreach($browse_record as $ROW){
    
                    $add_freq = $ROW['freq'] + 1;
                    
                    $sql = "UPDATE BrowseRecord SET freq='$add_freq' WHERE pNo='$pNo' AND mId='$user_id[0]'";
                    $db -> exec($sql);
                }
             
            }
    
        }
      
        // retrieve the product information
        $sql = "SELECT * FROM `Product` WHERE `pNo`='$pNo'";
        $get_product = $db->query($sql);
        
        foreach($get_product as $product){
            $pNo = $product["pNo"];
            $pName = $product["pName"];
            $productImage = $product["pImage"];
            $unitPrice = $product["unitPrice"];
            $description = $product["description"];
            $category = $product["category"];
            $heartNum = $product["heartNum"];
            $hashtags = $product["hashtag"];
            
            
        }
?>
  
        <!-- // show on the web -->
    <div class="whole_box">
        <?php require 'main_header.php'?>
      
        <div class="main_content">
            <div class="product_image">
                <img src="<?php echo "images/".$productImage;?>" />
            </div>
            <div class="product_info">
              

                <div class="product_name"><?=$pName?></div>
                <div class="product_price">$<?=$unitPrice?></div>
                <div class="product_btns">
                    <div class="product_amount">
                        <span id="minus" onclick="minus_amount();">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            </svg>  
                        </span>
                        <input type="text" value="1" id="amount_input"/>
                        <span id="plus" onclick="plus_amount();">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                            </svg>
                        </span>
                    </div>
                    <?php if (isset($_COOKIE['CookieUname'])) { ?>
                        <button class="add_cart_btn" onclick="add_cart_func('<?=$pNo?>','<?php echo $_COOKIE['CookieUname']?>')"><span>ADD TO CART<span></button>
                    <?php
                    } 
                    else { ?>
                        <button class="add_cart_btn" onclick="location.href='logindex.php'"><span>ADD TO CART<span></button>
                    <?php
                    }?>
                    
                    <script>
                        function add_cart_func(pNo, added_user){
                            var get_var = "pNo=" + pNo + "&amount=" + $("#amount_input").val() + "&user_name=" + added_user;
                            console.log(get_var);
                            $.ajax({
                                url: 'add_chart.php?' + get_var,
                                type: 'GET',
                                dataType: 'html',
                                success: function(response) {
                                    // Insert the new content into the DOM
                                    alert("Added to your cart!");
                                    console.log(response);
                                }
                            });
                        }
                    
                    </script>
                   
                </div>
              
                <!-- 產品說明 -->
                <div class="detail_show" onclick="$('#description').toggle('linear');">
                    <div id="details_btn">PRODUCT DETAILS</div>
                    <span id="show_more">+</span>
                </div>
                <div class="product_desc" id="description">
                        <?=$description?>
                </div>

                <!-- 產品愛心 -->
                <div class="detail_show" onclick="$('#comments').toggle('linear');">
                    <div id="details_btn">COMMENTS AND LIKES</div>
                    <span id="show_more">+</span>
                </div>
                <div class="comments_hearts" id="comments">
                    <div class="hearts" onclick="add_heart(<?=$pNo?>);">
                      
                        <?php
                        if (isset($user_id[0])) {
                            $heart = $db->query("SELECT * FROM heartrecord WHERE mId='$user_id[0]' AND pNo='$pNo'");
                            $heart = $heart->rowCount();
                            if ($heart > 0) {
                        ?>
                            <svg id="heart_hole" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="rgb(180, 50, 50)" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"></path>
                            </svg>

                            <script>var heart=1;</script>
                            
                        <?php
                            } 
                            else { ?>
                                <svg id="heart_hole" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"></path>
                                </svg>
    
                                <script>var heart=0;</script>
    
                            <?php
                            }                     
                        }
                        else { ?>
                            <svg id="heart_hole" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"></path>
                            </svg>

                            <script>var heart=0;</script>

                        <?php
                        }
                        ?>



                        <!-- <svg id="heart_fill" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M6.979 3.074a6 6 0 0 1 4.988 1.425l.037 .033l.034 -.03a6 6 0 0 1 4.733 -1.44l.246 .036a6 6 0 0 1 3.364 10.008l-.18 .185l-.048 .041l-7.45 7.379a1 1 0 0 1 -1.313 .082l-.094 -.082l-7.493 -7.422a6 6 0 0 1 3.176 -10.215z" stroke-width="0" fill="currentColor"></path>
                        </svg> -->
                        <span class="heart_num"><?=$heartNum;?></span>
                        
                    </div>
                </div>
                <div class="hashtag_show">
                <?php
                    // 處理 hashtag 字串
                    $tags_array = explode("#", $hashtags);
                    $tags_array = array_filter($tags_array);
                    foreach($tags_array as $tags){
                ?>
                        <div class="tags">#<?=$tags?></div>
                <?php
                    }
                
                ?>
                
                </div>
            </div>
        </div>
    </div>
<?php
    }




?>