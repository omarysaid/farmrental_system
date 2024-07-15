<?php
include("../include/header.php");
include("../include/sidebar.php");


$role_id = '';
$AddStatus = "";

if (isset($_POST["post_data"])) {
    $role_id = $_POST['role_id'];
    $permission_id = $_POST['permission_id'];

  
    if (!empty($role_id) && !empty($permission_id)) {
        $insert_new = "INSERT INTO rolepermissions (role_id, permission_id) VALUES ('$role_id', '$permission_id');";

        if (mysqli_query($connect, $insert_new)) {
            $AddStatus = "Permission added successfully";
        } else {
            $AddStatus = "Error occurred while adding permission";
        }
    }
}

include("../include/footer.php");
include("../include/formjs.php");
?>

<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height: 484px;">
                <div class="card-header shadow" style="background-color: black;">
                    <h3 style="color: white;">Role_Permissions Assigning form</h3>
                </div>

                <div class="alert <?php echo !empty($AddStatus) && strpos($AddStatus, 'successfully') !== false ? 'alert-success' : ''; ?>"
                    id="successMessage" style="width:1100px; margin-left:50px">
                    <?php echo $AddStatus; ?>
                </div>
                <div class="card-body shadow">
                    <form class="forms-sample" method="post">
                        <?php
                        $select_role = "SELECT * FROM roles WHERE role_id = '" . $_GET['role_id'] . "'";
                        $result = mysqli_query($connect, $select_role);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $name = $row['name'];
                                $role_id = $row['role_id'];
                        ?>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="exampleInputUsername2"
                                    placeholder="Username" style="height: 50px;border-color:black; border-radius:5px"
                                    value="<?php echo $name ?>" readonly>
                                <input type="hidden" class="form-control" id="exampleInputUsername2" name="role_id"
                                    value="<?php echo $role_id ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="permission" class="col-sm-2 col-form-label">Permission</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="permission" name="permission_id"
                                    style="height: 100px; border-color: black; border-radius: 5px;">
                                    <option value="" disabled selected>Select your permission</option>
                                    <?php
                                           
                                            $permissions_query = "SELECT permission_id, name FROM permissions";
                                            $permissions_result = mysqli_query($connect, $permissions_query);
                                            if ($permissions_result) {
                                                while ($permission_row = mysqli_fetch_assoc($permissions_result)) {
                                                    echo "<option value='" . $permission_row['permission_id'] . "'>" . $permission_row['name'] . "</option>";
                                                }
                                            } else {
                                                echo "Error: " . mysqli_error($connect);
                                            }
                                            ?>
                                </select>
                            </div>
                        </div>


                        <button type="submit" name="post_data" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
                <?php
                            }
                        }
                        ?>
            </div>
        </div>
    </div>
</div>
<?php
include("../include/footer.php");
include("../include/formjs.php");
?>