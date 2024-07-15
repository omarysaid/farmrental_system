<?php
include("../include/header.php");
include("../include/sidebar.php");


$user_id = '';
$AddStatus = "";

if (isset($_POST["post_data"])) {
    $user_id = $_POST['user_id'];
    $role_id = $_POST['role_id'];

   
    if (!empty($user_id) && !empty($role_id)) {
        $insert_new = "INSERT INTO userroles (user_id, role_id) VALUES ('$user_id', '$role_id');";

        if (mysqli_query($connect, $insert_new)) {
            $AddStatus = "role assigned successfully";
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
                    <h3 style="color: white;">User_Roles Assigning form</h3>
                </div>

                <div class="alert <?php echo !empty($AddStatus) && strpos($AddStatus, 'successfully') !== false ? 'alert-success' : ''; ?>"
                    id="successMessage" style="width:1100px; margin-left:50px">
                    <?php echo $AddStatus; ?>
                </div>
                <div class="card-body shadow">
                    <form class="forms-sample" method="post">
                        <?php
                        $select_user = "SELECT * FROM users WHERE user_id = '" . $_GET['user_id'] . "'";
                        $result = mysqli_query($connect, $select_user);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $fullname = $row['fullname'];
                                $user_id = $row['user_id'];
                        ?>
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="exampleInputUsername2"
                                    placeholder="Username" style="height: 50px;border-color:black; border-radius:5px"
                                    value="<?php echo $fullname ?>" readonly>
                                <input type="hidden" class="form-control" id="exampleInputUsername2" name="user_id"
                                    value="<?php echo $user_id ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="permission" class="col-sm-2 col-form-label">Roles</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="role" name="role_id"
                                    style="height: 100px; border-color: black; border-radius: 5px;">
                                    <option value="" disabled selected>Select your role</option>
                                    <?php
                                           
                                            $role_query = "SELECT role_id, name FROM roles";
                                            $role_result = mysqli_query($connect, $role_query);
                                            if ($role_result) {
                                                while ($role_row = mysqli_fetch_assoc($role_result)) {
                                                    echo "<option value='" . $role_row['role_id'] . "'>" . $role_row['name'] . "</option>";
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