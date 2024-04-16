<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Kitchen Report</li>
        </ol>
    </div><!--/.row-->

   

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Kitchen Details:
                    <a href="index.php?report" class="btn btn-success pull-right" style="border-radius:0%">Booking Report</a>
                    <a href="index.php?complaint_report" class="btn btn-warning pull-right" style="border-radius:0%">Complaint Report</a>
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
                            <th>Invoice N0.</th>
                            <th>Customer Name</th>
                            <th>Total Price</th>
                            <th>Paid</th>
                            <th>Room Charged</th>
                            <th>Created Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $invoice_query = "SELECT * FROM kitchen_invoice ORDER BY id desc";
                        $invoice_result = mysqli_query($connection, $invoice_query);
                        if (mysqli_num_rows($invoice_result) > 0) {
                            $num = 0;
                            while ($invoice = mysqli_fetch_assoc($invoice_result)) {
                                $num++
                                ?>
                                <tr>
                                    <td><?php echo $num ?></td>
                                    <td><?php echo sprintf("%06d", $invoice['id']) ?></td>
                                    <td><?php echo $invoice['customer_id'] ? $invoice['customer_id'] : $invoice['description'] ?></td>
                                    <td><?php echo number_format($invoice['total_price']) ?></td>
                                    <td><?php echo number_format($invoice['paid']) ?></td>
                                    <td><?php echo $invoice['room_id'] ? get_room_name($invoice['room_id']) : "" ?></td>
                                    <td><?php echo date('M j, Y',strtotime($invoice['created_at'])) ?></td>
                                    
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
    ?>

</div>    <!--/.main-->
