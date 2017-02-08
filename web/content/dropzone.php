<?php
include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	include_once('includes/dbopen.php');
		$db = new Connection();
		$db = $db->dbConnect();
		
		

	$ds = DIRECTORY_SEPARATOR;  //1


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


if (!empty($_FILES)) {
	
	if ($primary == 1 || $sales == 1) {
		
	
		$section = filter_input(INPUT_POST, 'section', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
		$projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);

		
		$path_parts = 		pathinfo($_FILES["file"]["name"]);
		$name = 			$path_parts['filename'].'_'.time().'.'.$path_parts['extension']; 
		$temp = 			$_FILES['file']['tmp_name'];  
		$type = 			$_FILES['file']['type'];  
		$size = 			$_FILES['file']['size'];  
		$path = 			'assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$name.''; 
		$pathThumb = 		'assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/thumb_'.$name.''; 
		
		$image = 			imagecreatefromstring(file_get_contents($_FILES['file']['tmp_name']));

		if($type == 'image/jpeg'){
			$exif = exif_read_data($_FILES['file']['tmp_name']);
		} 
		
		$dimentions = 		getimagesize($temp); 
		$origWidth = 		$dimentions[0];
		$origHeight = 		$dimentions[1];
	
	
		if( is_dir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images') === false )
		{
		mkdir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images', 0777, true);
		}
		
		
		switch ($type) {
				
			case 'image/jpeg':
				
			// Rotate
			if(!empty($exif['Orientation'])) {
				switch($exif['Orientation']) {
					
					case 8:
						$rotate = imagerotate($image,90,0);
						break;
					case 3:
						$rotate = imagerotate($image,180,0);
						break;
					case 6:
						$rotate = imagerotate($image,-90,0);
						break;
					case 1:
						$rotate = imagerotate($image,0,0);
						break;
					}

					$rotateWidth = imagesx($rotate);
					$rotateHeight = imagesy($rotate);
				}
				
					
				if (!empty($rotateWidth)) { $width = $rotateWidth; } 
				else { $width = $origWidth; }
					
				if (!empty($rotateHeight)) { $height = $rotateHeight; } 
				else { $height = $origHeight; }
				
				if (!empty($rotate)) { $upload = $rotate; } 
				else { $upload = imagecreatefromjpeg($temp); }
			
					 
				//echo $width . '<br/>';
				//echo $height;
					
				if ($width == $height) { $case=1; }
				if ($width > $height) { $case=2; }
				if ($width < $height) { $case=3; }
		
				switch ($case) {
					//square
					case 1:
						$newwidth = 400;
						$newheight = 400;
						
						$thumbwidth = 120;
						$thumbheight = 120;
						break;
						
					//landscape
					case 2:
						$newheight = 768;
						$ratio = $newheight/$height;
						$newwidth = round($width * $ratio);
						
						$thumbheight = 120;
						$thumbratio = $thumbheight/$height;
						$thumbwidth = round($width * $thumbratio);
						break;
					
					//portrait
					case 3:
						$newwidth = 768;
						$ratio = $newwidth/$width;
						$newheight = round($height * $ratio);
						
						$thumbwidth = 120;
						$thumbratio = $thumbwidth/$width;
						$thumbheight = round($height * $thumbratio);
						break;
					}
					
					$newimage = imagecreatetruecolor($newwidth, $newheight);
					imagecopyresampled($newimage, $upload, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					imagejpeg($newimage, $path, 100);
					
					$thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
					imagecopyresampled($thumb, $upload, 0, 0, 0, 0, $thumbwidth, $thumbheight, $width, $height);
					imagejpeg($thumb, $pathThumb, 100);
				
				break;
				
				case 'image/png':
				
				$width = $origWidth;
				$height = $origHeight;
				$upload = imagecreatefrompng($temp); 
			
				if ($width == $height) { $case=1; }
				if ($width > $height) { $case=2; }
				if ($width < $height) { $case=3; }
		
				switch ($case) {
					//square
					case 1:
						$newwidth = 400;
						$newheight = 400;
						
						$thumbwidth = 120;
						$thumbheight = 120;
						break;
						
					//landscape
					case 2:
						$newheight = 768;
						$ratio = $newheight/$height;
						$newwidth = round($width * $ratio);
						
						$thumbheight = 120;
						$thumbratio = $thumbheight/$height;
						$thumbwidth = round($width * $thumbratio);
						break;
					
					//portrait
					case 3:
						$newwidth = 768;
						$ratio = $newwidth/$width;
						$newheight = round($height * $ratio);
						
						$thumbwidth = 120;
						$thumbratio = $thumbwidth/$width;
						$thumbheight = round($height * $thumbratio);
						break;
					}
					
					$newimage = imagecreatetruecolor($newwidth, $newheight);
					imagecopyresampled($newimage, $upload, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					imagepng($newimage, $path, 9);
					
					$thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
					imagecopyresampled($thumb, $upload, 0, 0, 0, 0, $thumbwidth, $thumbheight, $width, $height);
					imagepng($thumb, $pathThumb, 9);
				
				break;
				
				case 'image/gif':
				
				
				$width = $origWidth;
				$height = $origHeight;
				$upload = imagecreatefromgif($temp);
			
				if ($width == $height) { $case=1; }
				if ($width > $height) { $case=2; }
				if ($width < $height) { $case=3; }
		
				switch ($case) {
					//square
					case 1:
						$newwidth = 400;
						$newheight = 400;
						
						$thumbwidth = 120;
						$thumbheight = 120;
						break;
						
					//landscape
					case 2:
						$newheight = 768;
						$ratio = $newheight/$height;
						$newwidth = round($width * $ratio);
						
						$thumbheight = 120;
						$thumbratio = $thumbheight/$height;
						$thumbwidth = round($width * $thumbratio);
						break;
					
					//portrait
					case 3:
						$newwidth = 768;
						$ratio = $newwidth/$width;
						$newheight = round($height * $ratio);
						
						$thumbwidth = 120;
						$thumbratio = $thumbwidth/$width;
						$thumbheight = round($height * $thumbratio);
						break;
					}
					
					$newimage = imagecreatetruecolor($newwidth, $newheight);
					imagecopyresampled($newimage, $upload, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					imagegif($newimage, $path);
					
					$thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
					imagecopyresampled($thumb, $upload, 0, 0, 0, 0, $thumbwidth, $thumbheight, $width, $height);
					imagegif($thumb, $pathThumb);
				
				break;
				
				}
		
	  $st = $db->prepare("INSERT INTO evaluationPhoto SET evaluationID='$evaluationID', photoSection='$section', photoFilename='$name', photoDate=UTC_TIMESTAMP");
		  $st->execute();
			
	  echo $name;
	  exit();     
	}
}
?>
<?php include "templates/dropzone.html";  ?> 