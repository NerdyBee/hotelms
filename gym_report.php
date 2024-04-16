<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Gym/Pool Report</li>
        </ol>
    </div><!--/.row-->

   

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Gym/Pool Details:
                    <a href="index.php?report" class="btn btn-success pull-right" style="border-radius:0%">Booking Report</a>
                    <a href="index.php?sales_report" class="btn btn-secondary pull-right" style="border-radius:0%">Sales Report</a>
                    <a href="index.php?complaint_report" class="btn btn-warning pull-right" style="border-radius:0%">Complaint Report</a>
                    <a href="index.php?laundry_report" class="btn btn-danger pull-right" style="border-radius:0%">Laundry Report</a>
                </div>
                <div class="panel-body">
                    <?php
                    if (isset($_GET['error'])) {
                        echo "<div class='alert alert-danger'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error on Shift Change !
                            </div>";
                    }
                    if (isset($_GET['success'])) {
                        echo "<div class='alert alert-success'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Shift Successfully Changed!
                            </div>";
                    }
                    ?>
                    <table class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%"
                           id="rooms">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Created Date</th>
                            <th>Added By</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $complaint_query = "SELECT * FROM gym_pool";
                        $complaint_result = mysqli_query($connection, $complaint_query);
                        if (mysqli_num_rows($complaint_result) > 0) {
                            $num = 0;
                            while ($complaint = mysqli_fetch_assoc($complaint_result)) {
                                $num++
                                ?>
                                <tr>
                                    <td><?php echo $num ?></td>
                                    <td><?php echo $complaint['service'] ?></td>
                                    <td><?php echo $complaint['description'] ?></td>
                                    <td><?php echo number_format($complaint['amount']) ?></td>
                                    <td><?php echo date('M j, Y',strtotime($complaint['created_at'])) ?></td>
                                    <td><?php get_user($complaint['added_by']) ?></td>


                                </tr>
                            <?php }
                        } else {
                            echo "No Rooms";
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

    <?php
        function get_room_name($vl){
            global $connection;
            $query = "SELECT * from room WHERE room_id = $vl";
            $result = mysqli_query($connection, $query);

            $itemDetails = mysqli_fetch_assoc($result);
            echo $itemDetails['room_no'];
        };
        function get_user($vl){
            global $connection;
            $query = "SELECT * from user WHERE id = $vl";
            $result = mysqli_query($connection, $query);

            $itemDetails = mysqli_fetch_assoc($result);
            echo $itemDetails['name'];
        };
    ?>

</div>    <!--/.main-->
