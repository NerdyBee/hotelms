<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Gym/Pool</li>
        </ol>
    </div><!--/.row-->

    

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Gym/Pool</div>
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
                                <label>Service</label>
                                <!--input type="text" class="form-control" placeholder="Description" name="description" required-->
                                <select class="form-control" id="service" name="service" required data-error="Select Service">
                                        <option selected disabled>Select</option>
                                        <option value="gym">Gym</option>
                                        <option value="pool">Pool</option>
                                        <option value="other">Others</option>
                                    </select>
                                <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group col-lg-6">
                                <label>Description</label>
                                <input type="text" class="form-control" placeholder="Description" name="description">
                                <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group col-lg-6">
                                <label>Amount</label>
                                <input type="number" class="form-control" placeholder="Amount" name="amount">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Payment Type</label>
                                <select class="form-control" name="payment_type" id="payment_type" required
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
                            </div>

                            <!-- <div class="form-group col-lg-12">
                                <label>Please Describe Your Complaints</label>
                                <textarea class="form-control" name="complaint" placeholder="Complaint" required></textarea>
                            </div> -->

                        </div>

                        <button type="submit" class="btn btn-lg btn-success" name="createGym" style="border-radius:0%">Submit</button>
                        <button type="reset" class="btn btn-lg btn-danger" style="border-radius:0%">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Gym/Pool Activities</div>
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
                            <th>Service</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Payment Type</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $laundry_query = "SELECT * FROM gym_pool";
                        $laundry_result = mysqli_query($connection, $laundry_query);
                        if (mysqli_num_rows($laundry_result) > 0) {
                            $num = 0;
                            while ($laundry = mysqli_fetch_assoc($laundry_result)) {
                                $num++
                                ?>
                                <tr>
                                    <td><?php echo $num ?></td>
                                    <td><?php echo $laundry['service'] ?></td>
                                    <td><?php echo $laundry['description'] ?></td>
                                    <td><?php echo number_format($laundry['amount']) ?></td>
                                    <td><?php echo $laundry['payment_type'] ?></td>
                                    <td><?php get_user($laundry['added_by']); ?></td>
                                    <td>
                                        <button title="Edit Gym" style="border-radius:60px;" data-toggle="modal"
                                                data-target="#editGym" data-id="<?php echo $laundry['id']; ?>"
                                                id="gymEdit" class="btn btn-info"><i class="fa fa-pencil"></i></button>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "No Service yet";
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!--Edit Gym Modal -->
    <div id="editGym" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Gym/Pool</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="gymEditFrom" data-toggle="validator" role="form">
                                <div class="edit_response"></div>

                                <div class="form-group">
                                    <label>Service</label>
                                    <!--input class="form-control" placeholder="Description" id="edit_description" required
                                           data-error="Enter Description"-->
                                    <select class="form-control" id="edit_service" required data-error="Select option">
                                        <option selected disabled>Select</option>
                                        <option value="gym">Gym</option>
                                        <option value="pool">Pool</option>
                                        <option value="other">Others</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" placeholder="Description" id="edit_description" required
                                           data-error="Enter Description">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" placeholder="Amount" id="edit_amount" required
                                           data-error="Enter Amount">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <input type="hidden" id="edit_id">
                                <button class="btn btn-success pull-right">Edit</button>
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
        function get_user($vl){
            global $connection;
            $query = "SELECT * from user WHERE id = $vl";
            $result = mysqli_query($connection, $query);

            $itemDetails = mysqli_fetch_assoc($result);
            echo $itemDetails['name'];
        };
    ?>

</div>    <!--/.main-->