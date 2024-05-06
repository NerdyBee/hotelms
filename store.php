<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Store</li>
        </ol>
    </div><!--/.row-->

    

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Supply Bar</div>
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
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Item removed From Supply !
                            </div>";
                    }
                    ?>
                    <form role="form" data-toggle="validator" method="post" action="ajax.php">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Item </label>
                                <select class="form-control" id="item" name="item" required data-error="Select Item">
                                    <option selected disabled>Select Item</option>
                                    <?php
                                    $query  = "SELECT * FROM inventory ORDER BY item";
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

                        <button type="submit" class="btn btn-lg btn-success" name="addStore" style="border-radius:0%">Add</button>
                        <!-- <button type="reset" class="btn btn-lg btn-danger" style="border-radius:0%">Reset</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Supply History</div>
                <!-- <div class="panel-body">
                    <h2 class="title-anchor title-heading"><?php echo $company_name?></h2>
					<p>Tel: <?php echo $company_phone?></p>
                    <p>Invoice No.: <?php echo sprintf("%06d", $_SESSION['invoice_no'])?></p>
					<p>Kitchen/Bar Invoice</p>
                </div> -->
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
                            <th>Quantity</th>
                            <th>Added Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            
                            <?php
                                $tot = 0;
                                $store_query = "SELECT * FROM store";
                                $store_result = mysqli_query($connection, $store_query);
                                if (mysqli_num_rows($store_result) > 0) {
                                    $num = 0;
                                    while ($store = mysqli_fetch_assoc($store_result)) {
                                        $num++;
                                        // $tot += $store['price'] * $store['quantity'];
                                        ?>
                                        <tr>
                                            <td><?php echo $num ?></td>
                                            <td><?php get_item_name($store['item_id']) ?></td>
                                            <td><?php echo $store['quantity'] ?></td>
                                            <td><?php echo $store['created_at'] ?></td>
                                            <td>
                                                <a href="ajax.php?delete_invoice_item=<?php echo $store['store_id']; ?>"
                                                    class="btn btn-danger" style="border-radius:60px;" onclick="return confirm('Are you Sure?')"><i
                                                                class="fa fa-trash" alt="delete"></i></a>
                                            </td>
                                        </tr>
                                    <?php }
                                } else {
                                    echo "No Supplies";
                                }
                            ?>
                            <!-- <tr>
                                <td colspan="3"></td>
                                <td>Total</td>
                                <td><-?php echo number_format($tot); ?></td>
                                <td></td>
                            </tr> -->

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

    <div class="row">
        <div class="col-sm-12">
        <p class="back-link">Developed By Bashir Abdulhakeem</p>
        </div>
    </div>
    <?php
        function get_item_name($vl){
            global $connection;
            $query = "SELECT * from inventory WHERE item_id = $vl";
            $result = mysqli_query($connection, $query);

            $itemDetails = mysqli_fetch_assoc($result);
            echo $itemDetails['item'];
        };

        function get_stok($vl){
            global $connection;
            $query_supply = "SELECT sum(quantity) AS s_supply FROM supply WHERE item_id = $vl";
            $query_store = "SELECT sum(quantity) AS s_store FROM store WHERE item_id = $vl";
            $query_sales = "SELECT sum(quantity) AS s_sales FROM sales WHERE item_id = $vl";
            $result_supply = mysqli_query($connection, $query_supply);
            $result_store = mysqli_query($connection, $query_store);
            $result_sales = mysqli_query($connection, $query_sales);

            if($result_supply) {
                $sum_supply = mysqli_fetch_assoc($result_supply);
                $sup = $sum_supply['s_supply'];
            } else {
                $sup = 0;
            }
            if($result_store) {
                $sum_store = mysqli_fetch_assoc($result_store);
                $store = $sum_store['s_store'];
            } else {
                $store = 0;
            }
            if($result_sales) {
                $sum_sales = mysqli_fetch_assoc($result_sales);
                $sal = $sum_sales['s_sales'];
            } else {
                $sal = 0;
            }
            echo $sup - $sal;
            // echo $sal;
        };
    ?>

</div>    <!--/.main-->