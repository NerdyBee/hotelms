<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Room Types</li>
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
                <div class="panel-heading">Room Types
                    <button class="btn btn-secondary pull-right" style="border-radius:0%" data-toggle="modal" data-target="#addRoomType">Add Room Type</button>
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
                            <th>Room Type</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $room_query = "SELECT * FROM room_type WHERE deleteStatus != 1";
                        $rooms_result = mysqli_query($connection, $room_query);
                        if (mysqli_num_rows($rooms_result) > 0) {
                            while ($rooms = mysqli_fetch_assoc($rooms_result)) { ?>
                                <tr>
                                    <td><?php echo $rooms['room_type'] ?></td>
                                    <td><?php echo number_format($rooms['price']) ?></td>
                                    <td>

                                        <button title="Edit Room Information" style="border-radius:60px;" data-toggle="modal"
                                                data-target="#editRoomType" data-id="<?php echo $rooms['room_type_id']; ?>"
                                                id="roomTypeEdit" class="btn btn-info"><i class="fa fa-pencil"></i></button>

                                        <a href="ajax.php?delete_room_type=<?php echo $rooms['room_type_id']; ?>"
                                           class="btn btn-danger" style="border-radius:60px;" onclick="return confirm('Are you Sure?')"><i
                                                    class="fa fa-trash" alt="delete"></i></a>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "No Room Types";
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Add Room Type Modal -->
    <div id="addRoomType" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Room Type</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="addRoomType" data-toggle="validator" role="form">
                                <div class="response"></div>

                                <div class="form-group">
                                    <label>Room Type</label>
                                    <input type="text" class="form-control" placeholder="Room Type" id="room_type"
                                           data-error="Enter Room Type" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>Room Price</label>
                                    <input type="number" class="form-control" placeholder="Room Price" id="price"
                                           data-error="Enter Room Price" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <button class="btn btn-success pull-right">Add Room Type</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!--Edit Room Type Modal -->
    <div id="editRoomType" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Room Type</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="roomTypeEditFrom" data-toggle="validator" role="form">
                                <div class="edit_response"></div>

                                <div class="form-group">
                                    <label>Room Type</label>
                                    <input class="form-control" placeholder="Room Type" id="edit_room_type" required
                                           data-error="Enter Room Type">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" class="form-control" placeholder="Room Price" id="edit_price" required
                                           data-error="Enter Room Price">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <input type="hidden" id="edit_room_type_id">
                                <button class="btn btn-success pull-right">Edit Room Type</button>
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



