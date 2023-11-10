<?php require 'includes/db.php'?>

<?php 

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $pNo = $_GET["pNo"];
        $sql = "SELECT * FROM `Product` WHERE `pNo`='$pNo'";
        $products_info = $db->query($sql);

        foreach($products_info as $product_info){
            $pNo = $product_info["pNo"];
            $pName = $product_info["pName"];
            $price = $product_info["unitPrice"];
            $desc = $product_info["description"];
            $origin_category = $product_info["category"];
            $current_image = $product_info["pImage"];
            
            
        ?>
            <div class="x" onclick="$('#edit_area').toggle();">X</div>
            <div class="edit_place">
                <form action="" method="POST" id="edit_form">
                    <input type="hidden" name="pNo" value="<?=$pNo?>"/>
                    <img src="<?="images/".$current_image?>">
                    
                    <label>Product Name : <input type="text" name="update_pname" value="<?=$pName?>"></label>
                    <label>Product Price : $<input type="text" name="update_price" value="<?=$price?>"></label>
                    <label>Product Category :  
                        <select name="update_category" >
                            <?php // get all category
                                $sql = "SELECT * FROM `Category`";
                                $all_categories = $db -> query($sql);
                                foreach($all_categories as $category){
                                    if($category['cName'] == $origin_category){
                            ?>
                                        <option value='<?=$category['cName']?>' selected><?=$category['cName']?></option>
                            <?php
                                    } else{
                            ?>
                                    <option value='<?=$category['cName']?>'><?=$category['cName']?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </label>
                    Product Details : <textarea name="update_desc"><?=$desc?></textarea>
                    <button type="submit" id="edit_submit">Edit</button>
                </form>
            </div>
        <?php
        }

       
    }
   
?>
<?php
   
   if($_SERVER["REQUEST_METHOD"] == "POST"){
       $pNo = $_POST["pNo"];
       $update_pname = $_POST["update_pname"];
       $update_price = $_POST["update_price"];
       $update_desc = $_POST["update_desc"];
       $update_category = $_POST["update_category"];

       
       $sql = "UPDATE `Product` SET `pName`='$update_pname', `unitPrice`='$update_price',
               `description`='$update_desc', `category`='$update_category' WHERE `pNo`='$pNo'";
        echo $sql;
        
       if($db->exec($sql)){
           echo "success";
       }
       else{
           echo " wrong";
       }
   
   }
   ?>
   