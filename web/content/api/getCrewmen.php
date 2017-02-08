<?php
	header('Content-Type: application/json');
	include_once('../api/class_GetCrewmen.php');
	
	if (isset($_POST["token"])) {
		$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
		$object = new GetCrewmen();
		$object->setToken($token);
		$object->authenticate();
		$response = $object->getResults();

		echo json_encode($response);
?>