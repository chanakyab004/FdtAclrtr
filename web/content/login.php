<?php

	session_start();

	if(isset($_SESSION["userID"])) {
		header('location:index.php');
	}	
		
	// set_error_handler('error_handler');
	
	if(isset($_GET['returnurl'])) {
		 $returnURL = $_GET['returnurl'];
	} else {
		$returnURL = '';
	}
	
	$formMessage = '';
	$userEmail = '';
	
	include_once('includes/classes/class_UserLogin.php');
	
	// Parse the log in form if the user has filled it out and pressed "Log In"
	if (isset($_POST["submit"])) {
		
		
		$userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$returnURL = filter_input(INPUT_POST, 'returnURL', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

			
		$object = new UserLogin();
		$object->setLogin($userEmail, $userPassword);
		$object->setReturnURL($returnURL);
		$object->Login();
		$formMessage = $object->getMessage();
			
	}
		
?>
<?php include "templates/login.html";  ?>
