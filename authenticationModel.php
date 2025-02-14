<?php
	//import database connector
	require_once 'connector.php';
	
	//-------------------------------//
	//--class for login page active--//
	//-------------------------------//
	class authenticationModel extends Connector{
		function __construct(){
			parent::__construct();
		}
		
		//-------------------------------//
		//--  function starts here      --//
		function loggedin(){
            $sql = "SELECT * FROM `admin_tb` WHERE admin_username = ? and admin_password = ?";
            $query = $this->conn->prepare($sql);
            
            // Bind the parameters
            $query->bindParam(1, $_POST['username']);
            $query->bindParam(2, $_POST['password']);
        
            //execute query
            $query->execute();
            //return
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        

	// 	function register(){

	// 		$sql = "INSERT INTO `user_tb` (`user_fullname`, `user_email`, `user_password`) 
	// 							VALUE ('{$_POST['name']}','{$_POST['email']}','{$_POST['password']}')";
	// 		$query = $this->conn->prepare($sql);
			

	// 		//execute query
	// 		$query->execute();
	// 		//return
	// 		return true;


	// 	}
	 }
?>