<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $required_fields = ['user_id', 'farm_id', 'start_date', 'end_date', 'total_amount', 'payment_method'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $response = array("success" => false, "message" => "Missing required field: $field");
            echo json_encode($response);
            exit;
        }
    }

    $user_id = $_POST["user_id"];
    $farm_id = $_POST["farm_id"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $total_amount = $_POST["total_amount"];
    $payment_method = $_POST["payment_method"];
    $card_number = $_POST["card_number"] ?? null;
    $card_expiry = $_POST["card_expiry"] ?? null;
    $card_cvv = $_POST["card_cvv"] ?? null;
    $paypal_email = $_POST["paypal_email"] ?? null;
    $bank_name = $_POST["bank_name"] ?? null;
    $bank_account_number = $_POST["bank_account_number"] ?? null;

    $order_check_sql = "SELECT * FROM orders WHERE farm_id = ?";
    $order_stmt = $connect->prepare($order_check_sql);
    $order_stmt->bind_param("s", $farm_id);
    $order_stmt->execute();
    $order_result = $order_stmt->get_result();

    if ($order_result->num_rows > 0) {
        $response = array("success" => false, "message" => "This farm has already been ordered.");
        echo json_encode($response);
    } else {
        $role_name = 'Renter';
        $permission_name = 'Rent';
        
        $role_permission_check_sql = "
            SELECT ur.user_id 
            FROM userroles ur
            JOIN roles r ON ur.role_id = r.role_id
            JOIN rolepermissions rp ON r.role_id = rp.role_id
            JOIN permissions p ON rp.permission_id = p.permission_id
            WHERE ur.user_id = ? AND r.name = ? AND p.name = ?
        ";
        
        $stmt = $connect->prepare($role_permission_check_sql);
        $stmt->bind_param("sss", $user_id, $role_name, $permission_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $sql = "INSERT INTO orders (user_id, farm_id, start_date, end_date, total_amount, payment_method, card_number, card_expiry, card_cvv, paypal_email, bank_name, bank_account_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("ssssssssssss", $user_id, $farm_id, $start_date, $end_date, $total_amount, 
            $payment_method, $card_number, $card_expiry, $card_cvv, $paypal_email, $bank_name, $bank_account_number);

            if ($stmt->execute()) {
                $response = array("success" => true, "message" => "Order details added successfully.");
            } else {
                $response = array("success" => false, "message" => "Error adding order details: " . $stmt->error);
            }
            echo json_encode($response);
            $stmt->close();
        } else {
            $response = array("success" => false, "message" => "You don't have permission to Rent.");
            echo json_encode($response);
        }
        $stmt->close();
    }
    $order_stmt->close();
    $connect->close();
} else {
    $response = array("success" => false, "message" => "Unsupported request method.");
    echo json_encode($response);
}
?>
