<?php
session_start();
include("./connection/connection.php");

$userAddStatus = "";

if (isset($_POST["add_user"])) {
  
    $required_fields = ['fullname', 'region', 'phone', 'email', 'password'];
    $errors = array();
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            $errors[] = "$field is required.";
        }
    }

    if (empty($errors)) {
        $fullname = $_POST['fullname'];
        $region = $_POST['region'];
        $district = isset($_POST['district']) ? $_POST['district'] : ''; 
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);

     
        $insert_new_user = "INSERT INTO users (fullname, region, district, phone, email, password) 
                            VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $insert_new_user);
        mysqli_stmt_bind_param($stmt, "ssssss", $fullname, $region, $district, $phone, $email, $password);
        if (mysqli_stmt_execute($stmt)) {
            $user_id = mysqli_insert_id($connect); 

            $role_id_query = "SELECT role_id FROM roles WHERE name = 'ExtensionOfficer'";
            $role_id_result = mysqli_query($connect, $role_id_query);
            if ($role_id_result && mysqli_num_rows($role_id_result) > 0) {
                $role_id_row = mysqli_fetch_assoc($role_id_result);
                $role_id = $role_id_row['role_id'];
                $insert_user_role = "INSERT INTO userroles (user_id, role_id) VALUES (?, ?)";
                $stmt = mysqli_prepare($connect, $insert_user_role);
                mysqli_stmt_bind_param($stmt, "ii", $user_id, $role_id);
                mysqli_stmt_execute($stmt);

                $userAddStatus = "<div class='alert alert-success'>You are successfully registered as an Extension Officer.</div>";
            } else {
                $userAddStatus = "<div class='alert alert-danger'>Error occurred while assigning role.</div>";
            }
        } else {
            $userAddStatus = "<div class='alert alert-danger'>Error occurred while adding user.</div>";
        }
    } else {
       
        $errorMessage = '';
        foreach ($errors as $error) {
            $errorMessage .= "<div class='alert alert-danger'>$error</div>";
        }
       
        $userAddStatus = $errorMessage;
    }
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <title>Farm rental system</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./assets3/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./assets3/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./assets3/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./assets3/css/util.css">
    <link rel="stylesheet" type="text/css" href="./assets3/css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100">

            <div class="wrap-login100">

                <span class="login100-form-title p-b-0" style="color: teal;">
                    FARM RENTAL SYSTEM
                </span>
                <span class="login100-form-title p-b-0" style="color: teal;">
                    <i class="zmdi zmdi-account-circle"></i>
                </span>
                <!-- Display error and success messages -->
                <div id="message">
                    <?php echo $userAddStatus; ?>
                </div>

                <form class="login100-form validate-form" action="" method="POST">

                    <div class="wrap-input100 validate-input" data-validate="enter fullname">
                        <input required="true" class="input100" type="text" name="fullname">
                        <span class="focus-input100" data-placeholder="fullname"></span>
                    </div>

                    <!-- Region Dropdown -->
                    <div class="wrap-input100 validate-input" data-validate="Select region">
                        <select required="true" class="input100" id="region" name="region" onchange="fetchDistricts()">
                            <option value="" disabled selected>Select Region</option>
                            <option value="Arusha">Arusha</option>
                            <option value="Dar es Salaam">Dar es Salaam</option>
                            <option value="Dodoma">Dodoma</option>
                            <option value="Geita">Geita</option>
                            <option value="Iringa">Iringa</option>
                            <option value="Kagera">Kagera</option>
                            <option value="Katavi">Katavi</option>
                            <option value="Kigoma">Kigoma</option>
                            <option value="Kilimanjaro">Kilimanjaro</option>
                            <option value="Lindi">Lindi</option>
                            <option value="Manyara">Manyara</option>
                            <option value="Mara">Mara</option>
                            <option value="Mbeya">Mbeya</option>
                            <option value="Morogoro">Morogoro</option>
                            <option value="Mtwara">Mtwara</option>
                            <option value="Mwanza">Mwanza</option>
                            <option value="Njombe">Njombe</option>
                            <option value="Pwani">Pwani</option>
                            <option value="Rukwa">Rukwa</option>
                            <option value="Ruvuma">Ruvuma</option>
                            <option value="Shinyanga">Shinyanga</option>
                            <option value="Simiyu">Simiyu</option>
                            <option value="Singida">Singida</option>
                            <option value="Tabora">Tabora</option>
                            <option value="Tanga">Tanga</option>
                        </select>
                    </div>

                    <!-- District Dropdown -->
                    <div class="wrap-input100 validate-input" data-validate="Select district">
                        <select required="true" class="input100" id="district" name="district">
                            <option value="" disabled selected>Select District</option>
                        </select>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="enter phone">
                        <input class="input100" type="number" name="phone">
                        <span class="focus-input100" data-placeholder="phone"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
                        <input class="input100" type="text" name="email">
                        <span class="focus-input100" data-placeholder="Email"></span>
                    </div>


                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>


                    <!-- <input type="hidden" name="role" value="ExtensionOfficer">
                    <span class="focus-input100"></span> -->


                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" type="submit" name="add_user"
                                style="background-color: teal;">
                                Register
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-10">
                        <span class="txt1">
                            Already have an account?
                        </span>

                        <a class="txt2" href="./index.php">
                            Sign In
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="./assets3/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="./assets3/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="./assets3/vendor/bootstrap/js/popper.js"></script>
    <script src="./assets3/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="./assets3/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="./assets3/vendor/daterangepicker/moment.min.js"></script>
    <script src="./assets3/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="./assets3/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="./assets3/js/main.js"></script>


    <script>
    // Function to fetch and populate districts based on the selected region
    function fetchDistricts() {
        var region = document.getElementById('region').value;
        var districts = {
            "Arusha": ["Arusha", "Meru", "Arusha City", "Karatu"],
            "Dar es Salaam": ["Ilala", "Kinondoni", "Temeke", "Kigamboni"],
            "Dodoma": ["Dodoma", "Bahi", "Chamwino", "Kondoa"],
            "Geita": ["Geita", "Bukombe", "Chato", "Mbogwe"],
            "Iringa": ["Iringa", "Iringa Rural", "Kilolo", "Mafinga"],
            "Kagera": ["Bukoba", "Bukoba Rural", "Karagwe", "Misenyi"],
            "Katavi": ["Mpanda", "Mlele", "Nsimbo", "Tanganyika"],
            "Kigoma": ["Kigoma", "Buhigwe", "Kakonko", "Kasulu"],
            "Kilimanjaro": ["Moshi", "Hai", "Mwanga", "Rombo"],
            "Lindi": ["Lindi", "Kilwa", "Liwale", "Nachingwea"],
            "Manyara": ["Babati", "Hanang", "Kiteto", "Simanjiro"],
            "Mara": ["Musoma", "Bunda", "Butiama", "Rorya"],
            "Mbeya": ["Mbeya", "Chunya", "Kyela", "Rungwe"],
            "Morogoro": ["Morogoro", "Gairo", "Kilombero", "Ulanga"],
            "Mtwara": ["Mtwara", "Masasi", "Nanyumbu", "Newala"],
            "Mwanza": ["Mwanza", "Ilemela", "Kwimba", "Magu"],
            "Njombe": ["Njombe", "Ludewa", "Makambako", "Wanging'ombe"],
            "Pwani": ["Kibaha", "Bagamoyo", "Kisarawe", "Mkuranga"],
            "Rukwa": ["Sumbawanga", "Kalambo", "Nkasi", "Sumbawanga Rural"],
            "Ruvuma": ["Songea", "Mbinga", "Tunduru", "Namtumbo"],
            "Shinyanga": ["Shinyanga", "Kahama", "Kishapu", "Shinyanga Rural"],
            "Simiyu": ["Bariadi", "Busega", "Itilima", "Maswa"],
            "Singida": ["Singida", "Iramba", "Manyoni", "Singida Rural"],
            "Tabora": ["Tabora", "Igunga", "Kaliua", "Urambo"],
            "Tanga": ["Tanga", "Handeni", "Kilindi", "Korogwe"]
        };

        var districtDropdown = document.getElementById('district');
        districtDropdown.innerHTML = '<option value="" disabled selected>Select District</option>';
        if (districts[region]) {
            districts[region].forEach(function(district) {
                var option = document.createElement('option');
                option.value = district;
                option.text = district;
                districtDropdown.appendChild(option);
            });
        }
    }
    </script>
</body>

</html>