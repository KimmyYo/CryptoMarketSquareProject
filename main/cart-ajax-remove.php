<?php
require 'includes/db.php';

$pNo = $_GET['pNo'];

$SQL = "DELETE FROM Contain WHERE pNo=$pNo";
$update = $db->prepare($SQL);
$update->execute();
?>