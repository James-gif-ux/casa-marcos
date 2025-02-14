<?php
	//import model
	include_once '../model/authenticationModel.php';

	$page_info['page'] = 'login'; //for page that needs to be called
	$page_info['sub_page'] = isset($_GET['sub_page'])? $_GET['sub_page'] : 'login'; //for function to be loaded
		
	//-----------------------//
	//--     --//
	//-----------------------//
	session_start();
	if(!isset($_SESSION['loggedin'])){
		try {//used try to catch unfortunate errors
			//check for active function
			if (isset($_GET['function'])){
				new LoginActive($page_info);
			}else{
				//no active function, use the default page to view
				new Login($page_info);
			}		
			
		}catch (Throwable $e){ //get the encountered error
			echo '<h1>ERROR 404</h1>';
			echo $e->getMessage();
		}//end of validation
	}else{
		header("Location: ../pages/dashboard.php");
	}
	
	
	//-----------------------//
	//--  Class Navigation --//
	//-----------------------//
	class Login{
		//set default page info
		private $page = '';
		private $sub_page = '';
		
		//run function construct
		function __construct($page_info){
			//assign page info
			$this->page = $page_info['page'];
			$this->sub_page = $page_info['sub_page'];
			
			//run the function
			$this->{$page_info['sub_page']}();
		}
		
		//-----------------------------//
		//--   function start here   --//
		function login(){
			include '../views/login.php';
		}
		function register(){ //register page
			include "../views/register.php";
		}
		function dashboard(){
			include '../views/dashboard.php';
		}
	}
	
	//-----------------------//
	//-- Active Class      --//
	//-----------------------//
	class LoginActive{
		//set default page info
		private $page = '';
		private $sub_page = '';
		
		//run function construct
		function __construct($page_info){
			//assign page info
			$this->page = $page_info['page'];
			$this->sub_page = $page_info['sub_page'];
			
			//run the function
			$this->{$page_info['sub_page']}();
		}
		
		//-----------------------------//
		//--   function start here   --//
		
		//-----------------------------------//
		//--  active function start here   --//
		
		function loggedin(){ //validate login
			//instantiate class model
			
			$loggedin = new authenticationModel();
			

			$result = $loggedin->loggedin($_POST);
			
			if($result){
				if($result['admin_type'] === 'admin'){
					header('Location: ../pages/dashboard.php?sub_page=dashboard');
				}else{
					header('Location: ../pages/dashboard.php?sub_page=dashboard');
				}
			}else{
				$msg = "Invalid Username or Password!";
				include '../views/login.php';
			}

			
		}
		
		// function register(){//register user
		
		// 	$register = new authenticationModel();

		// 	$result = $register->register($_POST);
			
		// 	if($result){
		// 		echo "<script>alert('REGISTERED SUCCESSFULLY')</script>";
		// 		include '../views/login.php';
		// 	}else{
		// 		echo "<script>alert('REGISTRATION FAILED')</script>";
		// 		include '../views/register.php';
		// 	}
		
			
		// }
	
	}
	
?>