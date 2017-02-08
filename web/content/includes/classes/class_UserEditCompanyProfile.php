<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class UserEdit {
		
		private $db;
		private $userID;
		private $companyID;
		private $firstName;
		private $lastName;
		private $email;
		private $password;
		private $primaryAnswer;
		private $projectManagementAnswer;
		private $salesAnswer;
		private $marketingAnswer;
		private $installationAnswer;
		private $bidVerificationAnswer;
		private $bidCreationAnswer;
		private $pierDataRecorderAnswer;
		private $timecardApproverAnswer;
		private $calendarBgColor;
		private $userBio;
		private $activeAnswer;
		private $fileName;
		private $fileContent;
		private $fileType;
		private $fileSize;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			
		public function setUser($userID, $companyID, $firstName, $lastName, $email, $password, $primaryAnswer, $projectManagementAnswer, $marketingAnswer, $salesAnswer, $installationAnswer, $bidVerificationAnswer, $bidCreationAnswer, $pierDataRecorderAnswer, $timecardApproverAnswer, $calendarBgColor, $userBio, $activeAnswer, $fileName, $fileContent, $fileType, $fileSize) {
			
			$this->userID = $userID;
			$this->companyID = $companyID;
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->email = $email;

			if (!empty($password)) {
				$this->password = password_hash($password, PASSWORD_BCRYPT, array(
					'cost' => 12
				));
			}
			
			$this->primaryAnswer = $primaryAnswer;
			$this->projectManagementAnswer = $projectManagementAnswer;
			$this->marketingAnswer = $marketingAnswer;
			$this->salesAnswer = $salesAnswer;
			$this->installationAnswer = $installationAnswer;
			$this->bidVerificationAnswer = $bidVerificationAnswer;
			$this->bidCreationAnswer = $bidCreationAnswer;
			$this->pierDataRecorderAnswer = $pierDataRecorderAnswer;
			$this->timecardApproverAnswer = $timecardApproverAnswer;
			$this->calendarBgColor = $calendarBgColor;

			$this->userBio = $userBio;
			$this->activeAnswer = $activeAnswer;
			
			$this->fileName = $fileName;
			$this->fileContent = $fileContent;
			$this->fileType = $fileType;
			$this->fileSize = $fileSize;

		}
		

		public function UploadPhoto() {

			$path_parts = 		pathinfo($this->fileName);
			$name = 			$path_parts['filename'].'.'.$path_parts['extension']; 
			$temp = 			$this->fileContent;  
			$type = 			$this->fileType;  
			$size = 			$this->fileSize; 
			$path = 			'assets/company/'.$this->companyID.'/users/'.$this->userID.'/'.$name.''; 
			
			$image = 			imagecreatefromstring(file_get_contents($this->fileContent));
			
			if($type == 'image/jpeg'){
				$exif = exif_read_data($this->fileContent);
			} 
			
			$dimentions = 		getimagesize($temp); 
			$origWidth = 		$dimentions[0];
			$origHeight = 		$dimentions[1];
		
		
			if( is_dir('assets/company/'.$this->companyID.'/users/'.$this->userID.'') === false )
			{
			mkdir('assets/company/'.$this->companyID.'/users/'.$this->userID.'', 0777, true);
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
							$newwidth = 150;
							$newheight = 150;
							break;
							
						//landscape
						case 2:
							$newheight = 150;
							$ratio = $newheight/$height;
							$newwidth = round($width * $ratio);
							break;
						
						//portrait
						case 3:
							$newwidth = 150;
							$ratio = $newwidth/$width;
							$newheight = round($height * $ratio);
							break;
					}
						
					$newimage = imagecreatetruecolor($newwidth, $newheight);
					imagecopyresampled($newimage, $upload, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					imagejpeg($newimage, $path, 100);
					
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
							$newwidth = 150;
							$newheight = 150;
							break;
							
						//landscape
						case 2:
							$newheight = 150;
							$ratio = $newheight/$height;
							$newwidth = round($width * $ratio);
							break;
						
						//portrait
						case 3:
							$newwidth = 150;
							$ratio = $newwidth/$width;
							$newheight = round($height * $ratio);
							break;
						}
						
						$newimage = imagecreatetruecolor($newwidth, $newheight);
						imagecopyresampled($newimage, $upload, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
						imagepng($newimage, $path, 9);
					
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
							$newwidth = 150;
							$newheight = 150;
							break;
							
						//landscape
						case 2:
							$newheight = 150;
							$ratio = $newheight/$height;
							$newwidth = round($width * $ratio);
							break;
						
						//portrait
						case 3:
							$newwidth = 150;
							$ratio = $newwidth/$width;
							$newheight = round($height * $ratio);
							break;
					}
						
					$newimage = imagecreatetruecolor($newwidth, $newheight);
					imagecopyresampled($newimage, $upload, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					imagegif($newimage, $path);
					
					break;
			}

			$photoSt = $this->db->prepare("UPDATE `user`
				SET	
				`userPhoto` = :userPhoto
				WHERE companyID = :companyID AND userID = :userID");
		
			$photoSt->bindParam(':companyID', $this->companyID);
			$photoSt->bindParam(':userID', $this->userID);
			$photoSt->bindParam(':userPhoto', $this->fileName);
			
			$photoSt->execute();
		}	
			
			
		public function UpdateUser() {
			
			if (!empty($this->userID) && !empty($this->firstName) && !empty($this->lastName) && !empty($this->email)) {
				
				$st = $this->db->prepare("select * from user where userEmail = :email AND userID = :userID");
				//write parameter query to avoid sql injections
				$st->bindParam(':email', $this->email);
				$st->bindParam(':userID', $this->userID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					
					if (empty($this->password)) {
						
						$st = $this->db->prepare("UPDATE `user`
						SET	
						
						`userFirstName` = :firstName,
						`userLastName` = :lastName,
						`primary` = :primaryAnswer,
						`projectManagement` = :projectManagementAnswer,
						`marketing` = :marketingAnswer,
						`sales` = :salesAnswer,
						`installation` = :installationAnswer,
						`bidVerification` = :bidVerificationAnswer,
						`bidCreation` = :bidCreationAnswer,
						`pierDataRecorder` = :pierDataRecorderAnswer,
						`timecardApprover` = :timecardApproverAnswer,
						`userActive` = :activeAnswer,
						`calendarBgColor` = :calendarBgColor,
						`userBio` = :userBio
						
						
						WHERE userID = :userID AND companyID = :companyID AND userEmail = :email");
				
						
						$st->bindParam(':firstName', $this->firstName);
						$st->bindParam(':lastName', $this->lastName);
						$st->bindParam(':primaryAnswer', $this->primaryAnswer);
						$st->bindParam(':projectManagementAnswer', $this->projectManagementAnswer);
						$st->bindParam(':marketingAnswer', $this->marketingAnswer);
						$st->bindParam(':salesAnswer', $this->salesAnswer);
						$st->bindParam(':installationAnswer', $this->installationAnswer);
						$st->bindParam(':bidVerificationAnswer', $this->bidVerificationAnswer);
						$st->bindParam(':bidCreationAnswer', $this->bidCreationAnswer);
						$st->bindParam(':pierDataRecorderAnswer', $this->pierDataRecorderAnswer);
						$st->bindParam(':timecardApproverAnswer', $this->timecardApproverAnswer);
						$st->bindParam(':activeAnswer', $this->activeAnswer);
						$st->bindParam(':userID', $this->userID);
						$st->bindParam(':companyID', $this->companyID);
						$st->bindParam(':email', $this->email);
						$st->bindParam(':calendarBgColor', $this->calendarBgColor);
						$st->bindParam(':userBio', $this->userBio);
						
						$st->execute();

						if (!empty($this->fileName) && !empty($this->fileContent)) {

							$this->UploadPhoto();
							
						}
						
					} else {

						$st = $this->db->prepare("UPDATE `user`
						SET	
						
						`userFirstName` = :firstName,
						`userLastName` = :lastName,
						`userPassword` = :password,
						`primary` = :primaryAnswer,
						`projectManagement` = :projectManagementAnswer,
						`marketing` = :marketingAnswer,
						`sales` = :salesAnswer,
						`installation` = :installationAnswer,
						`bidVerification` = :bidVerificationAnswer,
						`bidCreation` = :bidCreationAnswer,
						`pierDataRecorder` = :pierDataRecorderAnswer,
						`timecardApprover` = :timecardApproverAnswer,
						`userActive` = :activeAnswer,
						`calendarBgColor` = :calendarBgColor,
						`userBio` = :userBio
						
						WHERE userID = :userID AND companyID = :companyID AND userEmail = :email");
				
						
						$st->bindParam(':firstName', $this->firstName);
						$st->bindParam(':lastName', $this->lastName);
						$st->bindParam(':password', $this->password);
						$st->bindParam(':primaryAnswer', $this->primaryAnswer);
						$st->bindParam(':projectManagementAnswer', $this->projectManagementAnswer);
						$st->bindParam(':marketingAnswer', $this->marketingAnswer);
						$st->bindParam(':salesAnswer', $this->salesAnswer);
						$st->bindParam(':installationAnswer', $this->installationAnswer);
						$st->bindParam(':bidVerificationAnswer', $this->bidVerificationAnswer);
						$st->bindParam(':bidCreationAnswer', $this->bidCreationAnswer);
						$st->bindParam(':pierDataRecorderAnswer', $this->pierDataRecorderAnswer);
						$st->bindParam(':timecardApproverAnswer', $this->timecardApproverAnswer);
						$st->bindParam(':activeAnswer', $this->activeAnswer);
						$st->bindParam(':userID', $this->userID);
						$st->bindParam(':companyID', $this->companyID);
						$st->bindParam(':email', $this->email);
						$st->bindParam(':calendarBgColor', $this->calendarBgColor);
						$st->bindParam(':userBio', $this->userBio);
						
						$st->execute();

						if (!empty($this->fileName) && !empty($this->fileContent)) {

							$this->UploadPhoto();
							
						}
						
					}
					
					$secondST = $this->db->prepare("select * from user where userID=:userID AND companyID=:companyID AND userEmail=:email LIMIT 1");
					//write parameter query to avoid sql injections
					$secondST->bindParam(':userID', $this->userID);	
					$secondST->bindParam(':companyID', $this->companyID);	
					$secondST->bindParam(':email', $this->email);					
					$secondST->execute();
					
					if ($secondST->rowCount()>=1) {
						while ($row = $secondST->fetch((PDO::FETCH_ASSOC))) {
							$returnUsers[] = $row;
						}
						
						$this->results = $returnUsers; 
						
					} else {
						$this->results = "user could not be updated";
					}
					
				} 
				
				else {	
					$st = $this->db->prepare("select * from user where userEmail = :email");
					//write parameter query to avoid sql injections
					$st->bindParam(':email', $this->email);
					
					$st->execute();
					
					if ($st->rowCount()==1) {
						$this->results = "email already exists";
					} else {
						
						if (empty($this->password)) {
						
							$st = $this->db->prepare("UPDATE `user`
							
							SET	
							
							`userFirstName` = :firstName,
							`userLastName` = :lastName,
							`userEmail` = :email,
							`primary` = :primaryAnswer,
							`projectManagement` = :projectManagementAnswer,
							`marketing` = :marketingAnswer,
							`sales` = :salesAnswer,
							`installation` = :installationAnswer,
							`bidVerification` = :bidVerificationAnswer,
							`bidCreation` = :bidCreationAnswer,
							`pierDataRecorder` = :pierDataRecorderAnswer,
							`timecardApprover` = :timecardApproverAnswer,
							`userActive` = :activeAnswer,
							`calendarBgColor` = :calendarBgColor,
							`userBio` = :userBio
							
							WHERE userID = :userID AND companyID = :companyID");
					
							
							$st->bindParam(':firstName', $this->firstName);
							$st->bindParam(':lastName', $this->lastName);
							$st->bindParam(':email', $this->email);
							$st->bindParam(':primaryAnswer', $this->primaryAnswer);
							$st->bindParam(':projectManagementAnswer', $this->projectManagementAnswer);
							$st->bindParam(':marketingAnswer', $this->marketingAnswer);
							$st->bindParam(':salesAnswer', $this->salesAnswer);
							$st->bindParam(':installationAnswer', $this->installationAnswer);
							$st->bindParam(':bidVerificationAnswer', $this->bidVerificationAnswer);
							$st->bindParam(':bidCreationAnswer', $this->bidCreationAnswer);
							$st->bindParam(':pierDataRecorderAnswer', $this->pierDataRecorderAnswer);
							$st->bindParam(':timecardApproverAnswer', $this->timecardApproverAnswer);
							$st->bindParam(':activeAnswer', $this->activeAnswer);
							$st->bindParam(':userID', $this->userID);
							$st->bindParam(':companyID', $this->companyID);
							$st->bindParam(':calendarBgColor', $this->calendarBgColor);
							$st->bindParam(':userBio', $this->userBio);
							
							
							$st->execute();

							if (!empty($this->fileName) && !empty($this->fileContent)) {

								$this->UploadPhoto();
							
							}
						
						} else {
							
							$st = $this->db->prepare("UPDATE `user`
							
							SET	
							
							`userFirstName` = :firstName,
							`userLastName` = :lastName,
							`userEmail` = :email,
							`userPassword` = :password,
							`primary` = :primaryAnswer,
							`projectManagement` = :projectManagementAnswer,
							`marketing` = :marketingAnswer,
							`sales` = :salesAnswer,
							`installation` = :installationAnswer,
							`bidVerification` = :bidVerificationAnswer,
							`bidCreation` = :bidCreationAnswer,
							`pierDataRecorder` = :pierDataRecorderAnswer,
							`timecardApprover` = :timecardApproverAnswer,
							`userActive` = :activeAnswer,
							`calendarBgColor` = :calendarBgColor,
							`userBio` = :userBio
							
							WHERE userID = :userID AND companyID = :companyID");
					
							
							$st->bindParam(':firstName', $this->firstName);
							$st->bindParam(':lastName', $this->lastName);
							$st->bindParam(':email', $this->email);
							$st->bindParam(':password', $this->password);
							$st->bindParam(':primaryAnswer', $this->primaryAnswer);
							$st->bindParam(':projectManagementAnswer', $this->projectManagementAnswer);
							$st->bindParam(':marketing', $this->marketingAnswer);
							$st->bindParam(':salesAnswer', $this->salesAnswer);
							$st->bindParam(':installationAnswer', $this->installationAnswer);
							$st->bindParam(':bidVerificationAnswer', $this->bidVerificationAnswer);
							$st->bindParam(':bidCreationAnswer', $this->bidCreationAnswer);
							$st->bindParam(':pierDataRecorderAnswer', $this->pierDataRecorderAnswer);
							$st->bindParam(':timecardApproverAnswer', $this->timecardApproverAnswer);
							$st->bindParam(':activeAnswer', $this->activeAnswer);
							$st->bindParam(':userID', $this->userID);
							$st->bindParam(':companyID', $this->companyID);
							$st->bindParam(':calendarBgColor', $this->calendarBgColor);
							$st->bindParam(':userBio', $this->userBio);
							
							
							$st->execute();

							if (!empty($this->fileName) && !empty($this->fileContent)) {

								$this->UploadPhoto();
							
							}

						}
						
						
						$secondST = $this->db->prepare("select * from user where userID=:userID AND companyID=:companyID LIMIT 1");
						//write parameter query to avoid sql injections
						$secondST->bindParam(':userID', $this->userID);	
						$secondST->bindParam(':companyID', $this->companyID);					
						$secondST->execute();
						
						if ($secondST->rowCount()>=1) {
							while ($row = $secondST->fetch((PDO::FETCH_ASSOC))) {
								$returnUsers[] = $row;
							}
							
							$this->results = $returnUsers; 
							
						} else {
							$this->results = "user could not be updated";
						}
							
					}
				
					
				}
			}
		
		}
		
		
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>