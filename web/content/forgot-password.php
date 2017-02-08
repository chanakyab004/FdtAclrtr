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

	if (isset($_POST["submit"])) {
			
		$userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$object = new ForgotPassword();
		$object->setUser($userEmail);
		$object->setTemporaryPassword();
		$formMessage = $object->getMessage();
		
			
	}
		
?>
<?php include "templates/forgot-password.html";  ?>
