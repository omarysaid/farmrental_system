<?php
include("../include/header.php");
include("../include/offsidebar.php");
?>
<div class="main-content">
    <div class="card-header shadow d-block" style="background-color: black">
        <h3 style="color: white;font-size: 18px;">Extension Officer Dashboard</h3>
    </div>
    <div class="container-fluid" style="margin-top: 80px;">
        <div class="row clearfix">

            <div class="col-lg-2 col-md-12 col-sm-12">

            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="widget ">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <?php
$logged_in_user_id = $_SESSION['user_id']; 
$sql = "SELECT region FROM users WHERE user_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $logged_in_user_id);
$stmt->execute();
$result = $stmt->get_result();
$logged_in_user_region = $result->fetch_assoc()['region'];

$sql = "SELECT COUNT(*) AS total 
        FROM farms 
        INNER JOIN users ON farms.user_id = users.user_id 
        WHERE farms.status = 0 AND users.region = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $logged_in_user_region);
$stmt->execute();
$result = $stmt->get_result();
$total = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row["total"];
}
?>

                            <div class="state">
                                <h6>NEW FARM</h6>
                                <h2> <?php echo $total; ?></h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-square"></i>
                            </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total Registered Officers</small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="100" aria-valuemin="100"
                            aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <?php
$logged_in_user_id = $_SESSION['user_id']; 
$sql = "SELECT region FROM users WHERE user_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $logged_in_user_id);
$stmt->execute();
$result = $stmt->get_result();
$logged_in_user_region = $result->fetch_assoc()['region'];

$sql = "SELECT COUNT(*) AS total 
        FROM farms 
        INNER JOIN users ON farms.user_id = users.user_id 
        WHERE farms.status = 1 AND users.region = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $logged_in_user_region);
$stmt->execute();
$result = $stmt->get_result();
$total = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row["total"];
}
?>

                            <div class="state">
                                <h6>APROVED FARMS</h6>
                                <h2> <?php echo $total; ?></h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-square"></i>
                            </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total Registered Farmers</small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">

            </div>
        </div>
    </div>
    <div class="card-header shadow d-block" style="height: 1px;">

    </div>

</div>

<?php
include("../include/footer.php");
?>