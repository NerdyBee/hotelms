<?php
// if (isset($_POST['moreBook'])) {
//     // Process received data
//     $customerId = $_POST['customerId'];
//     $check_in = $_POST['checkin'];
//     $check_out = $_POST['checkout'];
//     $discount = $_POST['discount'];
//     $added_by = $_SESSION['user_id'];

//     // Initialize response array
//     $response = array();

//     // Check if any rooms are selected
//     if (isset($_POST['rooms'])) {
//         $selectedRooms = $_POST['rooms'];

//         // Loop through each selected room
//         foreach ($selectedRooms as $room_id) {
//             // You may want to perform additional validations here
//             // For example, check if the room is available for the requested dates

//             // Insert a record into the booking table for the current room
//             $query = "INSERT INTO booking (customer_id, room_id, check_in, check_out, total_p, remaining_p, discounted, added_by) VALUES ('$customerId', '$room_id', '$check_in', '$check_out', '0', '0', '$discount', '$added_by')";
//             $result = mysqli_query($connection, $query);

//             // Check if the query was successful
//             if ($result) {
//                 // Insertion successful
//                 $response[] = array('room_id' => $room_id, 'status' => 'success');
//             } else {
//                 // Insertion failed
//                 $response[] = array('room_id' => $room_id, 'status' => 'error');
//             }
//         }

//         // Check if all insertions were successful
//         $success = !in_array('error', array_column($response, 'status'));
//         $response['done'] = $success;
//         $response['data'] = 'Successfully Booking';

//         // Send a response back to JavaScript
//         echo json_encode($response);
//     } else {
//         // No rooms selected
//         $response['done'] = false;
//         $response['data'] = 'No rooms selected.';
//         echo json_encode($response);
//     }
// }

if (isset($_POST['moreBook'])) {
    // Process received data
    $customerId = $_POST['customerId'];
    $check_in = $_POST['checkin'];
    $check_out = $_POST['checkout'];
    $total_price = $_POST['total_price'];
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
                $query = "INSERT INTO booking (customer_id, room_id, check_in, check_out, total_p, remaining_p, discounted, added_by) VALUES ('$customerId', '$room_id', '$check_in', '$check_out', '$total_price', '$total_price', '$discount', '$added_by')";
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