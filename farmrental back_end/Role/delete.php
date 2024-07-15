<?php
include("../connection/connection.php");
$role_id = $_REQUEST['role_id'];
$query = "DELETE FROM roles WHERE role_id=$role_id";
$result = mysqli_query($connect, $query) or die(mysqli_error($connect));


if ($result) {
    
    header("Location: ./view.php?success=1");
} else {
   
    header("Location: ./view.php?success=0");
}
exit();