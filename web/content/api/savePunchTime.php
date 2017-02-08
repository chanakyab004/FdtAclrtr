<?php
	header('Content-Type: application/json');
	include_once('../api/class_SavePunchTime.php');
	
	if (isset($_POST["token"])) {
		$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if (isset($_POST["projectID"])) {
		$projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
	}

	if (isset($_POST["installerUserID"])) {
		$installerUserID = filter_input(INPUT_POST, 'installerUserID', FILTER_SANITIZE_NUMBER_INT);
	}

	if (isset($_POST["timecardDate"])) {
		$timecardDate = filter_input(INPUT_POST, 'timecardDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if (isset($_POST["crewmen"])) {
		$crewmen = $_POST["crewmen"];
	}

	//echo json_encode($_POST);

		$object = new SavePunchTime();
		$object->setToken($token);
		$object->setProjectID($projectID);
		$object->setInstallerUserID($installerUserID);
		$object->setTimecardDate($timecardDate);
		$object->setCrewmen($crewmen);
		$object->authenticate();
		$response = $object->getResults();

		echo json_encode($response);
?>