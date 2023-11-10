<?php
    require 'includes/db.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $search_content = $_POST["search_content"];
        
        $SQL= "SELECT * FROM Product WHERE pName LIKE '%$search_content%'";
        $search_result = $db -> prepare($SQL);
        $search_result -> execute();
    
        if($search_result -> rowCount() > 0){
            foreach($search_result as $product){
            
                $pNo = $product["pNo"];
                $pName = $product["pName"];
                $productImage = $product["pImage"];
                $unitPrice = $product["unitPrice"];
                $description = $product["description"];
                $heartNum = $product["heartNum"];
            
       
     
    ?>	
        <div class="product_box">
            <div class="image">
                <a href='product_info.php?pNo=<?=$pNo;?>'>
                    <img src="<?php echo "images/".$productImage;?>" alt="">
                </a>
            </div>
            <div class="name"><?=$pName?></div>
            <div class="price"><?php echo "$".$unitPrice?></div>
            
        </div>
        <?php
            }   
        }  
    }

?>