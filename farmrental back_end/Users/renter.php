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
                            <h3 style="color: white;font-size: 18px;">Renter Details Table </h3>
                        </div>

                       
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-responsive">
                        <table id="multi-colum-dt" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Region</th>
                                    <th>District</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $cnt = 1; 
                                    $select_users = "
                                        SELECT users.user_id, users.fullname, users.region, users.district, users.phone, users.email, users.created_at
                                        FROM users
                                        JOIN userroles ON users.user_id = userroles.user_id
                                        JOIN roles ON userroles.role_id = roles.role_id
                                        WHERE roles.name = 'Renter'
                                    ";

                                    $result = mysqli_query($connect, $select_users) or die(mysqli_error($connect));
                                    $number = mysqli_num_rows($result);
                                    if ($number > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr>
                                    <td><?php echo $cnt++; ?></td>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['region']; ?></td>
                                    <td><?php echo $row['district']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>

                                    <td>
                                        <?php
                                      
                                        if (in_array('Update', $_SESSION['permissions'])) {
                                        ?>
                                        <span>
                                            <a href="./update.php?user_id=<?php echo $row['user_id'] ?>">
                                                <button class="btn btn-success">
                                                    <i class="ik ik-edit"></i>
                                                </button>
                                            </a>
                                        </span>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                      
                                        if (in_array('Add', $_SESSION['permissions'])) {
                                        ?>
                                        <span>
                                            <a href="../user_role/create.php?user_id=<?php echo $row['user_id'] ?>">
                                                <button class="btn btn-primary">
                                                    <i class="ik ik-lock"></i>
                                                </button>
                                            </a>
                                        </span>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                       
                                        if (in_array('Delete', $_SESSION['permissions'])) {
                                        ?>
                                        <span>
                                            <button class="btn btn-danger"
                                                onclick="confirmDelete(<?php echo $row['user_id'] ?>)">
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
                                        echo "<tr><td colspan='7'>0 results</td></tr>";
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
        window.location.href = "./delete3.php?user_id=" + Id;
    }
}
</script>