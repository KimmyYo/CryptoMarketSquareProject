
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2 "></script>

<link rel="stylesheet" href="styles/charts_board/charts_board.css">
<?php

require 'includes/db.php';
require 'includes/other_functions.php';
require 'get_chart.php';

// RETRIEVE SELLER mId
$user_name = $_COOKIE["CookieUname"];
$SQL = "SELECT mId FROM Member WHERE user_name = '$user_name'";
$sellermId = $db -> query($SQL);
$sellermId = $sellermId -> fetch();
$sellermId = $sellermId[0];


// WEEKLY SALES
$SQL = "SELECT DATE(o.orderTime), SUM(oUnitPrice * amount) FROM OrderInfo O
NATURAL JOIN Product P
NATURAL JOIN Member M
WHERE M.user_name = '$user_name'
GROUP BY DATE(o.orderTime)
ORDER BY `DATE(o.orderTime)` DESC"; 

$week_sales = $db -> prepare($SQL);
$week_sales -> execute();
$day_count = $week_sales -> rowCount();

$week_data = array();
foreach($week_sales as $daily_sales){
    // detect date
    array_push($week_data, array($daily_sales[0], $daily_sales[1]));
}

// encode to javascript format
$js_week_data = json_encode($week_data);




// WEEKLY CUSTOMERS 成長圖 Find_Customers(Transaction) ->> 找自家產品(OrderInfo, Product, Member)
$SQL = "SELECT DATE(O.OrderTime), COUNT(DISTINCT T.mId), T.mId 
        FROM Transaction T 
        NATURAL JOIN OrderInfo O 
        WHERE O.pNo IN 
        (SELECT pNo FROM Product WHERE mId = '$sellermId')
        GROUP BY DATE(O.orderTime)
        ORDER BY DATE(O.orderTime) DESC";

$week_customer_growth = $db -> prepare($SQL);
$week_customer_growth -> execute();
$days_count = $week_customer_growth -> rowCount();

//// 儲存個欄位在新的array and encode to json
$week_customers = array();
$check_customers = array();

foreach($week_customer_growth as $days_customers){
   
    if(!in_array($days_customers[2], $check_customers)){
        array_push($check_customers, $days_customers[2]);
    }
    array_push($week_customers, array($days_customers[0], $days_customers[1]));

    
}
$js_week_customers = json_encode($week_customers);


// 熱賣 Hasgtag 長條圖 (OrderInfo, Product) -> split Hashtag
$SQL = "SELECT hashtag FROM OrderInfo O
        NATURAL JOIN Product P
        WHERE P.mId = $sellermId";
$sold_hashtags = $db -> prepare($SQL);
$sold_hashtags -> execute();

// //// store hashtage separately to array
$tags_sold = array();
foreach($sold_hashtags as $ROW){

    $tags_array = explode("#", $ROW[0]);
    $tags_array = array_filter($tags_array);

    foreach($tags_array as  $tag){
        array_push($tags_sold, $tag);
    }
    
}
$js_tags_sold = json_encode($tags_sold);



// 產品類別 販賣比例 圓餅圖
$SQL = "SELECT category, COUNT(category) FROM OrderInfo O
        NATURAL JOIN Product P
        WHERE P.mId = '$sellermId'
        GROUP BY p.category";

$category_prop = $db -> prepare($SQL);
$category_prop -> execute();
$category_count = $category_prop -> rowCount();

$sold_category_prop = array();
foreach($category_prop as $category_data){
    array_push($sold_category_prop, array($category_data[0], $category_data[1]));
}

$js_sold_category = json_encode($sold_category_prop);



?>

<div class="charts_box">
<div class="chart">
    <div class="left">
        <div class="up">
            <div class="title">Total Sales</div>
            <div class="brief" id="total_brief">
                <script>
                    function format(date){
                        console.log(date);
                        var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        var month = date.getMonth();
                        var day = String(date.getDate()).padStart(2, '0');
                        var formatted =  months[month] + '  ' + day;
                        return formatted;
                    }
                    var now = new Date();
                    var today = format(now);
                    var last_week = new Date(now.getFullYear(), now.getMonth(), now.getDate() - 7);
                    last_week = format(last_week);
                   
                    
                    $("#total_brief").html(last_week + " - " + today);
                </script>
            </div>
            <div class="content" id="total_sales_w"></div>
        </div>
        <div class="up">
            <div class="title">Top Sales</div>
            <div class="brief" id="top_brief"></div>
            <div class="content" id="top_sales_w"></div>
        </div>

    </div>
    <div class="main">
        <div class="title">Weekly Sales</div>
        <div class="brief_desc">Sales growth of this week</div>
        <canvas id="weekly_sales_chart"></canvas>
    </div>
</div>
<script>
        
        var xy_values = weekly_data_process(<?=$js_week_data?>);
        for(let i = 0; i < xy_values[1].length; i++){
          
            xy_values[1][i] = xy_values[1][i] / 1000;
        }
        var sum = xy_values[1].reduce((pv, cv) => pv + cv, 0);
        sum = Math.round(sum * 100) / 100;
        $("#total_sales_w").html("$" + sum + "k");
        
        var tops = Math.max.apply(Math, xy_values[1]);
      
        var index = xy_values[1].indexOf(Math.max.apply(Math, xy_values[1]));
        tops = Math.round(tops * 100) / 100;
        
        console.log(xy_values[0][index]);
        $("#top_brief").html(xy_values[0][index]);
        $("#top_sales_w").html("$" + tops + "k");
        console.log("lalal" + xy_values[1]);
        var options = {
            type: "line",
            data: {
                labels: xy_values[0],
                datasets: [{
                    label: 'Sales',
                    fill: false,
                    lineTension: 0,
                    pointBackgroundColor: '#488A99',
                    pointBorderColor:  '#488A99',
                    backgroundColor:  '#488A99',
                    borderColor:  '#488A99',
                    data: xy_values[1]
                }]
            },
            options: {
                legend: {
                    display: true,
                    text: 'Sales',
                    "position": "top",
                    "align": "end"
                    
                }
               
            }
        }


        // render charts
        var myChart = $("#weekly_sales_chart");
        new Chart(myChart, options);
    </script>



<div class="chart">
    <div class="main">
        <div class="title">Weekly Customers</div>
        <div class="brief_desc">Customer growth in this week</div>
        <canvas id="weekly_customers_chart" style="width: 700px;"></canvas>
    </div>
    <div class="left">
        <div class="up" id="total_customers">
            <div class="title">Total Customers</div>
            <div class="brief" id="total_brief"></div>
            <div class="content" id="total_cust_w"><span><?=count($check_customers)?> </span>Special Customers</div>
        </div>
    </div>
</div>
<script>
    // CHART DATA PROCESSING
    xy_values = weekly_data_process(<?=$js_week_customers?>);
    
    // RENDER CHART
    var options = {
        type: "line",
        data: {
            labels: xy_values[0],
            datasets: [{
                label: 'Customers',
                fill: false,
                lineTension: 0,
                pointBackgroundColor:  "#488A99",
                pointBorderColor: " #488A99",
                backgroundColor: " #488A99",
                borderColor: " #488A99",
                data: xy_values[1]
            }]
        },
        options: {
            legend: {
                display: true,
                text: 'Sales',
                "position": "top",
                "align": "end"
                
            },
            scales: {
                yAxes: [{
                    ticks: {
                    beginAtZero: true,
                    callback: function(value) {if (value % 1 === 0) {return value;}}
                    }
                }]
            }
        }
    }


    // render charts
    var myChart = $("#weekly_customers_chart");
    new Chart(myChart, options);
</script>

<div class="chart">
        <div class="left">
            <div class="up" id="total_customers">
                <div class="title">Best 3 Hashtags</div>
                <div class="brief"></div>
                <div class="content" id="best_tags"></div>
            </div>
        </div>
    <div class="main">
        <div class="title">Hot Hashtags #</div>
        <div class="brief_desc">Best Selling 10 Hashtags</div>
        <canvas id="best_sold_tags"></canvas>
    </div>
</div>
<script>
    xy_values = best_tags_process(<?=$js_tags_sold?>);
    console.log("heejgiowqgqgrqgq");
    console.log(xy_values[1].sort().reverse());
    if(xy_values[1].length < 3){
        x_length = xy_values[1].length;
    }else{
        x_length = 3;
    }
    for(let i = 0; i < x_length; i++)
        $("#best_tags").append("<div>#" + xy_values[0][i] + "</div>");

    options = {
        type: 'bar',
        data: {
            labels: xy_values[0],
            datasets: [{
                label: 'Hashtags',
                fill: false,
                lineTension: 0,
                pointBackgroundColor: "#20283E",
                pointBorderColor: "#20283E",
                backgroundColor: "#20283E",
                borderColor: "#20283E",
                data: xy_values[1]
            }]
        },
        options: {
            legend: {
                display: true,
                text: 'Hashtags',
                "position": "top",
                "align": "end"
                
            },
            scales: {
                yAxes: [{
                    ticks: {
                    beginAtZero: true,
                    callback: function(value) {if (value % 1 === 0) {return value;}}
                    }
                }]
            }
        }

    }

    var tags_chart = $("#best_sold_tags");
    new Chart(tags_chart, options);
</script>

<div class="chart" id="cate_chart">
  
    <div class="main">
        <div class="title">Category Sales</div>
        <div class="brief_desc">Proportion of sold category</div>
        <canvas id="category_prop" ></canvas>
    </div>
    <div class="left">
        <div class="up" id="total_customers">
            <div class="title">Best Selling Category</div>
            <div class="brief"></div>
            <div class="content" id="best_cate"></div>
        </div>
    </div>
</div>
<script>

    xy_values = proportion_process(<?=$js_sold_category?>);
    console.log(xy_values);
    console.log(xy_values[1].sort().reverse());
   
    if(xy_values[1].length < 3){
        x_length = xy_values[1].length;
    }else{
        x_length = 3;
    }
    
    for(let i = 0; i < x_length; i++)
        $("#best_cate").append("<div>" + xy_values[0][i] + "</div>");

    background_colors = [
        'rgb(255, 99, 132)', // Red
        'rgb(255, 159, 64)', // Orange
        'rgb(255, 205, 86)', // Yellow
        'rgb(75, 192, 192)', // Teal
        'rgb(153, 102, 255)', // Purple
        'rgb(255, 0, 0)', // Bright Red
        'rgb(0, 255, 0)', // Bright Green
        'rgb(0, 0, 255)', // Blue
    ]
    b_colors = [
        "#488A99", "#AC3E31", "#484848", "#DBAE58", "#DADADA", "#20283E", "#000000"
    ];
    // console.log(background_colors.slice(0, xy_values[0].length));
    c_options = {
        type: 'pie',
        data: {
            labels: xy_values[0],
            datasets: [
                {
                    data: xy_values[1],
                    backgroundColor: b_colors.slice(0, xy_values[0].length),
                    
                }
            ],
        },
        options:{
            plugins: {
                datalabels: {
                    formatter: (value) => {
                    return value * 100 + '%';
                    },
                },
            },
            legend: {
                display: true,
                text: 'Sales',
                "position": "left",
                "align": "end"
                
            }
              
        },
    }

    var cate_prop = $("#category_prop");
    new Chart(cate_prop, c_options);
</script>


</div>




