<?php

    header("Access-Control-Allow-Origin: *");
    // header("Content-Type: application/json; charset=UTF-8");
	header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
// 

    include_once 'database.php';

    $database = new Database();
    $response  = array();
    $con = $database->getConnection();

    if($con == null){
        http_response_code(401);
        echo json_encode(
            array("message" => "UnAuthorized request. You are not allowed to perform this request.")
        );
        exit();
    }

	$from_id = $_POST['from_id'];
	$to_id = $_POST['to_id'];
	$checkUser ="SELECT * FROM chats 
                 WHERE (from_id ='$from_id' AND to_id = '$to_id') 
                 OR (from_id ='$to_id' AND to_id = '$from_id') 
                 ORDER BY id DESC";
    
	// $checkUser ="SELECT * FROM chats WHERE (from_id ='$from_id' and to_id = '$to_id')  ORDER BY id ASC ";
	$result = mysqli_query($con,$checkUser);

        foreach($result as $key => $val){

        array_push($response, $val);
        }

    echo json_encode($response, JSON_PRETTY_PRINT);
    
    

 ?>