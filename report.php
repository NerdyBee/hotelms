<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Booking Report</li>
        </ol>
    </div><!--/.row-->

   

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Bookings Details:
                    <a href="index.php?sales_report" class="btn btn-secondary pull-right" style="border-radius:0%">Bar Report</a>
                    <a href="index.php?complaint_report" class="btn btn-warning pull-right" style="border-radius:0%">Complaint Report</a>
                    <a href="index.php?gym_report" class="btn btn-success pull-right" style="border-radius:0%">Gym/Pool Report</a>
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
                            <th>Customer</th>
                            <th>Room</th>
                            <th>Booking Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Outstanding</th>
                            <th>Added By</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        //$staff_query = "SELECT * FROM staff  JOIN staff_type JOIN shift ON staff.staff_type_id =staff_type.staff_type_id ON shift.";
                        $staff_query = "SELECT * FROM booking NATURAL JOIN customer NATURAL JOIN room ORDER BY booking_id DESC";
                        $staff_result = mysqli_query($connection, $staff_query);

                        if (mysqli_num_rows($staff_result) > 0) {
                            while ($staff = mysqli_fetch_assoc($staff_result)) { ?>
                                <tr>

                                    <td><?php echo $staff['booking_id']; ?></td>
                                    <td><?php echo $staff['customer_name']; ?></td>
                                    <td><?php echo $staff['room_no']; ?></td>
                                    <td><?php echo date('M j, Y', strtotime($staff['booking_date'])); ?></td>
                                    <td><?php echo $staff['check_in']; ?></td>
                                    <td><?php echo $staff['check_out']; ?></td>
                                    <td><?php echo number_format($staff['discount']); ?></td>
                                    <td><?php echo number_format($staff['total_price']); ?></td>
                                    <td><?php echo number_format($staff['remaining_price']); ?></td>
                                    <td><?php get_user($staff['added_by']); ?></td>
                                    
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
    <?php
        function get_user($vl){
            global $connection;
            $query = "SELECT * from user WHERE id = $vl";
            $result = mysqli_query($connection, $query);

            $itemDetails = mysqli_fetch_assoc($result);
            echo $itemDetails['name'];
        };
    ?>

</div>    <!--/.main-->
