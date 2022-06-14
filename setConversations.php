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

	$from_id = $_POST['from_id'];
	$to_id = $_POST['to_id'];
	
    $insert1 = "INSERT INTO conversations(`from`,`to`) VALUES($from_id,$to_id)";

    $insert2 = "INSERT INTO conversations(`to`,`from`) VALUES($from_id,$to_id)";

    $result1=mysqli_query($con,$insert1);
    $getId1 = mysqli_insert_id($con);

    $result2=mysqli_query($con,$insert2);
    $getId2 = mysqli_insert_id($con);

    
    $conv1 = "SELECT * FROM conversations WHERE id='$getId1'";
    $conv2 = "SELECT * FROM conversations WHERE id='$getId2'";

    $getConvo1 = mysqli_query($con,$conv1);
    $getConvo2 = mysqli_query($con,$conv2);

    $row1 = $getConvo1 -> fetch_row();
    $row2 = $getConvo2 -> fetch_row();

    $data1 = [
        "id" => (int) $row1[0],
        "from_id" => $row1[1],
        "to_id" => $row1[2],
        
    ];
    $data2 = [
        "id" => (int) $row2[0],
        "from_id" => $row2[1],
        "to_id" => $row2[2],
        
    ];
    $response = array(
        "status" => "success",
        "msg" => "Message Saved Successfully..!",
        "data1" => $data1,
        "data2" => $data2
    );


	echo json_encode($response, JSON_PRETTY_PRINT);

 ?>
 	