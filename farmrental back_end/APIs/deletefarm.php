<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

session_start();
include("./connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "DELETE") { 
    $user_id = $_POST["user_id"];
    $location = $_POST["location"];
    $size = $_POST["size"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $farm_image = ""; 
    if(isset($_FILES["farm_image"]["name"]) && $_FILES["farm_image"]["error"] == 0){
        $targetDirImage = "uploads/";
        $farm_image = basename($_FILES["farm_image"]["name"]);
        $targetFilePathImage = $targetDirImage . $farm_image;
        unlink($targetFilePathImage); 
    }
    $document = ""; 
    if(isset($_FILES["document"]["name"]) && $_FILES["document"]["error"] == 0){
        $targetDirDocument = "documents/";
        $documentName = basename($_FILES["document"]["name"]);
        $targetFilePathDocument = $targetDirDocument . $documentName;
        $fileType = strtolower(pathinfo($documentName, PATHINFO_EXTENSION));
        if ($fileType === "pdf") {
            unlink($targetFilePathDocument); 
        } else {
         
            $response = array("success" => false, "message" => "Only PDF files are allowed for the document.");
            echo json_encode($response);
            exit(); 
        }
    }

    $sql = "DELETE FROM farm WHERE user_id = ? AND location = ? AND size = ? AND description = ? AND price = ? AND document = ? AND farm_image = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("sssssss", $user_id, $location, $size, $description, $price, $document, $farm_image);

    if ($stmt->execute()) {
      
        $response = array("success" => true, "message" => "Farm details deleted successfully.");
        echo json_encode($response);
    } else {
       
        $response = array("success" => false, "message" => "Error deleting farm details: " . $stmt->error);
        echo json_encode($response);
    }

    $stmt->close();
    $connect->close();
} else {
  
    $response = array("success" => false, "message" => "Unsupported request method.");
    echo json_encode($response);
}
?>