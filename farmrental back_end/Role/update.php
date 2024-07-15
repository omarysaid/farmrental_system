<?php
include("../include/header.php");
include("../include/sidebar.php");


if (isset($_POST['update_role'])) {
    $role_id = $_GET['role_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
  


    if (empty($errors)) {
        $update = "UPDATE roles SET name='$name', description='$description'
        WHERE role_id = '$role_id'";

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
                    <h3 style="color: white;">Role updation form</h3>
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
                                    $select_user = "SELECT * FROM roles WHERE role_id = '" . $_GET['role_id'] . "'";
                                    $result = mysqli_query($connect, $select_user);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>

                        <div class="form-group row">
                            <label for="role" class="col-sm-2 col-form-label">Role Name</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="role" name="name"
                                    style="height: 100px; border-color: black; border-radius: 5px;">
                                    <option value="" disabled>Select your role</option>
                                    <option value="Administrator"
                                        <?php echo ($row['name'] == 'Administrator') ? 'selected' : ''; ?>>Administrator
                                    </option>
                                    <option value="ExtensionOfficer"
                                        <?php echo ($row['name'] == 'ExtensionOfficer') ? 'selected' : ''; ?>>
                                        ExtensionOfficer</option>
                                    <option value="Farmer" <?php echo ($row['name'] == 'Farmer') ? 'selected' : ''; ?>>
                                        Farmer</option>
                                    <option value="Renter" <?php echo ($row['name'] == 'Renter') ? 'selected' : ''; ?>>
                                        Renter</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Descriptions</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="exampleInputUsername2"
                                    placeholder="Enter your description here" name="description"
                                    style="height: 200px; border-color:black; border-radius:5px;"><?php echo htmlspecialchars($row['description']); ?></textarea>
                            </div>
                        </div>



                        <button type="submit" name="update_role" class="btn btn-primary mr-2">update</button>

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