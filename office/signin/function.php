<?php
	include('../assets/php/sql_conn.php');
	$fn = '';
	if(isset($_POST["fn"])){
	$fn = $_POST["fn"];
	}
	
	//Login function
	if($fn == 'doLogin'){
		$return_result = array();
		$username = $_POST["username"];
		$password = $_POST["password"];
		$status = true;
		
		//$v = "'".$param1."','".$param2."'";		
		
		try {
			$sql = "SELECT * FROM login WHERE username = '".$username."' && password = '".$password."'";
			$result = $mysqli->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_array();
				$login_id = $row['login_id'];			
				$username = $row['username'];			
				$password = $row['password'];			
				$profile_name = $row['profile_name'];
				$_SESSION["username"] = $username;
				$_SESSION["password"] = $password;			
				$_SESSION["profile_name"] = $profile_name;			
				$_SESSION["login_id"] = $login_id;
			} else {
				$status = false;
			}
			//$mysqli->close();
		} catch (PDOException $e) {
			die("Error occurred:" . $e->getMessage());
		}

		$return_result['status'] = $status;
		sleep(2);
		echo json_encode($return_result);
	}//end function doLogin
	
	//Login function
	if($fn == 'updateProfile'){
		$return_result = array();
		$profile_name = $_POST["profile_name"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$status = true;			
		
		$sql = "UPDATE login SET profile_name = '" .$profile_name. "', username = '".$username."', password = '".$password."' WHERE login_id = 1";
		$result = $mysqli->query($sql);
		$ststus = true;
		//$mysqli->close();

		$return_result['status'] = $status;
		sleep(2);
		echo json_encode($return_result);
	}//end function doLogin

    ?>