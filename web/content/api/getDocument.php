<?php
header('Content-Type: application/json');
/*
cid = company id
uid = user id
pid = project id
eid = evaluation id

Location by type:

projectdoc Project Documents - assets/company/{cid}/projects/{pid}/documents/{name}
evalimage Evaluation Images - assets/company/{cid}/projects/{pid}/evaluations/{eid}/images/{name}
evaldrawing Evaluation Drawings - assets/company/{cid}/projects/{pid}/evaluations/{eid}/drawings/{name}
evaldoc Evaluation Documents -	assets/company/{cid}/projects/{pid}/evaluations/{eid}/documents/{name}

document location using getDocument.php:
Project Documents - getDocument.php?cid={cid}&type=projectdoc&pid={pid}&name={name}
Evaluation Photos - getDocument.php?cid={cid}&type=evalphoto&pid={pid}&eid={eid}&name={name}
Evaluation Drawings - getDocument.php?cid={cid}&type=evaldrawing&pid={pid}&eid={eid}&name={name}
Evaluation Documents -	getDocument.php?cid={cid}&type=evaldoc&pid={pid}&eid={eid}&name={name}
*/


	function showFile($filePath){
		// open the file in a binary mode
		$filePath = '../' . $filePath;
		if (file_exists($filePath)) {
			$file = fopen($filePath, 'rb');

			// send the right headers
			header("Content-Type: " . mime_content_type($filePath));
			header("Content-Length: " . filesize($filePath)); 

			// dump the picture and stop the script
			fpassthru($file); 
			exit;
		}
		else{
			echo 'no file';
		}
	}

	if(isset($_GET['token'])) {
		$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	include_once('../api/class_Authenticate.php');
	$object = new Authenticate();
	$object->setToken($token);
	$object->Authenticate();
	$response = $object->getResults();
	
	if (empty($response) || $response['message'] != 'success'){
		echo $response['message'];
	}
	else{
		if(isset($_GET['name'])) {
			$name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$name = htmlspecialchars_decode($name);
		}

		if(isset($_GET['eid'])) {
			$evaluationID = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_NUMBER_INT);
		}

		if(isset($_GET['cid'])) {
			$companyID = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_NUMBER_INT);
		}

		if(isset($_GET['pid'])) {
			$projectID = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_NUMBER_INT);
		}

		if(isset($_GET['type'])) {
			$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		//get path to file by type
		$path = NULL;
		$basepath = 'assets/company/'.$companyID.'/';

		if ($type == 'projectdoc'){
			$path = $basepath . 'projects/'.$projectID.'/documents/'.$name;
			showFile($path);
		}
		else if ($type == 'evalphoto'){
			$path = $basepath . 'projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$name;
			showFile($path);
		}
		else if ($type == 'evaldrawing'){
			$path = $basepath .'projects/'.$projectID.'/evaluations/'.$evaluationID.'/drawings/'.$name;
			showFile($path);
		}
		else if ($type == 'evaldoc'){
			$path = $basepath . 'projects/'.$projectID.'/evaluations/'.$evaluationID.'/documents/'.$name;
			showFile($path);
		}
		else{
			echo 'File not found ';
		}
	}
?>