<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Manage Hall Booking</li>
        </ol>
    </div><!--/.row-->

   

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Hall Bookings Details:
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
                            <th>Hall</th>
                            <th>Booking Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Outstanding</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        //$staff_query = "SELECT * FROM staff  JOIN staff_type JOIN shift ON staff.staff_type_id =staff_type.staff_type_id ON shift.";
                        $staff_query = "SELECT * FROM hall_booking NATURAL JOIN customer NATURAL JOIN halls";
                        $staff_result = mysqli_query($connection, $staff_query);

                        if (mysqli_num_rows($staff_result) > 0) {
                            while ($staff = mysqli_fetch_assoc($staff_result)) { ?>
                                <tr>

                                    <td><?php echo $staff['booking_id']; ?></td>
                                    <td><?php echo $staff['customer_name']; ?></td>
                                    <td><?php echo $staff['hall']; ?></td>
                                    <td><?php echo date('M j, Y', strtotime($staff['booking_date'])); ?></td>
                                    <td><?php echo $staff['check_in']; ?></td>
                                    <td><?php echo $staff['check_out']; ?></td>
                                    <td><?php echo number_format($staff['discount']); ?></td>
                                    <td><?php echo number_format($staff['total_price']); ?></td>
                                    <td><?php echo number_format($staff['remaining_price']); ?></td>
                                    <td><?php echo $staff['added_by']; ?></td>
                                    <td>
                                        <!-- <button title="Edit Booking" style="border-radius:60px;" data-toggle="modal"
                                            data-target="#editBooking" data-id="<-?php echo $staff['booking_id']; ?>"
                                            id="bookingEdit" class="btn btn-info"><i class="fa fa-pencil"></i></button> -->
                                        
                                        <a title="Edit Booking" href="index.php?edit_reservation&booking_id=<?php echo $staff['booking_id']; ?>"
                                           class="btn btn-info" style="border-radius:60px;"><i
                                                    class="fa fa-pencil" alt="edit"></i></a>

                                        <a href="ajax.php?delete_booking=<?php echo $staff['booking_id']; ?>"
                                            class="btn btn-danger" style="border-radius:60px;" onclick="return confirm('Are you Sure?')">
                                            <i class="fa fa-trash" alt="delete"></i></a>
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
