
<link rel="stylesheet" href="styles/product/product.css">
<link rel="stylesheet" href="styles/upload/upload.css">
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<script src="script.js"></script>

<?php
    require 'includes/db.php';

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $content_id = substr($_GET["id"], -1);
        
       
        if($content_id == 1){
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
?>
            
<div class="upload_form_box">

<form method="POST" action="" enctype="multipart/form-data" id="upload_form">
    
    <div class="upper_part">    
        <div class="title">New Product</div>
    </div>
    <div class="form_section" id="section_1">
        <div class="title">
            <span>1</span>Information 
        </div>
        <!-- 產品名稱 -->
        <div class="input_box">
            <span>Name *</span>
            <input required id="product_name" name="pName" type="text" placeholder="Jeans" minlength="1" maxlength="200"/>
        </div>
        <!-- 產品金額 -->
        <div class="input_box">
            <span>Price *</span>
            <input id="product_price" name="unitPrice" type="text" maxlength="15"/>
        </div>
        <!-- 產品說明 -->
        <div class="input_box">
            <span>Descrition *</span>
            <textarea id="editor" name="description"></textarea>
            <!-- <script>
                ClassicEditor
                .create(document.querySelector('#editor'), {
                    plugins: [ 'Essentials', 'Paragraph', 'Bold', 'Italic', 'List'],
                    toolbar: [ 'undo', 'redo', '|', 'bold', 'italic', 'list']
                    
                })
                .catch(error => {
                    console.error(error);
                });
            </script> -->
        </div>
        <!-- 產品圖片 -->
        <div class="image_box">
            <span class="title">Picture * </span>
            <div class="file_box">
                
                <label class="adding_part" id="add_image">
                    <div class="icon" id="to_put_image">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M15 8h.01"></path>
                            <path d="M12.5 21h-6.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6.5"></path>
                            <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l4 4"></path>
                            <path d="M14 14l1 -1c.67 -.644 1.45 -.824 2.182 -.54"></path>
                            <path d="M16 19h6"></path>
                            <path d="M19 16v6"></path>
                        </svg>
                    </div>
                    Upload an image of your product
                    <input id="image_name" name="get_image_path" type="file" onchange="loadFile(event)"/>
                </label>
            </div>
        </div>
    </div>
    <div class="form_section" id="section_2">
        <div class="title">
            <span>2</span>Settings
        </div>
        <!-- 產品類型 -->
        <div class="input_box">
            <span>Category *</span>
            <select name="category">
                <?php // get all category
                    $sql = "SELECT * FROM `Category`";
                    $all_categories = $db -> query($sql);
                    $cId = 0;
                    foreach($all_categories as $category){
                ?>
                        <option value="<?=$category['cName']?>"><?=$category["cName"]?></option>
                        
                <?php
                        
                    }
                ?>
            </select>
        </div>
        <!-- 產品存貨 -->
        <div class="input_box">
            <span>Stocks *</span>
            <input type="number" name="pStock">
        </div>
        <!-- 產品hashtag -->
        <div class="input_box">
            <span>Hashtags *</span>
            
            <ul id="tagList"></ul>
            <!-- <div style="clear:both"></div> -->
            <input type="hidden"  id="tags"/>
            <div id='addd_box'>
                <input type="text" id="tagInput"/>
                <span class="add_tag_btn" onclick="upload_hashtag()">+</span>
                </div>
                <input type="hidden" name="hashtags" id="all_tags"/>
        </div>
        
    </div>
    <div class=submit_box>
        <button type="submit" id="upload_submit" onclick="get_upload(event);">Upload</button>
    </div>

</form>
</div>
<?php
        }
        if($content_id == 2){
            require 'chart_analysis.php';
        }
        if($content_id == 3){
?> 
            <div id="query_table">
                <div class="title" style="font-size: 2em; font-weight: 500">FILTER</div>
                <form method="post" id="filter_form">
                    <!-- // search by product names -->
                    <div class="input_box" >
                        <label>Product Name</label>
                        <input type="text" name="filtered_pName" id="find_pName"/>
                    </div>
                    <!-- // search by product category -->
                    <div class="input_box">
                        <label>Category</label>
                        <div class="inner">
                            <select name="filtered_category" id="find_category">
                                <option value='All'>All</option>
                                <?php // get all category
                                    $sql = "SELECT * FROM `Category`";
                                    $all_categories = $db -> query($sql);
                                    foreach($all_categories as $category){
                                        
                                ?>
                                        <option value="<?=$category["cName"]?>"><?=$category["cName"]?></option>
                                <?php
                                    }
                                ?>
                                
                            </select>
                        
                            
                        </div>
                    </div>
                    <div class="input_box">
                        <label>Hashtags</label>
                       <?php
                            $user_name = $_COOKIE['CookieUname'];
                            $sql = "SELECT P.hashtag FROM Product P NATURAL JOIN Member M WHERE M.user_name = '$user_name'";
                            $raw_tags = $db -> prepare($sql);
                            $raw_tags -> execute();
                            $raw_tags = $raw_tags -> fetchAll(PDO::FETCH_ASSOC);
                            // process tags;
                            $processed_tag = array();
                            foreach($raw_tags as $tags){
                                // split tags 
                                $tags_array = explode("#", $tags['hashtag']);
                                $tags_array = array_filter($tags_array);
                                for($i = 1; $i <= count($tags_array); $i++){
                                 
                                    if(!in_array($tags_array[$i], $processed_tag)){
                                        array_push($processed_tag, $tags_array[$i]);
                                    }
                                }
                            }
                            $processed_tag = array_filter($processed_tag);
                          
                       ?>
                    <select name="filtered_hashtag" id="find_hashtag">
                        <option value='All'>All</option>
                    <?php
                        foreach($processed_tag as $tag){
                    ?>
                        <option value='<?=$tag?>'><?=$tag?></option>
                    <?php
                        }
                    ?>
                    </select>
                    </div>
                    <button type="submit" onclick="filter_products();">
                            Search
                            </button>
                </form>
            </div>
            <div class="product_table">  
                <div class="title">YOUR PRODUCT</div>
        <?php
                // identify user_name and insert user_id to product table
                $user_name = $_COOKIE["CookieUname"];
                if(empty($user_name)){
                    echo "no user";
                }
                $sql = "SELECT mId FROM `Member` WHERE `user_name`='$user_name'";
                $users = $db -> query($sql);
                $users = $users -> fetch();
                $sql = "SELECT * FROM `Product` WHERE mId='$users[0]' ORDER BY `pNo` DESC";  
                $all_products = $db->query($sql);
            
                foreach($all_products as $product){
                
                    $pNo = $product["pNo"];
                    $name = $product["pName"];
                    $unitPrice = $product["unitPrice"];
                    $category = $product["category"];
                    $image = $product["pImage"]; 
        ?>
                    <div class="table_row">
                        <div class="row_cell"><input type="checkbox"></div>
                        <div class="row_cell">
                            <img src="<?php echo "images/".$image;?>"/>
                        </div>
                        <div class="row_cell"><?=$name;?></div>
                        <div class="row_cell"><?=$pNo;?></div>

                        <div class="row_cell">$<?=$unitPrice;?></div>
                        <div class="row_cell"><span><?=$category;?></span></div>
                        <div class="row_cell"> 
                            <button id="edit_button" onclick="get_edit(<?=$pNo?>, 'edit');">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
   <path d="M13.5 6.5l4 4"></path>
</svg>
                            </button>
                        </div>
                        <div class="row_cell">
                            <button id="delete_button" onclick="get_edit(<?=$pNo?>, 'delete');">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M4 7l16 0"></path>
   <path d="M10 11l0 6"></path>
   <path d="M14 11l0 6"></path>
   <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
   <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
</svg>
                        </button>
                        </div>
                    </div> 
        <?php
                } // end of foreach
        ?>  
            <div id="edit_area" style="display: none;"></div>   
            <div id="delete_area" style="display: none;"></div>
         
            <!-- product table end div -->
            </div> 
        <?php
        }// end of show product content in dashboard  
        else if($content_id == 5){
            // echo $content_id;
            require 'favorite_product.php';
        }
        else if($content_id == 4){
            require 'default_dashboard.php';
        }
        else if($content_id == 6){
            require 'profile_edit.php';
        }
        // else{
        //     echo "herhehrwhaitoawit";
        //     require 'default_dashboard.php';
        // }
    }// end of get dashboard content
?>
