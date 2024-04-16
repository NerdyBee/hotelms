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
                            <th>Contact</th>
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
                        $staff_query = "SELECT * FROM hall_booking NATURAL JOIN hall_customer NATURAL JOIN halls ORDER BY booking_id DESC";
                        $staff_result = mysqli_query($connection, $staff_query);

                        if (mysqli_num_rows($staff_result) > 0) {
                            $num = 0;
                            while ($staff = mysqli_fetch_assoc($staff_result)) {
                                $num++
                                ?>
                                <tr>

                                    <td><?php echo $num ?></td>
                                    <td><?php echo $staff['customer_name']; ?></td>
                                    <td><?php echo $staff['contact_no']; ?></td>
                                    <td><?php echo $staff['hall']; ?></td>
                                    <td><?php echo date('M j, Y', strtotime($staff['booking_date'])); ?></td>
                                    <td><?php echo $staff['check_in']; ?></td>
                                    <td><?php echo $staff['check_out']; ?></td>
                                    <td><?php echo number_format($staff['discount']); ?></td>
                                    <td><?php echo number_format($staff['total_price']); ?></td>
                                    <td><?php echo number_format($staff['remaining_price']); ?></td>
                                    <td><?php get_user($staff['added_by']); ?></td>
                                    <td>
                                        <button title="Pay For Hall" style="border-radius:60px;" data-toggle="modal"
                                            data-target="#hallPaymentModal" data-id="<?php echo $staff['booking_id']; ?>"
                                            id="hallPayments" class="btn btn-success"><i class="fa fa-money"></i></button>
                                        
                                        <a title="Edit Hall Booking" href="index.php?edit_hall_reservation&booking_id=<?php echo $staff['booking_id']; ?>"
                                           class="btn btn-info" style="border-radius:60px;"><i
                                                    class="fa fa-pencil" alt="edit"></i></a>

                                        <a href="ajax.php?delete_halls_booking=<?php echo $staff['booking_id']; ?>&customer=<?php echo $staff['customer_id']; ?>"
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

     <!-- Payment Modal-->
    <div id="hallPaymentModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><b>Hall- Payment</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-responsive table-bordered">
                                
                                <tbody>
                                <tr>
                                    <td><b>Customer Name</b></td>
                                    <td id="getCustomerName_p"></td>
                                </tr>
                                <tr>
                                    <td><b>Hall</b></td>
                                    <td id="getHall"></td>
                                </tr>
                                <tr>
                                    <td><b>Check In</b></td>
                                    <td id="getCheckIn_p"></td>
                                </tr>
                                <tr>
                                    <td><b>Check Out</b></td>
                                    <td id="getCheckOut_p"></td>
                                </tr>
                                <tr>
                                    <td><b>Total Amount</b></td>
                                    <td id="getTotalPrice_p"></td>
                                </tr>
                                <tr>
                                    <td><b>Remaining Amount</b></td>
                                    <td id="getRemainingPrice_p"></td>
                                </tr>
                                </tbody>
                            </table>
                            <form role="form" id="hallPayment" data-toggle="validator">
                                <div class="payment-response"></div>
                                <div class="form-group col-lg-12">
                                    <label><b>Amount</b></label>
                                    <input type="number" class="form-control" id="hall_payment"
                                           placeholder="Make Payment" required
                                           data-error="Please Enter valid Amount">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Payment Type</label>
                                    <select class="form-control" id="payment_type" required
                                            data-error="Select Payment Type">
                                        <option selected disabled>Select Payment Type</option>
                                        <?php
                                        $query = "SELECT * FROM payment_type";
                                        $result = mysqli_query($connection, $query);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($payment_type = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $payment_type['payment_type'] . '">' . $payment_type['payment_type'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="hidden" id="getBookingId_h">
                                <button type="submit" class="btn btn-primary pull-right">Proceed Payment</button>
                            </form>
                        </div>
                    </div>
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
