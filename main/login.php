<?php include 'includes/db.php'?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<?php 
	

	if (isset($_POST['uname']) && isset($_POST['password'])) {

		function validate($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
		}

		$uname = validate($_POST['uname']);
		$pass = validate($_POST['password']);

		if (empty($uname)) {
			header("Location: logindex.php?error=Username is required");
			exit();

		}else if(empty($pass)){
			header("Location: logindex.php?error=Password is required");
			exit();

		}else{
			$result = $db->query("SELECT * FROM member WHERE `user_name`='$uname' AND `password`='$pass'");

			if (!empty($result->fetch())) {
				$row = $result->fetch();
				if (1) {
					$expireTime = time() + 60*60*24*7;
					session_start();
					setcookie("CookieUname", $uname, $expireTime);
					echo "session created!";
					// echo $_COOKIE["CookieUname"];
					// setcookie("CookiePass", $pass, $expireTime);
					header("Location: index.php");
				?>
					
				<?php
					exit();
				}else{
					header("Location: logindex.php?error=Incorrect Username or Password");
					exit();
				}
			}else{
				header("Location: logindex.php?error=Incorect Username or Password");
				exit();
			}
		}
		
	}else{
		header("Location: logindex.php");
		exit();
	}
?>