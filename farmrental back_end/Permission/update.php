<?php
include("../include/header.php");
include("../include/sidebar.php");

if (isset($_POST['update'])) {
    $permission_id = $_GET['permission_id'];
    $name = $_POST['name'];
    $descriptions = $_POST['descriptions'];
  
    if (empty($errors)) {
        $update = "UPDATE permissions SET name='$name', descriptions='$descriptions'
        WHERE permission_id = '$permission_id'";

        if (mysqli_query($connect, $update)) {
          
            $roleStatus = " update successfully";
        } else {
           
            $roleStatus = "Error occurred while updating ";
        }
    } else {
    
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height: 484px;">
                <div class="card-header shadow" style="background-color: black;">
                    <h3 style="color: white;">Permissions updation form</h3>
                </div>

                <?php if (!empty($roleStatus)) : ?>
                <div class="alert <?php echo strpos($roleStatus, 'successfully') !== false ? 'alert-success' : 'alert-success'; ?>"
                    id="successMessage">
                    <?php echo $roleStatus; ?>
                </div>
                <?php endif; ?>

                <div class="card-body shadow">
                    <form class="forms-sample" method="post">
                        <?php
                                    $select = "SELECT * FROM permissions WHERE permission_id = '" . $_GET['permission_id'] . "'";
                                    $result = mysqli_query($connect, $select);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>

                        <div class="form-group row">
                            <label for="role" class="col-sm-2 col-form-label">Role Name</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="permission" name="name"
                                    style="height: 100px; border-color: black; border-radius: 5px;">
                                    <option value="" disabled>Select your permission</option>
                                    <option value="Register"
                                        <?php echo ($row['name'] == 'Register') ? 'selected' : ''; ?>>Register</option>
                                    <option value="Login" <?php echo ($row['name'] == 'Login') ? 'selected' : ''; ?>>
                                        Login</option>
                                    <option value="Logout" <?php echo ($row['name'] == 'Logout') ? 'selected' : ''; ?>>
                                        Logout</option>
                                    <option value="Read" <?php echo ($row['name'] == 'Read') ? 'selected' : ''; ?>>Read
                                    </option>
                                    <option value="Add" <?php echo ($row['name'] == 'Add') ? 'selected' : ''; ?>>Add
                                    </option>
                                    <option value="Update" <?php echo ($row['name'] == 'Update') ? 'selected' : ''; ?>>
                                        Update</option>
                                    <option value="Delete" <?php echo ($row['name'] == 'Delete') ? 'selected' : ''; ?>>
                                        Delete</option>
                                    <option value="ViewDashboard"
                                        <?php echo ($row['name'] == 'ViewDashboard') ? 'selected' : ''; ?>>ViewDashboard
                                    </option>
                                    <option value="Postfarm"
                                        <?php echo ($row['name'] == 'Postfarm') ? 'selected' : ''; ?>>Postfarm</option>
                                    <option value="Rent" <?php echo ($row['name'] == 'Rent') ? 'selected' : ''; ?>>Rent
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Descriptions</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="exampleInputUsername2"
                                    placeholder="Enter your description here" name="descriptions"
                                    style="height: 200px; border-color:black; border-radius:5px;"><?php echo htmlspecialchars($row['descriptions']); ?></textarea>
                            </div>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary mr-2">update</button>

                        <?php
                                        }
                                    }
                                    ?>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("../include/footer.php");
include("../include/formjs.php");
?>