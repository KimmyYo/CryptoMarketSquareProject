<?php include 'includes/db.php'?>
<link rel="stylesheet" href="styles/product/product.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="script.js"></script>

<?php
        if($_SERVER["REQUEST_METHOD"] == "GET"){
            
            $pNo = $_GET["pNo"];
           

            if($_GET["action"] == "edit"){
                echo "<script>console.log('get get');</script>";
                $sql = "SELECT * FROM `Product` WHERE `pNo`='$pNo'";
                $products_info = $db->query($sql);
            
                foreach($products_info as $product_info){
                    $pNo = $product_info["pNo"];
                    $pName = $product_info["pName"];
                    $price = $product_info["unitPrice"];
                    $desc = $product_info["description"];
                    $current_image = $product_info["pImage"];
        ?>

                    <div id="edit_section">
                        <div class="x">X</div>
                        <div class="edit_place">
                            <form action="" method="POST">
                                <input type="hidden" name="pNo" value="<?=$pNo?>"/>
                                <img src="<?="images/".$current_image?>">
                                <button type="submit"><?="images/".$current_image?></button>
                                <input type="text" name="update_pname" value="<?=$pName?>">
                                <input type="text" name="update_price" value="<?=$price?>">
                                <textarea name="update_desc"><?=$desc?></textarea>
                                <button type="submit">Edit</button>
                            </form>
                        </div>
                    </div>
        <?php 
                } // foreach product
            
            } else if ($_GET["action"] == "delete"){
                $sql = "SELECT * FROM `Product` WHERE `pNo`='$pNo'";
                $products_info = $db->query($sql);
            
                foreach($products_info as $product_info){
                    $pNo = $product_info["pNo"];
                    $pName = $product_info["pName"];
                    $price = $product_info["unitPrice"];
                    $desc = $product_info["description"];
                    $current_image = $product_info["pImage"];
                

        ?>
                <div class="question_section">
                    <div id="to_delete">
                        <img id="image" src="<?php echo "images/".$current_image;?>" />
                        <div class="pname"><?=$pName;?></div>
                        <div class="price">$<?=$price;?>
                    </div>
                    <div id="question_box"> 
                        <div class="x" id="question_x">X</div>
                        <div class="question_text">Do you want to delete?</div>
                        <div class="yes_no_btns">
                            
                            <form action="delete_product.php" method="post">
                                <input type="hidden" name="pNo" value="<?=$pNo;?>">
                                <button class="yes_btn" name="yes_btn" type="submit">Delete</button>
                                <button class="no_btn" name="no_btn" type="submit">Cancel</button>
                            </form>
                            
                            
                        </div>
                    </div>
                </div>

        <?php      
                }
            }
        
                
   
        } // end of if GET
        ?>
        <!-- body box end div -->
        </div> 
    </div>  
</div>
<?php
   
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $pNo = $_POST["pNo"];
    $update_pname = $_POST["update_pname"];
    $update_price = $_POST["update_price"];
    $update_desc = $_POST["update_desc"];

    $sql = "UPDATE `Product` SET `pName`='$update_pname', `unitPrice`='$update_price',
            `description`='$update_desc' WHERE `pNo`='$pNo'";
    if($db->exec($sql)){
        echo "success";
        echo "<script>window.top.location='product.php'</script>";
    }
    else{
        echo " wrong";
    }

}
?>
