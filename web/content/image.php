<?php
/*
cid = company id
uid = user id
pid = project id
eid = evaluation id

Location by type:

companylogo Company Logo - assets/company/{cid}/{name}
userimage User Image - assets/company/{cid}/users/{uid}/{name}
warranty Warranties - assets/company/{cid}/warranties/{name}
projectdoc Project Documents - assets/company/{cid}/projects/{pid}/documents/{name}
evalimage Evaluation Images - assets/company/{cid}/projects/{pid}/evaluations/{eid}/images/{name}
evaldrawing Evaluation Drawings - assets/company/{cid}/projects/{pid}/evaluations/{eid}/drawings/{name}
evaldoc Evaluation Documents -	assets/company/{cid}/projects/{pid}/evaluations/{eid}/documents/{name}

image location using image.php: (always pass in cid)
Company Logo - image.php?cid={cid}&type=companylogo&name={name}
User Image - image.php?cid={cid}&type=userimage&uid={uid}&name={name}
Warranties - image.php?cid={cid}&type=warranty&name={name}
Project Documents - image.php?cid={cid}&type=projectdoc&pid={pid}&name={name}
Evaluation Images - image.php?cid={cid}&type=evalimage&pid={pid}&eid={eid}&name={name}
Evaluation Drawings - image.php?cid={cid}&type=evaldrawing&pid={pid}&eid={eid}&name={name}
Evaluation Documents -	image.php?cid={cid}&type=evaldoc&pid={pid}&eid={eid}&name={name}
*/
	  

	if(isset($_GET['name'])) {
		$name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	else{
		header('location:index.php');
		exit();
	}

	if(isset($_GET['eid'])) {
		$evaluationID = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_NUMBER_INT);
	}
	else{
		// header('location:index.php');
		// exit();
	}

	//displaying another user's image will require different user id than logged in user
	if(isset($_GET['uid'])) {
		$imageUserID = filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT);
	}
	else{
		// header('location:index.php');
		// exit();
	}  

	if(isset($_GET['cid'])) {
		$companyID = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_NUMBER_INT);
	}
	else{
		// header('location:index.php');
		// exit();
	}

	if(isset($_GET['pid'])) {
		$projectID = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_NUMBER_INT);
	}
	else{
		// header('location:index.php');
		// exit();
	}

	if(isset($_GET['type'])) {
		$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	else{
		header('location:index.php');
		exit();
	}      

	function showFile($filePath){
		// open the file in a binary mode
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
			//echo 'Cannot open file ';
		}	
	}

		//get path to file by type
		$path = NULL;
		$basepath = 'assets/company/'.$companyID.'/';

		if ($type == 'companylogo'){
			$path = $basepath . $name;
			showFile($path);
		}
		else if ($type == 'userimage'){
			$path = $basepath . 'users/'.$imageUserID.'/'.$name;
			showFile($path);
		}
		else if ($type == 'warranty'){
			$path = $basepath .'warranties/'.$name;
			showFile($path);
		}
		else if ($type == 'projectdoc'){
			$path = $basepath . 'projects/'.$projectID.'/documents/'.$name;
			showFile($path);
		}
		else if ($type == 'evalimage'){
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

?>