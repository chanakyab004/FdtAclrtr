<?php

	session_start();

	if(isset($_SESSION["userID"])) {
		header('location:index.php');
	}	
		
	// set_error_handler('error_handler');
	
	// include_once('includes/classes/class_Signup.php');
	
	// // Parse the log in form if the user has filled it out and pressed "Log In"
	// if (isset($_POST["submit"])) {
	// 	$userFirstName = filter_input(INPUT_POST, 'userFirstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$userLastName = filter_input(INPUT_POST, 'userLastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$companyName = filter_input(INPUT_POST, 'companyName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$referralCode = filter_input(INPUT_POST, 'referralCode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$referralName = filter_input(INPUT_POST, 'referralName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$manufacturerID = NULL;
			
	// 	$object = new Signup();
	// 	$object->setSignup($userFirstName, $userLastName, $companyName, $userEmail, $manufacturerID, $referralCode, $referralName);
	// 	$object->sendSignup();
	// 	$formMessage = $object->getMessage();
	// }
?>
<?php include "templates/signup.html";  ?>
