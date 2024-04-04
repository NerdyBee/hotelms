<?php
include_once 'db.php';
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!$email && !$password) {
        header('Location:login.php?empty');
    } else {
        $password = md5($password);
        $query = "SELECT * FROM user WHERE username = '$email' OR email='$email' AND password='$password'";
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_privilege'] = $user['privilege_id'];
            header('Location:index.php?dashboard');
        } else {
            header('Location:login.php?loginE');
        }
    }
}

if (isset($_POST['add_hall'])) {
    $hall = $_POST['hall'];
    $price = $_POST['price'];

    if ($hall != '') {
        $sql = "SELECT * FROM halls WHERE hall = '$hall'";
        if (mysqli_num_rows(mysqli_query($connection, $sql)) >= 1) {
            $response['done'] = false;
            $response['data'] = "Hall Already Exist";
        } else {
            $query = "INSERT INTO halls (hall, price, status) VALUES ('$hall', '$price', '0')";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $response['done'] = true;
                $response['data'] = 'Successfully Added Hall';
            } else {
                $response['done'] = false;
                $response['data'] = "DataBase Error";
            }
        }
    } else {

        $response['done'] = false;
        $response['data'] = "Please Enter Hall";
    }

    echo json_encode($response);
}

if (isset($_POST['edit_hall'])) {
    $hall_id = $_POST['hall_id'];
    $price = $_POST['price'];
    $hall = $_POST['hall'];

    if ($hall_id != '') {
        $sql = "SELECT * FROM halls WHERE hall = '$hall' AND hall_id <> '$hall_id'";
        if (mysqli_num_rows(mysqli_query($connection, $sql)) >= 1) {
            $response['done'] = false;
            $response['data'] = "Hall Already Exist";
        } else {
            $query = "UPDATE halls SET hall = '$hall',price = '$price' where hall_id = '$hall_id'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $response['done'] = true;
                $response['data'] = 'Successfully Edit Hall';
            } else {
                $response['done'] = false;
                $response['data'] = "DataBase Error";
            }
        }

    } else {

        $response['done'] = false;
        $response['data'] = "Please Enter Hall Name";
    }

    echo json_encode($response);
}

if (isset($_POST['hall_edit'])) {
    $hall_id = $_POST['hall_id'];

    $sql = "SELECT * FROM halls WHERE hall_id = '$hall_id'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $room = mysqli_fetch_assoc($result);
        $response['done'] = true;
        $response['hall'] = $room['hall'];
        $response['price'] = $room['price'];
        $response['hall_id'] = $room['hall_id'];
    } else {
        $response['done'] = false;
        $response['data'] = "DataBase Error";
    }

    echo json_encode($response);
}

if (isset($_POST['add_room_type'])) {
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];

    if ($room_type != '') {
        $sql = "SELECT * FROM room_type WHERE room_type = '$room_type'";
        if (mysqli_num_rows(mysqli_query($connection, $sql)) >= 1) {
            $response['done'] = false;
            $response['data'] = "Room Type Already Exist";
        } else {
            $query = "INSERT INTO room_type (room_type, price, max_person) VALUES ('$room_type', '$price', '3')";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $response['done'] = true;
                $response['data'] = 'Successfully Added Room Type';
            } else {
                $response['done'] = false;
                $response['data'] = "DataBase Error";
            }
        }
    } else {

        $response['done'] = false;
        $response['data'] = "Please Enter Room Type";
    }

    echo json_encode($response);
}

if (isset($_POST['add_room'])) {
    $room_type_id = $_POST['room_type_id'];
    $room_no = $_POST['room_no'];

    if ($room_no != '') {
        $sql = "SELECT * FROM room WHERE room_no = '$room_no'";
        if (mysqli_num_rows(mysqli_query($connection, $sql)) >= 1) {
            $response['done'] = false;
            $response['data'] = "Room No Already Exist";
        } else {
            $query = "INSERT INTO room (room_type_id,room_no) VALUES ('$room_type_id','$room_no')";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $response['done'] = true;
                $response['data'] = 'Successfully Added Room';
            } else {
                $response['done'] = false;
                $response['data'] = "DataBase Error";
            }
        }
    } else {

        $response['done'] = false;
        $response['data'] = "Please Enter Room No";
    }

    echo json_encode($response);
}

if (isset($_POST['room'])) {
    $room_id = $_POST['room_id'];

    $sql = "SELECT * FROM room WHERE room_id = '$room_id'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $room = mysqli_fetch_assoc($result);
        $response['done'] = true;
        $response['room_no'] = $room['room_no'];
        $response['room_type_id'] = $room['room_type_id'];
    } else {
        $response['done'] = false;
        $response['data'] = "DataBase Error";
    }

    echo json_encode($response);
}

if (isset($_POST['room_type_edit'])) {
    $room_type_id = $_POST['room_type_id'];

    $sql = "SELECT * FROM room_type WHERE room_type_id = '$room_type_id'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $room = mysqli_fetch_assoc($result);
        $response['done'] = true;
        $response['room_type'] = $room['room_type'];
        $response['price'] = $room['price'];
        $response['room_type_id'] = $room['room_type_id'];
    } else {
        $response['done'] = false;
        $response['data'] = "DataBase Error";
    }

    echo json_encode($response);
}

if (isset($_POST['edit_laundry'])) {
    $apparel = $_POST['apparel'];
    $wash = $_POST['wash'];
    $iron = $_POST['iron'];
    $laundry_id = $_POST['laundry_id'];

    if ($apparel != '' && isset($wash) && $wash != '') {
        $query = "UPDATE laundry SET apparel = '$apparel',wash_iron = '$wash',iron = '$iron' where id = '$laundry_id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $response['done'] = true;
            $response['data'] = 'Successfully Edit Laundry';
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error";
        }

    } else {

        $response['done'] = false;
        $response['data'] = "Please Enter Apparel Type and Price";
    }

    echo json_encode($response);
}

if (isset($_POST['edit_item'])) {
    $item = $_POST['item'];
    $price = $_POST['price'];
    $item_id = $_POST['item_id'];

    if ($item != '' && isset($price)) {
        $query = "UPDATE inventory SET item = '$item',price = '$price' where item_id = '$item_id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $response['done'] = true;
            $response['data'] = 'Successfully Edit Room';
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error";
        }

    } else {

        $response['done'] = false;
        $response['data'] = "Please Enter Room No";
    }

    echo json_encode($response);
}

if (isset($_POST['edit_menu'])) {
    $item = $_POST['item'];
    $price = $_POST['price'];
    $item_id = $_POST['item_id'];

    if ($item != '' && isset($price)) {
        $query = "UPDATE menu SET item = '$item',price = '$price' where item_id = '$item_id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $response['done'] = true;
            $response['data'] = 'Successfully Edit Room';
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error";
        }

    } else {

        $response['done'] = false;
        $response['data'] = "Please Enter Room No";
    }

    echo json_encode($response);
}

if (isset($_POST['edit_room_type'])) {
    $room_type_id = $_POST['room_type_id'];
    $price = $_POST['price'];
    $room_type = $_POST['room_type'];

    if ($room_type_id != '') {
        $sql = "SELECT * FROM room_type WHERE room_type = '$room_type' AND room_type_id <> '$room_type_id'";
        if (mysqli_num_rows(mysqli_query($connection, $sql)) >= 1) {
            $response['done'] = false;
            $response['data'] = "Room Type Already Exist";
        } else {
            $query = "UPDATE room_type SET room_type = '$room_type',price = '$price' where room_type_id = '$room_type_id'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $response['done'] = true;
                $response['data'] = 'Successfully Edit Room';
            } else {
                $response['done'] = false;
                $response['data'] = "DataBase Error";
            }
        }

    } else {

        $response['done'] = false;
        $response['data'] = "Please Enter Room No";
    }

    echo json_encode($response);
}

if (isset($_POST['edit_room'])) {
    $room_type_id = $_POST['room_type_id'];
    $room_no = $_POST['room_no'];
    $room_id = $_POST['room_id'];

    if ($room_no != '') {
        $query = "UPDATE room SET room_no = '$room_no',room_type_id = '$room_type_id' where room_id = '$room_id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $response['done'] = true;
            $response['data'] = 'Successfully Edit Room';
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error";
        }

    } else {

        $response['done'] = false;
        $response['data'] = "Please Enter Room No";
    }

    echo json_encode($response);
}

if (isset($_GET['delete_hall'])) {
    $hall_id = $_GET['delete_hall'];
    $sql = "UPDATE halls set deleteStatus = '1' WHERE hall_id = '$hall_id'";
    // $sql = "DELETE FROM halls WHERE id = '$hall_id'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        header("Location:index.php?halls&success");
    } else {
        header("Location:index.php?halls&error");
    }
}

if (isset($_GET['delete_room_type'])) {
    $room_id = $_GET['delete_room_type'];
    $sql = "UPDATE room_type set deleteStatus = '1' WHERE room_type_id = '$room_id'";
    // $sql = "DELETE FROM room_type WHERE room_type_id = '$room_id'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        header("Location:index.php?room_type&success");
    } else {
        header("Location:index.php?room_type&error");
    }
}

if (isset($_GET['delete_room'])) {
    $room_id = $_GET['delete_room'];
    $sql = "UPDATE room set deleteStatus = '1' WHERE room_id = '$room_id' AND status IS NULL";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        header("Location:index.php?room_mang&success");
    } else {
        header("Location:index.php?room_mang&error");
    }
}

if (isset($_POST['room_type'])) {
    $room_type_id = $_POST['room_type_id'];

    $sql = "SELECT * FROM room WHERE room_type_id = '$room_type_id' AND deleteStatus = '0'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        echo "<option selected disabled>Select Room Type</option>";
        while ($room = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $room['room_id'] . "'>" . $room['room_no'] . "</option>";
        }
    } else {
        echo "<option>Not Available</option>";
    }
}

if (isset($_POST['room_type_checked'])) {
    $room_type_id = $_POST['room_type_id'];

    $sql = "SELECT * FROM room WHERE room_type_id = '$room_type_id' AND check_in_status = '1' AND deleteStatus = '0'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        echo "<option selected disabled>Select Room Type</option>";
        while ($room = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $room['room_id'] . "'>" . $room['room_no'] . "</option>";
        }
    } else {
        echo "<option>Not Available</option>";
    }
}

if (isset($_POST['room_price'])) {
    $room_id = $_POST['room_id'];

    $sql = "SELECT * FROM room NATURAL JOIN room_type WHERE room_id = '$room_id'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $room = mysqli_fetch_assoc($result);
        echo $room['price'];
    } else {
        echo "0";
    }
}

if (isset($_POST['hall_price'])) {
    $hall_id = $_POST['hall_id'];

    $sql = "SELECT * FROM halls WHERE hall_id = '$hall_id'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $hall = mysqli_fetch_assoc($result);
        echo $hall['price'];
    } else {
        echo "0";
    }
}

if (isset($_POST['hall_booking'])) {
    $hall_id = $_POST['hall_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $discount = $_POST['discount'];
    $total_price = $_POST['total_price'];
    $name = $_POST['name'];
    $contact_no = $_POST['contact_no'];
    $added_by = $_SESSION['user_id'];

    $check_availability = "SELECT * FROM hall_booking WHERE hall_id = '$hall_id' AND '$check_in' BETWEEN check_in AND check_out";
    $check = mysqli_query($connection, $check_availability);
    if (mysqli_num_rows($check) < 1){
        $customer_sql = "INSERT INTO hall_customer (customer_name,contact_no,total_price,remaining_price,discount,added_by) VALUES
        ('$name','$contact_no','$total_price','$total_price','$discount','$added_by')";
        $customer_result = mysqli_query($connection, $customer_sql);
    // if($discount <= ((40 / 100) * $total_price)){
        if ($customer_result) {
            $customer_id = mysqli_insert_id($connection);
            $booking_sql = "INSERT INTO hall_booking (customer_id,hall_id,check_in,check_out,total_price,remaining_price,discount,added_by) VALUES
            ('$customer_id','$hall_id','$check_in','$check_out','$total_price','$total_price','$discount','$added_by')";
            $booking_result = mysqli_query($connection, $booking_sql);
            if ($booking_result) {
                $hall_stats_sql = "UPDATE halls SET status = '1' WHERE hall_id = '$hall_id'";
                if (mysqli_query($connection, $hall_stats_sql)) {
                    $response['done'] = true;
                    $response['data'] = 'Successfully Book Hall';
                } else {
                    $response['done'] = false;
                    $response['data'] = "DataBase Error in status change";
                }
            } else {
                $response['done'] = false;
                $response['data'] = "DataBase Error booking hall";
            }
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error adding customer";
        }
    } else {
        $response['done'] = false;
        $response['data'] = "Hall is not available for the requested date range";
    }

    echo json_encode($response);
}

if (isset($_POST['edit_hall_booking'])) {
    $booking_id = $_POST['booking_id'];
    $customer_id = $_POST['customer_id'];
    $hall_id = $_POST['hall_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $discount = $_POST['discount'];
    $total_price = $_POST['total_price'];
    $name = $_POST['name'];
    $contact_no = $_POST['contact_no'];
    $added_by = $_SESSION['user_id'];

    $check_availability = "SELECT * FROM hall_booking WHERE hall_id = '$hall_id' AND '$check_in' BETWEEN check_in AND check_out AND booking_id <> '$booking_id'";
    $check = mysqli_query($connection, $check_availability);
    if (mysqli_num_rows($check) < 1){
        $customer_sql = "UPDATE hall_customer SET customer_name='$name',contact_no='$contact_no',total_price='$total_price',remaining_price='$total_price',discount='$discount' WHERE customer_id = $customer_id";
        $customer_result = mysqli_query($connection, $customer_sql);
    // if($discount <= ((40 / 100) * $total_price)){
        if ($customer_result) {
            $customer_id = mysqli_insert_id($connection);
            $booking_sql = "UPDATE hall_booking SET hall_id='$hall_id',check_in='$check_in',check_out='$check_out',total_price='$total_price',remaining_price='$total_price',discount='$discount' WHERE booking_id = '$booking_id'";
            $booking_result = mysqli_query($connection, $booking_sql);
            if ($booking_result) {
                $hall_stats_sql = "UPDATE halls SET status = '1' WHERE hall_id = '$hall_id'";
                if (mysqli_query($connection, $hall_stats_sql)) {
                    $response['done'] = true;
                    $response['data'] = 'Successfully Book Hall';
                } else {
                    $response['done'] = false;
                    $response['data'] = "DataBase Error in status change";
                }
            } else {
                $response['done'] = false;
                $response['data'] = "DataBase Error booking hall";
            }
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error adding customer";
        }
    } else {
        $response['done'] = false;
        $response['data'] = "Hall is not available for the requested date range";
    }

    echo json_encode($response);
}

if (isset($_POST['booking'])) {
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $discount = $_POST['discount'];
    $total_price = $_POST['total_price'];
    $name = $_POST['name'];
    $contact_no = $_POST['contact_no'];
    $email = $_POST['email'];
    $id_card_id = $_POST['id_card_id'];
    $id_card_no = $_POST['id_card_no'];
    $address = $_POST['address'];
    $added_by = $_SESSION['user_id'];

    $check_availability = "SELECT * FROM booking WHERE room_id = '$room_id' AND '$check_in' BETWEEN check_in AND check_out AND checkout_status = 0";
    $check = mysqli_query($connection, $check_availability);
    if (mysqli_num_rows($check) < 1){
        $customer_sql = "INSERT INTO customer (customer_name,contact_no,email,id_card_type_id,id_card_no,address,total_price,remaining_price,discount,added_by) VALUES ('$name','$contact_no','$email','$id_card_id','$id_card_no','$address','$total_price','$total_price','$discount','$added_by')";
        $customer_result = mysqli_query($connection, $customer_sql);
    // if($discount <= ((40 / 100) * $total_price)){
        if ($customer_result) {
            $customer_id = mysqli_insert_id($connection);
            $booking_sql = "INSERT INTO booking (customer_id,room_id,check_in,check_out,total_p,remaining_p,discounted,added_by) VALUES ('$customer_id','$room_id','$check_in','$check_out','$total_price','$total_price','$discount','$added_by')";
            $booking_result = mysqli_query($connection, $booking_sql);
            $book_id = mysqli_insert_id($connection);
            if ($booking_result) {
                $room_stats_sql = "UPDATE room SET status = '1' WHERE room_id = '$room_id'";
                if (mysqli_query($connection, $room_stats_sql)) {
                    $response['done'] = true;
                    $response['book_id'] = $book_id;
                    $response['data'] = 'Successfully Booking';
                } else {
                    $response['done'] = false;
                    $response['data'] = "DataBase Error in status change";
                }
            } else {
                $response['done'] = false;
                $response['data'] = "DataBase Error booking";
            }
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error add customer";
        }
    } else {
        $response['done'] = false;
        $response['data'] = "Room is not available for the requested date range";
    }

    echo json_encode($response);
}

if (isset($_POST['edit_booking'])) {
    $booking_id = $_POST['booking_id'];
    $customer_id = $_POST['customer_id'];
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $discount = $_POST['discount'];
    $total_price = $_POST['total_price'];
    $name = $_POST['name'];
    $contact_no = $_POST['contact_no'];
    $email = $_POST['email'];
    $id_card_id = $_POST['id_card_id'];
    $id_card_no = $_POST['id_card_no'];
    $address = $_POST['address'];
    $added_by = $_SESSION['user_id'];

    $check_availability = "SELECT * FROM booking WHERE room_id = '$room_id' AND '$check_in' BETWEEN check_in AND check_out AND checkout_status = 0 AND booking_id <> '$booking_id'";
    $check = mysqli_query($connection, $check_availability);
    if (mysqli_num_rows($check) < 1){
        $customer_sql = "UPDATE customer SET customer_name = '$name',contact_no = '$contact_no',email = '$email',id_card_type_id = '$id_card_id',id_card_no = '$id_card_no',address = '$address',total_price = '$total_price',remaining_price = '$total_price',discount = '$discount' WHERE customer_id = $customer_id";
        $customer_result = mysqli_query($connection, $customer_sql);
    // if($discount <= ((40 / 100) * $total_price)){
        if ($customer_result) {
            $customer_id = mysqli_insert_id($connection);
            $booking_sql = "UPDATE booking SET room_id='$room_id',check_in='$check_in',check_out='$check_out',total_p='$total_price',remaining_p='$total_price',discounted='$discount' WHERE booking_id = '$booking_id'";
            $booking_result = mysqli_query($connection, $booking_sql);
            if ($booking_result) {
                $room_stats_sql = "UPDATE room SET status = '1' WHERE room_id = '$room_id'";
                if (mysqli_query($connection, $room_stats_sql)) {
                    $response['done'] = true;
                    $response['book_id'] = $booking_id;
                    $response['data'] = 'Successfully Booking';
                } else {
                    $response['done'] = false;
                    $response['data'] = "DataBase Error in status change";
                }
            } else {
                $response['done'] = false;
                $response['data'] = "DataBase Error editing booking";
            }
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error editing customer";
        }
    } else {
        $response['done'] = false;
        $response['data'] = "Room is not available for the requested date range";
    }

    echo json_encode($response);
}

if (isset($_GET['delete_booking'])) {
    $book_id = $_GET['delete_booking'];
    $cust_id = $_GET['customer'];
    $sql = "DELETE FROM booking WHERE booking_id = $book_id";
    $sql_cus = "DELETE FROM customer WHERE customer_id = $cust_id";
    $result = mysqli_query($connection, $sql);
    $result_cus = mysqli_query($connection, $sql_cus);
    if ($result) {
        header("Location:index.php?reservation_mang&delete_success");
    } else {
        header("Location:index.php?reservation_mang&error");
    }
}

if (isset($_GET['delete_halls_booking'])) {
    $book_id = $_GET['delete_halls_booking'];
    $cust_id = $_GET['customer'];
    $sql = "DELETE FROM hall_booking WHERE booking_id = $book_id";
    $sql_cus = "DELETE FROM hall_customer WHERE customer_id = $cust_id";
    $result = mysqli_query($connection, $sql);
    $result_cus = mysqli_query($connection, $sql_cus);
    if ($result) {
        header("Location:index.php?hall_reservation_mang&delete_success");
    } else {
        header("Location:index.php?hall_reservation_mang&error");
    }
}

if (isset($_POST['invoiceDetails'])) {
    //$customer_result='';
    $invoice_id = $_POST['invoice_id'];

    if ($invoice_id != '') {
        $sql = "SELECT * FROM sales WHERE invoice_id = '$invoice_id'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            while($invoice_details = mysqli_fetch_assoc($result)){
                $invoice_table = '<td>'.sprintf("%06d", $invoice_details['invoice_id']).'</td>
                <td>'.$invoice_details['item_id'].'</td>
                <td>'.$invoice_details['quantity'].'</td>
                <td>'.$invoice_details['price'].'</td>
                <td>'.$invoice_details['created_at'].'</td>';
            };
            
            // $id_type = $invoice_details['id_card_type_id'];
            // $query = "select id_card_type from id_card_type where id_card_type_id = '$id_type'";
            // $result = mysqli_query($connection, $query);
            // $id_type_name = mysqli_fetch_assoc($result);
            $response['done'] = true;
            $response['inv_det'] = $invoice_table;
            // $response['item'] = $invoice_details['item_id'];
            // $response['price'] = $invoice_details['price'];
            // $response['quantity'] = $invoice_details['quantity'];
            // $response['created_at'] = $invoice_details['created_at'];
            // $response['id_card_type_id'] = $id_type_name['id_card_type'];
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error";
        }

        echo json_encode($response);
    }
}

if (isset($_POST['hallCutomerDetails'])) {
    //$customer_result='';
    $hall_id = $_POST['hall_id'];

    if ($hall_id != '') {
        // $sql = "SELECT * FROM room NATURAL JOIN room_type NATURAL JOIN booking NATURAL JOIN customer WHERE room_id = '$room_id'";
        $sql = "SELECT * 
        FROM halls
        JOIN hall_booking ON halls.hall_id = hall_booking.hall_id 
        JOIN hall_customer ON hall_booking.customer_id = hall_customer.customer_id 
        WHERE halls.hall_id = '$hall_id'";
        
        $result = mysqli_query($connection, $sql);
        if ($result) {
            $customer_details = mysqli_fetch_assoc($result);
            $response['done'] = true;
            $response['customer_id'] = $customer_details['customer_id'];
            $response['customer_name'] = $customer_details['customer_name'];
            $response['contact_no'] = $customer_details['contact_no'];
            $response['remaining_price'] = $customer_details['remaining_price'];
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error";
        }

        echo json_encode($response);
    }
}

if (isset($_POST['cutomerDetails'])) {
    //$customer_result='';
    $room_id = $_POST['room_id'];

    if ($room_id != '') {
        // $sql = "SELECT * FROM room NATURAL JOIN room_type NATURAL JOIN booking NATURAL JOIN customer WHERE room_id = '$room_id'";
        $sql = "SELECT * 
        FROM room 
        JOIN room_type ON room.room_type_id = room_type.room_type_id 
        JOIN booking ON room.room_id = booking.room_id 
        JOIN customer ON booking.customer_id = customer.customer_id 
        WHERE room.room_id = '$room_id' AND booking.checkout_status = 0";
        
        $result = mysqli_query($connection, $sql);
        if ($result) {
            $customer_details = mysqli_fetch_assoc($result);
            $id_type = $customer_details['id_card_type_id'];
            $query = "select id_card_type from id_card_type where id_card_type_id = '$id_type'";
            $result = mysqli_query($connection, $query);
            $id_type_name = mysqli_fetch_assoc($result);
            $response['done'] = true;
            $response['customer_id'] = $customer_details['customer_id'];
            $response['customer_name'] = $customer_details['customer_name'];
            $response['contact_no'] = $customer_details['contact_no'];
            $response['email'] = $customer_details['email'];
            $response['id_card_no'] = $customer_details['id_card_no'];
            $response['id_card_type_id'] = $id_type_name['id_card_type'];
            $response['address'] = $customer_details['address'];
            $response['remaining_price'] = $customer_details['remaining_price'] + $customer_details['extras'];
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error";
        }

        echo json_encode($response);
    }
}

if (isset($_POST['booked_hall'])) {
    $hall_id = $_POST['hall_id'];

    // $sql = "SELECT * FROM room NATURAL JOIN room_type NATURAL JOIN booking NATURAL JOIN customer WHERE room_id = '$room_id'";
    $sql = "SELECT * FROM halls 
        JOIN hall_booking ON halls.hall_id = hall_booking.hall_id 
        JOIN hall_customer ON hall_booking.customer_id = hall_customer.customer_id 
        WHERE halls.hall_id = '$hall_id'";

    $result = mysqli_query($connection, $sql);
    if ($result) {
        $room = mysqli_fetch_assoc($result);
        $response['done'] = true;
        $response['booking_id'] = $room['booking_id'];
        $response['name'] = $room['customer_name'];
        $response['hall'] = $room['hall'];
        $response['check_in'] = date('M j, Y', strtotime($room['check_in']));
        $response['check_out'] = date('M j, Y', strtotime($room['check_out']));
        $response['total_price'] = $room['total_price'];
        $response['remaining_price'] = $room['remaining_price'];
    } else {
        $response['done'] = false;
        $response['data'] = "DataBase Error";
    }

    echo json_encode($response);
}

if (isset($_POST['booked_room'])) {
    $room_id = $_POST['room_id'];

    // $sql = "SELECT * FROM room NATURAL JOIN room_type NATURAL JOIN booking NATURAL JOIN customer WHERE room_id = '$room_id'";
    $sql = "SELECT * FROM room 
        JOIN room_type ON room.room_type_id = room_type.room_type_id 
        JOIN booking ON room.room_id = booking.room_id 
        JOIN customer ON booking.customer_id = customer.customer_id 
        WHERE room.room_id = '$room_id' AND booking.checkout_status = 0";

    $result = mysqli_query($connection, $sql);
    if ($result) {
        $room = mysqli_fetch_assoc($result);
        $response['done'] = true;
        $response['booking_id'] = $room['booking_id'];
        $response['name'] = $room['customer_name'];
        $response['room_no'] = $room['room_no'];
        $response['room_type'] = $room['room_type'];
        $response['check_in'] = date('M j, Y', strtotime($room['check_in']));
        $response['check_out'] = date('M j, Y', strtotime($room['check_out']));
        $response['total_price'] = $room['total_price'] + $room['extras'];
        $response['remaining_price'] = $room['remaining_price'] + $room['extras'];
    } else {
        $response['done'] = false;
        $response['data'] = "DataBase Error";
    }

    echo json_encode($response);
}

if (isset($_POST['check_in_room'])) {
    $booking_id = $_POST['booking_id'];
    $advance_payment = $_POST['advance_payment'];
    $payment_type = $_POST['payment_type'];
    $added_by = $_SESSION['user_id'];

    if ($booking_id != '') {
        $query = "SELECT * FROM booking WHERE booking_id = '$booking_id'";
        $result = mysqli_query($connection, $query);
        $booking_details = mysqli_fetch_assoc($result);

        $customer_id = $booking_details['customer_id'];
        $room_id = $booking_details['room_id'];
        $remaining_p = $booking_details['remaining_p'] - $advance_payment;

        $queryCus = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
        $resultCus = mysqli_query($connection, $queryCus);
        $cus_details = mysqli_fetch_assoc($resultCus);
        $remaining_price = $cus_details['remaining_price'] - $advance_payment;

        $updateCustomer = "UPDATE customer SET remaining_price =  $remaining_price WHERE customer_id = '$customer_id'";
        $resultCustomer = mysqli_query($connection, $updateCustomer);
        $updateBooking = "UPDATE booking SET remaining_p = '$remaining_price' WHERE booking_id = '$booking_id'";
        $result = mysqli_query($connection, $updateBooking);
        if ($resultCustomer) {
            $updatebook = "UPDATE booking SET checkin_status = '1' WHERE booking_id = '$booking_id'";
            $updateRes = mysqli_query($connection, $updatebook);
            $updateRoom = "UPDATE room SET check_in_status = '1' WHERE room_id = '$room_id'";
            $updateResult = mysqli_query($connection, $updateRoom);
            if ($updateRes) {
                if($advance_payment != 0){
                    $paymentHistory = "INSERT INTO payment_history(booking_id,customer_id,payment_type,amount,added_by) VALUES ('$booking_id', '$customer_id', '$payment_type', '$advance_payment', '$added_by')";
                    $paymentResult = mysqli_query($connection, $paymentHistory);
                }
                if ($updateRes) {
                    $response['done'] = true;
                    $response['data'] = "Check in successful";
                } else {
                    $response['done'] = false;
                    $response['data'] = "Problem in adding payment history";
                }
            } else {
                $response['done'] = false;
                $response['data'] = "Problem in Update Room Check in status";
            }
        } else {
            $response['done'] = false;
            $response['data'] = "Problem in payment";
        }
    } else {
        $response['done'] = false;
        $response['data'] = "Error With Booking";
    }
    echo json_encode($response);
}

if (isset($_POST['check_out_room'])) {
    $booking_id = $_POST['booking_id'];
    $remaining_amount = $_POST['remaining_amount'];
    $payment_type = $_POST['payment_type'];
    $added_by = $_SESSION['user_id'];

    if ($booking_id != '') {
        $query = "SELECT * FROM booking WHERE booking_id = '$booking_id'";
        $result = mysqli_query($connection, $query);
        $booking_details = mysqli_fetch_assoc($result);
        $room_id = $booking_details['room_id'];
        $customer_id = $booking_details['customer_id'];
        $remaining_p = $booking_details['remaining_p'];
        $extras = $booking_details['extras'];
        $queryCus = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
        $resultCus = mysqli_query($connection, $queryCus);
        $cus_details = mysqli_fetch_assoc($resultCus);
        $remaining_price = $cus_details['total_price'] + $extras;

        if ($remaining_price == $remaining_amount) {
        // if ($remaining_price) {
            $updateCustomer = "UPDATE customer SET remaining_price = '0',payment_status = '1' WHERE customer_id = '$customer_id'";
            $resultCustomer = mysqli_query($connection, $updateCustomer);
            $updateBooking = "UPDATE booking SET remaining_p = '0',payment_stat = '1',checkin_status = '0',checkout_status = '1' WHERE booking_id = '$booking_id'";
            $result = mysqli_query($connection, $updateBooking);
            if ($result) {
                $updateRoom = "UPDATE room SET status = NULL,check_in_status = '0',check_out_status = '1' WHERE room_id = '$room_id'";
                $updateResult = mysqli_query($connection, $updateRoom);
                if ($updateResult) {
                    if($amount != 0){
                        $paymentHistory = "INSERT INTO payment_history(booking_id,customer_id,payment_type,amount,added_by) VALUES ('$booking_id', '$customer_id', '$payment_type', '$remaining_amount', '$added_by')";
                        $paymentResult = mysqli_query($connection, $paymentHistory);
                    }
                    if ($paymentResult) {
                        $response['done'] = true;
                        $response['data'] = "Check out successful";
                    } else {
                        $response['done'] = false;
                        $response['data'] = "Problem in adding payment history";
                    }
                } else {
                    $response['done'] = false;
                    $response['data'] = "Problem in Update Room Check in status";
                }
            } else {
                $response['done'] = false;
                $response['data'] = "Problem in payment";
            }

        } else {
            $response['done'] = false;
            $response['data'] = "Please Enter Full Payment";
        }
    } else {
        $response['done'] = false;
        $response['data'] = "Error With Booking";
    }
    echo json_encode($response);
}

if (isset($_POST['more_payment'])) {
    $booking_id = $_POST['booking_id'];
    $remaining_amount = $_POST['remaining_amount'];
    $payment_type = $_POST['payment_type'];
    $added_by = $_SESSION['user_id'];

    if ($booking_id != '') {
        $query = "SELECT * FROM booking WHERE booking_id = '$booking_id'";
        $result = mysqli_query($connection, $query);
        $booking_details = mysqli_fetch_assoc($result);
        $customer_id = $booking_details['customer_id'];
        $room_id = $booking_details['room_id'];
        $remaining_p = $booking_details['remaining_p'];
        $extras = $booking_details['extras'];

        $queryCus = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
        $resultCus = mysqli_query($connection, $queryCus);
        $cus_details = mysqli_fetch_assoc($resultCus);
        $remaining_price = $cus_details['total_price'] + $extras;

        if ($remaining_amount != 0 && isset($payment_type)) {
            $updateCustomer = "UPDATE customer SET remaining_price =  remaining_price - $remaining_amount WHERE customer_id = '$customer_id'";
            $resultCustomer = mysqli_query($connection, $updateCustomer);
            $updateBooking = "UPDATE booking SET remaining_p = remaining_p - $remaining_amount WHERE booking_id = '$booking_id'";
            $result = mysqli_query($connection, $updateBooking);
            if ($result) {
                $paymentHistory = "INSERT INTO payment_history(booking_id,customer_id,payment_type,amount,added_by) VALUES ('$booking_id', '$customer_id', '$payment_type', '$remaining_amount', '$added_by')";
                $paymentResult = mysqli_query($connection, $paymentHistory);
                if ($paymentResult) {
                    $response['done'] = true;
                    $response['data'] = "Payment successful";
                } else {
                    $response['done'] = false;
                    $response['data'] = "Problem in adding payment history";
                }
            } else {
                $response['done'] = false;
                $response['data'] = "Please Enter Amount Paid here";
            }
        } else {
            $response['done'] = false;
            $response['data'] = "Please Enter Full Payment and Payment Type";
        }
    } else {
        $response['done'] = false;
        $response['data'] = "Error With Booking";
    }
    echo json_encode($response);
}

if (isset($_POST['hall_payment'])) {
    $booking_id = $_POST['booking_id'];
    $remaining_amount = $_POST['remaining_amount'];
    $payment_type = $_POST['payment_type'];
    $added_by = $_SESSION['user_id'];

    if ($booking_id != '') {
        $query = "SELECT * FROM hall_booking WHERE booking_id = '$booking_id'";
        $result = mysqli_query($connection, $query);
        $booking_details = mysqli_fetch_assoc($result);
        $customer_id = $booking_details['customer_id'];
        $hall_id = $booking_details['hall_id'];
        $remaining_p = $booking_details['remaining_price'];
        $extras = $booking_details['extras'];

        $queryCus = "SELECT * FROM hall_customer WHERE customer_id = '$customer_id'";
        $resultCus = mysqli_query($connection, $queryCus);
        $cus_details = mysqli_fetch_assoc($resultCus);
        $remaining_price = $cus_details['total_price'] + $extras;

        if ($remaining_amount != 0 && isset($payment_type)) {
            $updateCustomer = "UPDATE hall_customer SET remaining_price =  remaining_price - $remaining_amount WHERE customer_id = '$customer_id'";
            $resultCustomer = mysqli_query($connection, $updateCustomer);
            $updateBooking = "UPDATE hall_booking SET remaining_price = remaining_price - $remaining_amount WHERE booking_id = '$booking_id'";
            $result = mysqli_query($connection, $updateBooking);
            if ($result) {
                $paymentHistory = "INSERT INTO hall_payment_history(booking_id,customer_id,payment_type,amount,added_by) VALUES ('$booking_id', '$customer_id', '$payment_type', '$remaining_amount', '$added_by')";
                $paymentResult = mysqli_query($connection, $paymentHistory);
                if ($paymentResult) {
                    $response['done'] = true;
                    $response['data'] = "Payment successful";
                } else {
                    $response['done'] = false;
                    $response['data'] = "Problem in adding payment history";
                }
            } else {
                $response['done'] = false;
                $response['data'] = "Please Enter Amount Paid here";
            }
        } else {
            $response['done'] = false;
            $response['data'] = "Please Enter Amount and Payment Type";
        }
    } else {
        $response['done'] = false;
        $response['data'] = "Error With Booking";
    }
    echo json_encode($response);
}

if (isset($_POST['add_employee'])) {

    $staff_type = $_POST['staff_type'];
    $shift = $_POST['shift'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $name = $first_name . ' ' . $last_name;
    $contact_no = $_POST['contact_no'];
    $id_card_id = $_POST['id_card_id'];
    $id_card_no = $_POST['id_card_no'];
    $address = $_POST['address'];
    $salary = $_POST['salary'];

    if ($staff_type == '' && $shift == '' && $salary == ''){
        $response['done'] = false;
        $response['data'] = "Please Enter Carednalities";
    }else{
        $customer_sql = "INSERT INTO staff (emp_name,staff_type_id,shift_id,id_card_type,id_card_no,address,contact_no,salary) VALUES ('$name','$staff_type','$shift','$id_card_id','$id_card_no','$address','$contact_no','$salary')";
        $customer_result = mysqli_query($connection, $customer_sql);
        $emp_id = mysqli_insert_id($connection);
        $insert = "INSERT INTO emp_history (emp_id,shift_id) VALUES ('$emp_id','$shift')";
        $insert_result = mysqli_query($connection,$insert);
        if ($customer_result && $insert_result) {
            $response['done'] = true;
            $response['data'] = 'Successfully Booking';
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error in status change";
        }
    }
    echo json_encode($response);
}

if (isset($_POST['add_user'])) {

    $privilege_id = $_POST['privilege_id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $added_by = $_SESSION['user_id'];

    if ($privilege_id == '' && $name == '' && $password == ''){
        $response['done'] = false;
        $response['data'] = "Please Enter Carednalities";
    }else{
        $pword = md5($password);
        $customer_sql = "INSERT INTO user (privilege_id,name,username,email,password,added_by) VALUES ('$privilege_id','$name','$username','$email','$pword','$added_by')";
        $customer_result = mysqli_query($connection, $customer_sql);
        if ($customer_result) {
            $response['done'] = true;
            $response['data'] = 'Successfully User Added';
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error in adding user";
        }
    }
    echo json_encode($response);
}

if (isset($_POST['createGym'])) {
    $service = $_POST['service'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $added_by = $_SESSION['user_id'];

    $query = "INSERT INTO gym_pool (service,description,amount,added_by) VALUES ('$service','$description','$amount','$added_by')";
    $result = mysqli_query($connection, $query);
    $inv_id = mysqli_insert_id($connection);
    if ($result) {
        header("Location:index.php?gym");
    } else {
        header("Location:index.php?gym&error");
    }

}

if (isset($_POST['createInvoice'])) {
    $description = $_POST['customer'];
    $added_by = $_SESSION['user_id'];

    $query = "INSERT INTO invoice (description,added_by) VALUES ('$description','$added_by')";
    $result = mysqli_query($connection, $query);
    $inv_id = mysqli_insert_id($connection);
    if ($result) {
        $_SESSION['invoice_no'] = $inv_id;
        header("Location:index.php?sales");
    } else {
        header("Location:index.php?bar&error");
    }

}

if (isset($_POST['createKitchenInvoice'])) {
    $description = $_POST['customer'];
    $added_by = $_SESSION['user_id'];

    $query = "INSERT INTO kitchen_invoice (description,added_by) VALUES ('$description','$added_by')";
    $result = mysqli_query($connection, $query);
    $inv_id = mysqli_insert_id($connection);
    if ($result) {
        $_SESSION['kitchen_invoice_no'] = $inv_id;
        header("Location:index.php?kitchen_sales");
    } else {
        header("Location:index.php?kitchen&error");
    }

}

if (isset($_POST['createLaundryInvoice'])) {
    $description = $_POST['customer'];
    $added_by = $_SESSION['user_id'];

    $query = "INSERT INTO laundry_invoice (description,added_by) VALUES ('$description','$added_by')";
    $result = mysqli_query($connection, $query);
    $inv_id = mysqli_insert_id($connection);
    if ($result) {
        $_SESSION['laundry_invoice'] = $inv_id;
        header("Location:index.php?service");
    } else {
        header("Location:index.php?laundry_services&error");
    }

}

if(isset($_POST['saveInvoice'])) {
    $room = $_POST['room'];
    $paid = $_POST['paid'];
    $payment_type = $_POST['payment_type'];
    $total_price = $_POST['total_price'];
    $inv = $_POST['invoice_no'];

    $query = "UPDATE invoice set paid = '$paid', room_id = '$room', payment_type = '$payment_type', total_price = $total_price WHERE id = '$inv'";
    $result = mysqli_query($connection, $query);
    if(isset($room) && $room != '' && $room != ' '){
        $booking_query = "UPDATE booking set extras = extras + '$total_price' WHERE room_id = '$room' AND checkout_status = 0";
        $booking_result = mysqli_query($connection, $booking_query);
    }

    if ($result) {
        header("Location:index.php?bar");
    } else {
        header("Location:index.php?sales&error&" . mysqli_error($connection));
    }
}

if(isset($_POST['saveKitchenInvoice'])) {
    $room = $_POST['room'];
    $paid = $_POST['paid'];
    $payment_type = $_POST['payment_type'];
    $total_price = $_POST['total_price'];
    $inv = $_POST['invoice_no'];

    $query = "UPDATE kitchen_invoice set paid = '$paid', room_id = '$room', payment_type = '$payment_type', total_price = $total_price WHERE id = '$inv'";
    $result = mysqli_query($connection, $query);
    if(isset($room) && $room != '' && $room != ' '){
        $booking_query = "UPDATE booking set extras = extras + '$total_price' WHERE room_id = '$room' AND checkout_status = 0";
        $booking_result = mysqli_query($connection, $booking_query);
    }

    if ($result) {
        header("Location:index.php?bar");
    } else {
        header("Location:index.php?sales&error&" . mysqli_error($connection));
    }
}

if(isset($_POST['saveLaundryInvoice'])) {
    $room = $_POST['room'];
    $paid = $_POST['paid'];
    $payment_type = $_POST['payment_type'];
    $total_price = $_POST['total_price'];
    $inv = $_POST['invoice_no'];

    $query = "UPDATE laundry_invoice set paid = '$paid', room_id = '$room', payment_type = '$payment_type', total_price = $total_price WHERE id = '$inv'";
    $result = mysqli_query($connection, $query);
    if(isset($room) && $room != '' && $room != ' '){
        $booking_query = "UPDATE booking set extras = extras + '$total_price' WHERE room_id = '$room' AND checkout_status = 0";
        $booking_result = mysqli_query($connection, $booking_query);
        // $cust_query = "UPDATE customer set extras_charge = extras + '$total_price' WHERE room_id = '$room' AND checkout_status = 0";
        // $cust_result = mysqli_query($connection, $cust_query);
    }

    if ($result) {
        header("Location:index.php?laundry_services");
    } else {
        header("Location:index.php?service&error&" . mysqli_error($connection));
    }
}

if (isset($_POST['createService'])) {
    $apparel = $_POST['apparel'];
    $serv_type = $_POST['serv_type'];
    $inv = $_SESSION['laundry_invoice'];
    $quantity = $_POST['quantity'];
    $added_by = $_SESSION['user_id'];

    $query1 = "SELECT * FROM laundry WHERE id = $apparel";
    $result1 = mysqli_query($connection, $query1);
    $item_details = mysqli_fetch_assoc($result1);
    $price = $item_details[$serv_type];
    // $iron = $item_details['iron'];
    if ($result1){
        $sub_total = $price * $quantity;
        $query = "INSERT INTO laundry_jobs (invoice_id,laundry_id,service,price,quantity,sub_total,added_by) VALUES ('$inv','$apparel','$serv_type','$price','$quantity','$sub_total','$added_by')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            header("Location:index.php?service");
        } else {
            header("Location:index.php?service&error");
        }
    } else {
        header("Location:index.php?service&errorService");
    }

}

if (isset($_POST['createSales'])) {
    $item = $_POST['item'];
    $inv = $_SESSION['invoice_no'];
    $quantity = $_POST['quantity'];
    $added_by = $_SESSION['user_id'];

    $query1 = "select * from inventory where item_id = $item";
    $result1 = mysqli_query($connection, $query1);
    $item_details = mysqli_fetch_assoc($result1);
    $price = $item_details['price'];
    if ($result1){
        $sub_total = $price * $quantity;
        $query = "INSERT INTO sales (invoice_id,item_id,price,quantity,sub_total,added_by) VALUES ('$inv','$item','$price','$quantity','$sub_total','$added_by')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            header("Location:index.php?sales");
        } else {
            header("Location:index.php?sales&error");
        }
    } else {
        header("Location:index.php?sales&errorItem");
    }

}

if (isset($_POST['createKitchenSales'])) {
    $item = $_POST['item'];
    $inv = $_SESSION['kitchen_invoice_no'];
    $quantity = $_POST['quantity'];
    $added_by = $_SESSION['user_id'];

    $query1 = "SELECT * FROM menu WHERE item_id = $item";
    $result1 = mysqli_query($connection, $query1);
    $item_details = mysqli_fetch_assoc($result1);
    $price = $item_details['price'];
    if ($result1){
        $sub_total = $price * $quantity;
        $query = "INSERT INTO kitchen_sales (invoice_id,item_id,price,quantity,sub_total,added_by) VALUES ('$inv','$item','$price','$quantity','$sub_total','$added_by')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            header("Location:index.php?kitchen_sales");
        } else {
            header("Location:index.php?kitchen_sales&error");
        }
    } else {
        header("Location:index.php?kitchen_sales&errorItem");
    }

}

if (isset($_POST['editSales'])) {
    $item = $_POST['item'];
    $inv = $_POST['invoice_no'];
    $quantity = $_POST['quantity'];
    $added_by = $_SESSION['user_id'];

    $query1 = "select * from inventory where item_id = $item";
    $result1 = mysqli_query($connection, $query1);
    $item_details = mysqli_fetch_assoc($result1);
    $price = $item_details['price'];
    if ($result1){
        $sub_total = $price * $quantity;
        $query = "INSERT INTO sales (invoice_id,item_id,price,quantity,sub_total,added_by) VALUES ('$inv','$item','$price','$quantity','$sub_total','$added_by')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            header("Location:index.php?sales");
        } else {
            header("Location:index.php?sales&error");
        }
    } else {
        header("Location:index.php?sales&errorItem");
    }

}

if (isset($_GET['delete_invoice_item'])) {
    $sales_id = $_GET['delete_invoice_item'];
    $inv_id = $_GET['inv'];
    $sql = "DELETE FROM sales WHERE id = $sales_id";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        header("Location:index.php?sales&invoice=".$inv_id."&delete_success");
    } else {
        header("Location:index.php?sales&invoice=".$inv_id."&error");
    }
}

if (isset($_GET['delete_kitchen_invoice_item'])) {
    $sales_id = $_GET['delete_kitchen_invoice_item'];
    $inv_id = $_GET['inv'];
    $sql = "DELETE FROM kitchen_sales WHERE id = $sales_id";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        header("Location:index.php?kitchen_sales&invoice=".$inv_id."&delete_success");
    } else {
        header("Location:index.php?kitchen_sales&invoice=".$inv_id."&error");
    }
}

if (isset($_GET['delete_laundry_invoice_item'])) {
    $sales_id = $_GET['delete_laundry_invoice_item'];
    $inv_id = $_GET['inv'];
    $sql = "DELETE FROM laundry_jobs WHERE id = $sales_id";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        header("Location:index.php?service&invoice=".$inv_id."&delete_success");
    } else {
        header("Location:index.php?service&invoice=".$inv_id."&error");
    }
}

if (isset($_POST['createComplaint'])) {
    $complainant_name = $_POST['complainant_name'];
    $complaint_type = $_POST['complaint_type'];
    $complaint = $_POST['complaint'];
    $added_by = $_SESSION['user_id'];

    $query = "INSERT INTO complaint (complainant_name,complaint_type,complaint,added_by) VALUES ('$complainant_name','$complaint_type','$complaint','$added_by')";
    $result = mysqli_query($connection, $query);
    if ($result) {
        header("Location:index.php?complain&success");
    } else {
        header("Location:index.php?complain&error");
    }

}

if (isset($_POST['resolve_complaint'])) {
    $budget = $_POST['budget'];
    $complaint_id = $_POST['complaint_id'];
    $query = "UPDATE complaint set budget = '$budget',resolve_status = '1' WHERE id='$complaint_id'";
    $result = mysqli_query($connection, $query);
    if ($result) {
        header("Location:index.php?complain&resolveSuccess");
    } else {
        header("Location:index.php?complain&resolveError");
    }
}


if (isset($_POST['change_shift'])) {
    $emp_id = $_POST['emp_id'];
    $shift_id = $_POST['shift_id'];
    $query = "UPDATE staff set shift_id = '$shift_id' WHERE emp_id='$emp_id'";
    $result = mysqli_query($connection, $query);
    $to_date = date("Y-m-d H:i:s");
    $update = "UPDATE emp_history SET to_date = '$to_date' WHERE emp_id = '$emp_id' AND to_date IS NULL";
    $update_result = mysqli_query($connection,$update);
    $insert = "INSERT INTO emp_history (emp_id,shift_id) VALUES ('$emp_id','$shift_id')";
    $insert_result = mysqli_query($connection,$insert);

    if ($result && $insert_result && $update_result) {
        header("Location:index.php?staff_mang&success");
    } else {
        header("Location:index.php?staff_mang&error");
    }
}

/***** Bizzy *****/

if (isset($_POST['createLaundry'])) {
    $apparel = $_POST['apparel'];
    $wash = $_POST['wash'];
    $iron = $_POST['iron'];

    $query = "INSERT INTO laundry (apparel,wash_iron,iron) VALUES ('$apparel','$wash', '$iron')";
    $result = mysqli_query($connection, $query);    if ($result) {
        header("Location:index.php?laundry&success");
    } else {
        header("Location:index.php?laundry&error");
    }

}

if (isset($_POST['createItem'])) {
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];

    $query = "INSERT INTO inventory (item,price) VALUES ('$item_name', '$price')";
    $result = mysqli_query($connection, $query);    if ($result) {
        header("Location:index.php?inventory&success");
    } else {
        header("Location:index.php?inventory&error");
    }
}

if (isset($_POST['createMenu'])) {
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];

    $query = "INSERT INTO menu (item,price) VALUES ('$item_name', '$price')";
    $result = mysqli_query($connection, $query);    if ($result) {
        header("Location:index.php?menu&success");
    } else {
        header("Location:index.php?menu&error");
    }
}

if (isset($_POST['gym_edit'])) {
    $gym_id = $_POST['gym_id'];

    $sql = "SELECT * FROM gym_pool WHERE id = '$gym_id'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $gym = mysqli_fetch_assoc($result);
        $response['done'] = true;
        $response['service'] = $gym['service'];
        $response['description'] = $gym['description'];
        $response['amount'] = $gym['amount'];
        $response['id'] = $gym['id'];
    } else {
        $response['done'] = false;
        $response['data'] = "DataBase Error right here!";
    }

    echo json_encode($response);
}

if (isset($_POST['edit_gym'])) {
    $service = $_POST['service'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $gym_id = $_POST['gym_id'];

    if ($description != '' && isset($amount) && $amount != '') {
        $query = "UPDATE gym_pool SET service = '$service',description = '$description',amount = '$amount' where id = '$gym_id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $response['done'] = true;
            $response['data'] = 'Successfully Edit Gym/Pool';
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error";
        }

    } else {

        $response['done'] = false;
        $response['data'] = "Please Enter Description and Amount";
    }

    echo json_encode($response);
}

if (isset($_POST['laundry_edit'])) {
    $laundry_id = $_POST['laundry_id'];

    $sql = "SELECT * FROM laundry WHERE id = '$laundry_id'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $laundry = mysqli_fetch_assoc($result);
        $response['done'] = true;
        $response['apparel'] = $laundry['apparel'];
        $response['wash'] = $laundry['wash_iron'];
        $response['iron'] = $laundry['iron'];
        $response['id'] = $laundry['id'];
    } else {
        $response['done'] = false;
        $response['data'] = "DataBase Error right here!";
    }

    echo json_encode($response);
}

if (isset($_POST['item_edit'])) {
    $item_id = $_POST['item_id'];

    $sql = "SELECT * FROM inventory WHERE item_id = '$item_id'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $item = mysqli_fetch_assoc($result);
        $response['done'] = true;
        $response['item'] = $item['item'];
        $response['quantity'] = $item['quantity'];
        $response['price'] = $item['price'];
        $response['item_id'] = $item['item_id'];
    } else {
        $response['done'] = false;
        $response['data'] = "DataBase Error right here!";
    }

    echo json_encode($response);
}

if (isset($_POST['addSupply'])) {
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];
    $added_by = $_SESSION['user_id'];

    $query = "INSERT INTO supply (item_id,quantity,added_by) VALUES ('$item','$quantity','$added_by')";
    $result = mysqli_query($connection, $query);
    if ($result) {
        header("Location:index.php?supply&success");
    } else {
        header("Location:index.php?supply&error");
    }

}

if (isset($_POST['moreBook'])) {
    // Process received data
    $customerId = $_POST['customerId'];
    $check_in = $_POST['checkin'];
    $check_out = $_POST['checkout'];
    $total_price = $_POST['total_price']; // Total price sent from JavaScript
    $discount = $_POST['discount'];
    $added_by = $_SESSION['user_id'];

    // Initialize response array
    $response = array();

    // Check if any rooms are selected
    if (isset($_POST['rooms'])) {
        $selectedRooms = $_POST['rooms'];

        // Check existing bookings for the customer
        $check_existing_book_query = "SELECT room_id FROM booking WHERE customer_id = $customerId";
        $existing_result = mysqli_query($connection, $check_existing_book_query);
        $existing_booked_rooms = [];
        while ($row = mysqli_fetch_assoc($existing_result)) {
            $existing_booked_rooms[] = $row['room_id'];
        }

        // Loop through each selected room
        foreach ($selectedRooms as $room_id) {
            // Check if the room is already booked by the customer
            if (!in_array($room_id, $existing_booked_rooms)) {
                // Insert a record into the booking table for the current room
                $query = "INSERT INTO booking (customer_id, room_id, check_in, check_out, total_p, remaining_p, discounted, added_by) VALUES
                ('$customerId', '$room_id', '$check_in', '$check_out', '$total_price', '$total_price', '$discount', '$added_by')";
                $result = mysqli_query($connection, $query);

                // Check if the query was successful
                if ($result) {
                    // Insertion successful
                    $response[] = array('room_id' => $room_id, 'status' => 'success');
                } else {
                    // Insertion failed
                    $response[] = array('room_id' => $room_id, 'status' => 'error');
                }
            } else {
                // Room is already booked by the customer
                $response[] = array('room_id' => $room_id, 'status' => 'booked');
            }
        }

        // Update total price for the customer
        $update_customer_query = "UPDATE customer SET total_price = $total_price, remaining_price = $total_price, discount = $discount WHERE customer_id = $customerId";
        $update_customer_result = mysqli_query($connection, $update_customer_query);

        // Check if the update was successful
        if ($update_customer_result) {
            // Total price update successful
            $response['total_price_updated'] = true;
        } else {
            // Total price update failed
            $response['total_price_updated'] = false;
        }

        // Check if all insertions were successful
        $success = !in_array('error', array_column($response, 'status'));
        $response['done'] = $success;
        $response['data'] = 'Successfully Booking';

        // Send a response back to JavaScript
        echo json_encode($response);
    } else {
        // No rooms selected
        $response['done'] = false;
        $response['data'] = 'No rooms selected.';
        echo json_encode($response);
    }
}

