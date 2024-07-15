<?php
include("../include/header.php");
include("../include/sidebar.php");


$roleAddStatus = "";

$errors = [];

if (isset($_POST["add_role"])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
  
    if (empty($errors)) {
        $insert_new_role = "INSERT INTO roles (name, description) VALUES('$name','$description');";
        if (mysqli_query($connect, $insert_new_role)) {
           
            $roleAddStatus = " Role for ($name) added successfully";
        } else {
         
            $roleAddStatus = "Error occurred while adding role";
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
                    <h3 style="color: white;">Role creating form</h3>
                </div>

                <div class="alert <?php echo !empty($roleAddStatus) && strpos($roleAddStatus, 'successfully') !== false ? 'alert-success' : ''; ?>"
                    id="successMessage" style="width:1100px; margin-left:50px">
                    <?php echo $roleAddStatus; ?>
                </div>
                <div class="card-body shadow">
                    <form class="forms-sample" method="post">
                        <div class="form-group row">
                            <label for="role" class="col-sm-2 col-form-label">Role_name</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="role" name="name"
                                    style="height: 100px; border-color: black; border-radius: 5px;">
                                    <option value="" disabled selected>Select your role</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="ExtensionOfficer">ExtensionOfficer</option>
                                    <option value="Farmer">Farmer</option>
                                    <option value="Renter">Renter</option>
                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Descriptions</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="exampleInputUsername2"
                                    placeholder="Enter your description here" name="description"
                                    style="height: 200px; border-color:black; border-radius:5px;"></textarea>
                            </div>
                        </div>



                        <button type="submit" name="add_role" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
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