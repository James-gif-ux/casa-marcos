<?php
	include '../model/Booking_Model.php';	
	include '../model/BookingModel.php';//set page variables
	$page_info['page'] = 'confirmBooking'; //for page that needs to be called
	$page_info['sub_page'] = isset($_GET['sub_page'])? $_GET['sub_page'] : 'confirmBooking'; //for function to be loaded

	//--   home page       --//

	try {

		if (isset($_GET['function'])){
			new ServicesPageActive($page_info);
		}else{

			new ServicesPage($page_info);
		}
	}catch (Throwable $e){ 
		echo '<h1>ERROR 404</h1>';
		echo $e->getMessage();
	}//end of validation

	//--class for services page--//

    class ServicesPage{
        private $page= '';
		private $sub_page= '';

		function __construct($page_info){
			$this->page = $page_info['page'];
			$this->sub_page = $page_info['sub_page'];

			$this->{$page_info['sub_page']}();
		}

        
		function confirmBooking(){
			include '../views/confirmBooking.php';
		}
    }


    class ServicesPageActive{

    }
?>