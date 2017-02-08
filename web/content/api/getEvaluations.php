<?php
	header('Content-Type: application/json');
	include_once('../api/class_GetEvaluations.php');
	
	if (isset($_POST["token"])) {
		$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if (isset($_POST["projectID"])) {
		$projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
	}

		$object = new GetEvaluations();
		$object->setToken($token);
		$object->setProjectID($projectID);
		$object->authenticate();
		$response = $object->getResults();

		echo json_encode($response);
?>