
<!-- orderinfo一定要有東西 -->
<!-- orderinfo一定要有東西 -->
<!-- orderinfo一定要有東西 -->
<!-- orderinfo一定要有東西 -->

<?php
/**
*   一般產生訂單(全功能)範例
*/
    require 'includes/db.php';

    $test = $_POST['tprice'];
    $rowCount = $_POST['rowCount'];
    
    
    // $first = $db->query("SELECT tNo FROM `OrderInfo` Limit 1");
    // $first = $first -> fetch();
    
    // $first = (int)$first['tNo'];
    // $tNo = $first +1;        //製造tNo

    $paymethod = $_POST['paymethod'];   //付款荒逝
   
    

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $adress = $_POST['adress'];
    
    $remark = $_POST['remark'];

    // transaction區

    //要改
    $user_name = $_COOKIE["CookieUname"];
	$sql = "SELECT mId FROM `Member` WHERE `user_name`='$user_name'";
	$user = $db -> query($sql);
	$user = $user->fetch();

    
    $SQL = "INSERT INTO `Transaction`(`mId`, `paymethod`, `tAddress`, `tName`, `tPhone`, `remark`) VALUES ('$user[0]','$paymethod','$adress', '$name','$phone','$remark')";
    echo $SQL;
    $update = $db->prepare($SQL);
    $update->execute();
     
   

   
    // transaction區

    
    //載入SDK(路徑可依系統規劃自行調整)
    include('ECPay.Payment.Integration.php');
    try {
        
    	$obj = new ECPay_AllInOne();
   
        //服務參數
        $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";  //服務位置
        $obj->HashKey     = 'pwFHCqoQZGmho4w6' ;                                          //測試用Hashkey，請自行帶入ECPay提供的HashKey
        $obj->HashIV      = 'EkRm7iFT261dpevs' ;                                          //測試用HashIV，請自行帶入ECPay提供的HashIV
        $obj->MerchantID  = '3002607';                                                    //測試用MerchantID，請自行帶入ECPay提供的MerchantID
        $obj->EncryptType = '1';                                                          //CheckMacValue加密類型，請固定填入1，使用SHA256加密


        //基本參數(請依系統規劃自行調整)
        $MerchantTradeNo = "Test".time() ;
        $obj->Send['ReturnURL']         = "http://www.ecpay.com.tw/receive.php" ;     //付款完成通知回傳的網址
        $obj->Send['MerchantTradeNo']   = $MerchantTradeNo;                           //訂單編號
        $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                        //交易時間
        $obj->Send['TotalAmount']       = $test;                                       //交易金額
        $obj->Send['TradeDesc']         = "good to drink" ;                           //交易描述
        // $obj->Send['ChoosePayment']     = ECPay_PaymentMethod::ATM ;                  //付款方式:全功能

        switch($_POST['paymethod']) {
            case "COD":
                $obj->Send['ChoosePayment'] = ECPay_PaymentMethod::ALL;
                break;
            case "CRD":
                $obj->Send['ChoosePayment'] = ECPay_PaymentMethod::Credit ;
                break;
            case "ATM":
                $obj->Send['ChoosePayment'] = ECPay_PaymentMethod::ATM ;
                break;
            case "COIN":
                $obj->Send['ChoosePayment'] = ECPay_PaymentMethod::ALL;
                break;
        }


        //訂單的商品資料
        // array_push($obj->Send['Items'], array('Name' => "不會真的想付款吧？", 'Price' => (int)"8888",
        //            'Currency' => "元", 'Quantity' => (int) "6666", 'URL' => "dedwed"));


        for ($i=1; $i<=$rowCount; $i++) {
            $pNo = $_POST['order_pNo'.$i];
            $product = $db->query("SELECT * FROM Product WHERE pNo='$pNo'");
            $product = $product -> fetch();
            $amount = $db->query("SELECT amount FROM Contain WHERE pNo='$pNo' AND mId='$user[0]'");
            $amount = $amount->fetch();
            $tNo = $db->query("SELECT tNo FROM Transaction ORDER BY tNo DESC LIMIT 1");
            $tNo = $tNo -> fetch();

            $SQL = "INSERT INTO OrderInfo(`tNo`, `pNo`, `oUnitPrice`, `amount`, `orderTime`) VALUES ('$tNo[0]','$pNo','$product[unitPrice]','$amount[amount]', NOW())";
            echo $SQL;
            $update = $db->prepare($SQL);
            $update->execute();     //新增訂單資料
           


            $SSQL = "DELETE FROM Contain WHERE pNo=$pNo AND mId=$user[0]";
            $delete = $db->prepare($SSQL);
            $delete->execute();

            $SSSQL = $db->query("SELECT pStock FROM product WHERE pNo='$pNo'");
            $SSSQL = $SSSQL->fetch();
            $newStock = $SSSQL['pStock'] - $amount['amount'];
            $SSSQL = "UPDATE `product` SET `pStock`='$newStock' WHERE pNo='$pNo'";
            $update = $db->prepare($SSSQL);
            $update->execute();
            



            array_push($obj->Send['Items'], array('Name' => $product['pName'], 'Price' => (int)$product['unitPrice'],
                   'Currency' => "元", 'Quantity' => (int) $amount['amount'], 'URL' => "dedwed"));
        }

        # 電子發票參數
        /*
        $obj->Send['InvoiceMark'] = ECPay_InvoiceState::Yes;
        $obj->SendExtend['RelateNumber'] = "Test".time();
        $obj->SendExtend['CustomerEmail'] = 'test@ecpay.com.tw';
        $obj->SendExtend['CustomerPhone'] = '0911222333';
        $obj->SendExtend['TaxType'] = ECPay_TaxType::Dutiable;
        $obj->SendExtend['CustomerAddr'] = '台北市南港區三重路19-2號5樓D棟';
        $obj->SendExtend['InvoiceItems'] = array();
        // 將商品加入電子發票商品列表陣列
        foreach ($obj->Send['Items'] as $info)
        {
            array_push($obj->SendExtend['InvoiceItems'],array('Name' => $info['Name'],'Count' =>
                $info['Quantity'],'Word' => '個','Price' => $info['Price'],'TaxType' => ECPay_TaxType::Dutiable));
        }
        $obj->SendExtend['InvoiceRemark'] = '測試發票備註';
        $obj->SendExtend['DelayDay'] = '0';
        $obj->SendExtend['InvType'] = ECPay_InvType::General;
        */


        //產生訂單(auto submit至ECPay)
        $obj->CheckOut();
      

    
    } catch (Exception $e) {
    	echo $e->getMessage();
    } 


 
?>