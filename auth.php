<?php
class Auth {
    private $db;

    public function __construct() {
        $this->db = new Connector();
    }

    public function loggedin($postData) {
        $username = trim($postData['username']);
        $password = trim($postData['password']);
        
        // Check if username exists
        $sql = "SELECT * FROM admin_tb WHERE admin_user = ?";
        $result = $this->db->executeQuery($sql, [$username]);
        
        if (!$result || count($result) === 0) {
            $_SESSION['error'] = "Username not found";
            return false;
        }
        
        // Validate password
        if (!password_verify($password, $result[0]['admin_password'])) {
            $_SESSION['error'] = "Incorrect password";
            return false;
        }
        
        // Set session variables on successful login
        $_SESSION['admin_id'] = $result[0]['admin_id'];
        $_SESSION['admin_user'] = $result[0]['admin_user'];
        $_SESSION['admin_type'] = $result[0]['admin_type'];
        return true;
    }
}

?>