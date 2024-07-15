<?php
include("../include/header.php");
include("../include/sidebar.php");


$AddStatus = "";

$errors = [];

if (isset($_POST["add_perm"])) {
    $name = $_POST['name'];
    $descriptions = $_POST['descriptions'];
   
    if (empty($errors)) {
        $insert_new_perm = "INSERT INTO permissions (name, descriptions) VALUES('$name','$descriptions');";
        if (mysqli_query($connect, $insert_new_perm)) {
        
            $AddStatus = " Permission for ($name) added successfully";
        } else {
            
            $AddStatus = "Error occurred while adding role";
        }
    } else {
       
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger error'>$error</div>";
        }
    }
}

?>
<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height: 484px;">
                <div class="card-header shadow" style="background-color: black;">
                    <h3 style="color: white;">Permissions creating form</h3>
                </div>

                <div class="alert <?php echo !empty($AddStatus) && strpos($AddStatus, 'successfully') !== false ? 'alert-success' : ''; ?>"
                    id="successMessage" style="width:1100px; margin-left:50px">
                    <?php echo $AddStatus; ?>
                </div>
                <div class="card-body shadow">
                    <form class="forms-sample" method="post">
                        <div class="form-group row">
                            <label for="permission" class="col-sm-2 col-form-label">Permission</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="permission" name="name"
                                    style="height: 100px; border-color: black; border-radius: 5px;">
                                    <option value="" disabled selected>Select your permission</option>
                                    <option value="Register">Register</option>
                                    <option value="Login">Login</option>
                                    <option value="Logout">Logout</option>
                                    <option value="Read">Read</option>
                                    <option value="Add">Add</option>
                                    <option value="Update">Update</option>
                                    <option value="Delete">Delete</option>
                                    <option value="ViewDashboard">ViewDashboard</option>
                                    <option value="Postfarm">Postfarm</option>
                                    <option value="Rent">Rent</option>

                                </select>
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Descriptions</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="exampleInputUsername2"
                                    placeholder="Enter your description here" name="descriptions"
                                    style="height: 200px; border-color:black; border-radius:5px;"></textarea>
                            </div>
                        </div>



                        <button type="submit" name="add_perm" class="btn btn-primary mr-2">Submit</button>

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