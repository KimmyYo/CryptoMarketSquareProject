

<div class="main_header">
    <!-- header -->
    <div class="logo">
        <a href="index.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-coinbase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12.95 22c-4.503 0 -8.445 -3.04 -9.61 -7.413c-1.165 -4.373 .737 -8.988 4.638 -11.25a9.906 9.906 0 0 1 12.008 1.598l-3.335 3.367a5.185 5.185 0 0 0 -7.354 .013a5.252 5.252 0 0 0 0 7.393a5.185 5.185 0 0 0 7.354 .013l3.349 3.367a9.887 9.887 0 0 1 -7.05 2.912z"></path>
            </svg>
        </a>
    </div>
    <div class="top_nav">
        <div class="left_nav">
            <div class="crumb">Crypto Market Square</div>
        </div>
        <div class="right_nav">
            <?php 
                if(isset($_COOKIE["CookieUname"])){
                    $usernameoh = $_COOKIE['CookieUname'];

            ?>
            <div class="set_hashtag"># Found Your Hashtag</div>
                <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"/>
            <div class="input-box" id="search_button">
                <input type="text" id="search_input" placeholder="Search..." />
                <span class="search">
                    <i class="uil uil-search search-icon"  onclick="show_search();"></i>
                </span>
                <i class="uil uil-times close-icon" onclick="close_search();"></i>
                <script>
                    function show_search(){
                        $(".input-box").addClass('open');
                    }
                    function close_search(){
                        $(".input-box").removeClass('open');
                    }
                    $("#search_input").on('keypress', function(e){
                        if(e.which == "13"){
                            var search_content = $("#search_input").val();
                            $.ajax({
                                url: 'search_product.php',
                                type: 'POST',
                                data: {search_content: search_content},
                                success: function(response){
                                    // console.log(response);
                                    $(".products_section").empty();
                                    $(".products_section").html(response);
                                    $(".search_input").empty();
                                }
                            })
                        }
                      
                    })
                   
                </script>
            </div>
            <div class="user_head" id="user_head">
                <div class="user_login">
                    <div class="name" id="user_arrow"><?=$usernameoh;?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M6 9l6 6l6 -6"></path>
                        </svg>
                    </div>
                    <div id="leaving_box" style="display: none">
                        <div class="item"><a href="dashboard.php?user_name='<?=$usernameoh?>'">Dashboard</a></div>
                       
                        <div class="item"><a href="logout.php">Log Out</a></div>
                    </div>
                </div>
                
            </div>
        
            <div class="user_cart">
                <a href="cart.php"> 
                    <div class="cart_title">Your Cart</div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                        <path d="M17 17h-11v-14h-2"></path>
                        <path d="M6 5l14 1l-1 7h-13"></path>
                    </svg>  
                </a>
            </div>    
            
           
        <?php
            } else{
        ?>
       
            <div class="search">
                Search
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                <path d="M21 21l-6 -6"></path>
                </svg>
            </div>
            <div class="user_head" id="user_head">
                <a href="login.php">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    </svg>
                </a>
            </div>
        
            <?php
                }
                    
            ?>
               
        </div>
    </div>
</div>
</div>

<div class="stage">     <!-- 大平台 -->
    
    <div class="stage_inner">
        <div class="x close_stage">X</div>
        <div class="title">What's Your Preference?</div>
        <div class="textbox_title">Set up your own hashtags (At most 10 tags)</div>
        <div class="textbox_title">Hastags: Tags that represent your preferences.</div>
        <div class="textbox_title">Weights: How important do you think this label is.</div>
        <div class="textbox_title">Separated by enter key | form: #hashtag,weight</div>
        
        <!-- action="pair-out.php" -->
        <div class="write_tag">
            <form id="pair_out" method="post"> 
                <textarea id="tags" name="input_tag" class="tagbox" cols="32" rows="10" placeholder="#blue,5&#10;#convenient,3"></textarea>
                <!-- 送出表單 -->
                <button type="submit" class="button" onclick="get_hashtag();">Matching products</button>
            </form>
        </div>
    </div>
<!-- 送出表單 -->
</div>