<?php
include("../include/header.php");
include("../include/sidebar.php");
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
                                    <th>Farmer Name</th>
                                    <th>Size</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Document</th>
                                    <th>Farm Image</th>
                                    <th>Fertile</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$cnt = 1; 
$select = "
    SELECT 
        f.farm_id, 
        f.user_id, 
        f.size, 
        f.description, 
        f.price, 
        f.document, 
        f.farm_image, 
          f.fertile, 
        f.status,
        u.fullname AS user_name
    FROM 
        farms f
    JOIN 
        users u ON f.user_id = u.user_id
";
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
                                        foreach(array_chunk($description_words, 4) as $description_chunk) {
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

                                    <td>
                                        <?php 
                                        $description_words = explode(" ", $row['fertile']);
                                        foreach(array_chunk($description_words, 4) as $description_chunk) {
                                            echo implode(" ", $description_chunk) . "<br>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($row['status'] == 1): ?>
                                        <b style="color:green"> <i class="fa fa-check"></i> Approved</b>
                                        <?php else: ?>
                                        <b style="color:red"> <i class="fa fa-times"></i> Not Approved</b>
                                        <?php endif; ?>
                                    </td>
                                    <td>

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
function confirmDelete(farm_id) {
    if (confirm("Are you sure you want to delete this farm?")) {
        window.location.href = "./delete.php?farm_id=" + farm_id;
    }
}
</script>