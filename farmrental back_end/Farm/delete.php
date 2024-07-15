<?php
include("../connection/connection.php");
$farm_id = $_REQUEST['farm_id'];
$query = "DELETE FROM farms WHERE farm_id=$farm_id";
$result = mysqli_query($connect, $query) or die(mysqli_error($connect));


if ($result) {
   
    header("Location: ./view.php?success=1");
} else {
 
    header("Location: ./view.php?success=0");
}
exit();