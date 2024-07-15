<?php
include("../include/header.php");
include("../include/sidebar.php");


if (isset($_POST['update_data'])) {
    $user_id = $_GET['user_id'];
    $fullname = $_POST['fullname'];
    $region = $_POST['region'];
     $district = $_POST['district'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);




    if (empty($errors)) {
        $update_user = "UPDATE users SET fullname='$fullname', region='$region',  district='$district',phone='$phone' , email='$email' , password='$password'
        WHERE user_id = '$user_id'";

        if (mysqli_query($connect, $update_user)) {
          
            $userStatus = "User update successfully";
        } else {
          
            $userStatus = "Error occurred while updating User";
        }
    } else {
       
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}


?>

<?php
include("../include/header.php");
include("../include/sidebar.php");
?>
<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height: 484px;">
                <div class="card-header shadow" style="background-color: black;">
                    <h3 style="color: white;">User updation form</h3>
                </div>
                <div class="card-body shadow">
                    <?php if (!empty($userStatus)) : ?>
                    <div class="alert <?php echo strpos($roleStatus, 'successfully') !== false ? 'alert-success' : 'alert-success'; ?>"
                        id="successMessage">
                        <?php echo $userStatus; ?>
                    </div>
                    <?php endif; ?>
                    <form class="forms-sample" method="POST">

                        <?php
                                    $select_user = "SELECT * FROM users WHERE user_id = '" . $_GET['user_id'] . "'";
                                    $result = mysqli_query($connect, $select_user);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>



                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-2 col-form-label">fullname</label>
                            <div class="col-sm-10">
                                <input type="text" name="fullname" required="true" class="form-control"
                                    id="exampleInputUsername2" value="<?php echo $row['fullname'] ?>"
                                    style="height: 50px;border-color:black; border-radius:5px">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputEmail2" class="col-sm-2 col-form-label">Region</label>
                            <div class="col-sm-10">
                                <input type="text" name="region" required="true" class="form-control"
                                    id="exampleInputEmail2" value="<?php echo $row['region'] ?>"
                                    style="height: 50px;border-color:black; border-radius:5px">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputMobile" class="col-sm-2 col-form-label">District</label>
                            <div class="col-sm-10">
                                <input type="text" name="district" required="true" class="form-control"
                                    id="exampleInputMobile" value="<?php echo $row['district'] ?>"
                                    style="height: 50px;border-color:black; border-radius:5px">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="number" name="phone" required="true" class="form-control"
                                    id="exampleInputPassword2" value="<?php echo $row['phone'] ?>"
                                    style="height: 50px;border-color:black; border-radius:5px">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" required="true" class="form-control"
                                    id="exampleInputPassword2" value="<?php echo $row['email'] ?>"
                                    style="height: 50px;border-color:black; border-radius:5px">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" required="true" class="form-control"
                                    id="exampleInputPassword2" value="<?php echo $row['password'] ?>"
                                    style="height: 50px;border-color:black; border-radius:5px">
                            </div>
                        </div>

                        <button type="submit" name="update_data" class="btn btn-primary mr-2">update</button>

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