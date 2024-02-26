<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Inventory</li>
        </ol>
    </div><!--/.row-->

    

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Item</div>
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
                                <label>Item Name</label>
                                <input type="text" class="form-control" placeholder="Item Name" name="item_name" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Item Category</label>
                                <select class="form-control" id="item_category" name="category" required data-error="Select Item Category">
                                    <option selected disabled>Select Item Category</option>
                                    <?php
                                    $query  = "SELECT * FROM departments order by name";
                                    $result = mysqli_query($connection,$query);
                                    if (mysqli_num_rows($result) > 0){
                                        while ($room_type = mysqli_fetch_assoc($result)){
                                            echo '<option value="'.$room_type['id'].'">'.ucfirst($room_type['name']).'</option>';
                                        }}
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Price</label>
                                <input type="text" class="form-control" placeholder="Price" name="price" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <!-- <div class="form-group col-lg-12">
                                <label>Please Describe Your Complaints</label>
                                <textarea class="form-control" name="complaint" placeholder="Complaint" required></textarea>
                            </div> -->

                        </div>

                        <button type="submit" class="btn btn-lg btn-success" name="createItem" style="border-radius:0%">Submit</button>
                        <button type="reset" class="btn btn-lg btn-danger" style="border-radius:0%">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Inventory Items</div>
                <div class="panel-body">
                    <?php
                    if (isset($_GET['resolveError'])) {
                        echo "<div class='alert alert-danger'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error on Resolve !
                            </div>";
                    }
                    if (isset($_GET['resolveSuccess'])) {
                        echo "<div class='alert alert-success'>
                                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Complaint Successfully Resolve !
                            </div>";
                    }
                    ?>
                    <table class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%" id="rooms">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Item Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $inventory_query = "SELECT * FROM inventory";
                        $inventory_result = mysqli_query($connection, $inventory_query);
                        if (mysqli_num_rows($inventory_result) > 0) {
                            $num = 0;
                            while ($inventory = mysqli_fetch_assoc($inventory_result)) {
                                $num++
                                ?>
                                <tr>
                                    <td><?php echo $num ?></td>
                                    <td><?php echo $inventory['item'] ?></td>
                                    <td><?php echo get_category($inventory['category']) ?></td>
                                    <td><?php echo number_format($inventory['price']) ?></td>
                                    <td><?php echo get_stok($inventory['item_id']) ?></td>
                                    <td>
                                        <button title="Edit Item" style="border-radius:60px;" data-toggle="modal"
                                                data-target="#editItem" data-id="<?php echo $inventory['item_id']; ?>"
                                                id="itemEdit" class="btn btn-info"><i class="fa fa-pencil"></i></button>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "No Items";
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Add Item Modal -->
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

    <!--Edit Room Modal -->
    <div id="editItem" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Item</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="itemEditFrom" data-toggle="validator" role="form">
                                <div class="edit_response"></div>

                                <div class="form-group">
                                    <label>Item</label>
                                    <input class="form-control" placeholder="Item" id="edit_item" required
                                           data-error="Enter Item Name">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" id="edit_category" required
                                           data-error="Select Item Category">
                                           <option selected disabled>Select Item Category</option>
                                            <?php
                                                $query  = "SELECT * FROM departments order by name";
                                                $result = mysqli_query($connection,$query);
                                                if (mysqli_num_rows($result) > 0){
                                                    while ($item = mysqli_fetch_assoc($result)){
                                                        echo '<option value="'.$item['id'].'">'.ucfirst($item['name']).'</option>';
                                                    }}
                                            ?>
                                        </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" class="form-control" placeholder="Item Price" id="edit_price" required
                                           data-error="Enter Item Price">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="number" class="form-control" placeholder="Stock" id="edit_quantity" required
                                           data-error="Enter Item Stock">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <input type="hidden" id="edit_item_id">
                                <button class="btn btn-success pull-right">Edit Item</button>
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
        function get_category($vl){
            global $connection;
            $query = "SELECT * from departments WHERE id = $vl";
            $result = mysqli_query($connection, $query);

            $itemDetails = mysqli_fetch_assoc($result);
            echo $itemDetails['name'];
        };

        function get_stok($vl){
            global $connection;
            $query_supply = "SELECT sum(quantity) AS s_supply FROM supply WHERE item_id = $vl";
            $query_sales = "SELECT sum(quantity) AS s_sales FROM sales WHERE item_id = $vl";
            $result_supply = mysqli_query($connection, $query_supply);
            $result_sales = mysqli_query($connection, $query_sales);

            if($result_supply) {
                $sum_supply = mysqli_fetch_assoc($result_supply);
                $sup = $sum_supply['s_supply'];
            } else {
                $sup = 0;
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