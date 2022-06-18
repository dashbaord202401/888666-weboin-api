<?php

	header("Access-Control-Allow-Origin: *");
	
	header("Content-Type: multipart/form-data");

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


    $curret_time =time();
    
    //echo $curret_time."\n";
    $target_dir = "uploads/";
    $target_file = $target_dir . basename("FILE".$curret_time.$_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }

    // Check if file already exists
    // if (file_exists($target_file)) {
    //   echo "Sorry, file already exists.";
    //   $uploadOk = 0;
    // }
    
     // Check file size
    // if ($_FILES["fileToUpload"]["size"] > 50) {
      // echo "Sorry, your file is too large.";
      // $uploadOk = 0;
    // }
    
    // Allow certain file formats


    // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    // && $imageFileType != "gif" && $imageFileType != "mp4" ) {
    //   $data = [
    //     "status" => "failure"
    //     ];

    //     echo json_encode($data, JSON_PRETTY_PRINT);

    //   // "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //   $uploadOk = 0;
    // }

    
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {

      $data = [
        "status" => "failure"
        ];

        echo json_encode($data, JSON_PRETTY_PRINT);
      
    // if everything is ok, try to upload file
    } 
    else
    {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $data = [
          "status" => "success",
          "path" => "".htmlspecialchars( basename("FILE".$curret_time.$_FILES["fileToUpload"]["name"]))
          ];
        
        echo json_encode($data, JSON_PRETTY_PRINT);
        // "The file ".$target_file. " has been uploaded."
      } else {
        $data = [
          "status" => "failure",
          "path" => "".htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]))
          ];
        
        echo json_encode($data, JSON_PRETTY_PRINT);
        
      }
    }

 ?>
