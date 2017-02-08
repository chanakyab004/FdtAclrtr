<?php
	header('Content-Type: application/json');
	include_once('../api/class_GetProjectsWithEvaluations.php');
	
	if (isset($_POST["token"])) {
		$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if (isset($_POST["viewStartDate"])) {
		$viewStartDate = filter_input(INPUT_POST, 'viewStartDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if (isset($_POST["viewEndDate"])) {
		$viewEndDate = filter_input(INPUT_POST, 'viewEndDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

		$object = new GetProjectsWithEvaluations();
		$object->setToken($token);
		$object->setViewStartDate($viewStartDate);
		$object->setViewEndDate($viewEndDate);
		$object->authenticate();
		$response = $object->getResults();

		echo json_encode($response);
?>