<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

session_start();
include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["user_id"])) {
        $user_id = $_GET["user_id"];
        $base_url = "http://192.168.120.183/farmrental/APIs/uploads/";  

      
        $select_farms = "SELECT farm_id, user_id, size, description, price, document, CONCAT('$base_url', farm_image) as farm_image, status, fertile FROM farms WHERE user_id = ? ORDER BY farm_id DESC";
        $stmt = $connect->prepare($select_farms);
        $stmt->bind_param("s", $user_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $farms = $result->fetch_all(MYSQLI_ASSOC);

            $response = array("success" => true, "farms" => $farms);
            echo json_encode($response);
        } else {
            $response = array("success" => false, "message" => "Error fetching farm details: " . $stmt->error);
            echo json_encode($response);
        }

        $stmt->close();
    } else {
        $response = array("success" => false, "message" => "Missing user_id parameter.");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "message" => "Unsupported request method.");
    echo json_encode($response);
}

$connect->close();