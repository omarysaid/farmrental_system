<?php
session_start();
include("./connection/connection.php");

function getUserRoles($connect, $user_id) {
    $roles = [];
    $sql = "SELECT r.name FROM roles r 
            JOIN userroles ur ON r.role_id = ur.role_id 
            WHERE ur.user_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row['name'];
    }
    $stmt->close();
    return $roles;
}

function getUserPermissions($connect, $user_id) {
    $permissions = [];
    $sql = "SELECT p.name FROM permissions p 
            JOIN rolepermissions rp ON p.permission_id = rp.permission_id 
            JOIN roles r ON rp.role_id = r.role_id 
            JOIN userroles ur ON r.role_id = ur.role_id 
            WHERE ur.user_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $permissions[] = $row['name'];
    }
    $stmt->close();
    return $permissions;
}

if (isset($_POST['login_data'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email=? AND password=?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $number = $result->num_rows;

    if ($number > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['fullname'] = $row['fullname'];
          $_SESSION['region'] = $row['region'];

        $user_id = $row['user_id'];
        $roles = getUserRoles($connect, $user_id);
        $user_permissions = getUserPermissions($connect, $user_id);

        if (!in_array('Login', $user_permissions)) {
            $_SESSION['message'] = "User has no permission to login";
            $_SESSION['message_type'] = "danger";
            header('Location: index.php');
            exit;
        }

        $_SESSION['roles'] = $roles;
        $_SESSION['permissions'] = $user_permissions;

        if (in_array('Administrator', $roles)) {
            if (in_array('ViewDashboard', $user_permissions)) {
                $_SESSION['message'] = "Login Successful";
                $_SESSION['message_type'] = "success";
                echo "<script>
                        setTimeout(function() {
                            window.location.href = './Admin/index.php';
                        }, 1000); // 1 second delay
                      </script>";
                exit;
            } else {
                $_SESSION['message'] = "User has no permission to view the dashboard";
                $_SESSION['message_type'] = "danger";
                header('Location: index.php');
                exit;
            }
        } else if (in_array('ExtensionOfficer', $roles)) {
            $_SESSION['message'] = "Login Successful";
            $_SESSION['message_type'] = "success";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = './officers/index.php';
                    }, 1000); // 1 second delay
                  </script>";
            exit;
        } else {
            $_SESSION['message'] = "No appropriate dashboard found for user role";
            $_SESSION['message_type'] = "danger";
            header('Location: index.php');
            exit;
        }
    } else {
        $_SESSION['message'] = "Wrong username or password";
        $_SESSION['message_type'] = "danger";
        header('Location: index.php');
        exit;
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Farm rental system</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./assets3/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./assets3/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="./assets3/css/util.css">
    <link rel="stylesheet" type="text/css" href="./assets3/css/main.css">
</head>

<body>
    <div class="limiter" style="margin-top: -50px;">
        <div class="container-login100">
            <div class="wrap-login100">
                <span class="login100-form-title p-b-30" style="color: teal;">
                    FARM RENTAL SYSTEM
                </span>
                <span class="login100-form-title p-b-30" style="color: teal;">
                    <i class="zmdi zmdi-account-circle"></i>
                </span>

                <?php
                if (isset($_SESSION['message'])) {
                    $message_type = $_SESSION['message_type'];
                    echo "<div class='alert alert-$message_type' role='alert'>
                            {$_SESSION['message']}
                          </div>";
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                }
                ?>

                <form class="login100-form validate-form" method="POST" action="">

                    <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
                        <input class="input100" type="text" name="email">
                        <span class="focus-input100" data-placeholder="Email"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <div class="container-login100-form-btn ">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn "></div>
                            <button type="submit" name="login_data" class="login100-form-btn"
                                style="background-color: teal;">
                                Login
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-100">
                        <span class="txt1">
                            Don’t have an account?
                        </span>

                        <a class="txt2" href="./register.php">
                            Sign Up
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>

    <script src="./assets3/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="./assets3/vendor/animsition/js/animsition.min.js"></script>
    <script src="./assets3/vendor/bootstrap/js/popper.js"></script>
    <script src="./assets3/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="./assets3/vendor/select2/select2.min.js"></script>
    <script src="./assets3/vendor/daterangepicker/moment.min.js"></script>
    <script src="./assets3/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="./assets3/vendor/countdowntime/countdowntime.js"></script>
    <script src="./assets3/js/main.js"></script>
</body>

</html>