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
        $sql = "SELECT * FROM halls WHERE hall = '$hall' AND id <> '$hall_id'";
        if (mysqli_num_rows(mysqli_query($connection, $sql)) >= 1) {
            $response['done'] = false;
            $response['data'] = "Hall Already Exist";
        } else {
            $query = "UPDATE halls SET hall = '$hall',price = '$price' where id = '$hall_id'";
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

    $sql = "SELECT * FROM halls WHERE id = '$hall_id'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $room = mysqli_fetch_assoc($result);
        $response['done'] = true;
        $response['hall'] = $room['hall'];
        $response['price'] = $room['price'];
        $response['hall_id'] = $room['id'];
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
    $category = $_POST['category'];
    $price = $_POST['price'];
    $item_id = $_POST['item_id'];

    if ($item != '' && isset($category) && $category != '') {
        $query = "UPDATE inventory SET item = '$item',category = '$category',price = '$price' where item_id = '$item_id'";
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
    $sql = "UPDATE halls set deleteStatus = '1' WHERE id = '$hall_id'";
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

    $sql = "SELECT * FROM room WHERE room_type_id = '$room_type_id' AND check_in_status = '0' AND deleteStatus = '0'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        echo "<option selected disabled>Select Room Type</option>";
        while ($room = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $room['room_id'] . "'>" . $room['room_no'] . "</option>";
        }
    } else {
        echo "<option>No Available</option>";
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
        echo "<option>No Available</option>";
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

    $sql = "SELECT * FROM halls WHERE id = '$hall_id'";
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
    $email = $_POST['email'];
    $id_card_id = $_POST['id_card_id'];
    $id_card_no = $_POST['id_card_no'];
    $address = $_POST['address'];
    $added_by = $_SESSION['user_id'];

    $customer_sql = "INSERT INTO customer (customer_name,contact_no,email,id_card_type_id,id_card_no,address) VALUES ('$name','$contact_no','$email','$id_card_id','$id_card_no','$address')";
    $customer_result = mysqli_query($connection, $customer_sql);
    // if($discount <= ((40 / 100) * $total_price)){
        if ($customer_result) {
            $customer_id = mysqli_insert_id($connection);
            $booking_sql = "INSERT INTO hall_booking (customer_id,hall_id,check_in,check_out,total_price,remaining_price,discount,added_by) VALUES ('$customer_id','$hall_id','$check_in','$check_out','$total_price','$total_price','$discount','$added_by')";
            $booking_result = mysqli_query($connection, $booking_sql);
            if ($booking_result) {
                $hall_stats_sql = "UPDATE halls SET status = '1' WHERE id = '$hall_id'";
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
    // } else {
    //     $response['done'] = false;
    //     $response['data'] = "DataBase Error add discount";
    // }

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

    $customer_sql = "INSERT INTO customer (customer_name,contact_no,email,id_card_type_id,id_card_no,address) VALUES ('$name','$contact_no','$email','$id_card_id','$id_card_no','$address')";
    $customer_result = mysqli_query($connection, $customer_sql);
    // if($discount <= ((40 / 100) * $total_price)){
        if ($customer_result) {
            $customer_id = mysqli_insert_id($connection);
            $booking_sql = "INSERT INTO booking (customer_id,room_id,check_in,check_out,total_price,remaining_price,discount,added_by) VALUES ('$customer_id','$room_id','$check_in','$check_out','$total_price','$total_price','$discount','$added_by')";
            $booking_result = mysqli_query($connection, $booking_sql);
            if ($booking_result) {
                $room_stats_sql = "UPDATE room SET status = '1' WHERE room_id = '$room_id'";
                if (mysqli_query($connection, $room_stats_sql)) {
                    $response['done'] = true;
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
    // } else {
    //     $response['done'] = false;
    //     $response['data'] = "DataBase Error add discount";
    // }

    echo json_encode($response);
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

if (isset($_POST['cutomerDetails'])) {
    //$customer_result='';
    $room_id = $_POST['room_id'];

    if ($room_id != '') {
        $sql = "SELECT * FROM room NATURAL JOIN room_type NATURAL JOIN booking NATURAL JOIN customer WHERE room_id = '$room_id' AND payment_status = '0'";
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
            $response['remaining_price'] = $customer_details['remaining_price'];
        } else {
            $response['done'] = false;
            $response['data'] = "DataBase Error";
        }

        echo json_encode($response);
    }
}

if (isset($_POST['booked_room'])) {
    $room_id = $_POST['room_id'];

    $sql = "SELECT * FROM room NATURAL JOIN room_type NATURAL JOIN booking NATURAL JOIN customer WHERE room_id = '$room_id' AND payment_status = '0'";
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
        $response['total_price'] = $room['total_price'];
        $response['remaining_price'] = $room['remaining_price'];
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
        $query = "select * from booking where booking_id = '$booking_id'";
        $result = mysqli_query($connection, $query);
        $booking_details = mysqli_fetch_assoc($result);
        $room_id = $booking_details['room_id'];
        $remaining_price = $booking_details['total_price'] - $advance_payment;

        $updateBooking = "UPDATE booking SET remaining_price = '$remaining_price' where booking_id = '$booking_id'";
        $result = mysqli_query($connection, $updateBooking);
        if ($result) {
            $updateRoom = "UPDATE room SET check_in_status = '1' WHERE room_id = '$room_id'";
            $updateResult = mysqli_query($connection, $updateRoom);
            if ($updateResult) {
                $paymentHistory = "INSERT INTO payment_history(booking_id,payment_type,amount,added_by) VALUES ('$booking_id', '$payment_type', '$advance_payment', '$added_by')";
                $paymentResult = mysqli_query($connection, $paymentHistory);
                if ($paymentResult) {
                    $response['done'] = true;
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
        $query = "select * from booking where booking_id = '$booking_id'";
        $result = mysqli_query($connection, $query);
        $booking_details = mysqli_fetch_assoc($result);
        $room_id = $booking_details['room_id'];
        $remaining_price = $booking_details['remaining_price'];

        if ($remaining_price == $remaining_amount) {
            $updateBooking = "UPDATE booking SET remaining_price = '0',payment_status = '1' where booking_id = '$booking_id'";
            $result = mysqli_query($connection, $updateBooking);
            if ($result) {
                $updateRoom = "UPDATE room SET status = NULL,check_in_status = '0',check_out_status = '1' WHERE room_id = '$room_id'";
                $updateResult = mysqli_query($connection, $updateRoom);
                if ($updateResult) {
                    $paymentHistory = "INSERT INTO payment_history(booking_id,payment_type,amount,added_by) VALUES ('$booking_id', '$payment_type', '$remaining_amount', '$added_by')";
                    $paymentResult = mysqli_query($connection, $paymentHistory);
                    if ($paymentResult) {
                        $response['done'] = true;
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
        $query = "select * from booking where booking_id = '$booking_id'";
        $result = mysqli_query($connection, $query);
        $booking_details = mysqli_fetch_assoc($result);
        $room_id = $booking_details['room_id'];
        $remaining_price = $booking_details['remaining_price'];

        if ($remaining_amount != 0 && isset($payment_type)) {
            $updateBooking = "UPDATE booking SET remaining_price = remaining_price - $remaining_amount where booking_id = '$booking_id'";
            $result = mysqli_query($connection, $updateBooking);
            if ($result) {
                $paymentHistory = "INSERT INTO payment_history(booking_id,payment_type,amount,added_by) VALUES ('$booking_id', '$payment_type', '$remaining_amount', '$added_by')";
                $paymentResult = mysqli_query($connection, $paymentHistory);
                if ($paymentResult) {
                    $response['done'] = true;
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
        $booking_query = "UPDATE booking set remaining_price = remaining_price + '$total_price' WHERE room_id = '$room'";
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
        $booking_query = "UPDATE booking set remaining_price = remaining_price + '$total_price' WHERE room_id = '$room'";
        $booking_result = mysqli_query($connection, $booking_query);
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

    $query1 = "select * from laundry where id = $apparel";
    $result1 = mysqli_query($connection, $query1);
    $item_details = mysqli_fetch_assoc($result1);
    $price = $item_details[$serv_type];
    // $iron = $item_details['iron'];
    if ($result1){
        $sub_total = $price * $quantity;
        $query = "INSERT INTO laundry_jobs (invoice_id,laundry_id,price,quantity,sub_total,added_by) VALUES ('$inv','$apparel','$price','$quantity','$sub_total','$added_by')";
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
    $sql = "DELETE FROM sales WHERE id = $sales_id";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        header("Location:index.php?sales&delete_success");
    } else {
        header("Location:index.php?sales&error");
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
    $category = $_POST['category'];

    $query = "INSERT INTO inventory (item,category,price,quantity) VALUES ('$item_name','$category', '$price', 0)";
    $result = mysqli_query($connection, $query);    if ($result) {
        header("Location:index.php?inventory&success");
    } else {
        header("Location:index.php?inventory&error");
    }

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
    $result = mysqli_query($connection, $query);    if ($result) {
        header("Location:index.php?supply&success");
    } else {
        header("Location:index.php?supply&error");
    }

}