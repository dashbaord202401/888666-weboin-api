<?php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
	// header("content-Type: application/JSON");

	include_once 'database.php';

	$database = new Database();

	// $con = $database->getConnection($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
	$con = $database->getConnection();

    if($con == null){
        http_response_code(401);
        echo json_encode(
            array("message" => "UnAuthorized request. You are not allowed to perform this request.")
        );
        exit();
    }

	$name = $_POST['name'];
	$username = $_POST['username'];
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$country = $_POST['country'];
	$dob = $_POST['dob'];
	$gender = $_POST['gender'];

	echo $name;


	$checkPhone = "SELECT * FROM users WHERE phone='$phone'";
	$checkQueryPhone = mysqli_query($con,$checkPhone);
	
	$checkUserName = "SELECT * FROM users WHERE username='$username'";
	$checkQuery = mysqli_query($con,$checkUserName);

	if(mysqli_num_rows($checkQueryPhone)>0){
		$response = array(
			"status" => "error",
			"msg" => "Phone already exist.",
			"data" => []
		);
	}
	elseif(mysqli_num_rows($checkQuery)>0){
		$response = array(
			"status" => "error",
			"msg" => "Username already exist.",
			"data" => []
		);
	}
	else{

		$encryptedPassword = md5($password);

		$insert = "INSERT INTO users(name,username,phone,password,country,status,is_active, date_of_birth, gender,created_at,updated_at) VALUES('$name','$username','$phone', '$encryptedPassword','$country','0','1', '$dob', '$gender',NOW(),NOW())";
		$result=mysqli_query($con,$insert);
		$getId = mysqli_insert_id($con);
		$user = "SELECT * FROM users WHERE id='$getId'";
		$getUser = mysqli_query($con,$user);
		$row = $getUser -> fetch_row();

		// $userImg = null;
		// if($row[7] == null){
		// 	$userImg = $database->assetsUrl . 'default.png';
		// }else{
		// 	$userImg = $database->assetsUrl . 'images/' . $row[7];
		// }

		$data = [
			"id" => (int) $row[0],
			"name" => $row[1],
			"phone" => $row[2],
			"username" => $row[3]
		];
		$response = array(
			"status" => "success",
			"msg" => "Registered Successfully..!",
			"data" => $data
		);
	}

	echo json_encode($response, JSON_PRETTY_PRINT);

 ?>
