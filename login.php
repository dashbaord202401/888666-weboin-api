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
	$password = md5($_POST['password']);


	$checkUser = "SELECT * FROM users WHERE phone='$phone' and password='$password'";
	$result = mysqli_query($con,$checkUser);

    if(mysqli_num_rows($result)>0){
        $row = $result -> fetch_row();
    
        $data = [
            "id" => (int) $row[0],
            "phone" => $row[2]
        ];
        $response = array(
            "status" => "success",
            "msg" => "success",
            "data" => [$data]
        );
    }else{
        
        $response = array(
            "status" => "failure",
            "msg" => "Invalid Credentials.",
            "data" => []
        );
    }
	
	echo json_encode($response, JSON_PRETTY_PRINT);

 ?>