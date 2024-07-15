<?php
include("../include/header.php");
include("../include/sidebar.php");
?>
<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height: 484px;">
                <div class="card-header shadow" style="background-color: teal;">
                    <h3 style="color: white;">User Registration form</h3>
                </div>
                <div class="card-body shadow">
                    <form class="forms-sample">
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="exampleInputUsername2"
                                    placeholder="Username" style="height: 50px;border-color:black; border-radius:5px">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputEmail2" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email"
                                    style="height: 50px;border-color:black; border-radius:5px">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputMobile" class="col-sm-2 col-form-label">Mobile</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="exampleInputMobile"
                                    placeholder="Mobile number"
                                    style="height: 50px;border-color:black; border-radius:5px">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="exampleInputPassword2"
                                    placeholder="Password" style="height: 50px;border-color:black; border-radius:5px">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputConfirmPassword2" class="col-sm-2 col-form-label">Re
                                Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="exampleInputConfirmPassword2"
                                    placeholder="Password" style="height: 50px;border-color:black; border-radius:5px">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="../Users/view.php"><button class="btn btn-light">Cancel</button></a>
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