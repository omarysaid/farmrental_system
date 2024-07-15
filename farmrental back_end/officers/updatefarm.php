<?php
include("../include/header.php");
include("../include/offsidebar.php");


$updateStatus = "";

$errors = [];


if (isset($_GET['farm_id'])) {
    $farm_id = $_GET['farm_id'];
    $select_farm = "SELECT farm_image, status FROM farms WHERE farm_id = '$farm_id'";
    $result = mysqli_query($connect, $select_farm);

    if ($result && mysqli_num_rows($result) > 0) {
        $farm = mysqli_fetch_assoc($result);
    } else {
        $errors[] = "Farm not found.";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_farm'])) {
    $status = $_POST['status'];
    $fertile = $_POST['fertile'];

   
    if (empty($errors)) {
        $update_farm = "UPDATE farms SET status = '$status', fertile = '$fertile' WHERE farm_id = '$farm_id'";
        if (mysqli_query($connect, $update_farm)) {
            $updateStatus = "Farm details updated successfully.";
        } else {
            $updateStatus = "Error occurred while updating farm details.";
        }
    }
}
?>

<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height: 484px;">
                <div class="card-header shadow" style="background-color: black;">
                    <h3 style="color: white;">Aprove Farm Details</h3>
                </div>



                <div class="alert <?php echo !empty($updateStatus) && strpos($updateStatus, 'successfully') !== false ? 'alert-success' : ''; ?>"
                    id="successsMessage" style="width:1100px; margin-left:140px">
                    <?php echo $updateStatus; ?>
                </div>

                <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger" style="width:1100px; margin-left:50px">
                    <?php foreach ($errors as $error) {
                            echo $error . "<br>";
                        } ?>
                </div>
                <?php endif; ?>

                <?php if (isset($farm)) : ?>
                <div class="card-body shadow">
                    <form class="forms-sample" method="post">
                        <div class="form-group row">
                            <label for="farmImage" class="col-sm-2 col-form-label">Farm Image</label>
                            <div class="col-sm-10">
                                <img src="../APIs/uploads/<?php echo $farm['farm_image']; ?>" alt="farm_image"
                                    style="width: 800px; height: 500px;margin-left:100px; border-radius:10px">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="status" name="status"
                                    style="border-color: black; border-radius: 5px;">
                                    <option value="" disabled>Select Status</option>
                                    <option value="1" <?php echo ($farm['status'] == '1') ? 'selected' : ''; ?>>
                                        Aproved</option>
                                    <option value="0" <?php echo ($farm['status'] == '0') ? 'selected' : ''; ?>>
                                        Not Aproved
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Fertile Soil</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="exampleInputUsername2"
                                    placeholder="Enter fertile here" name="fertile"
                                    style="height: 200px; border-color:black; border-radius:5px;"></textarea>
                            </div>
                        </div>

                        <button type="submit" name="update_farm" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light" type="reset">Cancel</button>
                    </form>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php
include("../include/footer.php");
include("../include/formjs.php");
?>