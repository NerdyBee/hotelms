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
            <form role="form" id="hallBooking" data-toggle="validator" autocomplete="off">
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
                                                echo '<option value="'.$hall['hall_id'].'">'.$hall['hall'].'</option>';
                                            }}
                                        ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Check In Date</label>
                                    <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="check_in_date" data-error="Select Check In Date" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Check Out Date</label>
                                    <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="check_out_date" data-error="Select Check Out Date" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Discount</label>
                                    <input type="number" class="form-control" onblur="myFunction()" id="discount" data-error="Discount can't be more than 40% of cost">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="col-lg-12">
                                    <h4 style="font-weight: bold">Total Days : <span id="staying_day">0</span> Day(s)</h4>
                                    <h4 style="font-weight: bold">Price: ₦<span id="price">0</span> </h4>
                                    <h4 style="font-weight: bold">Total Amount : ₦<span id="total_price">0</span> </h4>
                                    <h4 style="font-weight: bold">Discount : ₦<span id="disco">0</span> </h4>
                                    <h4 style="font-weight: bold">Total Paying : ₦<span id="total_pay">0</span> </h4>
                                </div>
                            </div>
                        </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Customer Detail:</div>
                        <div class="panel-body">
                            <div class="form-group col-lg-6">
                                <label>First Name</label>
                                <input class="form-control" placeholder="First Name" id="first_name" data-error="Enter First Name" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Last Name</label>
                                <input class="form-control" placeholder="Last Name" id="last_name" data-error="Enter Last Name" required>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Contact Number</label>
                                <input type="number" class="form-control" data-error="Enter Min 10 Digit" data-minlength="10" placeholder="Contact No" id="contact_no" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Email Address</label>
                                <input type="email" class="form-control" placeholder="Email Address" id="email">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>ID Card Type</label>
                                <select class="form-control" id="id_card_id" onchange="validId(this.value);">
                                    <option selected value=" ">Select ID Card Type</option>
                                    <?php
                                    $query  = "SELECT * FROM id_card_type";
                                    $result = mysqli_query($connection,$query);
                                    if (mysqli_num_rows($result) > 0){
                                        while ($id_card_type = mysqli_fetch_assoc($result)){
                                            echo '<option value="'.$id_card_type['id_card_type_id'].'">'.$id_card_type['id_card_type'].'</option>';
                                        }}
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Selected ID Card Number</label>
                                <input type="text" class="form-control" placeholder="ID Card Number" id="id_card_no">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-12">
                                <label>Residential Address</label>
                                <input type="text" class="form-control" placeholder="Full Address" id="address" required>
                                <div class="help-block with-errors"></div>
                            </div>
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
<div id="bookingConfirm" class="modal fade" role="dialog">
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
                <a class="btn btn-primary" style="border-radius:60px;" href="index.php?hall_mang"><i class="fa fa-check-circle"></i></a>
            </div>
        </div>

    </div>
</div>


