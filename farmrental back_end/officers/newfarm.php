<?php
include("../include/header.php");
include("../include/offsidebar.php");
?>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header shadow d-block" style="background-color: black; width:fit-content">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 style="color: white;font-size: 18px;">Farm Details Table</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-responsive">
                        <table id="multi-colum-dt" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Size</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Document</th>
                                    <th>Farm Image</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$cnt = 1; 


$logged_in_user_id = $_SESSION['user_id'];
$logged_in_user_query = "
    SELECT 
        u.user_id, 
        u.district,
        r.name AS role
    FROM 
        users u 
    JOIN 
        userroles ur ON u.user_id = ur.user_id
    JOIN 
        roles r ON ur.role_id = r.role_id
    WHERE 
        u.user_id = '$logged_in_user_id'
";
$logged_in_user_result = mysqli_query($connect, $logged_in_user_query) or die(mysqli_error($connect));
$logged_in_user = mysqli_fetch_assoc($logged_in_user_result);
$logged_in_user_role = $logged_in_user['role'];
$logged_in_user_district = $logged_in_user['district'];


if ($logged_in_user_role == 'ExtensionOfficer') {
    $select = "
        SELECT 
            f.farm_id, 
            f.user_id, 
            f.size, 
            f.description, 
            f.price, 
            f.document, 
            f.farm_image, 
            f.status,
            u.fullname AS user_name,
            u.district AS user_district
        FROM 
            farms f
        JOIN 
            users u ON f.user_id = u.user_id
        WHERE 
            f.status = 0 AND u.district = '$logged_in_user_district'
    ";
} else {
    $select = "
        SELECT 
            f.farm_id, 
            f.user_id, 
            f.size, 
            f.description, 
            f.price, 
            f.document, 
            f.farm_image, 
            f.status,
            u.fullname AS user_name
        FROM 
            farms f
        JOIN 
            users u ON f.user_id = u.user_id
        WHERE 
            f.status = 0
    ";
}

$result = mysqli_query($connect, $select) or die(mysqli_error($connect));
$number = mysqli_num_rows($result);

if ($number > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
?>
                                <tr>
                                    <td><?php echo $cnt++; ?></td>
                                    <td><?php echo $row['user_name']; ?></td>
                                    <td><?php echo $row['size']; ?></td>
                                    <td>
                                        <?php 
                                        $description_words = explode(" ", $row['description']);
                                        foreach (array_chunk($description_words, 5) as $description_chunk) {
                                            echo implode(" ", $description_chunk) . "<br>";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><a
                                            href="../APIs/documents/<?php echo $row['document']; ?>"><?php echo $row['document']; ?></a>
                                    </td>
                                    <td><img src="../APIs/uploads/<?php echo $row['farm_image']; ?>" alt="farm_image"
                                            style="width: 150px; height: 150px;"></td>
                                    <td style="color: red;">
                                        <?php echo '<i class="fa fa-check"></i>'; ?><b>Not Approved</b>
                                    </td>
                                    <td>
                                        <?php
                                       
                                        if (in_array('Update', $_SESSION['permissions'])) {
                                        ?>
                                        <span>
                                            <a href="./updatefarm.php?farm_id=<?php echo $row['farm_id'] ?>">
                                                <button class="btn btn-success">
                                                    <i class="ik ik-edit"></i>
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
                                                onclick="confirmDelete(<?php echo $row['farm_id'] ?>)">
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
    echo "<tr><td colspan='9'>No results found</td></tr>";
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
function confirmDelete(id) {

    if (confirm("Are you sure you want to delete this farm?")) {

        window.location.href = "./deletefarm.php?farm_id=" + id;
    }
}
</script>