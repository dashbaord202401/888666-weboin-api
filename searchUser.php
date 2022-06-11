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

	$phone = $_POST['phone'];
    
	$checkUser ="SELECT * FROM users WHERE phone LIKE '$phone%'";
	$result = mysqli_query($con,$checkUser);
    
    // if(mysqli_num_rows($result)>0){
        // $row = $result -> fetch_row();
        foreach($result as $key => $val){
    // if(mysqli_num_rows($val)>0){
    //     $row = $result -> fetch_row();
    // print_r($val);
    // $response = array(
        //     "status" => "success",
        //     "msg" => "success",
        //     "data" => [$val]
        // );
        array_push($response, $val);
    }
    // }
    echo json_encode($response, JSON_PRETTY_PRINT);
    
    // $userImg = null;
        // if($row[7] == null){
        //     $userImg = $database->assetsUrl . 'default.png';
        // }else{
        //     $userImg = $database->assetsUrl . 'images/' . $row[7];
        // }
    
        // $data = [
        //     "id" => (int) $row[0],
        //     "name" => $row[1],
        //     "phone" => $row[2],
        //     "username" => $row[3],
        //     "status" => (int) $row[12],
        //     "country" => $row[10],
        //     // "pic" => $userImg
        // ];
        
    // }else{
    //     // $response = array(
    //     //     "status" => "error",
    //     //     "msg" => "Credentials invalid.",
    //     //     "data" => []
    //     // );
    // }
	

 ?>