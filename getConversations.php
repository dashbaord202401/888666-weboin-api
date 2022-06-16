<?php

  header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");

    include_once 'database.php';

    $database = new Database();
    $response  = [];
    $userDetail = [];
    $con = $database->getConnection();

    if($con == null){
        http_response_code(401);
        echo json_encode(
            array("message" => "UnAuthorized request. You are not allowed to perform this request.")
        );
        exit();
    }

	$from_id = $_POST['from_id'];
    
	$checkUser ="SELECT `to`, last_msg, `time` FROM conversations WHERE (`from` ='$from_id') ORDER BY `time` DESC";

    
	$result = mysqli_query($con,$checkUser);
  
  $response_data = [];

foreach($result as $key => $val){
  $to_id = $val["to"];
  
  $finalResult=new stdClass;
  $finalResult->to=$to_id;
  $finalResult->last_msg=$val["last_msg"];
  $finalResult->time=$val["time"];
  
  $getUser ="SELECT id, name, picture, is_active, last_seen FROM users WHERE (`id` = '$to_id')";
  
  $userData = mysqli_query($con,$getUser);
  foreach($userData as $keys => $value){
  
    $finalResult->name=$value["name"];
    $finalResult->picture=$value["picture"];
    $finalResult->is_active=$value["is_active"];
    $finalResult->last_seen=$value["last_seen"];
  }
  
  array_push($response_data, $finalResult);
  
  }

  echo json_encode($response_data, JSON_PRETTY_PRINT);

 ?>