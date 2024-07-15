<?php
include("../include/header.php");
include("../include/sidebar.php");
?>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header shadow d-block" style="background-color: black">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 style="color: white;font-size: 18px;">Roles_Permission Details Table </h3>
                        </div>


                    </div>


                </div>
                <div class="card-body">
                    <div class="dt-responsive">
                        <table id="multi-colum-dt" class="table table-striped table-bordered nowrap ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role-Name</th>
                                    <th>Permissions</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$cnt = 1; 
$select_perm = "
    SELECT 
        rp.role_id, 
        p.permission_id, 
        r.name AS role_name, 
        p.name, 
        rp.`created_date`
    FROM 
        rolepermissions rp
    JOIN 
        permissions p ON rp.permission_id = p.permission_id
    JOIN 
        roles r ON rp.role_id = r.role_id
    ORDER BY 
        rp.role_id, p.permission_id
";
$result = mysqli_query($connect, $select_perm) or die(mysqli_error($connect));
$number = mysqli_num_rows($result);

if ($number > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
?>


                                <tr>
                                    <td><?php echo $cnt++; ?></td>
                                    <td><?php echo $row['role_name']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['created_date']; ?></td>
                                    <td>


                                        <?php
                                      
                                        if (in_array('Delete', $_SESSION['permissions'])) {
                                        ?>
                                        <span>
                                            <button class="btn btn-danger"
                                                onclick="confirmDelete(<?php echo $row['permission_id'] ?>)">
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
    echo "<tr><td colspan='5'>0 results</td></tr>";
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

        window.location.href = "./delete.php?permission_id=" + Id;
    }
}
</script>