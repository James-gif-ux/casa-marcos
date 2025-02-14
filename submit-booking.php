<?php
// Include necessary files
include_once '../model/Booking_Model.php';  // Assuming this contains logic for booking insertion
session_start();  // Start session to store confirmation data

$bookingModel = new Booking_Model();       // Create an instance of the booking model

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $date = $_POST['date'];
    $service_id = $_POST['service_id'];  // Get the selected service ID from the form

    // Insert the booking into the database
    $result = $bookingModel->insert_booking($fullname, $email, $number, $date, $service_id);

    if ($result === true) {
        // Set session variables to display in confirmation page
        $_SESSION['booking_success'] = true;
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;
        $_SESSION['number'] = $number;
        $_SESSION['service_name'] = $bookingModel->get_service_name_by_id($services_id);  // Assuming this method exists to get the service name
        $_SESSION['date'] = $date;
        $_SESSION['time'] = $time;

        // Redirect to confirmation page
        header("Location: ../views/confirmation.php");
        exit();
    } else {
        // Handle errors (optional)
        echo "Error: " . $result;
    }
}
