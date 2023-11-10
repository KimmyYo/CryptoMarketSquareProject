<link rel="stylesheet" href="styles/profile/profile.css">
<?php

    require 'includes/db.php';

    $user_name = $_COOKIE["CookieUname"];
    // SELECT current user profile and store name 
    $SQL = "SELECT * FROM Member M
            NATURAL JOIN Seller S
            WHERE M.user_name='$user_name'
            ";
    
    $profile_contents = $db -> prepare($SQL);
    $profile_contents -> execute();
    
    foreach($profile_contents as $profile){
        $user_name = $profile["user_name"];
        $user_image = $profile["mImage"];
        $store_name = $profile["storeName"];
        $public_key = $profile["publicKey"];

    }

?>
<div class="profile_page">
    <div class="image_box">
        <div class="image"><img src="<?="images/" . $user_image?>"></div>
    </div>
    <div class="name_box">
        <div class="image"><img src="<?="images/" . $user_image?>"></div>
        <div class="name"><?=$store_name?></div>
    </div>
    <button id="profile_edit" onclick="show_profile_edit();">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
        <path d="M13.5 6.5l4 4"></path>
        </svg>
    </button>
</div>

<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"/>
<div id="profile_edit_area">
    <div class="edit_box">
        <label>Store Name</label>
        <input type="text" name="store_name" id="store_name"value="<?=$store_name?>">
        <label> Public Key
        <input type="text" name="public_key" id="public_key" value="<?=$public_key?>">
        <button onclick="change_profile()">Edit</button>
        <i class="uil uil-times close-icon" onclick="close_edit_profile();"></i>
    </div>
</div>


<script>
    function show_profile_edit(){
        $("#profile_edit_area").toggle();
    }
    function change_profile(user_name){
        var new_store_name = $("#store_name").val();
        var public_key = $("#public_key").val();
        // console.log(public_key);
      
        $.ajax({
            url: 'profile_edit_ajax.php',
            type: 'POST',
            data: {store_name: new_store_name, public_key: public_key},
            success: function(response){
                console.log(response);
                alert("Profile Changed!");
                $("#profile_edit_area").toggle();
            }
        })
    }
    function close_edit_profile(){
        $("#profile_edit_area").toggle();
    }
   
</script>