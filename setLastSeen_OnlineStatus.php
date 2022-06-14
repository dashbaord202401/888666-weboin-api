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

	$user_id = $_POST['user_id'];
	$time = $_POST['time'];
	$active = $_POST['active'];

	$insert = "UPDATE users SET last_seen=$time,is_active=$active WHERE id=$user_id";
	
	if ($con->query($insert) === TRUE) {
		echo "Record updated successfully";
		} else {
		echo "Error updating record: " . $con->error;
		}

	$user = "SELECT * FROM users WHERE id=$user_id";
	$getUser = mysqli_query($con,$user);
	$row = $getUser -> fetch_row();

	$data = [
		"id" =>  $row[0],
		"isActive" => $row[7],
		"lastSeen" => $row[13]
	];
	$response = array(
		"isUpdated" => "true",
		"msg" => "Last Seen Updated Successfully..!",
		"data" => $data
	);
	 

	echo json_encode($response, JSON_PRETTY_PRINT);

 ?>
