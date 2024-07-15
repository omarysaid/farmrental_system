<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

session_start();
include("../connection/connection.php");


$userAddStatus = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $postData = json_decode(file_get_contents("php://input"), true);


    $required_fields = ['fullname', 'region', 'district', 'phone', 'email', 'password', 'role'];
    $errors = array();
    foreach ($required_fields as $field) {
        if (!isset($postData[$field]) || empty(trim($postData[$field]))) {
            $errors[] = "$field is required.";
        }
    }

    if (empty($errors)) {
        $fullname = $postData['fullname'];
        $region = $postData['region'];
        $district = $postData['district'];
        $phone = $postData['phone'];
        $email = $postData['email'];
        $password = md5($postData['password']); 
        $roleName = $postData['role']; 

       
        $insert_new_user = "INSERT INTO users (fullname, region, district, phone, email, password) 
                            VALUES ('$fullname', '$region', '$district', '$phone', '$email', '$password')";

        if (mysqli_query($connect, $insert_new_user)) {
            $user_id = mysqli_insert_id($connect);

           
            $role_id_query = "SELECT role_id FROM roles WHERE name = '$roleName'";
            $role_id_result = mysqli_query($connect, $role_id_query);

            if ($role_id_result && mysqli_num_rows($role_id_result) > 0) {
                $role_id_row = mysqli_fetch_assoc($role_id_result);
                $role_id = $role_id_row['role_id'];

               
                $insert_user_role = "INSERT INTO userroles (user_id, role_id) VALUES ('$user_id', '$role_id')";
                mysqli_query($connect, $insert_user_role);

            
                $permission_id_query = "SELECT permission_id FROM permissions WHERE name = 'Register'";
                $permission_id_result = mysqli_query($connect, $permission_id_query);

                if ($permission_id_result && mysqli_num_rows($permission_id_result) > 0) {
                    $permission_id_row = mysqli_fetch_assoc($permission_id_result);
                    $permission_id = $permission_id_row['permission_id'];

                   
                    $insert_role_permission = "INSERT INTO rolepermissions (role_id, permission_id) VALUES ('$role_id', '$permission_id')";
                    mysqli_query($connect, $insert_role_permission);

                  
                    $userAddStatus = "User ($fullname) added successfully as $roleName.";
                    echo json_encode(["status" => "success", "message" => $userAddStatus]);
                } else {
                    $userAddStatus = "Error occurred while assigning permission.";
                    echo json_encode(["status" => "error", "message" => $userAddStatus]);
                }
            } else {
                $userAddStatus = "Error occurred while fetching role.";
                echo json_encode(["status" => "error", "message" => $userAddStatus]);
            }
        } else {
          
            $userAddStatus = "Error occurred while adding user.";
            echo json_encode(["status" => "error", "message" => $userAddStatus]);
        }
    } else {
        
        echo json_encode(["status" => "error", "message" => $errors]);
    }
}