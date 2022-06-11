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
    
	$checkUser1 ="SELECT to_id FROM chats 
                 WHERE (from_id ='$from_id' )
                 ORDER BY id DESC";
	$checkUser2 ="SELECT from_id FROM chats 
                 WHERE ( to_id = '$from_id') 
                 ORDER BY id DESC";
    
	$result1 = mysqli_query($con,$checkUser1);
	$result2 = mysqli_query($con,$checkUser2);

    $row1 = $result1 -> fetch_row();
    $row2 = $result2 -> fetch_row();
    if($row1){
        array_push($response, $row1[0]);
    }
    if($row2){
        array_push($response, $row2[0]);
    }

    foreach($response as $res){
        $getUser ="SELECT id, name, picture, is_active, last_seen FROM users WHERE id = '$res' ";

        $userData = mysqli_query($con,$getUser);

        $resultData = $userData -> fetch_row();

        array_push($userDetail, $resultData);
    }

    $final_array = array_unique($userDetail);
    echo json_encode($final_array, JSON_PRETTY_PRINT);

    
    // echo json_encode($userDetail, JSON_PRETTY_PRINT);
    // echo json_encode($response, JSON_PRETTY_PRINT);

    //Without Duplicate

 ?>