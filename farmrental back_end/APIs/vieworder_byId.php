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

        $select_orders = "SELECT o.order_id, o.user_id, o.farm_id, o.order_date, o.start_date, o.end_date, o.total_amount, o.status, 
            CONCAT('http://192.168.120.183/farmrental/APIs/uploads/', f.farm_image) as farm_image_url,
            u.region, u.district, f.fertile
            FROM orders o 
            JOIN farms f ON o.farm_id = f.farm_id 
            JOIN users u ON f.user_id = u.user_id
            WHERE o.user_id = ?";
        $stmt = $connect->prepare($select_orders);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $orders = $result->fetch_all(MYSQLI_ASSOC);

            $response = array("success" => true, "orders" => $orders);
            echo json_encode($response);
        } else {
            $response = array("success" => false, "message" => "Error fetching orders: " . $stmt->error);
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