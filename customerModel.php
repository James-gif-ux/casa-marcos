<?php
require_once 'server.php';

class CustomerModel {
    private $conn;

    public function __construct() {
        $database = new Connector();
        $this->conn = $database->getConnection();
    }

    public function addCustomer($name, $email, $otherData) {
        try {
            $query = "INSERT INTO customer_tb (cstm_name, cstm_email, cstm_approved) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $approved = 0; // Change this if you want to set different approval state
            return $stmt->execute([$name, $email, $approved]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getCustomers() {
        try {
            $query = "SELECT * FROM customer_tb";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function approveCustomer($customerId) {
        try {
            $query = "UPDATE customer_tb SET cstm_approved = 1 WHERE cstm_id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$customerId]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function close() {
        $this->conn = null; // Close the connection
    }

    public function insert_customer($name, $email, $otherData) {
        try {
            $query = "INSERT INTO customer_tb (cstm_name, cstm_email, cstm_approved) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $approved = 0; // Change this if you want to set different approval state
            return $stmt->execute([$name, $email, $approved]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    
}
?>