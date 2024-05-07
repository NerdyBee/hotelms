<?php
/**
 * Created by PhpStorm.
 * User: vishal
 * Date: 10/21/17
 * Time: 4:16 PM
 */
include_once 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    echo $username;
    echo $password;
    $query = "select * from login where username = '$username' and password='$password'";
    $result = mysqli_query($connection, $query);

    $userdetails = mysqli_fetch_assoc($result);

    if($userdetails['username']=='manager')
    {
        header('Location: index.php?room_mang');
    }
    else{
        header('Location: login.php');
    }
}

if (isset($_POST['submit'])) {

    $emp_id = $_POST['emp_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $staff_type_id = $_POST['staff_type_id'];
    $shift_id= $_POST['shift_id'];
    $id_card_type = $_POST['id_card_type'];
    $id_card_no = $_POST['id_card_no'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact_no'];
    $joining_date = strtotime($_POST['joining_date']);

    $salary = $_POST['salary'];

    $query="UPDATE staff
SET emp_name='$first_name $last_name', staff_type_id='$staff_type_id', shift_id='$shift_id', id_card_type=$id_card_type,
id_card_no='$id_card_no',address='$address',contact_no='$contact_no',joining_date='$joining_date',salary='$salary'
WHERE emp_id=$emp_id ";
//echo $query;
    if (mysqli_query($connection, $query)) {
        header('Location: index.php?staff_mang');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if (isset($_POST['update'])) {

    $user_id = $_POST['user_id'];
    $staff_type = $_POST['staff_type_id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email= $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    // Validate password and ensure it matches the repeat password
    // if ($password !== $repeat_password || strlen($password) < 8) {
    if ($password !== $repeat_password) {
        header('Location: index.php?users&error=password_mismatch_or_weak');
        exit();
    }

    if($password != '' || $password != ' ') {
        $pword = md5($password);
        $query="UPDATE user SET name='$full_name', username='$username', email='$email', privilege_id=$staff_type, password='$pword' WHERE id=$user_id ";
    } else {
        $query="UPDATE user SET name='$full_name', username='$username', email='$email', privilege_id=$staff_type WHERE id=$user_id ";
    }

    if (mysqli_query($connection, $query)) {
        header('Location: index.php?users&updated');
    } else {
        header('Location: index.php?users&error');
    }
}

if (isset($_GET['empid'])!="")
{
   $emp_id=$_GET['empid'];
    $deleteQuery = "DELETE FROM staff WHERE emp_id=$emp_id";
    if (mysqli_query($connection, $deleteQuery)) {
        header('Location: index.php?staff_mang');
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}

if (isset($_GET['userid'])!="")
{
   $user_id=$_GET['userid'];
    $deleteQuery = "UPDATE user SET status = 0 WHERE id=$user_id";
    if (mysqli_query($connection, $deleteQuery)) {
        header('Location: index.php?users&deactivate_user');
    } else {
        header('Location: index.php?users&error');
    }
}

if (isset($_GET['restore'])!="")
{
   $user_id=$_GET['restore'];
    $deleteQuery = "UPDATE user SET status = 1 WHERE id=$user_id";
    if (mysqli_query($connection, $deleteQuery)) {
        header('Location: index.php?users&activate_user');
    } else {
        header('Location: index.php?users&error');
    }
}

?>