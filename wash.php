<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Laundry Service</li>
        </ol>
    </div><!--/.row-->

    

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Laundry Service</div>
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
                                <label>Apparel Type</label>
                                <input type="text" class="form-control" placeholder="Apparel Type" name="apparel" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Washing/Ironing Price</label>
                                <input type="text" class="form-control" placeholder="Washing and Ironing" name="wash">
                                <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group col-lg-6">
                                <label>Ironing Only Price</label>
                                <input type="text" class="form-control" placeholder="Ironing Only" name="iron">
                                <div class="help-block with-errors"></div>
                            </div>

                            <!-- <div class="form-group col-lg-12">
                                <label>Please Describe Your Complaints</label>
                                <textarea class="form-control" name="complaint" placeholder="Complaint" required></textarea>
                            </div> -->

                        </div>

                        <button type="submit" class="btn btn-lg btn-success" name="createLaundry" style="border-radius:0%">Submit</button>
                        <button type="reset" class="btn btn-lg btn-danger" style="border-radius:0%">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Laundry Price List</div>
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
                            <th>Apparel</th>
                            <th>Washing/ironing</th>
                            <th>Ironing Only</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $laundry_query = "SELECT * FROM laundry";
                        $laundry_result = mysqli_query($connection, $laundry_query);
                        if (mysqli_num_rows($laundry_result) > 0) {
                            $num = 0;
                            while ($laundry = mysqli_fetch_assoc($laundry_result)) {
                                $num++
                                ?>
                                <tr>
                                    <td><?php echo $num ?></td>
                                    <td><?php echo $laundry['apparel'] ?></td>
                                    <td><?php echo number_format($laundry['wash_iron']) ?></td>
                                    <td><?php echo number_format($laundry['iron']) ?></td>
                                    <td>
                                        <button title="Edit Laundry" style="border-radius:60px;" data-toggle="modal"
                                                data-target="#editLaundry" data-id="<?php echo $laundry['id']; ?>"
                                                id="laundryEdit" class="btn btn-info"><i class="fa fa-pencil"></i></button>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "No Service defined";
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!--Edit Laundry Modal -->
    <div id="editLaundry" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Laundry</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="laundryEditFrom" data-toggle="validator" role="form">
                                <div class="edit_response"></div>

                                <div class="form-group">
                                    <label>Apparel</label>
                                    <input class="form-control" placeholder="Apparel" id="edit_apparel" required
                                           data-error="Enter Apparel Name">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>Washing/Ironing Price</label>
                                    <input type="number" class="form-control" placeholder="Washing/Ironing Price" id="edit_wash" required
                                           data-error="Enter Washing/Ironing Price">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>Ironing Only Price</label>
                                    <input type="number" class="form-control" placeholder="Ironing Price" id="edit_iron" required
                                           data-error="Enter Ironing Price">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <input type="hidden" id="edit_id">
                                <button class="btn btn-success pull-right">Edit Laundry</button>
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

</div>    <!--/.main-->