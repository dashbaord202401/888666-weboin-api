<?php

use LDAP\Result;

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
	$msg = $_POST['msg'];
	$time = $_POST['time'];
	$attachment = $_POST['attachment'];
	$attachment_type = $_POST['attachment_type'];


	
		$insert = "INSERT INTO chats(from_id,to_id,msg_text,time,attachment,attachment_type) VALUES('$from_id','$to_id','$msg','$time', '$attachment','$attachment_type')";
		$update1 = "UPDATE conversations SET `last_msg` = '$msg' WHERE `from` = $from_id AND `to` =$to_id  ";
		$update2 = "UPDATE conversations SET `last_msg` = '$msg' WHERE `from` = $to_id AND `to` =$from_id   ";
		$result=mysqli_query($con,$insert);
		$getId = mysqli_insert_id($con);
		$update_result1=mysqli_query($con,$update1);
		$update_result2=mysqli_query($con,$update2);
		$chat = "SELECT * FROM chats WHERE id='$getId'";
		$getChat = mysqli_query($con,$chat);
		$row = $getChat -> fetch_row();
		if($result){
			echo "Chat Saved \n";
		}
		if($update_result1){
			echo "update_result1 Saved \n";
		}
		if($update_result2){
			echo "update_result2 Saved \n";
		}
	
		
		$data = [
			"id" => (int) $row[0],
			"from_id" => $row[1],
			"to_id" => $row[2],
			"msg" => $row[3],
			"created_at" => $row[4]
		];
		$response = array(
			"status" => "success",
			"msg" => "Message Saved Successfully..!",
			"data" => $data
		);


	echo json_encode($response, JSON_PRETTY_PRINT);

 ?>
 	