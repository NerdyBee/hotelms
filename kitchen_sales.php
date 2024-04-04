<?php
    if (isset($_GET['invoice']) && $_GET['invoice']>0){
        $_SESSION['kitchen_invoice_no'] = $_GET['invoice'];
    }
?>
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
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error on Sales !
                            </div>";
                    }
                    if (isset($_GET['success'])) {
                        echo "<div class='alert alert-success'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Sales Successfully Added !
                            </div>";
                    }
                    if (isset($_GET['delete_success'])) {
                        echo "<div class='alert alert-success'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Item removed From Invoice !
                            </div>";
                    }
                    ?>
                    <form role="form" data-toggle="validator" method="post" action="ajax.php">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Inventory </label>
                                <select class="form-control" id="item" name="item" required data-error="Select Item">
                                    <option selected disabled>Select Item</option>
                                    <?php
                                    $query  = "SELECT * FROM menu";
                                    $result = mysqli_query($connection,$query);
                                    if (mysqli_num_rows($result) > 0){
                                        while ($item = mysqli_fetch_assoc($result)){
                                            echo '<option value="'.$item['item_id'].'">'.$item['item'].'</option>';
                                        }}
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                            

                            <div class="form-group col-lg-6">
                                <label>Quantity</label>
                                <input type="number" class="form-control" placeholder="Quantity" name="quantity" required />
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-lg btn-success" name="createKitchenSales" style="border-radius:0%">Add</button>
                        <!-- <button type="reset" class="btn btn-lg btn-danger" style="border-radius:0%">Reset</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Invoice Content</div>
                <div class="panel-body">
                    <h2 class="title-anchor title-heading"><?php echo $company_name?></h2>
					<p>Tel: <?php echo $company_phone?></p>
                    <p>Invoice No.: <?php echo sprintf("%06d", $_SESSION['kitchen_invoice_no'])?></p>
					<p>Kitchen Invoice</p>
                </div>
                <div class="panel-body">
                    <?php
                    if (isset($_GET['resolveError'])) {
                        echo "<div class='alert alert-danger'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error on Resolve !
                            </div>";
                    }
                    if (isset($_GET['resolveSuccess'])) {
                        echo "<div class='alert alert-success'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Item added to invoice !
                            </div>";
                    }
                    ?>
                    <table class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%" id="rooms">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Sub Total</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            
                            <?php
                                $tot = 0;
                                $invId = $_SESSION['kitchen_invoice_no'];
                                $sale_query = "SELECT * FROM kitchen_sales WHERE invoice_id = $invId";
                                $sale_result = mysqli_query($connection, $sale_query);
                                if (mysqli_num_rows($sale_result) > 0) {
                                    $num = 0;
                                    while ($sale = mysqli_fetch_assoc($sale_result)) {
                                        $num++;
                                        $tot += $sale['price'] * $sale['quantity'];
                                        ?>
                                        <tr>
                                            <td><?php echo $num ?></td>
                                            <td><?php get_item_name($sale['item_id']) ?></td>
                                            <td><?php echo number_format($sale['price']) ?></td>
                                            <!-- <td><input type="number" name="qty" value="<-?php echo $sale['quantity'] ?>" id="qty" /></td> -->
                                            <td><?php echo $sale['quantity'] ?></td>
                                            <td><?php echo number_format($sale['sub_total']) ?></td>
                                            <td>
                                                <a href="ajax.php?&inv=<?php echo $invId; ?>&delete_kitchen_invoice_item=<?php echo $sale['id']; ?>"
                                                    class="btn btn-danger" style="border-radius:60px;" onclick="return confirm('Are you Sure?')"><i
                                                                class="fa fa-trash" alt="delete"></i></a>
                                            </td>
                                        </tr>
                                    <?php }
                                } else {
                                    echo "No Sales in invoice";
                                }
                            ?>
                            <tr>
                                <td colspan="3"></td>
                                <td>Total</td>
                                <td><?php echo number_format($tot); ?></td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>
                    <div class="panel-body">
                        <div>
                            <h4 class="">Charge To Room</h4>
                        </div>
                        <form role="form" id="bar" data-toggle="validator" method="post" action="ajax.php">    
                            <div class="col-md-12">
                                <div class="form-group col-lg-6">
                                    <label>Payment Type</label>
                                    <select class="form-control" id="payment_type" name="payment_type"
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
                                    <div class="help-block with-errors"></div>
                                </div>
                                
                                <div class="form-group col-lg-6">
                                    <label>Paid</label>
                                    <input type="text" class="form-control" id="paid" name="paid" autocomplete="false" />
                                    <div class="help-block with-errors"></div>
                                </div>
                                
                                <div class="form-group col-lg-6">
                                    <label>Room</label>
                                    <select class="form-control" name="room" id="room_no" data-error="Select Room Type">
                                        <option selected disabled>Select Room</option>
                                        <?php
                                        $query  = "SELECT * FROM room WHERE check_in_status = '1'";
                                        $result = mysqli_query($connection,$query);
                                        if (mysqli_num_rows($result) > 0){
                                            while ($room = mysqli_fetch_assoc($result)){
                                                echo '<option value="'.$room['room_id'].'">'.$room['room_no'].'</option>';
                                            }}
                                        ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invId ?>" />
                                <input type="hidden" name="total_price" id="total_price" value="<?php echo $tot ?>" />

                            </div>
                            
                            <div class="form-group col-lg-6">
                                <button type="submit" class="btn btn-lg btn-success" name="saveKitchenInvoice" style="border-radius:0%">Post Invoice</button>
                                <!-- <button type="reset" class="btn btn-lg btn-danger" style="border-radius:0%">Reset</button> -->
                            </div>
                        </form>
                    </div>
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

    <div class="row">
        <div class="col-sm-12">
        <p class="back-link">Developed By Bashir Abdulhakeem</p>
        </div>
    </div>
    <?php
        function get_item_name($vl){
            global $connection;
            $query = "SELECT * from menu WHERE item_id = $vl";
            $result = mysqli_query($connection, $query);

            $itemDetails = mysqli_fetch_assoc($result);
            echo $itemDetails['item'];
        };
    ?>

</div>    <!--/.main-->