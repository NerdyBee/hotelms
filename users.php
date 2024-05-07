<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Manage Users</li>
        </ol>
    </div><!--/.row-->

   

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">User Details:
                    <a href="index.php?add_user" class="btn btn-secondary pull-right" style="border-radius:0%">Add User</a>
                </div>
                <div class="panel-body">
                    <?php
                    if (isset($_GET['error'])) {
                        echo "<div class='alert alert-danger'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error on User Change !
                            </div>";
                    }
                    if (isset($_GET['updated'])) {
                        echo "<div class='alert alert-success'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; User Successfully Changed!
                            </div>";
                    }
                    ?>
                    <table class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%"
                           id="rooms">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Privilege</th>
                            <th>Added Date</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        //$staff_query = "SELECT * FROM staff  JOIN staff_type JOIN shift ON staff.staff_type_id =staff_type.staff_type_id ON shift.";
                        $staff_query = "SELECT * FROM user NATURAL JOIN privileges";
                        $staff_result = mysqli_query($connection, $staff_query);

                        if (mysqli_num_rows($staff_result) > 0) {
                            while ($staff = mysqli_fetch_assoc($staff_result)) { ?>
                                <tr>

                                    <td><?php echo $staff['id']; ?></td>
                                    <td><?php echo $staff['name']; ?></td>
                                    <td><?php echo $staff['username']; ?></td>
                                    <td><?php echo $staff['email']; ?></td>
                                    <td><?php echo $staff['privilege']; ?></td>
                                    <td><?php echo date('M j, Y', strtotime($staff['created_at'])); ?></td>
                                    <td><?php get_user($staff['added_by']); ?></td>
                                    <td>

                                        <button data-toggle="modal"
                                                data-target="#userDetail<?php echo $staff['id']; ?>"
                                                data-id="<?php echo $staff['id']; ?>" id="editUser"
                                                class="btn btn-info" style="border-radius:60px;"><i class="fa fa-pencil"></i></button>
                                        <?php if($staff['status'] == 1){ ?>
                                            <a href='functionmis.php?userid=<?php echo $staff['id']; ?>'
                                            class="btn btn-danger" onclick="return confirm('Are you Sure yuo want to deactivate user?')" style="border-radius:60px;"><i
                                                        class="fa fa-trash"></i></a>
                                        <?php } else { ?>
                                            <a href='functionmis.php?restore=<?php echo $staff['id']; ?>'
                                            class="btn btn-warning" onclick="return confirm('Are you Sure you want to activate user?')" style="border-radius:60px;"><i
                                                        class="fa fa-window-restore"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>


                                <?php
                            }
                        }
                        ?>


                        </tbody>
                    </table>
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

<?php
//$staff_query = "SELECT * FROM staff  JOIN staff_type JOIN shift ON staff.staff_type_id =staff_type.staff_type_id ON shift.";
$staff_query = "SELECT * FROM user";
$staff_result = mysqli_query($connection, $staff_query);

if (mysqli_num_rows($staff_result) > 0) {
    while ($staffGlobal = mysqli_fetch_assoc($staff_result)) {
        $fullname = explode(" ", $staffGlobal['name']);
        ?>

        <!-- Employee Detail-->
        <div id="userDetail<?php echo $staffGlobal['id']; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">User Detail</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <!-- <div class="panel-heading">User Detail:</div> -->
                                    <div class="panel-body">
                                        <form data-toggle="validator" role="form" action="functionmis.php"
                                              method="post">
                                            <div class="row">
                                                <div class="form-group col-lg-6">
                                                    <label>Privilege</label>
                                                    <select class="form-control" id="staff_type_id" name="staff_type_id"
                                                            required>
                                                        <option selected disabled>Select User Privilege</option>
                                                        <?php
                                                        $query = "SELECT * FROM privileges";
                                                        $result = mysqli_query($connection, $query);
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($staff = mysqli_fetch_assoc($result)) {
                                                                //  echo '<option value=" ' . $staff['staff_type_id'] . ' "  selected  >' . $staff['staff_type'] . '</option>';
                                                                echo '<option value="' . $staff['privilege_id'] . '" ' . (($staff['privilege_id'] == $staffGlobal['privilege_id']) ? 'selected="selected"' : "") . '>' . $staff['privilege'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <input type="hidden" value="<?php echo $staffGlobal['id']; ?>"
                                                       id="user_id" name="user_id">

                                                <div class="form-group col-lg-6">
                                                    <label>Full Name</label>
                                                    <input type="text" value="<?php echo $staffGlobal['name']; ?>"
                                                           class="form-control" placeholder="Full Name" id="full_name"
                                                           name="full_name" required>
                                                </div>

                                                <div class="form-group col-lg-6">
                                                    <label>Username</label>
                                                    <input type="text" value="<?php echo $staffGlobal['username']; ?>"
                                                           class="form-control" placeholder="Username" id="username"
                                                           name="username" required>
                                                </div>

                                                <div class="form-group col-lg-6">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control"
                                                           placeholder="janedoe@mail.com" id="email"
                                                           value="<?php echo $staffGlobal['email']; ?>"
                                                           name="email" required>
                                                </div>

                                                <div class="form-group col-lg-6">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" placeholder="password"
                                                           id="password" name="password">
                                                </div>

                                                <div class="form-group col-lg-6">
                                                    <label>Repeat Password</label>
                                                    <input type="password" class="form-control" placeholder="repeat password"
                                                           id="repeat_password" name="repeat_password">
                                                </div>

                                            </div>

                                            <button type="submit" class="btn btn-lg btn-primary" name="update">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- Employee Detail-->
        <div id="changeShift" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Change Shift</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <form data-toggle="validator" role="form" action="ajax.php" method="post">
                                            <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label>Shift</label>
                                                <select class="form-control" id="shift" name="shift_id" required>
                                                    <option selected disabled>Select Staff Type</option>
                                                    <?php
                                                    $query = "SELECT * FROM shift";
                                                    $result = mysqli_query($connection, $query);
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($shift = mysqli_fetch_assoc($result)) {
                                                            // echo '<option value="' . $shift['shift_id'] . '">' . $shift['shift'] . ' - ' . $shift['shift_timing'] . '</option>';
                                                            echo '<option value="' . $shift['shift_id'] . '" ' . (($shift['shift_id'] == $staffGlobal['shift_id']) ? 'selected="selected"' : "") . '>' . $shift['shift_timing'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            </div>
                                            <input type="hidden" name="emp_id" value="" id="getEmpId">
                                            <button type="submit" class="btn btn-lg btn-primary" name="change_shift">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </div>
        <?php
    }
}
function get_user($vl){
    global $connection;
    $query = "SELECT * from user WHERE id = $vl";
    $result = mysqli_query($connection, $query);

    $itemDetails = mysqli_fetch_assoc($result);
    echo $itemDetails['name'];
};
?>