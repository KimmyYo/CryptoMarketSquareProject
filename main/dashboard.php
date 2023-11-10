<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/dash_board/dash_board.css">
    <link rel="stylesheet" href="styles/product/product.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
   
   

</head>
<body>
    
<?php
if(isset($_COOKIE["CookieUname"])){
?>
    <!-- main-box -->
    <div class="whole_box">
        <!-- side_menu -->
        <div class="side_menu">
            <div class="user">
                <div class="user_img">
                    <img src="images/default_head.png" />
                </div>
                <div class="welcome_message">
                    Welcome Back! <?=$_COOKIE["CookieUname"];?>
                </div>
            </div>
            <!-- Dashboard 目錄 -->
            <div class="menu_box" id="side-menu">
                <div class="link_to" data-id="dashboard-widget-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
   <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
   <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"></path>
</svg>
                      <!-- when clicked, go to upload page -->
                    Profile
                </div>
                 <div class="link_to" data-id="dashboard-widget-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-pie-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M9.883 2.207a1.9 1.9 0 0 1 2.087 1.522l.025 .167l.005 .104v7a1 1 0 0 0 .883 .993l.117 .007h6.8a2 2 0 0 1 2 2a1 1 0 0 1 -.026 .226a10 10 0 1 1 -12.27 -11.933l.27 -.067l.11 -.02z" stroke-width="0" fill="currentColor"></path>
                        <path d="M14 3.5v5.5a1 1 0 0 0 1 1h5.5a1 1 0 0 0 .943 -1.332a10 10 0 0 0 -6.11 -6.111a1 1 0 0 0 -1.333 .943z" stroke-width="0" fill="currentColor"></path>
                     </svg>
                      <!-- when clicked, go to upload page -->
                    Dashboard
                </div>
                <div class="link_to" data-id="dashboard-widget-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-rounded-plus-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 2l.324 .001l.318 .004l.616 .017l.299 .013l.579 .034l.553 .046c4.785 .464 6.732 2.411 7.196 7.196l.046 .553l.034 .579c.005 .098 .01 .198 .013 .299l.017 .616l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.464 4.785 -2.411 6.732 -7.196 7.196l-.553 .046l-.579 .034c-.098 .005 -.198 .01 -.299 .013l-.616 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.785 -.464 -6.732 -2.411 -7.196 -7.196l-.046 -.553l-.034 -.579a28.058 28.058 0 0 1 -.013 -.299l-.017 -.616c-.003 -.21 -.005 -.424 -.005 -.642l.001 -.324l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.464 -4.785 2.411 -6.732 7.196 -7.196l.553 -.046l.579 -.034c.098 -.005 .198 -.01 .299 -.013l.616 -.017c.21 -.003 .424 -.005 .642 -.005zm0 6a1 1 0 0 0 -1 1v2h-2l-.117 .007a1 1 0 0 0 .117 1.993h2v2l.007 .117a1 1 0 0 0 1.993 -.117v-2h2l.117 -.007a1 1 0 0 0 -.117 -1.993h-2v-2l-.007 -.117a1 1 0 0 0 -.993 -.883z" fill="currentColor" stroke-width="0"></path>
                     </svg>
                      <!-- when clicked, go to upload page -->
                    Upload
                </div>
                <div class="link_to" data-id="dashboard-widget-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-box-bottom-right-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18.333 2c1.96 0 3.56 1.537 3.662 3.472l.005 .195v12.666c0 1.96 -1.537 3.56 -3.472 3.662l-.195 .005h-12.666a3.667 3.667 0 0 1 -3.662 -3.472l-.005 -.195v-12.666c0 -1.96 1.537 -3.56 3.472 -3.662l.195 -.005h12.666zm-6.333 13a1 1 0 0 0 -1 1v2l.007 .117a1 1 0 0 0 1.993 -.117v-2l-.007 -.117a1 1 0 0 0 -.993 -.883zm3 -4a1 1 0 0 0 -1 1v6l.007 .117a1 1 0 0 0 1.993 -.117v-6l-.007 -.117a1 1 0 0 0 -.993 -.883zm3 2a1 1 0 0 0 -1 1v4l.007 .117a1 1 0 0 0 1.993 -.117v-4l-.007 -.117a1 1 0 0 0 -.993 -.883z" stroke-width="0" fill="currentColor"></path>
                    </svg>
                   
                    Analysis
                   
                </div>
                <div class="link_to" data-id="dashboard-widget-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hanger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M14 6a2 2 0 1 0 -4 0c0 1.667 .67 3 2 4h-.008l7.971 4.428a2 2 0 0 1 1.029 1.749v.823a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-.823a2 2 0 0 1 1.029 -1.749l7.971 -4.428"></path>
                     </svg>
                    Products
                </div>
                <div class="link_to" data-id="dashboard-widget-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M6.979 3.074a6 6 0 0 1 4.988 1.425l.037 .033l.034 -.03a6 6 0 0 1 4.733 -1.44l.246 .036a6 6 0 0 1 3.364 10.008l-.18 .185l-.048 .041l-7.45 7.379a1 1 0 0 1 -1.313 .082l-.094 -.082l-7.493 -7.422a6 6 0 0 1 3.176 -10.215z" stroke-width="0" fill="currentColor"></path>
                    </svg>
                    Favorite
                </div>
            </div>
        </div>
        <?php require 'main_header.php';?>
        <!-- dash_board -->
        <div class="dashboard" id="dashboard">
           
            <!-- upload section -->
            <div id="dashboard-widget-1" class="dashboard-widget">
                <div id="dashboard-widget-1-content"></div>
            </div>
            <!-- analytics section -->
            <div id="dashboard-widget-2" class="dashboard-widget">
                <div id="dashboard-widget-2-content"></div>
            </div>
            <!-- product section -->
            <div id="dashboard-widget-3" class="dashboard-widget">
                <div id="dashboard-widget-3-content"></div>
            </div>
            <div id="dashboard-widget-4" class="dashboard-widget">
                <div id="dashboard-widget-4-content"></div>
                
            </div> 
            <div id="dashboard-widget-5" class="dashboard-widget">
                <div id="dashboard-widget-5-content"></div>
            </div>
            <div id="dashboard-widget-6" class="dashboard-widget">
                <div id="dashboard-widget-6-content"></div>
            </div>

            <div id="dashboard_default" class="dashboard-widget">
                <?php require 'default_dashboard.php'?>
            </div>
          
           
        </div>
    </div>
<?php
} else {
    header("Location: logindex.php");
}
?>

    

</body>
</html>




















 <!-- <div class="upper">
    <div class="total" id="revenue">
        <div class="title">Total Revenue</div>
        <div class="number">$ 299.35</div>
    </div>
    <div class="total" id="customer">
        <div class="title">Total Customers</div>
        <div class="number">3000</div>
    </div>
    <div class="total" id="profit">
        <div class="title">Total Profit</div>
        <div class="number">$ 100.35</div>
    </div>
</div> -->