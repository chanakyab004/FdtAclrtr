<?php
	include "includes/include.php";
	
	$object = new Session();
	$object->sessionCheck();	
		
	set_error_handler('error_handler');


	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	

	$manufacturers = NULL;
	$manufacturerDropdown = NULL;
	$categories = NULL;
	$categoryDropdown = NULL;


	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$admin = $userArray['admin'];

		if ($admin != '1') {
			header('location:index.php');
		}


	include_once('includes/classes/class_Manufacturers.php');
				
		$object = new Manufacturers();
		$object->getManufacturers();
		
		$manufacturerArray = $object->getResults();		

		foreach($manufacturerArray as &$row) {
			$manufacturerID = $row['manufacturerID'];
			$manufacturerName = $row['manufacturerName'];

			$manufacturers .= '<option value="'.$manufacturerID.'">'.$manufacturerName.'</option>';

		}

		$manufacturerDropdown = '<select class="manufacturers"><option></option>'.$manufacturers.'</select>';



	include_once('includes/classes/class_SubscriptionCategories.php');
				
		$object = new Categories();
		$object->getCategories();
		
		$categoryArray = $object->getResults();		

		foreach($categoryArray as &$row) {
			$subscriptionCategoryID = $row['subscriptionCategoryID'];
			$categoryName = $row['categoryName'];

			$categories .= '<option value="'.$subscriptionCategoryID.'">'.$categoryName.'</option>';

		}

		$categoryDropdown = '<select class="categories"><option></option>'.$categories.'</select>';	
	

?>
<?php include "templates/signup-manager.html";  ?>
