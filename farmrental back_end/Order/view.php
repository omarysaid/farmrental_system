<?php
include("../include/header.php");
include("../include/sidebar.php");


$select = "
    SELECT 
        o.order_id,
        u1.fullname AS posted_by,
        u2.fullname AS rented_by,
        u2.phone AS rented_phone,
        f.size,
        o.order_date,
        o.start_date,
        o.end_date,
        o.total_amount,
        o.payment_method,
        o.status
    FROM 
        orders o
    JOIN 
        farms f ON o.farm_id = f.farm_id
    JOIN 
        users u1 ON f.user_id = u1.user_id
    JOIN
        users u2 ON o.user_id = u2.user_id
";

$result = mysqli_query($connect, $select) or die(mysqli_error($connect));
$number = mysqli_num_rows($result);

?>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header shadow d-block" style="background-color: black; width:fit-content">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 style="color: white;font-size: 18px;">Order Details Table</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-responsive">
                        <table id="multi-colum-dt" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Posted By</th>
                                    <th>Rented By</th>
                                    <th>Renter Phone</th>
                                    <th>Size</th>
                                    <th>Order Date</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
if ($number > 0) {
    $cnt = 1;
    while ($row = mysqli_fetch_assoc($result)) {
?>
                                <tr>
                                    <td><?php echo $cnt++; ?></td>
                                    <td><?php echo $row['posted_by']; ?></td>
                                    <td><?php echo $row['rented_by']; ?></td>
                                    <td><?php echo $row['rented_phone']; ?></td>
                                    <td><?php echo $row['size']; ?></td>
                                    <td><?php echo $row['order_date']; ?></td>
                                    <td><?php echo $row['start_date']; ?></td>
                                    <td><?php echo $row['end_date']; ?></td>
                                    <td><?php echo $row['total_amount']; ?></td>
                                    <td><?php echo $row['payment_method']; ?></td>
                                    <td><?php echo $row['status'] == 1 ? '<b style="color:green"> <i class="fa fa-check"></i> Confirmed</b>' : '<b style="color:red"> <i class="fa fa-times"></i> Pending</b>'; ?>
                                    </td>
                                    <td>




                                        <?php
                                      
                                        if (in_array('Delete', $_SESSION['permissions'])) {
                                        ?>
                                        <span>
                                            <button class="btn btn-danger"
                                                onclick="confirmDelete(<?php echo $row['order_id'] ?>)">
                                                <i class="ik ik-minus-circle"></i>
                                            </button>
                                        </span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
    }
} else {
    echo "<tr><td colspan='11'>No results found</td></tr>";
}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("../include/footer.php");
include("../include/tablejs.php");
?>


<script>
function confirmDelete(Id) {

    if (confirm("Are you sure you want to delete?")) {

        window.location.href = "./delete.php?order_id=" + Id;
    }
}
</script>