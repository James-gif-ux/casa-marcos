<?php
require_once '../model/customerModel.php';

$customerModel = new CustomerModel();

// Add a customer
$name = "John Doe";
$email = "john.doe@example.com";
$otherData = "";

if ($customerModel->addCustomer($name, $email, $otherData)) {
    echo "Customer added successfully.";
} else {
    echo "Failed to add customer.";
}

// Fetch customers
$customers = $customerModel->getCustomers();
if (!empty($customers)) {
    foreach ($customers as $customer) {
        echo $customer['cstm_name'] . "<br>";
    }
} else {
    echo "No customers found.";
}

// Approve a customer
$customerId = 1; // Replace with the actual customer ID you want to approve
if ($customerModel->approveCustomer($customerId)) {
    echo "Customer approved successfully.";
} else {
    echo "Failed to approve customer.";
}

// Close the connection when done
$customerModel->close();
?>