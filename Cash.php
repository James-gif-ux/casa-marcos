<?php
session_start();

class PaymentProcessor {
    private $conn;
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "resort_db";

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Connection failed: " . $e->getMessage());
            $_SESSION['error'] = "Database connection error.";
            header("Location: Cash.php"); // Redirect if connection fails
            exit();
        }
    }

    public function processPayment() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                // Validate inputs
                if (empty($_POST['payment_method']) || empty($_POST['reference_number']) || empty($_FILES['payment_proof']) || empty($_POST['payment_amount'])) {
                    throw new Exception("All fields are required");
                }

                // Validate payment amount (example)
                $payment_amount = filter_var($_POST['payment_amount'], FILTER_VALIDATE_FLOAT);
                if ($payment_amount === false) {
                    throw new Exception("Invalid payment amount.");
                }

                // File upload handling
                $payment_proof = $_FILES['payment_proof'];
                $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];

                if (!in_array($payment_proof['type'], $allowed_types)) {
                    throw new Exception("Invalid file type. Only JPG, JPEG & PNG allowed");
                }

                $target_dir = "../images/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $file_extension = pathinfo($payment_proof['name'], PATHINFO_EXTENSION);
                $unique_filename = uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $unique_filename;

                if (!move_uploaded_file($payment_proof['tmp_name'], $target_file)) {
                    throw new Exception("Error uploading file");
                }

                // Database insertion
                $sql = "INSERT INTO payment_tb (
                    payment_amount,
                    payment_status,
                    payment_method,
                    reference_number,
                    payment_proof,
                    payment_transaction_date
                ) VALUES (:payment_amount, 'pending', :payment_method, :reference_number, :unique_filename, NOW())";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':payment_amount', $payment_amount, PDO::PARAM_STR);
                $stmt->bindParam(':payment_method', $_POST['payment_method'], PDO::PARAM_STR);
                $stmt->bindParam(':reference_number', $_POST['reference_number'], PDO::PARAM_STR);
                $stmt->bindParam(':unique_filename', $unique_filename, PDO::PARAM_STR);

                if (!$stmt->execute()) {
                    throw new Exception("Database error: " . print_r($stmt->errorInfo(), true));
                }

                $_SESSION['success'] = "Payment submitted successfully!";
                header("Location: confirmation.php");
                exit();

            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header("Location: Cash.php");
                exit();
            }
        }
    }

    public function __destruct() {
        // Close the database connection when the object is destroyed
        $this->conn = null;
    }
}

// Usage:
$paymentProcessor = new PaymentProcessor();
$paymentProcessor->processPayment();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Method</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 20px;
}

.payment-container {
    max-width: 800px;
    margin: 0 auto;
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
    text-align: center;
    margin-bottom: 30px;
}

.payment-method {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 20px;
    margin-bottom: 20px;
}

.payment-method h3 {
    color: #444;
    margin-top: 0;
}

.payment-details {
    margin-left: 20px;
}

.payment-details p {
    margin: 5px 0;
    color: #666;
}

.payment-proof, .payment-reference {
    margin: 20px 0;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-top: 5px;
}

input[type="file"] {
    margin-top: 5px;
}

a {
    background-color: #4CAF50;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    margin-top: 20px;
}

.submit-btn,a:hover {
    background-color: #45a049;
}

label {
    color: #555;
    display: block;
    margin-bottom: 5px;
}
</style>
<body>
    <div class="payment-container">
        <h2>Select Payment Method</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form action="../model/process_payment.php" method="POST" enctype="multipart/form-data">
            <div class="payment-method">
                <h3>Bank Transfer</h3>
                <div class="payment-details">
                    <p>Bank: BDO</p>
                    <p>Account Name: Casa Marcos</p>
                    <p>Account Number: 1234-5678-9012</p>
                    
                    <input type="radio" name="payment_method" value="bank_transfer" required>
                    <label>Pay via Bank Transfer</label>
                </div>
            </div>

            <div class="payment-method">
                <h3>GCash</h3>
                <div class="payment-details">
                    <p>GCash Number: 0917-123-4567</p>
                    <p>Account Name: Casa Marcos</p>
                    
                    <input type="radio" name="payment_method" value="gcash" required>
                    <label>Pay via GCash</label>
                </div>
            </div>

            <div class="payment-proof">
                <label>Upload Payment Proof:</label>
                <input type="file" name="payment_proof" accept="image/jpeg,image/png,image/jpg" required>
                
            </div>

            <div class="payment-reference">
                <label>Reference/Transaction Number:</label>
                <input type="text" name="reference_number" pattern="[A-Za-z0-9-]+" required>
            </div>

            <input type="hidden" name="payment_amount" value="<?php echo htmlspecialchars($_GET['payment_amount'] ?? ''); ?>">
            
            <button type="submit" class="btn btn-success">Submit Payment</button>
        </form>
    </div>
</body>
</html>