<?php
include("../connection/connection.php");
$user_id = $_REQUEST['user_id'];
$query = "DELETE FROM userroles WHERE user_id=$user_id";
$result = mysqli_query($connect, $query) or die(mysqli_error($connect));


if ($result) {
   
    header("Location: ./view.php?success=1");
} else {
    
    header("Location: ./view.php?success=0");
}
exit();