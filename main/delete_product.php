<?php require 'includes/db.php';?>
<?php 
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $pNo = $_GET["pNo"];
        echo $pNo;
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
                    <div class="x" id="question_x" onclick="$('#delete_area').toggle();">X</div>
                    <div class="question_text">Do you want to delete?</div>
                    <div class="yes_no_btns">
                        
                        <form action="" method="POST" id="delete_form">
                            <input type="hidden" name="pNo" value="<?=$pNo;?>">
                            <button class="yes_btn" id="delete_submit" name="yes_btn" type="submit">Delete</button>
                            <button class="no_btn" name="no_btn" type="submit">Cancel</button>
                            
                        </form> 
                        
                    </div>
                </div> 
            </div>
        
<?php
        }
    }
   
?>
 <?=$pName?>
        

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $pNo = $_POST["pNo"];  
    $sql = "DELETE FROM `Product` WHERE `pNo`='$pNo'";

    if($db->exec($sql)){
        echo "success delete";
        
    } else{
        echo "<script>alert('There are some errors, please refresh and try again!')</script>";
    }

    
}  
?>