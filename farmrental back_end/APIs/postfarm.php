<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

session_start();
include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $user_id = $_POST["user_id"];
    $size = $_POST["size"];
    $description = $_POST["description"];
    $price = $_POST["price"];

   
    $permission_query = "SELECT p.name 
                         FROM permissions p 
                         INNER JOIN rolepermissions rp ON p.permission_id = rp.permission_id 
                         INNER JOIN userroles ur ON rp.role_id = ur.role_id 
                         WHERE ur.user_id = $user_id 
                         AND p.name = 'Postfarm'";
    $permission_result = mysqli_query($connect, $permission_query);

    if ($permission_result && mysqli_num_rows($permission_result) > 0) {
    
        $farm_image = ""; 
        if (isset($_FILES["farm_image"]["name"]) && $_FILES["farm_image"]["error"] == 0) {
            $targetDirImage = "uploads/";
            $farm_image = basename($_FILES["farm_image"]["name"]);
            $targetFilePathImage = $targetDirImage . $farm_image;
            move_uploaded_file($_FILES["farm_image"]["tmp_name"], $targetFilePathImage);
        }

        $document = ""; 
        if (isset($_FILES["document"]["name"]) && $_FILES["document"]["error"] == 0) {
            $targetDirDocument = "documents/";
            $documentName = basename($_FILES["document"]["name"]);
            $targetFilePathDocument = $targetDirDocument . $documentName;
           
            $fileType = strtolower(pathinfo($documentName, PATHINFO_EXTENSION));
            if ($fileType === "pdf") {
                move_uploaded_file($_FILES["document"]["tmp_name"], $targetFilePathDocument);
                $document = $documentName;
            } else {
               
                $response = array("success" => false, "message" => "Only PDF files are allowed for the document.");
                echo json_encode($response);
                exit(); 
            }
        }

       
        $sql = "INSERT INTO farms (user_id, size, description, price, document, farm_image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ssssss", $user_id, $size, $description, $price, $document, $farm_image);

      
        if ($stmt->execute()) {
          
            $response = array("success" => true, "message" => "Farm details added successfully.");
            echo json_encode($response);
        } else {
         
            $response = array("success" => false, "message" => "Error adding farm details: " . $stmt->error);
            echo json_encode($response);
        }

     
        $stmt->close();
    } else {
      
        $response = array("success" => false, "message" => "You do not have the permission to post a farm.");
        echo json_encode($response);
    }
    
    $connect->close();
} else {
  
    $response = array("success" => false, "message" => "Unsupported request method.");
    echo json_encode($response);
}
?>