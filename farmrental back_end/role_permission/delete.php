<?php
include("../connection/connection.php");
$permission_id = $_REQUEST['permission_id'];
$query = "DELETE FROM rolepermissions WHERE permission_id=$permission_id";
$result = mysqli_query($connect, $query) or die(mysqli_error($connect));


if ($result) {
   
    header("Location: ./view.php?success=1");
} else {
   
    header("Location: ./view.php?success=0");
}
exit();