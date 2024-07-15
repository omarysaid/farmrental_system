<?php
include("../connection/connection.php");
$farm_id = $_REQUEST['farm_id'];
$query = "DELETE FROM farms WHERE farm_id=$farm_id";
$result = mysqli_query($connect, $query) or die(mysqli_error($connect));


if ($result) {
  
    header("Location: ./aprovedfarm.php?success=1");
} else {
   
    header("Location: ./aprovedfarm.php?success=0");
}
exit();


if ($result) {
    
    header("Location: ./newfarm.php?success=1");
} else {
   
    header("Location: ./newfarm.php?success=0");
}
exit();