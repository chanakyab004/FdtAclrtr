<?php
	include_once('includes/dbopen.php');
	include_once 'includes/settings.php';


	$email_root = EMAIL_ROOT . "/";
	$error_email = ERROR_EMAIL;
	$server_role = SERVER_ROLE;
	
	$formMessage = '';
	$userEmail = '';
	$temp = '';
	
	//include_once('includes/classes/class_UserLogin.php');
	
	include_once('includes/classes/class_ForgotPassword.php');

	if (isset($_POST["userEmail"]) && isset($_POST['userID'])) {
		
		
		$userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$userID = filter_input(INPUT_POST, 'userID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$object = new ForgotPassword();
		$object->setUserByID($userID); 
		$object->resetPassword(); 
		// $formMessage = $object->getMessage();
		$formMessage = $object->getResetMessage();

		// var_dump($_POST);

			echo json_encode($formMessage);
			
	}
		
?>
