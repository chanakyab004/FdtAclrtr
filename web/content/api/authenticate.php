<?php
	header('Content-Type: application/json');
	include_once('../api/class_Authenticate.php');

	if (isset($_POST["userEmail"])) {
		$userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if (isset($_POST["userPassword"])) {
		$userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

		$object = new Authenticate();
		$object->setEmail($userEmail);
		$object->setPassword($userPassword);
		$object->Login();
		$response = $object->getResults();


		echo json_encode($response);
?>