<?php
include("../connection/connection.php");
$order_id = $_REQUEST['order_id'];
$query = "DELETE FROM orders WHERE order_id=$order_id";
$result = mysqli_query($connect, $query) or die(mysqli_error($connect));


if ($result) {
    header("Location: ./view.php?success=1");
} else {
    header("Location: ./view.php?success=0");
}
exit();