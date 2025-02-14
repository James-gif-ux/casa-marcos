<?php
session_start();
require_once 'server.php'; // Assuming this file contains your database connection parameters

class PaymentProcessor {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function processPayment($paymentData) {
        try {
            // Start transaction
            $this->conn->beginTransaction();

            // Create payment record
            $paymentQuery = "INSERT INTO payment_tb (payment_amount, payment_status, payment_transaction_date) 
                             VALUES (:amount, :status, NOW())";
            
            $stmt = $this->conn->prepare($paymentQuery);
            $stmt->execute([
                'payment_amount' => $paymentData['payment_amount'],
                'payment_status' => 'completed'
            ]);

            // Commit transaction
            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            // Rollback transaction on error
            $this->conn->rollBack();
            error_log("Payment processing error: " . $e->getMessage()); // Log the error
            return false;
        }
    }

    public function getPaymentDetails($paymentId) {
        $query = "SELECT * FROM payment_tb WHERE payment_id = :payment_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['payment_id' => $paymentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

echo "Payment processed successfully!";
?>