<?php
$userId = $_SESSION['user_id'];
$query = "SELECT * from user WHERE id = $userId";
$result = mysqli_query($connection, $query);

$userDetails = mysqli_fetch_assoc($result);
?>
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
                    <form role="form" id="changePword" data-toggle="validator">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Full Name</label>
                                <input type="text" class="form-control" placeholder="Full Name" value="<?php echo $userDetails['name'] ?>" readonly id="full_name" required data-error="Enter Full Name">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Username</label>
                                <input type="text" class="form-control" placeholder="Username" value="<?php echo $userDetails['username'] ?>" readonly id="username" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="janedoe@mail.com" readonly id="email" value="<?php echo $userDetails['email'] ?>" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Old Password</label>
                                <input type="password" class="form-control" placeholder="Old Password" id="old_password" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>New Password</label>
                                <input type="password" class="form-control" placeholder="New Password" id="new_password" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Repeat New Password</label>
                                <input type="password" class="form-control" placeholder="Repeat Password" id="repeat_password" required />
                                <div class="help-block with-errors"></div>
                            </div>
                            <input type="hidden" class="form-control" value="<?php echo $userDetails['id'] ?>" id="userId" required />
                            <input type="hidden" class="form-control" value="<?php echo $userDetails['password'] ?>" id="pword" required />

                        </div>

                        <button type="submit" class="btn btn-lg btn-success" style="border-radius:0%">Submit</button>
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




