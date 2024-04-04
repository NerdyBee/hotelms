<?php
if (isset($_GET['id'])){
    $get_book_id = $_GET['id'];
    // $get_book_sql = "SELECT * FROM booking  NATURAL JOIN customer NATURAL JOIN room WHERE booking_id = '$get_book_id'";
    $get_book_sql = "SELECT * 
        FROM booking 
        JOIN customer ON booking.customer_id = customer.customer_id 
        JOIN room ON booking.room_id = room.room_id 
        WHERE booking.booking_id = '$get_book_id'";
    $get_book_result = mysqli_query($connection,$get_book_sql);
    $get_book = mysqli_fetch_assoc($get_book_result);

    $get_book_id = $get_book['booking_id'];
    $get_book_room_id = $get_book['room_id'];
    $get_book_customer_id = $get_book['customer_id'];
    $get_book_customer = $get_book['customer_name'];
    $get_book_checkin = $get_book['check_in'];
    $get_book_checkout = $get_book['check_out'];
    $get_book_price = $get_book['total_price'];

    $dateout = new DateTime($get_book_checkout);
    $datein = new DateTime($get_book_checkin);
    $numDays = $dateout->diff($datein)->format('%a');
}
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">More Rooms</li>
        </ol>
    </div><!--/.row-->

    <br>

    <div class="row">
        <div class="col-lg-12">
            <div id="success"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add More Rooms to Reservation
                    <!-- <button class="btn btn-secondary pull-right" style="border-radius:0%" data-toggle="modal" data-target="#addHall">Add More Rooms</button> -->
                </div>
                <div class="panel-body">
                    <?php
                    if (isset($_GET['error'])) {
                        echo "<div class='alert alert-danger'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error on Delete !
                            </div>";
                    }
                    if (isset($_GET['success'])) {
                        echo "<div class='alert alert-success'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Successfully Delete !
                            </div>";
                    }
                    ?>
                    <form role="form" id="moreBooking" data-toggle="validator" autocomplete="off">
                    <div class="user-response"></div>
                    <div class="col-lg-12">
                        <h4 style="font-weight: bold">Customer: <span id="customer"><?php echo $get_book_customer; ?></span> </h4>
                        <h4 style="font-weight: bold">Check In: <span id="checkin"><?php echo $get_book_checkin; ?></span> </h4>
                        <h4 style="font-weight: bold">Check Out: <span id="checkout"><?php echo $get_book_checkout; ?></span> </h4>
                    </div>
                    <div class="form-group col-lg-12">
                        <div class="panel-heading">Available Rooms</div>
                        <?php
                        // $room_query = "SELECT * FROM room NATURAL JOIN room_type WHERE deleteStatus = 0";

                        $room_query = "SELECT room.*, room_type.*, 
                            CASE 
                                WHEN EXISTS (
                                    SELECT 1 
                                    FROM booking 
                                    WHERE room.room_id = booking.room_id 
                                    AND (
                                        (STR_TO_DATE(booking.check_in, '%d-%m-%Y') >= STR_TO_DATE('$get_book_checkin', '%d-%m-%Y') AND STR_TO_DATE(booking.check_in, '%d-%m-%Y') < STR_TO_DATE('$get_book_checkout', '%d-%m-%Y')) 
                                        OR 
                                        (STR_TO_DATE(booking.check_out, '%d-%m-%Y') > STR_TO_DATE('$get_book_checkin', '%d-%m-%Y') AND STR_TO_DATE(booking.check_out, '%d-%m-%Y') <= STR_TO_DATE('$get_book_checkout', '%d-%m-%Y'))
                                        OR
                                        (STR_TO_DATE(booking.check_in, '%d-%m-%Y') < STR_TO_DATE('$get_book_checkin', '%d-%m-%Y') AND STR_TO_DATE(booking.check_out, '%d-%m-%Y') > STR_TO_DATE('$get_book_checkout', '%d-%m-%Y'))
                                    )
                                ) THEN 'Booked'
                                ELSE 'Available'
                            END AS availability
                        FROM room 
                        INNER JOIN room_type ON room.room_type_id = room_type.room_type_id";

                        $rooms_result = mysqli_query($connection, $room_query);

                        $rooms_result = mysqli_query($connection, $room_query);
                        if (mysqli_num_rows($rooms_result) > 0) {
                            while ($rooms = mysqli_fetch_assoc($rooms_result)) {
                                if($get_book_room_id == $rooms['room_id']){
                                    ?>
                                    <input checked type="checkbox" id="<?php echo $rooms['room_id'] ?>" onclick="return false;" name="room_no" value="<?php echo $rooms['room_id'] ?>">
                                    <label for="room_no"><?php echo $rooms['room_no'] ?></label>&emsp;
                                <?php
                                } else { 
                                    if($rooms['availability'] == 'Available') {?>
                                    <!-- <input type="checkbox" id="<-?php echo $rooms['room_id'] ?>" onclick="fetch_more_price(this.value)" name="room_no[]" value="<-?php echo $rooms['room_id'] ?>"> -->
                                    <input type="checkbox" id="<?php echo $rooms['room_id'] ?>" onclick="handleCheckbox(this)" name="room_no" value="<?php echo $rooms['room_id'] ?>">

                                    <label for="room_no"><?php echo $rooms['room_no'] ?></label>&emsp;
                                <?php }
                                    }
                                ?>
                                
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Discount</label>
                        <input type="number" class="form-control" onblur="myFunction_more()" id="discount" data-error="Discount can't be more than 40% of cost">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="hidden" value="<?php echo $get_book_id ?>" id="bookingId">
                        <input type="hidden" value="<?php echo $get_book_customer_id ?>" id="customerId">
                    </div>
                     <div class="col-lg-12">
                        <h4 style="font-weight: bold">Total Days : <span id="staying_day"><?php echo $numDays; ?></span> Day(s)</h4>
                        <h4 style="font-weight: bold">Price: ₦<span id="price"><?php echo $get_book_price / $numDays; ?></span> </h4>
                        <h4 style="font-weight: bold">Total Amount : ₦<span id="total_price"><?php echo $get_book_price; ?></span> </h4>
                        <h4 style="font-weight: bold">Discount : ₦<span id="disco">0</span> </h4>
                        <h4 style="font-weight: bold">Total Paying : ₦<span id="total_pay">0</span> </h4>
                    </div>
                    <button type="submit" class="btn btn-lg btn-success pull-right" style="border-radius:0%">Submit</button>
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



