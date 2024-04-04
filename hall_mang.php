<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Manage Halls</li>
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
                <div class="panel-heading">Manage Halls
                    <button class="btn btn-secondary pull-right" style="border-radius:0%" data-toggle="modal" data-target="#addRoom">Add Halls</button>
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
                    <table class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%"
                           id="rooms">
                        <thead>
                        <tr>
                            <th>Hall</th>
                            <th>Booking Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // $room_query = "SELECT * FROM halls WHERE deleteStatus = 0";

                        $room_query = "SELECT halls.*, 
                            CASE 
                                WHEN hall_booking.hall_id IS NOT NULL THEN 'Booked'
                                ELSE 'Available'
                            END AS availability
                        FROM halls 
                        LEFT JOIN hall_booking ON halls.hall_id = hall_booking.hall_id 
                            AND STR_TO_DATE(hall_booking.check_in, '%d-%m-%Y') <= CURDATE()
                            AND STR_TO_DATE(hall_booking.check_out, '%d-%m-%Y') > CURDATE()
                        WHERE halls.deleteStatus = 0";

                        $rooms_result = mysqli_query($connection, $room_query);
                        if (mysqli_num_rows($rooms_result) > 0) {
                            while ($rooms = mysqli_fetch_assoc($rooms_result)) { ?>
                                <tr>
                                    <td><?php echo $rooms['hall'] ?></td>
                                    <td>
                                        <?php
                                        if ($rooms['availability'] == 'Available') {
                                            echo '<a href="index.php?reservation&id=' . $rooms['hall_id'] . '" class="btn btn-success" style="border-radius:0%">Book Hall</a>';
                                        } else {
                                            echo '<a href="#" class="btn btn-danger" style="border-radius:0%">Booked</a>';
                                        }
                                        ?>


                                    
                                    <td>

                                        <!-- <button title="Edit Room Information" style="border-radius:60px;" data-toggle="modal"
                                                data-target="#editRoom" data-id="<-?php echo $rooms['hall_id']; ?>"
                                                id="roomEdit" class="btn btn-info"><i class="fa fa-pencil"></i></button> -->
                                        <?php
                                        if ($rooms['availability'] == 'Booked' || $rooms['check_in_status'] == 1) {
                                            echo '<button title="Customer Information" data-toggle="modal" data-target="#cutomerDetailsModal" data-id="' . $rooms['hall_id'] . '" id="hallCutomerDetails" class="btn btn-warning" style="border-radius:60px;"><i class="fa fa-eye"></i></button>';
                                        }
                                        ?>

                                        <!-- <a href="ajax.php?delete_room=<-?php echo $rooms['hall_id']; ?>"
                                           class="btn btn-danger" style="border-radius:60px;" onclick="return confirm('Are you Sure?')"><i
                                                    class="fa fa-trash" alt="delete"></i></a> -->
                                    </td>
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

    <!---customer details-->
    <div id="cutomerDetailsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><b>Customer's Detail</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-responsive table-bordered">
                                <!-- <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Detail</th>
                                </tr>
                                </thead> -->
                                <tbody>
                                <tr>
                                    <td><b>Customer Name</b></td>
                                    <td id="customer_name"></td>
                                </tr>
                                <tr>
                                    <td><b>Contact Number</b></td>
                                    <td id="customer_contact_no"></td>
                                </tr>
                                <tr>
                                    <td><b>Remaining Amount</b></td>
                                    <td id="remaining_price"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---customer details ends here-->
    
    <div class="row">
        <div class="col-sm-12">
        <p class="back-link">Developed By Bashir Abdulhakeem</p>
        </div>
    </div>

</div>    <!--/.main-->



