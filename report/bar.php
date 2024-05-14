

<?php
// Include database connection
include '../db.php';

// Check if connection is successful
if ($connection === false) {
    die("Error: Database connection failed.");
}

// Initialize variables for default month and year
$selected_month = date("m");
$selected_year = date("Y");

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_month = date("m", strtotime($_POST["month"]));
    $selected_year = date("Y", strtotime($_POST["month"]));
}

// Prepare and execute SQL query for bar sales
$sql_bar = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_year,
               SUM(price * quantity) AS bar_sales
            FROM sales
            WHERE YEAR(created_at) = $selected_year
            AND MONTH(created_at) = $selected_month
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

$result_bar = $connection->query($sql_bar);
$bar_sales = 0;

if ($result_bar->num_rows > 0) {
    $row_bar = $result_bar->fetch_assoc();
    $bar_sales = $row_bar['bar_sales'];
}

// Prepare and execute SQL query for kitchen sales
$sql_kitchen = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_year,
                    SUM(price * quantity) AS kitchen_sales
                FROM kitchen_sales
                WHERE YEAR(created_at) = $selected_year
                AND MONTH(created_at) = $selected_month
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

$result_kitchen = $connection->query($sql_kitchen);
$kitchen_sales = 0;

if ($result_kitchen->num_rows > 0) {
    $row_kitchen = $result_kitchen->fetch_assoc();
    $kitchen_sales = $row_kitchen['kitchen_sales'];
}

// Prepare and execute SQL query for laundry sales
$sql_laundry = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_year,
                    SUM(price * quantity) AS laundry_sales
                FROM laundry_jobs
                WHERE YEAR(created_at) = $selected_year
                AND MONTH(created_at) = $selected_month
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

$result_laundry = $connection->query($sql_laundry);
$laundry_sales = 0;

if ($result_laundry->num_rows > 0) {
    $row_laundry = $result_laundry->fetch_assoc();
    $laundry_sales = $row_laundry['laundry_sales'];
}

// Prepare and execute SQL query for gym sales
$sql_gym = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_year,
                SUM(amount) AS gym_sales
            FROM gym_pool
            WHERE YEAR(created_at) = $selected_year
            AND MONTH(created_at) = $selected_month
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

$result_gym = $connection->query($sql_gym);
$gym_sales = 0;

if ($result_gym->num_rows > 0) {
    $row_gym = $result_gym->fetch_assoc();
    $gym_sales = $row_gym['gym_sales'];
}

// Prepare and execute SQL query for booking payment
$sql_book = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_year,
                SUM(amount) AS payment_history
            FROM payment_history
            WHERE YEAR(created_at) = $selected_year
            AND MONTH(created_at) = $selected_month
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

$result_book = $connection->query($sql_book);
$book_sales = 0;

if ($result_book->num_rows > 0) {
    $row_book = $result_book->fetch_assoc();
    $book_sales = $row_book['payment_history'];
}

// Prepare and execute SQL query for number of booked rooms
$sql_book_count = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_year,
                COUNT(*) AS books
            FROM booking
            WHERE YEAR(created_at) = $selected_year
            AND MONTH(created_at) = $selected_month
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

$result_book_count = $connection->query($sql_book_count);
$book_count = 0;

if ($result_book_count->num_rows > 0) {
    $row_book_count = $result_book_count->fetch_assoc();
    $book_count = $row_book_count['books'];
}

// Prepare and execute SQL query for hall payment
$sql_hall_book = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_year,
                SUM(amount) AS payment_history
            FROM hall_payment_history
            WHERE YEAR(created_at) = $selected_year
            AND MONTH(created_at) = $selected_month
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

$result_hall = $connection->query($sql_hall_book);
$hall_sales = 0;

if ($result_hall->num_rows > 0) {
    $row_hall = $result_hall->fetch_assoc();
    $hall_sales = $row_hall['payment_history'];
}

// Prepare and execute SQL query for number of booked halls
$sql_hall_count = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_year,
                COUNT(*) AS books
            FROM hall_booking
            WHERE YEAR(created_at) = $selected_year
            AND MONTH(created_at) = $selected_month
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

$result_hall_count = $connection->query($sql_hall_count);
$hall_count = 0;

if ($result_hall_count->num_rows > 0) {
    $row_hall_count = $result_hall_count->fetch_assoc();
    $hall_count = $row_hall_count['books'];
}

// Prepare and execute SQL query for expenses
$sql_exp = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_year,
                SUM(amount) AS expense
            FROM expenses
            WHERE YEAR(created_at) = $selected_year
            AND MONTH(created_at) = $selected_month
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

$result_exp = $connection->query($sql_exp);
$exp_sales = 0;

if ($result_exp->num_rows > 0) {
    $row_exp = $result_exp->fetch_assoc();
    $exp_sales = $row_exp['expense'];
}

// Prepare and execute SQL query for expenses  "or resolve_date
$sql_complaint = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_year,
                SUM(budget) AS cost
            FROM complaint
            WHERE YEAR(created_at) = $selected_year
            AND MONTH(created_at) = $selected_month
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

$result_complaint = $connection->query($sql_complaint);
$complaint_sales = 0;

if ($result_complaint->num_rows > 0) {
    $row_complaint = $result_complaint->fetch_assoc();
    $complaint_sales = $row_complaint['cost'];
}

// Set JSON header
header('Content-Type: application/json');

// Output JSON data
echo json_encode([
    'bar_sales' => $bar_sales,
    'kitchen_sales' => $kitchen_sales,
    'laundry_sales' => $laundry_sales,
    'gym_sales' => $gym_sales,
    'payment_history' => $book_sales,
    'book_count' => $book_count,
    'hall_sales' => $hall_sales,
    'hall_count' => $hall_count,
    'expenses' => $exp_sales,
    'complaint' => $complaint_sales,
    'total_spend' => $exp_sales + $complaint_sales,
    'total_earnings' => $bar_sales + $kitchen_sales + $laundry_sales + $gym_sales + $book_sales + $hall_sales,
]);
?>
