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
                            <h3 style="color: white;font-size: 18px;">Roles Details Table</h3>
                        </div>

                        <?php
                      
                        if (in_array('Add', $_SESSION['permissions'])) {
                        ?>
                        <div class="col-md-2">
                            <a href="../Role/create.php"> <button class="btn btn-success"><i
                                        class="ik ik-plus"></i></button></a>
                        </div>
                        <?php
                        }
                        ?>





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
                                <th>Decriptions</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                            $cnt = 1; 
                                            $select_roles = "SELECT * FROM roles";
                                            $result = mysqli_query($connect, $select_roles) or die(mysqli_error($connect));
                                            $number = mysqli_num_rows($result);
                                            if ($number > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                            ?>

                            <tr>
                                <td><?php echo $cnt++; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                                <td>
                                    <?php
                                       
                                        if (in_array('Update', $_SESSION['permissions'])) {
                                        ?>
                                    <span>
                                        <a href="./update.php?role_id=<?php echo $row['role_id'] ?>">
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
                                        <a href="../role_permission/create.php?role_id=<?php echo $row['role_id'] ?>">
                                            <button class="btn btn-primary">
                                                <i class="fas fa-key"></i>
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
                                            onclick="confirmDelete(<?php echo $row['role_id'] ?>)">
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

        window.location.href = "./delete.php?role_id=" + Id;
    }
}
</script>