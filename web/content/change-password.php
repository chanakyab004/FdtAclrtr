<?php

	include "includes/include.php";
	
	session_start();

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	}

	if (is_null($_SESSION["temporaryPasswordSet"])){
		header('Location:index.php');
	}

	$formMessage = '';
	
	include_once('includes/classes/class_ChangePassword.php');
	
	// Parse the log in form if the user has filled it out and pressed "Log In"
	if (isset($_POST["submit"])) {
		
		$userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$userPasswordConfirm = filter_input(INPUT_POST, 'userPasswordConfirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		//password requirement validation, must contain one upper one lower and one number
		$validate = true;
		if ($userPassword != $userPasswordConfirm){
			$formMessage .= " <br> Passwords do not match.";
			$validate = false;
			}

		if (empty($userPassword) or empty($userPasswordConfirm)) {
			$formMessage .= " <br> Password field is empty";
			$validate = false;
		}

	    if (strlen($userPassword) < '8') {
	        $formMessage .= " <br> Your password must contain at least 8 characters.";
	        $validate = false;
	    }

	    if(!preg_match("#[0-9]+#",$userPassword)) {
	        $formMessage .= " <br> Your password must contain at least 1 number.";
	        $validate = false;
	    }

	    if(!preg_match("#[A-Z]+#",$userPassword)) {
	        $formMessage .= " <br> Your password must contain at least 1 capital letter.";
	        $validate = false;
	    }

	    if(!preg_match("#[a-z]+#",$userPassword)) {
	    	$formMessage .= " <br> Your password must contain at least 1 lowercase letter.";
	    	$validate = false;
	    }

	    if(strpos($userPassword, ' ') !== false) {
	    	$formMessage .= " <br> Your password cannot contain spaces.";
	    	$validate = false;
	    }

	    if ($validate){
			$object = new ChangePassword();
			$object->setUser($userID, $userPassword);
			$object->setNewPassword();
	    }

	}
		
?>
<?php include "templates/change-password.html";  ?>
