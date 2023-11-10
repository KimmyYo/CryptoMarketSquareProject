<?php
    require 'includes/db.php';

    $user_name = $_COOKIE["CookieUname"];
    
    $SQL = "SELECT *, h.mId as userid FROM heartRecord h
            JOIN Product P ON h.pNo = P.pNo
            JOIN Member M ON h.mId = M.mId
            WHERE M.user_name = '$user_name'
            ORDER BY P.pNo DESC";
    $user_favorite = $db -> prepare($SQL);
    $user_favorite -> execute();
    $fave_count  = $user_favorite -> rowCount();
?>
<link rel="stylesheet" href="styles/fave/fave.css">
<script src="script.js"></script>
<div class="title" id="fave_title">Your Favorite</div>
<div class="fave_page">

<?php
if($fave_count > 0){
    foreach($user_favorite as $fave){
        
?>  
        <div class="fave_box" id="box">
            <div class="image"><img src="<?="images/".$fave["pImage"]?>"></div>
            <div class="pname">
                <?=$fave["pName"]?> 
                <span class="category"><?=$fave["category"]?></span>
            </div>
            <div class="hashtag"><?=$fave["hashtag"]?></div>
            <div class="price">
                <button class="heart" onclick="fave_delete(this,<?=$fave['pNo']?>, <?=$fave['userid']?>)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M6.979 3.074a6 6 0 0 1 4.988 1.425l.037 .033l.034 -.03a6 6 0 0 1 4.733 -1.44l.246 .036a6 6 0 0 1 3.364 10.008l-.18 .185l-.048 .041l-7.45 7.379a1 1 0 0 1 -1.313 .082l-.094 -.082l-7.493 -7.422a6 6 0 0 1 3.176 -10.215z" stroke-width="0" fill="currentColor"></path>
                    </svg>
                </button>
                $<?=$fave["unitPrice"]?>
            </div>
            
            
        </div>


<?php
    }
} else{
    echo "Find your products!";
}

?>
</div>

