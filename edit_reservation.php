<?php
    if (isset($_GET['booking_id'])){
        $get_reserv_id = $_GET['booking_id'];
        $get_reserv_sql = "SELECT * FROM booking NATURAL JOIN customer NATURAL JOIN room WHERE booking_id = '$get_reserv_id'";
        $get_reserv_result = mysqli_query($connection,$get_reserv_sql);
        $get_reserv = mysqli_fetch_assoc($get_reserv_result);

        $get_customer_id = $get_reserv['customer_id'];
        $get_customer_name = $get_reserv['customer_name'];
        $get_contact = $get_reserv['contact_no'];
        $get_address = $get_reserv['address'];
        $get_email = $get_reserv['email'];
        $get_id_type = $get_reserv['id_card_type_id'];
        $get_id_no = $get_reserv['id_card_no'];
        $get_reserv_room_id = $get_reserv['room_id'];
        $get_reserv_no = $get_reserv['room_no'];
        $get_reserv_discount = $get_reserv['discount'];
        $get_reserv_type_id = $get_reserv['room_type_id'];
        $get_check_in = $get_reserv['check_in'];
        $get_check_out = $get_reserv['check_out'];

        if($get_reserv_result){
            $get_room_sql = "SELECT * FROM room NATURAL JOIN room_type WHERE room_id = '$get_reserv_room_id'";
            $get_room_result = mysqli_query($connection,$get_room_sql);
            $get_room = mysqli_fetch_assoc($get_room_result);

            $get_room_type_id = $get_room['room_type_id'];
            $get_room_type = $get_room['room_type'];
            $get_room_no = $get_room['room_no'];
            $get_room_price = $get_room['price'];
        }

        $sep_name = explode(' ',$get_customer_name);
    }
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Reservation</li>
        </ol>
    </div><!--/.row-->

    <!-- <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Reservation</h1>
        </div>
    </div>/.row -->

    

    <div class="row">
        <div class="col-lg-12">
            <form role="form" id="edit_booking" data-toggle="validator">
                <div class="response"></div>
                <div class="col-lg-12">
                    <?php
                    if (isset($_GET['booking_id'])){?>

                        <div class="panel panel-default">
                            <div class="panel-heading">Room Information:
                                <a class="btn btn-secondary pull-right" href="index.php?room_mang">Replan Booking</a>
                            </div>
                            <div class="panel-body">
                                <div class="form-group col-lg-6">
                                    <label>Room Type</label>
                                    <!-- <select class="form-control" id="room_type" data-error="Select Room Type" required>
                                        <option selected disabled>Select Room Type</option>
                                        <option selected value="<-?php echo $get_room_type_id; ?>"><-?php echo $get_room_type; ?></option>
                                    </select> -->
                                    <select class="form-control" id="room_type" onchange="fetch_room(this.value);" required data-error="Select Room Type">
                                        <option disabled>Select Room Type</option>
                                        <?php
                                            $query  = "SELECT * FROM room_type";
                                            $result = mysqli_query($connection,$query);
                                            if (mysqli_num_rows($result) > 0){
                                                while ($room_type = mysqli_fetch_assoc($result)){
                                                    if ($room_type['room_type_id'] == $get_room_type_id) {
                                                        echo '<option selected value="'.$room_type['room_type_id'].'">'.$room_type['room_type'].'</option>';
                                                    } else {
                                                        echo '<option value="'.$room_type['room_type_id'].'">'.$room_type['room_type'].'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Room No</label>
                                    <select class="form-control" id="room_no" onchange="fetch_price(this.value)" required data-error="Select Room No">
                                        <option selected disabled>Select Room No</option>
                                        <option selected value="<?php echo $get_reserv_id; ?>"><?php echo $get_reserv_no; ?></option>
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
                                    <h4 style="font-weight: bold">Total Days : <span id="staying_day">0</span> Day(s)</h4>
                                    <h4 style="font-weight: bold">Price: ₦<span id="price"><?php echo $get_room_price; ?></span></h4>
                                    <h4 style="font-weight: bold">Total Amount : ₦<span id="total_price">0</span> </h4>
                                    <h4 style="font-weight: bold">Discount : ₦<span id="disco">0</span> </h4>
                                    <h4 style="font-weight: bold">Total Paying : ₦<span id="total_pay">0</span> </h4>
                                </div>
                            </div>
                        </div>
                    <?php } else{?>
                        <div class="panel panel-default">
                            <div class="panel-heading">Room Information:
                                <a class="btn btn-secondary pull-right" style="border-radius:0%" href="index.php?reservation">Replan Booking</a>
                            </div>
                            <div class="panel-body">
                                <div class="form-group col-lg-6">
                                    <label>Room Type</label>
                                    <select class="form-control" id="room_type" onchange="fetch_room(this.value);" required data-error="Select Room Type">
                                        <option selected disabled>Select Room Type</option>
                                        <?php
                                        $query  = "SELECT * FROM room_type";
                                        $result = mysqli_query($connection,$query);
                                        if (mysqli_num_rows($result) > 0){
                                            while ($room_type = mysqli_fetch_assoc($result)){
                                                echo '<option value="'.$room_type['room_type_id'].'">'.$room_type['room_type'].'</option>';
                                            }}
                                        ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Room No</label>
                                    <select class="form-control" id="room_no" onchange="fetch_price(this.value)" required data-error="Select Room No">

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
                    <?php }
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Customer Detail:</div>
                        <div class="panel-body">
                            <div class="form-group col-lg-6">
                                <label>First Name</label>
                                <input class="form-control" placeholder="First Name" value="<?php echo $sep_name[0]; ?>" id="first_name" data-error="Enter First Name" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Last Name</label>
                                <input class="form-control" placeholder="Last Name" id="last_name" value="<?php echo $sep_name[1]; ?>" data-error="Enter Last Name" required>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Contact Number</label>
                                <input type="number" class="form-control" data-error="Enter Min 10 Digit" data-minlength="10" placeholder="Contact No" id="contact_no" value="<?php echo $get_contact; ?>" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Email Address</label>
                                <input type="email" class="form-control" placeholder="Email Address" id="email" value="<?php echo $get_email ?>">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>ID Card Type</label>
                                <select class="form-control" id="id_card_id" onchange="validId(this.value);">
                                    <option value=" ">Select ID Card Type</option>
                                    <?php
                                    $query  = "SELECT * FROM id_card_type";
                                    $result = mysqli_query($connection,$query);
                                    if (mysqli_num_rows($result) > 0){
                                        while ($id_card_type = mysqli_fetch_assoc($result)){
                                            if($id_card_type['id_card_type_id'] == $get_id_type){
                                                echo '<option selected value="'.$id_card_type['id_card_type_id'].'">'.$id_card_type['id_card_type'].'</option>';
                                            } else {
                                                echo '<option value="'.$id_card_type['id_card_type_id'].'">'.$id_card_type['id_card_type'].'</option>';
                                            }
                                        }}
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Selected ID Card Number</label>
                                <input type="text" class="form-control" placeholder="ID Card Number" id="id_card_no" value="<?php echo $get_id_no ?>">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-12">
                                <label>Residential Address</label>
                                <input type="text" class="form-control" placeholder="Full Address" id="address" value="<?php echo $get_address ?>" required>
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
<div id="bookingConfirm" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"><b>Room Booking</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert bg-success alert-dismissable" role="alert"><em class="fa fa-lg fa-check-circle">&nbsp;</em>Room Successfully Booked</div>
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
                                <td><b>Room Type</b></td>
                                <td id="getRoomType"></td>
                            </tr>
                            <tr>
                                <td><b>Room No</b></td>
                                <td id="getRoomNo"></td>
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
                <a class="btn btn-primary" style="border-radius:60px;" href="index.php?room_mang"><i class="fa fa-check-circle"></i></a>
            </div>
        </div>

    </div>
</div>


