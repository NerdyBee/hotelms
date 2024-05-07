<?php
include_once "db.php";
session_start();
if (isset($_SESSION['user_id'], $_SESSION['user_privilege'])){
    $user_id = $_SESSION['user_id'];
    $user_privilege = $_SESSION['user_privilege'];
    $userQuery = "SELECT * FROM user NATURAL JOIN privileges WHERE id = '$user_id'";
    $result = mysqli_query($connection, $userQuery);
    $user = mysqli_fetch_assoc($result);
}else{
    header('Location:login.php');
}
include_once "header.php";
include_once "sidebar.php";


if (isset($_GET['room_mang'])){
    include_once "room_mang.php";
}
elseif (isset($_GET['dashboard']) && in_array($user_privilege, array(1, 2, 3, 7, 8))){
    include_once "report_dashboard.php";
}
elseif (isset($_GET['dashboard']) && !in_array($user_privilege, array(1, 2, 3, 7, 8))){
    include_once "dashboard.php";
}
elseif (isset($_GET['reservation_mang'])){
    include_once "reservation_mang.php";
}
elseif (isset($_GET['edit_reservation'])){
    include_once "edit_reservation.php";
}
elseif (isset($_GET['reservation'])){
    include_once "reservation.php";
}
elseif (isset($_GET['more_rooms'])){
    include_once "more_rooms.php";
}
elseif (isset($_GET['halls'])){
    include_once "halls.php";
}
elseif (isset($_GET['hall_reservation'])){
    include_once "hall_reservation.php";
}
elseif (isset($_GET['hall_mang'])){
    include_once "hall_mang.php";
}
elseif (isset($_GET['hall_reservation_mang'])){
    include_once "hall_reservation_mang.php";
}
elseif (isset($_GET['staff_mang'])){
    include_once "staff_mang.php";
}
elseif (isset($_GET['add_emp'])){
    include_once "add_emp.php";
}
elseif (isset($_GET['complain'])){
    include_once "complain.php";
}
elseif (isset($_GET['statistics'])){
    include_once "statistics.php";
}
elseif (isset($_GET['emp_history'])){
    include_once "emp_history.php";
}
elseif (isset($_GET['gym'])){
    include_once "gym.php";
}
elseif (isset($_GET['bar'])){
    include_once "sales.php";
}
elseif (isset($_GET['sales'])){
    include_once "bar.php";
}
elseif (isset($_GET['kitchen'])){
    include_once "kitchen.php";
}
elseif (isset($_GET['kitchen_sales'])){
    include_once "kitchen_sales.php";
}
elseif (isset($_GET['editKitchenInvoice'])){
    include_once "edit_kitchen_invoice.php";
}
elseif (isset($_GET['supply'])){
    include_once "supply.php";
}
elseif (isset($_GET['store'])){
    include_once "store.php";
}
elseif (isset($_GET['editInvoice'])){
    include_once "edit_invoice.php";
}
elseif (isset($_GET['inventory'])){
    include_once "inventory.php";
}
elseif (isset($_GET['expenses'])){
    include_once "expenses.php";
}
elseif (isset($_GET['menu'])){
    include_once "menu.php";
}
elseif (isset($_GET['laundry'])){
    include_once "wash.php";
}
elseif (isset($_GET['laundry_services'])){
    include_once "wash_service.php";
}
elseif (isset($_GET['service'])){
    include_once "laundry_service.php";
}
elseif (isset($_GET['edit_hall_reservation'])){
    include_once "edit_hall_reservation.php";
}
elseif (isset($_GET['editLaundryInvoice'])){
    include_once "editLaundryInvoice.php";
}
elseif (isset($_GET['room_type'])){
    include_once "room_type.php";
}
elseif (isset($_GET['laundry_report'])){
    include_once "laundry_report.php";
}
elseif (isset($_GET['sales_report'])){
    include_once "sales_report.php";
}
elseif (isset($_GET['gym_report'])){
    include_once "gym_report.php";
}
elseif (isset($_GET['complaint_report'])){
    include_once "complaint_report.php";
}
elseif (isset($_GET['report'])){
    include_once "report.php";
}
elseif (isset($_GET['users'])){
    include_once "users.php";
}
elseif (isset($_GET['add_user'])){
    include_once "add_user.php";
}
elseif (isset($_GET['change_password'])){
    include_once "change_password.php";
}
elseif (isset($_GET['room_mang'])){
    include_once "room_mang.php";
}
else {
    include_once "user_dashboard.php";
}

include_once "footer.php";