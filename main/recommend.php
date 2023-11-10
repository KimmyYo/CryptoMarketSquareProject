<?php

    require 'includes/db.php';
    // user對各商品買賣的參數：freq(瀏覽次數)、time(購買次數)、hashtag(tag類型)
    // 所有user資料（parameters）

    //// LEFT JOIN 瀏覽次數與購買商品 (Transaction mId)
    //// 某用戶買或瀏覽某商品的次數（freq, amount, tNo, hashtag）
    $SQL = "SELECT B.mId as browsemId, 
                   B.pNo as browsepNo, 
                   B.freq as browsefreq,
                   SUM(Purchased.amount) as buybuyamount,
                   Purchased.pNo as buypNo,
                   Purchased.tNo as buytNo,
                   P.hashtag as hashtag,
                   P.heartNum as hearts,
                   COUNT(h.mId) as liked
            FROM BrowseRecord B
            LEFT JOIN (
                SELECT O.pNo, O.amount, T.tNo, T.mId AS buymId FROM Transaction T
                NATURAL JOIN OrderInfo O
            ) AS Purchased
            ON B.pNo = Purchased.pNo AND B.mId = buymId
            JOIN Product P ON P.pNo = B.pNo
            LEFT JOIN heartRecord h ON h.pNo = B.pNo AND h.mId = B.mId
            GROUP BY B.pNo, buymId
            ORDER By browsemId
            ";
    
    
    $users_pref = $db->prepare($SQL);
    $users_pref -> execute();
    $user_all = $users_pref -> fetchAll(PDO::FETCH_ASSOC);
    $count_users = $users_pref -> rowCount();

    //// process query data
    //// create each user relational product (object)
    $rating = array();
    $check_user = array();
    $row = 0;
    for($i = 0; $i < $count_users; $i++){
       $user_p = $user_all[$i];
        //// store user (browsemId)  
        if(!in_array($user_p["browsemId"], $check_user)){
            array_push($check_user, $user_p["browsemId"]);
           
            //// store user's UserPrefer with bought product 
            /////// loop through what product does this user browse or bought
            $product_array = array();
            $same_flag = FALSE;
            for($row; $row < $count_users; $row++){
                $user_i = $user_all[$row];  

                if($user_i["browsemId"] == $user_p["browsemId"]){
                    $same_flag = TRUE;
                    $user_pNo = $user_i["browsepNo"];
                    $user_freq = $user_i["browsefreq"];
                    $user_buy_tNo = $user_i["buytNo"]; 
                    $user_buy_amount = $user_i["buybuyamount"];
                    $user_liked = $user_i["liked"];
                    $heart_amount = $user_i["hearts"];
                    
                    // $user_p_hashtags = $user_i["hashtag"];

                    // handeling hashtags
                    // $tags_array = explode("#", $user_p_hashtags);
                    // $tags_array = array_filter($tags_array);
                   
                    // handeling user buy or not 
                    if($user_buy_tNo == NULL){
                        $buy_record = 0;
                        $buy_amount = 0;
                    }
                    else{
                       $buy_record = 1;
                       $buy_amount = $user_buy_amount;
                    }

                    $product_array[$user_pNo] = array(
                        "browseFreq" => $user_freq,
                        "buyRecord" => $buy_record,
                        "buybuyamount" => $buy_amount,
                        "userLiked" => $user_liked,
                        "hearts" => $heart_amount
                        // "hashtags" => $tags_array,
                    );
                   

                }
                else{
                    break;
                }
              
            }
            if($same_flag == TRUE){
                $rating[$user_p["browsemId"]] = $product_array;
            }
            
        }  
       
    }
    // echo '<pre>'; print_r($rating); echo '</pre>';  
    // echo print_r($rating);
  
    $freqWeight = 15;
    $buyWeight = 30;
    $amountWeight = 5;
    $likedWeight = 20;
    $heartsWeight = 8;

   
    // target user (current cookie) for generating recommendation
    if (isset($_COOKIE["CookieUname"])) {
    $user_name = $_COOKIE["CookieUname"];
    $user_id = $db -> query("SELECT mId FROM Member WHERE user_name='$user_name'");
    $user_id = $user_id ->fetch();
    $target_user = $user_id[0];

    // consine similarity function
    function magnitude_cosine($user){
        $freqWeight = 15;
        $buyWeight = 30;
        $amountWeight = 5;
        $likedWeight = 20;
        $heartsWeight = 8;
        $sumOfSquares = 0;
        foreach($user as $item => $rating){
           $rates = $rating["browseFreq"] * $freqWeight + 
                    $rating["buyRecord"] * $buyWeight + 
                    $rating["buybuyamount"] * $amountWeight + 
                    $rating["userLiked"] * $likedWeight + 
                    $rating["hearts"] * $heartsWeight;
           
           $sumOfSquares += pow($rates, 2);

        }
        $magnitde = sqrt($sumOfSquares);
        return $magnitde;
    }
    function cosine_similarity($user1, $user2){
        // 權重：browseFreq * 8, buyRecord * 10, buybuyamount * 3
        $freqWeight = 15;
        $buyWeight = 30;
        $amountWeight = 5;
        $likedWeight = 20;
        $heartsWeight = 8;
        $dotProduct = 0;
        foreach($user1 as $item => $rating1){

            // echo  $rating1["browseFreq"] * $freqWeight;
            $rating_weight_1 =  $rating1["browseFreq"] * $freqWeight + 
                                $rating1["buyRecord"] * $buyWeight + 
                                $rating1["buybuyamount"] * $amountWeight + 
                                $rating1["userLiked"] * $likedWeight + 
                                $rating1["hearts"] * $heartsWeight;
            
           
            if(isset($user2[$item])){
                $rating2 = $user2[$item];
                $rating_weight_2 = $rating2["browseFreq"] * $freqWeight + 
                                   $rating2["buyRecord"] * $buyWeight + 
                                   $rating2["buybuyamount"] * $amountWeight + 
                                   $rating2["userLiked"] * $likedWeight + 
                                   $rating2["hearts"] * $heartsWeight;
                
                $dotProduct += $rating_weight_1 * $rating_weight_2;
                
            }
        }

        // magnitudes
        $magnitde1 = magnitude_cosine($user1);
        $magnitde2 = magnitude_cosine($user2);
       
        
        if($magnitde1 != 0 && $magnitde2 != 0){
            $similarity = $dotProduct / ($magnitde1 * $magnitde2);
        }
        else{
            $similarity = 0;
        }
        // echo $similarity."<br>";
        return $similarity;

    }
    // $freqWeight = 10;
    // $buyWeight = 30;
    // $amountWeight = 3;
    // calculate similarity between target user and other users based on multiple parameters
    $similarities = array();
 
    foreach($rating as $user => $items){
        if($user != $target_user){
            $similarities[$user] = cosine_similarity($rating[$target_user], $rating[$user]);
        }
    }
    

    // sort the similarity in descending orders (most similar user)
    arsort($similarities);
    // echo "thiswat";
    // print_r($similarities);
  

    $recommendations = array();
    foreach($similarities as $user => $similarity){
        foreach($rating[$user] as $item => $rate){
            if(!isset($rating[$target_user][$item])){

                $data = $rate["browseFreq"] * $freqWeight + 
                        $rate["buyRecord"] * $buyWeight + 
                        $rate["buybuyamount"] * $amountWeight +
                        $rate["userLiked"] * $likedWeight + 
                        $rate["hearts"] * $heartsWeight;
                // echo $data.": ".$item. "<br>";

                // if the item is not rated by target user 
                $recommendations[$item] = isset($recommendations[$item]) ? $recommendations[$item] + $data * $similarity : $data * $similarity;
            }
        }
    }

    asort($recommendations);
    // print_r($recommendations);
  
    // the return similarity is set as ascending order, where the last element of the recommendation is most recommended
    $recommend_pNo = array();
    foreach($recommendations as $pNo => $score){
        array_push($recommend_pNo, $pNo);
    }

    $recommend_pNo = array_reverse($recommend_pNo);

    // product to recommend 
    $recommend_pNo_formatted = implode(',', $recommend_pNo);
    
    // echo $recommend_pNo_formatted;
    // if the number of product is too little 
    $SQL = "SELECT DISTINCT pNo FROM Product WHERE pNo NOT IN ($recommend_pNo_formatted)";
    // echo $SQL;
    $rest_pNo = $db->query($SQL);
    
    $sub_recommend_pNo = array();
    foreach($rest_pNo as $pNo){
        array_push($sub_recommend_pNo, $pNo["pNo"]);
    }
   
    $user_recommend_pNo = array_merge($recommend_pNo, $sub_recommend_pNo);
    $user_recommend_pNo_formatted = implode(',', $user_recommend_pNo);
   
    $field = "pNo," . $user_recommend_pNo_formatted;
    }
?>



