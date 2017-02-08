<?php
	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');


	include_once('includes/dbopen.php');
		$db = new Connection();
		$db = $db->dbConnect();
		
	
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 

	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];

	if ($primary == 1 || $sales == 1) {
		
		$photoName = filter_input(INPUT_POST, 'photoName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
		$projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
		$section = filter_input(INPUT_POST, 'section', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		$dir = $evaluationID;
		
		
			$st = $db->prepare("SELECT p.evaluationID, p.photoOrder, p.photoSection, p.photoFilename, p.photoDate, e.projectID

				FROM evaluationPhoto AS p

				LEFT JOIN evaluation AS e ON e.evaluationID = p.evaluationID

				WHERE p.evaluationID = :evaluationID AND p.photoFilename = :photoName AND p.photoSection = :section ORDER BY photoDate ASC
				");
			$st->bindParam('evaluationID', $evaluationID);
			$st->bindParam('photoName', $photoName);
			$st->bindParam('section', $section);
			
			$st->execute();	

			if ($st->rowCount()>=1) {
				while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$projectID = $row['projectID'];
				}
				
			} 


			$deleteSt = $db->prepare("DELETE FROM evaluationPhoto WHERE evaluationID='$evaluationID' AND photoFilename='$photoName'");
			$deleteSt->execute();

			if (file_exists('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photoName)){
				unlink('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photoName);	
			}
			if (file_exists('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/thumb_'.$photoName)){
				unlink('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/thumb_'.$photoName);	
			}			
			$success='Success';
		
			echo json_encode($success);
		
	}
	
?>  