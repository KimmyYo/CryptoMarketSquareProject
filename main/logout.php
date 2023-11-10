<?php 
setcookie("CookieUname", "", time() - 1);
setcookie("CookiePass", "", time() - 1);


header("Location: index.php");
?>