<?php
session_start();
include("../connection/connection.php");

header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
    if (!isset($_GET['user_id'])) {
        echo json_encode(array("message" => "User ID not provided"));
        exit();
    }

    $owner_id = intval($_GET['user_id']);

    $sql = "
        SELECT 
            CONCAT('http://192.168.120.183/farmrental/APIs/uploads/', f.farm_image) AS farm_image_url, 
            f.size, 
            o.order_id,
            o.order_date, 
            o.start_date, 
            o.end_date, 
            o.total_amount, 
            o.status, 
            u.fullname,
            u.region, 
            u.district, 
            u.phone
        FROM farms f
        INNER JOIN orders o ON f.farm_id = o.farm_id
        LEFT JOIN users u ON o.user_id = u.user_id
        WHERE f.user_id = ?
    ";

    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $owner_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $farms = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $farms[] = $row;
        }
    } else {
        echo json_encode(array("message" => "No orders found"));
        exit();
    }

    echo json_encode(array("farms" => $farms));

    $stmt->close();
    $connect->close();

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['order_id']) || !isset($data['status'])) {
        echo json_encode(array("message" => "Order ID and status are required"));
        exit();
    }

    $order_id = intval($data['order_id']);
    $status = intval($data['status']);

   
    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii", $status, $order_id);

    if ($stmt->execute()) {
        echo json_encode(array("message" => "Order status updated successfully"));
    } else {
        echo json_encode(array("message" => "Failed to update order status"));
    }

    $stmt->close();
    $connect->close();

} else {
   
    echo json_encode(array("message" => "Invalid request method"));
}