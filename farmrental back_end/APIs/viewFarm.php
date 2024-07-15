<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

session_start();
include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $base_url = "http://192.168.120.183/farmrental/APIs/uploads/"; 

 
    $select_farms = "SELECT f.farm_id, f.size, f.description, f.price, f.document, CONCAT('$base_url', f.farm_image) as farm_image, f.status, f.fertile, u.region, u.district 
                     FROM farms f 
                     LEFT JOIN orders o ON f.farm_id = o.farm_id
                     JOIN users u ON f.user_id = u.user_id
                     WHERE f.status = 1 AND (o.status = 0 OR o.status IS NULL)
                     ORDER BY f.farm_id DESC";
    $stmt = $connect->prepare($select_farms);

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
    $response = array("success" => false, "message" => "Unsupported request method.");
    echo json_encode($response);
}

$connect->close();