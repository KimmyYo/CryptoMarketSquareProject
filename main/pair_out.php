<?php
require 'includes/db.php';


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user_name = $_COOKIE["CookieUname"];
    // 暫存裡面有沒有這個人的計算資料?有就先刪掉
    $indb = $db->query("SELECT * FROM tag_temp WHERE user_name = '$user_name'");
    $indb = $indb->rowCount();

    if ($indb > 0) {
        $SQL = "DELETE FROM tag_temp WHERE user_name = '$user_name'";
        $DELETE = $db->prepare($SQL);
        $DELETE->execute();
    }



    // 從pair-in接收使用者輸入的tag
    $tag = $_POST['input_tag'];


    $tag = explode("#", $tag);      //以#為界線炸開
    $tag_amount = count($tag)-1;      //有幾個tag
   

    // 主頁標籤顯示
    // $tags_array = explode("#", $hashtags);
    $tags_array = array_filter($tag);
    $check_duplicate = array();
    foreach($tags_array as $tags){
        $tag_ex = explode(",", $tags)[0];
        // print_r($tag_ex);
        if(!in_array($tag_ex, $check_duplicate)){
            array_push($check_duplicate, $tag_ex);
        
        }
    }
    
    echo "<script>";
    echo "$('.hashtag_section').empty()";
    echo "</script>";
    for($i = 0; $i < count($check_duplicate); $i++){
            echo "<script>";
            echo "var tag = $('<span>').text('#".$check_duplicate[$i]."');";
            echo "$('.hashtag_section').append(tag)";
            
            echo "</script>";
    }
  
    // print_r($check_duplicate);
    // foreach($check_duplicate as $tagex){
    //     echo "<script>";
    //     echo "var tag = $('<span>').text('#".$tag_ex."');";
    //     echo "$('.hashtag_section').append(tag)";
        
    //     echo "</script>";
    // }



    $temp = [];     //暫存相符的pNo的權重的陣列

    for ($i=1; $i<=$tag_amount; $i++) {
        $tag_exp = explode(",", $tag[$i]);

        if (isset($tag_exp[0]) && isset($tag_exp[1])) {
            $tag_exp[0] = preg_replace("/[^a-zA-Z]/iu",'', $tag_exp[0]);
            $tag_exp[1] = preg_replace('/[^\d]/','',$tag_exp[1]);
        }
        else {
            $tag_exp[0] = null;
            $tag_exp[1] = null;
        }
 
        //$match = 有相符
        $match = $db->query("SELECT pNo FROM Product WHERE hashtag LIKE '%$tag_exp[0]%'");
        
        foreach ($match as $ROWS) {     //配對陣列temp[pNo] = weight
            if (isset($temp[$ROWS[0]])) {
                
                $temp[$ROWS[0]] = $temp[$ROWS[0]] + $tag_exp[1];
                $weight = $temp[$ROWS[0]];
                $SQL = "UPDATE tag_temp SET weight='$weight' WHERE pNo = '$ROWS[0]'";
            }
            else {
                
                $temp[$ROWS[0]] = $tag_exp[1];
                $weight = $temp[$ROWS[0]];
                $SQL = "INSERT INTO tag_temp(`pNo`, `user_name`, `weight`) VALUES ('$ROWS[0]','$user_name','$weight')";
            }
            $update = $db->prepare($SQL);
            $update->execute();
            
        }
    }

   


    // response：被篩出來的產品
    $data = $db->query("SELECT * FROM Product JOIN tag_temp ON product.pNo=tag_temp.pNo WHERE user_name='$user_name' ORDER BY `weight` DESC limit 6");

    $data_all = $db->query("SELECT * FROM tag_temp WHERE user_name='$user_name'");
    $rowcount = $data_all->rowCount();
    if ($rowcount == 0) echo "<script>alert('No matching products');location.href='index.php'</script>";


    foreach ($data as $ROWS) {
        
        
        $productImage = $ROWS['pImage'];
        $pNo = $ROWS['pNo'];
        $pName = $ROWS['pName'];
        $unitPrice = $ROWS['unitPrice'];


        echo "<div class='product_box'>";
            echo "<div class='image'>";
        echo "<a href='product_info.php?pNo=$pNo'>";
        echo "<img src='images/$productImage?>' alt=''>";
        echo "</a>";
        echo "</div>";
        echo "<div class='name'>$pName</div>";
        echo "<div class='price'>$$unitPrice</div>";
        echo "</div>";

        
        
    }



}

?>