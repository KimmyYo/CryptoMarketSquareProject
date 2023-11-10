<?php include 'includes/db.php'?>
<?php 


if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['re_password'])) {
	
	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);
	$re_pass = validate($_POST['re_password']);
	


	if (empty($uname)) {
		header("Location: signup.php?error=Username is required");
	    exit();
	
	
	}else if(empty($pass)){
        header("Location: signup.php?error=Password is required");
	    exit();

	}
	
	else if(empty($re_pass)){
		
        header("Location: signup.php?error=Re Password is required");
	    exit();
	}

	else if($pass !== $re_pass){
        header("Location: signup.php?error=The Confirmation Password does not match");
	    exit();
	}

	else{
		$result = $db->query("SELECT * FROM member WHERE user_name='$uname'");
	

		if (!empty($result->fetch())) {
			header("Location: signup.php?error=The Username is taken. Try another");
	        exit();
		
		}else {
           	$signUpData = array(':user_name' => $uname, ':pass' => $pass);
			$SQL = "INSERT INTO `member` (`user_name`, `password`) VALUES(:user_name, :pass)";
			$SIGNUP = $db->prepare($SQL);
			$SIGNUP->execute($signUpData);
			
			$SQL = "SELECT mId FROM Member WHERE user_name='$uname'";
			$user_id = $db -> query($SQL);
			$user_id = $user_id -> fetch();
			
			print_r($user_id[0]);
			$default_store_name = '"'.$uname. "'s Store" . '"';
			$SQL = "INSERT INTO `Seller`(`mId`, `storeName`) VALUES ('$user_id[0]', " . $default_store_name . ")";
			// echo $SQL;
			$db -> exec($SQL);

           	if ($signUpData) {
            	header("Location: logindex.php?success=Your account has been created successfully");
	        	exit();

           }else {
	           	header("Location: signup.php?error=Unknown error occurred");
		        exit();
           }
		}
	}
	
}else{
	
	header("Location: signup.php");
	exit();
}