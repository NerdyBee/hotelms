<?php
    $sup = [1, 2, 7];
    $md = [6, 7];
    $bar = [4, 5, 7];
    $third_rule = [2, 3, 7];
    $fouth_rule = [2, 6, 7];
?>
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <div class="profile-sidebar">
        <div class="profile-userpic">
            <img src="img/user.png" class="img-responsive" alt="">
        </div>
        <div class="profile-usertitle">
            <div class="profile-usertitle-name"><?php echo $user['name'];?></div>
            <div class="profile-usertitle-status"><span class="indicator label-success"></span><?php echo $user['privilege'];?></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="divider"></div>
    <ul class="nav menu">
    <?php 
        if (isset($_GET['dashboard'])){ ?>
            <li class="active">
                <a href="index.php?dashboard"><em class="fa fa-dashboard">&nbsp;</em>
                    Dashboard
                </a>
            </li>
        <?php } else{?>
            <li>
                <a href="index.php?dashboard"><em class="fa fa-dashboard">&nbsp;</em>
                    Dashboard
                </a>
            </li>
        <?php }
        if(in_array($_SESSION['user_privilege'], $sup)) {
            if (isset($_GET['room_type'])){ ?>
                <li class="active">
                    <a href="index.php?room_type"><em class="fa fa-bed">&nbsp;</em>
                        Room Types
                    </a>
                </li>
            <?php } else{?>
                <li>
                <a href="index.php?room_type"><em class="fa fa-bed">&nbsp;</em>
                        Room Types
                    </a>
                </li>
            <?php }
        }

        if(in_array($_SESSION['user_privilege'], $md)) {
            if (isset($_GET['reservation'])){ ?>
                <li class="active">
                <a href="index.php?reservation"><em class="fa fa-calendar">&nbsp;</em>
                        Reservation
                    </a>
                </li>
            <?php } else {?>
                <li>
                <a href="index.php?reservation"><em class="fa fa-calendar">&nbsp;</em>
                        Reservation
                    </a>
                </li>
            <?php }
        
            if (isset($_GET['room_mang'])){ ?>
                <li class="active">
                    <a href="index.php?room_mang"><em class="fa fa-bed">&nbsp;</em>
                        Manage Rooms
                    </a>
                </li>
            <?php } else{?>
                <li>
                <a href="index.php?room_mang"><em class="fa fa-bed">&nbsp;</em>
                        Manage Rooms
                    </a>
                </li>
            <?php }
        }
        if(in_array($_SESSION['user_privilege'], $bar)) {
            if (isset($_GET['bar'])){ ?>
                <li class="active">
                    <a href="index.php?bar"><em class="fa fa-cutlery">&nbsp;</em>
                        Bar/Kitchen
                    </a>
                </li>
            <?php } else{?>
                <li>
                <a href="index.php?bar"><em class="fa fa-cutlery">&nbsp;</em>
                        Bar/Kitchen
                    </a>
                </li>
            <?php }
        }
        if(in_array($_SESSION['user_privilege'], $third_rule)) {
            if (isset($_GET['inventory'])){ ?>
                <li class="active">
                    <a href="index.php?inventory"><em class="fa fa-shopping-basket">&nbsp;</em>
                        Inventory
                    </a>
                </li>
            <?php } else{?>
                <li>
                    <a href="index.php?inventory"><em class="fa fa-shopping-basket">&nbsp;</em>
                        Inventory
                    </a>
                </li>
            <?php }
            if (isset($_GET['supply'])){ ?>
                <li class="active">
                    <a href="index.php?supply"><em class="fa fa-shopping-basket">&nbsp;</em>
                        Supply
                    </a>
                </li>
            <?php } else{?>
                <li>
                    <a href="index.php?supply"><em class="fa fa-shopping-basket">&nbsp;</em>
                        Supply
                    </a>
                </li>
            <?php }
            if (isset($_GET['staff_mang'])){ ?>
                <li class="active">
                    <a href="index.php?staff_mang"><em class="fa fa-users">&nbsp;</em>
                        Staff Section
                    </a>
                </li>
            <?php } else{?>
                <li>
                    <a href="index.php?staff_mang"><em class="fa fa-users">&nbsp;</em>
                        Staff Section
                    </a>
                </li>
            <?php }
        }
        if(in_array($_SESSION['user_privilege'], $fouth_rule)) {
            if (isset($_GET['complain'])){ ?>
                <li class="active">
                    <a href="index.php?complain"><em class="fa fa-comments">&nbsp;</em>
                        Manage Complaints
                    </a>
                </li>
            <?php } else{?>
                <li>
                    <a href="index.php?complain"><em class="fa fa-comments">&nbsp;</em>
                        Manage Complaints
                    </a>
                </li>
            <?php }
        }
        if(in_array($_SESSION['user_privilege'], $sup)) {
            if (isset($_GET['report'])){ ?>
                <li class="active">
                    <a href="index.php?report"><em class="fa fa-pie-chart">&nbsp;</em>
                        Report
                    </a>
                </li>
            <?php } else{?>
            <li>
                <a href="index.php?report"><em class="fa fa-pie-chart">&nbsp;</em>
                    Report
                </a>
            </li>
            <?php }
        
            if (isset($_GET['statistics'])){ ?>
                <li class="active">
                    <a href="index.php?statistics"><em class="fa fa-pie-chart">&nbsp;</em>
                        Statistics
                    </a>
                </li>
            <?php } else{?>
            <li>
                <a href="index.php?statistics"><em class="fa fa-pie-chart">&nbsp;</em>
                    Statistics
                </a>
            </li>
            <?php }
            if (isset($_GET['users'])){ ?>
                <li class="active">
                    <a href="index.php?users"><em class="fa fa-pie-chart">&nbsp;</em>
                        Users
                    </a>
                </li>
            <?php } else{?>
            <li>
                <a href="index.php?users"><em class="fa fa-pie-chart">&nbsp;</em>
                    Users
                </a>
            </li>
            <?php }
        }?>

        
    </ul>
</div><!--/.sidebar-->