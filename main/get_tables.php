<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<?php
// 賣家 mId 
    $user_name = $_COOKIE["CookieUname"];
    $SQL = "SELECT mId FROM Member WHERE user_name = '$user_name'";
    $sellermId = $db -> query($SQL);
    $sellermId = $sellermId -> fetch();
    $sellermId = $sellermId[0];



//WEEKLY SALES 折線圖
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
    // print_r($week_data);

    // encode to javascript format
    $js_week_data = json_encode($week_data);
    require 'get_chart.php';
?>
<div class="chart">
    <div class="title">Weekly Sales</div>
    <canvas class="myChart" style="width:100%;max-width:700px"></canvas>
  
    <script>
        
        var xy_values = weekly_data_process(<?=$js_week_data?>);
        console.log(xy_values);
        var options = {
            type: "line",
            data: {
                labels: xy_values[0],
                datasets: [{
                    label: 'Sales',
                    fill: false,
                    lineTension: 0,
                    pointBackgroundColor: "#1C4E808",
                    pointBorderColor: "#1C4E80",
                    backgroundColor: "#1C4E80",
                    borderColor: " #1C4E80",
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
        var myChart = $(".myChart");
        new Chart(myChart, options);
    </script>

</div>

