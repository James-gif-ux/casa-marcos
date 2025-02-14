<?php
require_once '../model/connector.php'; // Make sure to include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieving the values from POST request (make sure field names match your form)
    $booking_id = null; // Assuming booking_id is auto-increment or generated automatically; otherwise, manage as needed
    $booking_room_id = $_POST['room_id'] ?? null;
    $booking_fullname = $_POST['fullname'] ?? null;
    $booking_email = $_POST['email'] ?? null;
    $booking_number = $_POST['number'] ?? null;
    $booking_date = date('Y-m-d H:i:s'); // Current date and time (or from form)
    $booking_status = 'pending'; // or set based on your application logic

    // Validate required fields to avoid SQL errors
    if ($booking_room_id && $booking_fullname && $booking_email && $booking_number) {
        try {
            // Prepare the SQL statement
            $sql = "INSERT INTO `booking_tb` (`booking_id`, `booking_room_id`, `booking_fullname`, `booking_email`, `booking_number`, `booking_date`, `booking_status`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $params = [$booking_id, $booking_room_id, $booking_fullname, $booking_email, $booking_number, $booking_date, $booking_status];
            
            // Execute the SQL insertion
            $connector->executeUpdate($sql, $params);

            // Redirect or return success message
            header("Location: ../views/rooms.php?success=1");
            exit();
        } catch (PDOException $e) {
            error_log($e->getMessage()); // Log error for further review
            header("Location: ../views/reservation.php?error=1"); // Redirect on error
            exit();
        }
    } else {
        // Redirect if validation fails (required fields missing)
        header("Location: ../views/reservation.php?error=2");
        exit();
    }
}
?>