<?php
include("../include/header.php");
include("../include/sidebar.php");

$user_id = '';
$AddStatus = "";

// Update the role name
if (isset($_POST["update_role_name"])) {
    $role_id = $_POST['role_id'];
    $role_name = $_POST['role_name'];

    if (!empty($role_id) && !empty($role_name)) {
        $update_role = "UPDATE roles SET name = '$role_name' WHERE role_id = '$role_id'";

        if (mysqli_query($connect, $update_role)) {
            $AddStatus = "Role name updated successfully";
        } else {
            $AddStatus = "Error occurred while updating role name";
        }
    }
}
?>

<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height: 484px;">
                <div class="card-header shadow" style="background-color: black;">
                    <h3 style="color: white;">Update Role Name Assigned to User</h3>
                </div>

                <div class="alert <?php echo !empty($AddStatus) && strpos($AddStatus, 'successfully') !== false ? 'alert-success' : ''; ?>"
                    id="successMessage" style="width:1100px; margin-left:50px">
                    <?php echo $AddStatus; ?>
                </div>
                <div class="card-body shadow">
                    <?php
                    $user_id = $_GET['user_id'];
                    $select_user = "SELECT u.fullname, ur.role_id, r.name as role_name 
                                    FROM users u 
                                    INNER JOIN userroles ur ON u.user_id = ur.user_id 
                                    INNER JOIN roles r ON ur.role_id = r.role_id 
                                    WHERE u.user_id = '$user_id'";
                    $result = mysqli_query($connect, $select_user);
                    if (mysqli_num_rows($result) > 0) {
                        $user_data = mysqli_fetch_assoc($result);
                        $fullname = $user_data['fullname'];
                        $role_id = $user_data['role_id'];
                        $role_name = $user_data['role_name'];
                    ?>
                    <form class="forms-sample" method="post">
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="username" placeholder="Username"
                                    style="height: 50px; border-color: black; border-radius: 5px;"
                                    value="<?php echo $fullname ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-sm-2 col-form-label">Roles</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="role" name="role_id"
                                    style="height: 50px; border-color: black; border-radius: 5px;">
                                    <option value="" disabled>Select a role</option>
                                    <?php
                                    $role_query = "SELECT role_id, name FROM roles";
                                    $role_result = mysqli_query($connect, $role_query);
                                    if ($role_result) {
                                        while ($role_row = mysqli_fetch_assoc($role_result)) {
                                            $selected = $role_row['role_id'] == $role_id ? 'selected' : '';
                                            echo "<option value='" . $role_row['role_id'] . "' $selected>" . $role_row['name'] . "</option>";
                                        }
                                    } else {
                                        echo "Error: " . mysqli_error($connect);
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role_name" class="col-sm-2 col-form-label">Role Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="role_name" name="role_name"
                                    placeholder="Role Name"
                                    style="height: 50px; border-color: black; border-radius: 5px;"
                                    value="<?php echo $role_name ?>">
                            </div>
                        </div>

                        <button type="submit" name="update_role_name" class="btn btn-primary mr-2">Update Role
                            Name</button>
                        <button type="button" class="btn btn-light" onclick="window.history.back();">Cancel</button>
                    </form>
                    <?php
                    } else {
                        echo "<p>No role assigned to this user.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("../include/footer.php");
include("../include/formjs.php");
?>