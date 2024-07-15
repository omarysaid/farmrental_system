<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

session_start();
include("../connection/connection.php");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $postData = json_decode(file_get_contents("php://input"), true);

   
    if (isset($postData['email']) && isset($postData['password'])) {
        $email = $postData['email'];
        $password = md5($postData['password']);

        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($connect, $sql);
        $number = mysqli_num_rows($result);

        if ($number > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];

          
            $permission_query = "SELECT p.name 
                                 FROM permissions p 
                                 INNER JOIN rolepermissions rp ON p.permission_id = rp.permission_id 
                                 INNER JOIN userroles ur ON rp.role_id = ur.role_id 
                                 WHERE ur.user_id = $user_id 
                                 AND p.name = 'Login'";
            $permission_result = mysqli_query($connect, $permission_query);

            if ($permission_result && mysqli_num_rows($permission_result) > 0) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['fullname'] = $row['fullname'];

              
                $role_query = "SELECT r.name as role 
                               FROM roles r 
                               INNER JOIN userroles ur ON r.role_id = ur.role_id 
                               WHERE ur.user_id = $user_id";
                $role_result = mysqli_query($connect, $role_query);
                $role_row = mysqli_fetch_assoc($role_result);
                $role = $role_row['role'];

             
                $response = array(
                    'success' => true,
                    'message' => 'Login successful',
                    'user_id' => $row['user_id'],
                    'fullname' => $row['fullname'],
                    'region' => $row['region'],
                     'district' => $row['district'],
                    'phone' => $row['phone'],
                    'email' => $row['email'],
                    'role' => $role
                );

                echo json_encode($response);
            } else {
                
                $response = array(
                    'success' => false,
                    'message' => 'You do not have the permission to login.'
                );
                echo json_encode($response);
            }
        } else {
          
            $response = array(
                'success' => false,
                'message' => 'Wrong username or password. Please try again.'
            );
            echo json_encode($response);
        }
    } else {
      
        $response = array(
            'success' => false,
            'message' => 'Email or password missing in request.'
        );
        echo json_encode($response);
    }
}
?>