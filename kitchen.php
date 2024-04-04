<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Kitchen</li>
        </ol>
    </div><!--/.row-->

    

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Make Kitchen Sales</div>
                <div class="panel-body">
                    <?php
                    if (isset($_GET['error'])) {
                        echo "<div class='alert alert-danger'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error on Complaint !
                            </div>";
                    }
                    if (isset($_GET['success'])) {
                        echo "<div class='alert alert-success'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Complaint Successfully Added !
                            </div>";
                    }
                    ?>
                    <form role="form"  data-toggle="validator" method="post" action="ajax.php">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" class="form-control" placeholder="Table 1" value="Table" name="customer" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg btn-success" name="createKitchenInvoice" style="border-radius:0%">New Transaction</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Kitchen Invoices</div>
                <div class="panel-body">
                    <?php
                    if (isset($_GET['resolveError'])) {
                        echo "<div class='alert alert-danger'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error on Resolve !
                            </div>";
                    }
                    if (isset($_GET['resolveSuccess'])) {
                        echo "<div class='alert alert-success'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invoice Successfully Resolve !
                            </div>";
                    }
                    ?>
                    <table class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%" id="rooms">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice N0.</th>
                            <th>Customer Name</th>
                            <th>Total Price</th>
                            <th>Paid</th>
                            <th>Payment Type</th>
                            <th>Room Charged</th>
                            <th>Created Date</th>
                            <th>Action</th>
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
                                    <td><?php echo $invoice['payment_type'] ?></td>
                                    <td><?php echo $invoice['room_id'] ? get_room_name($invoice['room_id']) : "" ?></td>
                                    <td><?php echo date('M j, Y',strtotime($invoice['created_at'])) ?></td>
                                    <td>
                                        <a title="Edit Invoice" href="index.php?editKitchenInvoice&invoice=<?php echo $invoice['id']; ?>"
                                           class="btn btn-info" style="border-radius:60px;"><i
                                                    class="fa fa-pencil" alt="edit"></i></a>

                                        <!-- <button title="Edit Invoice" style="border-radius:60px;" data-toggle="modal"
                                                data-target="#editInvoice" data-id="<-?php echo $invoice['id']; ?>"
                                                id="invoiceEdit" class="btn btn-info"><i class="fa fa-pencil"></i></button> -->

                                        <button title="View Invoice Content" style="border-radius:60px;" data-toggle="modal"
                                                data-target="#invoiceDetailsModal" data-id="<?php echo $invoice['id']; ?>"
                                                id="invoiceDetails" class="btn btn-warning"><i class="fa fa-eye"></i></button>

                                        <!--?php
                                        if ($invoice['total_price'] != 0 && $invoice['total_price'] == $invoice['paid']) {
                                            echo '<button title="Invoice Detail" data-toggle="modal" data-target="#invoiceDetailsModal"
                                            data-id="' . $invoice['id'] . '" id="invoiceDetails" class="btn btn-success" style="border-radius:60px;">
                                            <i class="fa fa-list"></i></button>';
                                        }
                                        ?-->

                                        <!-- <a href="ajax.php?delete_invoice=<-?php echo $invoice['id']; ?>"
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

    <!-- Add Room Modal -->
    <div id="complaintModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Complaint Resolve</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form data-toggle="validator" role="form" method="post" action="ajax.php">
                                <div class="form-group">
                                    <label>Budget</label>
                                    <input class="form-control" placeholder="Budget" name="budget" data-error="Enter Budget" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <input type="hidden" id="complaint_id" name="complaint_id" value="">
                                <button class="btn btn-success pull-right" name="resolve_complaint">Resolve Complaint</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!---customer details-->
    <div id="invoiceDetailsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><b>Invoice Content</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>Invocie No</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Added Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr id="inv_det">
                                        <!-- <td id="invoice_id"></td>
                                        <td id="invoice_item"></td>
                                        <td id="invoice_quantity"></td>
                                        <td id="invoice_price"></td>
                                        <td id="invoice_created_at"></td> -->
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