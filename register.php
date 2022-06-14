<?php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");

	include_once 'database.php';

	$database = new Database();

	$con = $database->getConnection();

    if($con == null){
        http_response_code(401);
        echo json_encode(
            array("message" => "UnAuthorized request. You are not allowed to perform this request.")
        );
        exit();
    }

	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$name = $_POST['name'];

	$checkPhone = "SELECT * FROM users WHERE phone='$phone'";
	$checkQueryPhone = mysqli_query($con,$checkPhone);
	
	if(mysqli_num_rows($checkQueryPhone)>0){
		$response = array(
			"isExist" => "true",
			"msg" => "Phone already exist.",
			"data" => []
		);
	}
	else
	{
		$encryptedPassword = md5($password);

		$insert = "INSERT INTO users(phone,password,name,created_at,updated_at) VALUES('$phone', '$encryptedPassword','$name',NOW(),NOW())";
		$result=mysqli_query($con,$insert);
		$getId = mysqli_insert_id($con);
		$user = "SELECT * FROM users WHERE id='$getId'";
		$getUser = mysqli_query($con,$user);
		$row = $getUser -> fetch_row();

		$data = [
			"id" => (int) $row[0],
			"phone" => $row[2],
			"password" => $row[4]
		];
		$response = array(
			"isExist" => "false",
			"msg" => "Registered Successfully..!",
			"data" => $data
		);
	 }

	echo json_encode($response, JSON_PRETTY_PRINT);

 ?>
