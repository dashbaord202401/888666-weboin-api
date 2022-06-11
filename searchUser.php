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

	$checkUser ="SELECT * FROM users WHERE phone LIKE '$phone%'";
	$result = mysqli_query($con,$checkUser);

    if(mysqli_num_rows($result)>0)
    {
    foreach($result as $key => $val)
    {
        $results[] = $val;
    }

    $response = array(
        "status" => "success",
        "msg" => "queries found",
        "data" => $results
    );
}
else
{
    $response = array(
        "status" => "failure",
        "msg" => "queries not found",
        "data" => []
    );
}	
	echo json_encode($response, JSON_PRETTY_PRINT);

 ?>