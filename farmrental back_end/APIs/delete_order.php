<?php

include("../connection/connection.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');


function sendErrorResponse($message) {
    echo json_encode(["success" => false, "message" => $message]);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (!isset($_DELETE['order_id'])) {
        sendErrorResponse("Order ID is required.");
    }

    $order_id = mysqli_real_escape_string($connect, $_DELETE['order_id']);

    $sql = "DELETE FROM orders WHERE order_id = '$order_id'";
    if (mysqli_query($connect, $sql)) {
        echo json_encode(["success" => true, "message" => "Record deleted successfully"]);
    } else {
        sendErrorResponse("Error deleting record: " . mysqli_error($connect));
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
} else {
    http_response_code(405);
    sendErrorResponse("Method Not Allowed");
}
?>