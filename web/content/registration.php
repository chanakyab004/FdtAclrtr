<?php

	session_start();
	include_once('includes/classes/class_UserRegister.php');		
	if(isset($_SESSION["userID"])) {
		header('location:index.php');
	}	
    $showModal = '';
	if(isset($_GET['id'])) {
		 $registrationID = $_GET['id'];
		 $object = new UserRegister();
		 $object->setUser($registrationID);
	     $codeMatches = $object->checkCode();
	     	 
		if ($codeMatches == true){
	    	$showModal = true;
	    } 
			
	} else {
		$registrationID = '';
	}

	$formMessage = '';
	
	
	
	 
	// Parse the log in form if the user has filled it out and pressed "Log In"
	if (isset($_POST["submit"])) {

		$registrationID = filter_input(INPUT_POST, 'registrationID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$userPassword2 = filter_input(INPUT_POST, 'userPassword2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$object = new UserRegister();
		$object->setUser($registrationID, $userEmail, $userPassword);

		$errors = false;

		if ($userPassword != $userPassword2){
			$formMessage = $formMessage .  " <br> Passwords do not match.";
			$errors = true;
			}
		
		if (empty($userPassword) or empty($userPassword2)) {
			$formMessage = $formMessage .  " <br> Password field is empty";
			$errors = true;
		}

	    if (strlen($userPassword) < '8') {
	        $formMessage = $formMessage .  " <br> Your password must contain at least 8 characters.";
	        $errors = true;
	    }
	    
	    if(!preg_match("#[0-9]+#",$userPassword)) {
	        $formMessage = $formMessage .  " <br> Your password must contain at least 1 number.";
	        $errors = true;
	    }

	    if(!preg_match("#[A-Z]+#",$userPassword)) {
	        $formMessage = $formMessage .  " <br> Your password must contain at least 1 capital letter.";
	        $errors = true;
	    }
	    
	    if(!preg_match("#[a-z]+#",$userPassword)) {
	    	$formMessage = $formMessage .  " <br> Your password must contain at least 1 lowercase letter.";
	    	$errors = true;
	    }
	    
	    if(strpos($userPassword, ' ') !== false) {
	    	$formMessage = $formMessage .  " <br> Your password cannot contain spaces.";
	    	$errors = true;
	    }
			
		$codeMatches = $object->checkCode();
		if ($codeMatches == true){
	    	$showModal = true;
	    	$errors = true;
	    }

	    $emailMatches = $object->checkEmail();
	    if (!$emailMatches){
	    	$formMessage = $object->getMessage();
	    	$errors = true;
	    }

	    if($errors == false){	
			$object->sendUser();
			$formMessage = $object->getMessage();
	    }
	}	
?>
<?php include "templates/registration.html";  ?>
