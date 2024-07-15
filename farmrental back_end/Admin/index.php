<?php
include("../include/header.php");
include("../include/sidebar.php");
?>
<div class="main-content">
    <div class="card-header shadow d-block" style="background-color: black">
        <h3 style="color: white;font-size: 18px;">Administrator Dashboard</h3>
    </div>
    <div class="container-fluid" style="margin-top: 50px;">
        <div class="row clearfix">
            <?php
$sql = "SELECT COUNT(*) AS total 
        FROM users 
        INNER JOIN userroles ON users.user_id = userroles.user_id 
        INNER JOIN roles ON userroles.role_id = roles.role_id 
        WHERE roles.name = 'ExtensionOfficer'";
$result = $connect->query($sql);
$total = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row["total"];
}
?>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>OFFICERS</h6>
                                <h2> 0<?php echo $total; ?></h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-user"></i>
                            </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total Registered Officers</small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="100"
                            aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <?php
$sql = "SELECT COUNT(*) AS total 
        FROM users 
        INNER JOIN userroles ON users.user_id = userroles.user_id 
        INNER JOIN roles ON userroles.role_id = roles.role_id 
        WHERE roles.name = 'Farmer'";
$result = $connect->query($sql);
$total = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row["total"];
}
?>


                            <div class="state">
                                <h6>FARMERS</h6>
                                <h2> 0<?php echo $total; ?></h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-user"></i>
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
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <?php
$sql = "SELECT COUNT(*) AS total 
        FROM users 
        INNER JOIN userroles ON users.user_id = userroles.user_id 
        INNER JOIN roles ON userroles.role_id = roles.role_id 
        WHERE roles.name = 'Renter'";
$result = $connect->query($sql);
$total = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row["total"];
}
?>

                            <div class="state">
                                <h6>RENTERS</h6>
                                <h2> 0<?php echo $total; ?></h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-user"></i>
                            </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total Registered Renters</small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <?php
                                    $sql = "SELECT COUNT(*) AS total FROM farms ";
                                    $result = $connect->query($sql);
                                    $total = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $total = $row["total"];
                                    }
                                 
                                    ?>
                            <div class="state">
                                <h6>FARMS</h6>
                                <h2> 0<?php echo $total; ?></h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-square"></i>
                            </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total Farms</small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <hr style="background-color:red; height: 150px;">


            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <?php
                                    $sql = "SELECT COUNT(*) AS total FROM roles ";
                                    $result = $connect->query($sql);
                                    $total = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $total = $row["total"];
                                    }
                                 
                                    ?>
                            <div class="state">
                                <h6>ROLES</h6>
                                <h2> 0<?php echo $total; ?></h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-lock"></i>
                            </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total roles</small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <?php
                                    $sql = "SELECT COUNT(*) AS total FROM permissions ";
                                    $result = $connect->query($sql);
                                    $total = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $total = $row["total"];
                                    }
                                 
                                    ?>
                            <div class="state">
                                <h6>PERMISSION</h6>
                                <h2> 0<?php echo $total; ?></h2>
                            </div>
                            <div class="icon">
                                <i class="fas fa-key"></i>
                            </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total permissions</small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <?php
                                    $sql = "SELECT COUNT(*) AS total FROM orders ";
                                    $result = $connect->query($sql);
                                    $total = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $total = $row["total"];
                                    }
                                 
                                    ?>
                            <div class="state">
                                <h6>ORDERS</h6>
                                <h2> 0<?php echo $total; ?></h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-square"></i>
                            </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total orders</small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" style="width: 100%;"></div>
                    </div>

                </div>

            </div>


        </div>
    </div>
    <div class="card-header shadow d-block" style="height: 1px;">

    </div>

</div>

<?php
include("../include/footer.php");
?>