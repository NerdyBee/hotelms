<?php
    if (isset($_GET['booking_id'])){
        $get_reserv_id = $_GET['booking_id'];
        $get_reserv_sql = "SELECT * FROM hall_booking NATURAL JOIN hall_customer NATURAL JOIN halls WHERE booking_id = '$get_reserv_id'";
        $get_reserv_result = mysqli_query($connection,$get_reserv_sql);
        $get_reserv = mysqli_fetch_assoc($get_reserv_result);

        $get_customer_id = $get_reserv['customer_id'];
        $get_customer_name = $get_reserv['customer_name'];
        $get_contact = $get_reserv['contact_no'];
        $get_reserv_hall_id = $get_reserv['hall_id'];
        $get_reserv_hall = $get_reserv['hall'];
        $get_reserv_discount = $get_reserv['discount'];
        $get_check_in = $get_reserv['check_in'];
        $get_check_out = $get_reserv['check_out'];

        $date1 = new DateTime($get_check_in);
        $date2 = new DateTime($get_check_out);
        $interval = $date1->diff($date2);
        $daysDifference = $interval->days;

        if($get_reserv_result){
            $get_hall_sql = "SELECT * FROM halls WHERE hall_id = '$get_reserv_hall_id'";
            $get_hall_result = mysqli_query($connection,$get_hall_sql);
            $get_hall = mysqli_fetch_assoc($get_hall_result);

            $get_hall_id = $get_hall['hall_id'];
            $get_hall_name = $get_hall['hall'];
            $get_hall_price = $get_hall['price'];
        }
    }
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Hall Reservation</li>
        </ol>
    </div><!--/.row-->

    <!-- <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Reservation</h1>
        </div>
    </div>/.row -->

    

    <div class="row">
        <div class="col-lg-12">
            <form role="form" id="edit_hallBooking" data-toggle="validator" autocomplete="off">
                <div class="response"></div>
                <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Hall Information:
                                <!-- <a class="btn btn-secondary pull-right" style="border-radius:0%" href="index.php?reservation">Replan Booking</a> -->
                            </div>
                            <div class="panel-body">
                                <div class="form-group col-lg-6">
                                    <label>Halls</label>
                                    <select class="form-control" id="hall" onchange="fetch_hall_price(this.value)" required data-error="Select Hall">
                                        <option selected disabled>Select Hall</option>
                                        <?php
                                        $query  = "SELECT * FROM halls";
                                        $result = mysqli_query($connection,$query);
                                        if (mysqli_num_rows($result) > 0){
                                            while ($hall = mysqli_fetch_assoc($result)){
                                                if ($hall['hall_id'] == $get_hall_id) {
                                                    echo '<option selected value="'.$hall['hall_id'].'">'.$hall['hall'].'</option>';
                                                } else {
                                                    echo '<option value="'.$hall['hall_id'].'">'.$hall['hall'].'</option>';
                                                }
                                            }}
                                        ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Check In Date</label>
                                    <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="check_in_date" data-error="Select Check In Date" value="<?php echo $get_check_in ?>" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Check Out Date</label>
                                    <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="check_out_date" data-error="Select Check Out Date" value="<?php echo $get_check_out ?>" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Discount</label>
                                    <input type="number" class="form-control" onblur="myFunction()" id="discount" value="<?php echo $get_reserv_discount; ?>" data-error="Discount can't be more than 40% of cost">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="col-lg-12">
                                    <h4 style="font-weight: bold">Total Days : <span id="staying_day"><?php echo $daysDifference; ?></span> Day(s)</h4>
                                    <h4 style="font-weight: bold">Price: ₦<span id="price"><?php echo $get_hall_price; ?></span> </h4>
                                    <h4 style="font-weight: bold">Total Amount : ₦<span id="total_price"><?php echo $get_hall_price * $daysDifference; ?></span> </h4>
                                    <h4 style="font-weight: bold">Discount : ₦<span id="disco"><?php echo $get_reserv_discount; ?></span> </h4>
                                    <h4 style="font-weight: bold">Total Paying : ₦<span id="total_pay"><?php echo $get_hall_price * $daysDifference - $get_reserv_discount; ?></span> </h4>
                                </div>
                            </div>
                        </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Customer Detail:</div>
                        <div class="panel-body">
                            <div class="form-group col-lg-6">
                                <label>Full Name</label>
                                <input class="form-control" placeholder="Full Name" value="<?php echo $get_customer_name; ?>" id="full_name" data-error="Enter Full Name" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Contact Number</label>
                                <input type="number" class="form-control" data-error="Enter Min 10 Digit" data-minlength="10" value="<?php echo $get_contact; ?>" placeholder="Contact No" id="contact_no" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <input type="hidden" name="booking_id" id="booking_id" value="<?php echo $get_reserv_id ?>" required />
                            <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $get_customer_id ?>" required />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-lg btn-success pull-right" style="border-radius:0%">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <p class="back-link">Developed By Bashir Abdulhakeem</p>
        </div>
    </div>

</div>    <!--/.main-->


<!-- Booking Confirmation-->
<div id="hallBookingConfirm" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"><b>Hall Booking</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert bg-success alert-dismissable" role="alert"><em class="fa fa-lg fa-check-circle">&nbsp;</em>Hall Successfully Booked</div>
                        <table class="table table-striped table-bordered table-responsive">
                            <!-- <thead>
                            <tr>
                                <th>Name</th>
                                <th>Detail</th>
                            </tr>
                            </thead> -->
                            <tbody>
                            <tr>
                                <td><b>Customer Name</b></td>
                                <td id="getCustomerName"></td>
                            </tr>
                            <tr>
                                <td><b>Hall</b></td>
                                <td id="getHall"></td>
                            </tr>
                            <tr>
                                <td><b>Check In</b></td>
                                <td id="getCheckIn"></td>
                            </tr>
                            <tr>
                                <td><b>Check Out</b></td>
                                <td id="getCheckOut"></td>
                            </tr>
                            <tr>
                                <td><b>Discount</b></td>
                                <td id="getDiscount"></td>
                            </tr>
                            <tr>
                                <td><b>Total Amount</b></td>
                                <td id="getTotalPrice"></td>
                            </tr>
                            <tr>
                                <td><b>Payment Status</b></td>
                                <td id="getPaymentStaus"></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" style="border-radius:60px;" href="index.php?hall_reservation_mang"><i class="fa fa-check-circle"></i></a>
            </div>
        </div>

    </div>
</div>


