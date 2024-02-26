<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Add Employee</li>
        </ol>
    </div><!--/.row-->

    <!-- <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add Employee</h1>
        </div>
    </div> -->
    <!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Employee Detail:</div>
                <div class="panel-body">
                    <div class="user-response"></div>
                    <form role="form" id="addUser" data-toggle="validator">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Staff</label>
                                <select class="form-control" id="user_priv" required data-error="Select User Privilege">
                                    <option selected disabled>Select User Privilege</option>
                                    <?php
                                    $query = "SELECT * FROM privileges";
                                    $result = mysqli_query($connection, $query);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($staff = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $staff['privilege_id'] . '">' . $staff['privilege'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Full Name</label>
                                <input type="text" class="form-control" placeholder="Full Name" id="full_name" required data-error="Enter Full Name">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Username</label>
                                <input type="text" class="form-control" placeholder="Username" id="username" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="janedoe@mail.com" id="email" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password" id="password" required>
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-lg btn-success" style="border-radius:0%">Submit</button>
                        <button type="reset" class="btn btn-lg btn-danger" style="border-radius:0%">Reset</button>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-sm-12">
        <p class="back-link">Developed By Bashir Abdulhakeem</p>
        </div>
    </div>

</div>    <!--/.main-->




