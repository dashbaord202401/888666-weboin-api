<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

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

    $total = 0;
    $response=[];
    $current_time=time();

    if(isset($_FILES['media'])){
            $total = count((array)$_FILES['media']['name']);
    }

    for( $i=0 ; $i < $total ; $i++ ) {

        $targetDir = "uploads/";
        $fileName = basename($_FILES["media"]["name"][$i]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $targetDir = "uploads/";
        $fileName = 'FILE'.$current_time. $i . '.' . $fileType;
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if(move_uploaded_file($_FILES["media"]["tmp_name"][$i], $targetFilePath)){
            $data = [
                "status" => "success",
                "path" => "".htmlspecialchars( basename('FILE'.$current_time.$i.'.'.$fileType))
                ];
                array_push($response, $data);
        }
        else{
                $data = [
                    "status" => "failure",
                    "path" => "".htmlspecialchars( basename( $_FILES["media"]["name"]))
                ];
                array_push($response, $data);
        }
    }
    echo json_encode($response, JSON_PRETTY_PRINT);

?>