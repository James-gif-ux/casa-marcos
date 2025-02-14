<?php
class Booking_Model {
    private $conn;

    public function __construct() {
        // Database credentials
        $server = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'resort_db';

        // Create the MySQL connection
        $this->conn = new mysqli($server, $username, $password, $database);

        // Check for a connection error and handle it
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Fetch all available services from the database
    public function get_service() {
        $sql = "SELECT * FROM services_tb";
        $result = $this->conn->query($sql);
        $services = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $services[] = $row;
            }
        }

        return $services;
    }

    // Check if a service exists by its ID
    public function get_service_name_by_id($services_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM services_tb WHERE services_id = ?");
        $stmt->bind_param("i", $services_id);  // "i" for integer
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;  // Return true if the service exists, false otherwise
    }

    // Insert a new booking into the database
    public function insert_booking($fullname, $email, $number, $date, $services_id, $status = 'pending') {
        // Validate if the service exists
        if (!$this->get_service_name_by_id($services_id)) {
            return "";
        }

        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare("INSERT INTO booking_tb (booking_fullname, booking_email, booking_number, booking_date, booking_services_id, booking_status) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Bind the parameters
        $stmt->bind_param("ssssss", $fullname, $email, $number, $date, $services_id, $status);
        
        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            // If successful, return true
            $stmt->close();
            return true;
        } else {
            // If there was an error, return an error message
            $error = $stmt->error;
            $stmt->close();
            return "Error: " . $error;
        }
    }

    // Fetch booking details by booking ID
    public function get_booking_by_id($booking_id) {
        $stmt = $this->conn->prepare("SELECT * FROM booking_tb WHERE booking_id = ?");
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // No booking found
        }

        $stmt->close();
    }

    // Get all bookings that are pending approval
    public function get_pending_bookings() {
        $sql = "SELECT booking_id, booking_fullname, booking_email, booking_number, booking_date FROM booking_tb WHERE booking_status = 'pending'";
        $result = $this->conn->query($sql);
        $bookings = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
        }

        return $bookings;
    }

    // Update booking status (approve or reject)
    public function update_booking_status($booking_id, $status) {
        // Ensure the status is either 'approved' or 'rejected'
        if (!in_array($status, ['approved', 'rejected'])) {
            return "Invalid status provided.";
        }

        $stmt = $this->conn->prepare("UPDATE booking_tb SET booking_status = ? WHERE booking_id = ?");
        $stmt->bind_param("si", $status, $booking_id);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $error = $stmt->error;
            $stmt->close();
            return "Error: " . $error;
        }
    }

    // Close the database connection
    public function close_connection() {
        $this->conn->close();
    }
}
?>
