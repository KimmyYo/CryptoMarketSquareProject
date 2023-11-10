<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script>
     var nameInput = $("#name").val();
    var phoneInput = $("#phone").val();
    var addressInput = $("#adress").val();
    var remarkInput = $("#remark").val();
    console.log(nameInput, phoneInput, addressInput, remarkInput);
</script> -->

<?php

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    require 'includes/db.php';

    // $test = $_GET['test'];
    $name = $_GET['name'];
    $phone = $_GET['pphone'];
    $adress = $_GET['address'];
    $remark = $_GET['remark'];
    
    $user_name = $_COOKIE["CookieUname"];
    $sql = "SELECT mId FROM `Member` WHERE `user_name`='$user_name'";
    $user = $db -> query($sql);
    $user = $user->fetch();
    
    $SQL = "INSERT INTO `Transaction`(`mId`, `paymethod`, `tAddress`, `tName`, `tPhone`, `remark`) VALUES ('$user[0]','Crypto','$adress', '$name','$phone','$remark')";
    $update = $db->prepare($SQL);
    $update->execute();
    
    $pNoString = $_GET['pNo'];
    $pNo = explode(",", $pNoString);
    
    $amountString = $_GET['amount'];
    $amount = explode(",", $amountString);


    for ($i=0; $i <999; $i++) {
        if (!isset($pNo[$i])) break;
        $stock = $db->query("SELECT pStock FROM product WHERE pNo='$pNo[$i]'");
        $stock = $stock->fetch();
        $newstock = $stock['pStock'] - (int)$amount[$i];

        $SQL = "DELETE FROM Contain WHERE pNo='$pNo[$i]' AND mId='$user[0]'";
        $delete = $db->prepare($SQL);
        $delete->execute();

        $SSQL = "UPDATE product SET pStock='$newstock' WHERE pNo='$pNo[$i]'";
        $update = $db->prepare($SSQL);
        $update->execute();
    }

}
else
    echo "111";

?>