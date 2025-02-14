<?php
class Connector{
	
	//database variables
	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	
	protected $conn;
	function __construct(){
		try {
			$this->conn = new PDO("mysql:host=$this->servername;dbname=resort_db", $this->username, $this->password);
			// set the PDO error mode to exception
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//echo "Connected successfully";
		} catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}

	 // Method to execute update queries (INSERT, UPDATE, DELETE)
	 public function executeUpdate($sql, $params) {
        try {
            $stmt = $this->conn->prepare($sql); // Prepare the SQL query
            return $stmt->execute($params);    // Execute the query with parameters
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Method to execute select queries and fetch results
    public function executeQuery($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all results as an associative array
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }  // Add this getter method
    public function getConnection() {
        return $this->conn;
    }
}
?>


