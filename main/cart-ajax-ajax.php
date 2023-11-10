<?php
require 'includes/db.php';
$row = $db->query("SELECT * FROM Contain");

$user_name = $_COOKIE['CookieUname'];
$user_id = $db->query("SELECT mId FROM member WHERE user_name='$user_name'");
$user_id = $user_id->fetch();

$pNo = $_GET['pNo'];
$amount = $_GET['amount'];

$SQL = "UPDATE Contain SET amount = $amount WHERE pNo='$pNo' AND mId='$user_id[0]'";
$update = $db->prepare($SQL);
$update->execute();
?>