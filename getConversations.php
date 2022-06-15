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
    
	$checkUser ="SELECT `to` FROM conversations WHERE (`from` ='$from_id') ORDER BY id DESC";

    
	$result = mysqli_query($con,$checkUser);


  foreach($result as $key => $val){
    array_push($response, $val["to"]);
  }
    
  foreach($response as $res)
  {
      $getUser ="SELECT id, name, picture, is_active, last_seen FROM users WHERE (`id` = '$res')";

      $userData = mysqli_query($con,$getUser);

      $resultData = $userData -> fetch_row();

      array_push($userDetail, $resultData);
  }

  $data = [
    "list" => $userDetail
    ];
  
  echo json_encode($data, JSON_PRETTY_PRINT);

 ?>