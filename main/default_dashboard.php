

<?php
    require 'includes/db.php';
    require 'includes/other_functions.php';

    
    $user_name = $_COOKIE["CookieUname"];
    if(empty($user_name)){
        echo "no user";
    }
    $sql = "SELECT mId FROM `Member` WHERE `user_name`='$user_name'";
    $users = $db -> query($sql);
    foreach($users as $user_id){
        $user_id = $user_id[0];
    }

   
    // fetch the seller Id first 
    // Total Sales (OrderInfo, Product, Member)
    $sql = "SELECT SUM(O.oUnitPrice * O.amount) FROM OrderInfo O
            NATURAL JOIN Product P
            NATURAL JOIN Member M
            WHERE M.user_name='$user_name'";
    $total_sales = $db->query($sql);
    $total_sales = $total_sales -> fetch();
    // echo $sql;
    // compare to last week 
    // date_default_timezone_set('Taiwan/Taipei');
    $prev_week = date('Y-m-d', time() + 3600 * 6 - 3600 * 24 * 14);
    $curr_week = date('Y-m-d', time() + 3600 * 6 - 3600 * 24 * 7);
    $today =  date('Y-m-d', time() + 3600 * 6 + 3600 * 24);

    // sales of prev week (prev ~ curr)
    $prev_sql = "SELECT SUM(O.oUnitPrice * O.amount) FROM OrderInfo O
                NATURAL JOIN Product P
                NATURAL JOIN Member M
                WHERE M.user_name='$user_name'
                AND O.orderTime > '$prev_week'
                AND O.orderTime < '$curr_week'";

    
    $curr_sql = "SELECT SUM(O.oUnitPrice * O.amount) FROM OrderInfo O
                NATURAL JOIN Product P
                NATURAL JOIN Member M
                WHERE M.user_name='$user_name'
                AND O.orderTime > '$curr_week'
                AND O.orderTime < '$today'";
   

    $prev_week_sales = $db -> prepare($prev_sql);
    $prev_week_sales -> execute();
    $prev_week_sales = $prev_week_sales -> fetch();
    $curr_week_sales = $db -> prepare($curr_sql);
    $curr_week_sales -> execute();
    $curr_week_sales = $curr_week_sales -> fetch();

   
    $substract_week_sales = ($curr_week_sales[0] - $prev_week_sales[0]);
    if ($prev_week_sales[0] == 0) $prev_week_sales[0]=1;
    $week_sales_growth = round( (($substract_week_sales) / $prev_week_sales[0]),1);
    // echo $week_sales_growth;
    
    // Total Orders (num of orders) (OrderInfo, Product, Member)
    $sql = "SELECT DISTINCT COUNT(tNo) FROM OrderInfo O
            NATURAL JOIN Product P
            NATURAL JOIN Member M
            WHERE M.user_name='$user_name'";
    $total_orders = $db->query($sql);
    
    $total_orders = $total_orders -> fetch();

    $prev_sql = "SELECT DISTINCT COUNT(tNo) FROM OrderInfo O
                NATURAL JOIN Product P
                NATURAL JOIN Member M
                WHERE M.user_name='$user_name'
                AND O.orderTime > '$prev_week'
                AND O.orderTime < '$curr_week'";

    $curr_sql = "SELECT DISTINCT COUNT(tNo) FROM OrderInfo O
                NATURAL JOIN Product P
                NATURAL JOIN Member M
                WHERE M.user_name='$user_name'
                AND O.orderTime > '$curr_week'
                AND O.orderTime < '$today'";
    
    $prev_week_orders = $db->prepare($prev_sql);
    $prev_week_orders -> execute();
    $prev_week_orders = $prev_week_orders -> fetch();
    $curr_week_orders = $db->prepare($curr_sql);
    $curr_week_orders -> execute();
    $curr_week_orders = $curr_week_orders -> fetch();

    
    $substract_week_orders = ($curr_week_orders[0] - $prev_week_orders[0]);
    if ($prev_week_orders[0] == 0) $prev_week_orders[0] =1;
    $week_orders_growth = round((($substract_week_orders) / $prev_week_orders[0]),1);


    // Total Customers  (Transaction ->tNo<- OrderInfo, ->pNo<- Product, Member)
    $prev_sql = "SELECT DISTINCT T.mId FROM Product P
                JOIN OrderInfo O
                ON O.pNo = P.pNo
                JOIN Transaction T
                ON T.tNo = O.tNo
                JOIN Member M
                ON M.mId = P.mId
                WHERE M.user_name = '$user_name'
                AND O.orderTime > '$prev_week'
                AND O.orderTime < '$curr_week'";

    $curr_sql = "SELECT DISTINCT T.mId FROM Product P
                JOIN OrderInfo O
                ON O.pNo = P.pNo
                JOIN Transaction T
                ON T.tNo = O.tNo
                JOIN Member M
                ON M.mId = P.mId
                WHERE M.user_name = '$user_name'
                AND O.orderTime > '$curr_week'
                AND O.orderTime < '$today'";
      
    $prev_customers = $db -> prepare($prev_sql);
    $prev_customers -> execute();
    $prev_customers  = $prev_customers -> rowCount();
        
    $curr_customers = $db -> prepare($curr_sql);
    $curr_customers -> execute();
    $curr_customers  = $curr_customers -> rowCount();

    $customers_growth = $curr_customers - $prev_customers;


    // Top selling products (three at most) (OrderInfo (tNo, amount), Product, Member)
    // get every product sells amount -> sort it in order
    $sql = "SELECT *, COUNT(O.pNo) FROM Member M
            NATURAL JOIN Product P
            NATURAL JOIN OrderInfo O
            WHERE M.user_name='$user_name'
            GROUP BY O.pNo";
   
    $top_sellings = $db->prepare($sql);
    $top_sellings -> execute();
    $top_counts = $top_sellings -> rowCount();
    $top_sellings = $top_sellings -> fetchAll(PDO::FETCH_ASSOC);
    

    // Recent Orders (OrderInfo, Product)
    $sql = "SELECT P.pImage, P.pName, O.orderTime, M.user_name AS buyer FROM OrderInfo O
            NATURAL JOIN Product P
            JOIN Transaction T
            ON T.tNo = O.tNo
            JOIN Member M 
            ON T.mId = M.mId
            WHERE P.mId = '$user_id'
            ORDER BY o.orderTime DESC";

    $recent_orders = $db->prepare($sql);
    $recent_orders -> execute();
    $orders_count = $recent_orders -> rowCount();   

    
    

?>
<link rel="stylesheet" href="styles/selling_info/selling_info.css">
<div id="selling_board">
    <div class="left_part">
        <div class="upper">
            <div class="total_sales widget" style="background-color: #DBAE58">
                <div class="title">Total Sales</div>
                
                <div class="numbers"><?="$" . $total_sales[0];?></div>
                <div class="trend" id="sales_trend">
                        <div class="grow">
                            <?=$week_sales_growth."%"?>
                            <div id="sales_arrow"></div>
                            <span>  in the last week</span>
                        </div>
                        <script>
                           
                            if(<?=$substract_week_sales?> > 0){
                                trending_display("up", "sales_trend", "sales_arrow");
                            } else{
                                trending_display("down", "sales_trend", "sales_arrow");
                            }
                        </script>
                </div>
                
            </div>
            <div class="total_orders widget" style="background-color:  #A5D8DD">
                <div class="title">Total Orders</div>
                <div class="numbers"><?=$total_orders[0]?></div>
                <div class="trend" id="orders_trend">
                        <div class="grow">

                            <?=$week_orders_growth."%";?>
                            <div id="orders_arrow"></div>
                            <span>  in the last week</span>
                        </div>
                        <script>
                            console.log(<?=$week_orders_growth?>);
                            if(<?=$substract_week_orders?> > 0){
                                trending_display("up", "orders_trend", "orders_arrow");
                            } else{
                                trending_display("down", "orders_trend", "orders_arrow");
                            }
                        </script>
                </div>
            </div>
            <div class="total_customers widget" style="background-color: #dc9094">
                <div class="title">New Customers</div>
                <div class="numbers"><?=$curr_customers?></div>
                <div class="trend" id="customer_trend">
                        <div class="grow">
                            <?php
                                if($customers_growth >= 0){
                                    echo "+".$customers_growth;
                                }
                                else {
                                   
                                    echo $customers_growth;
                                }
                            // $customers_growth
                            ?>
                            
                            <div id="customers_arrow"></div>
                            <span> customers this week</span>
                        </div>
                        <script>
                            if(<?=$customers_growth?> > 0){
                                trending_display("up", "customer_trend", "customer_arrow");
                            } else{
                                trending_display("down", "customer_trend", "customer_arrow");
                            }
                        </script>
                </div>
            </div>
        </div>
        <div class="middle">
            <!-- <div class="buttons">
                <button onclick="get_tables(0)">Weekly Sales</button>
                <button onclick="get_tables(1)">Customer Growth</button>
            </div>
            -->
            <?php require 'get_tables.php'?>
            
        </div>
        <div class="bottom">
            <div class="top_selling">
                <div class="title">Top Selling Products</div>
                <div class="header">
                    <div class="product head">Product</div>
                    <div class="price head">Price</div>
                    <div class="orders head">Orders</div>
                    <div class="stock head">Stock</div>
                    <div class="amount head">Amount</div>
                </div>
                <div class="info">
                    <?php
                        if($top_counts < 3){
                            $top_most_num = $top_counts;
                        } else{
                            $top_most_num = 3;
                        }  

                        for($i = 0; $i < $top_most_num; $i++){   
                            $tops = $top_sellings[$i];
                            $amount = (int)$tops['COUNT(O.pNo)'] * (int)$tops['unitPrice'];
                    ?>
                        <div class="info_box">
                            <div class="first_header">
                                <div class="product_image"><img src='<?="images/".$tops["pImage"]?>'></div>
                                <div class="product_name"><?=$tops["pName"]?></div>
                            </div>
                            <div class="price head"><?= "$" . $tops["unitPrice"]?></div>
                            <div class="orders head"><?=$tops["COUNT(O.pNo)"]?></div>
                            <div class="stock head"><?=$tops["pStock"]?></div>
                            <div class="amount head"><?=$tops["amount"]?></div>
                        </div>
                    <?php
                        } // top selling foreach end
                    ?>
                        
                </div>
            </div>
        </div>
    </div>
    <div class="right_part">
        <div class="upper">
            <div class="recent_orders"> 
                <div class="title">Recent Order</div>
                <!-- orders -->
                <?php
                    foreach($recent_orders as $order){
                ?>
                        <div class="order_box">
                            
                            <div class="image_box"><img src="<?="images/".$order['pImage']?>"></div>
                            <div class="info_box">
                                <div class="pName"><?=$order['pName']?></div>
                                <div class="orderTime"><?=count_time($order['orderTime'])?></div>
                            </div>
                            <div class="price_box"><?=$order['buyer']?></div>
                           
                        </div>
                    
                <?php
                    }
                ?>
                
               
                
            </div>
        </div>
        <div class="bottom">
            <div class="message"></div>
        </div>
    </div>
</div>