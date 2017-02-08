<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class UserAdd {
		
		private $db;
		private $companyID;
		private $firstName;
		private $lastName;
		private $email;
		private $password;
		private $primaryAnswer;
		private $projectManagementAnswer;
		private $marketingAnswer;
		private $salesAnswer;
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
			
	    private function random_string($length = 32, $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
	    {
	        if ($length < 1) {
	            throw new InvalidArgumentException('Length must be a positive integer');
	        }
	        $str = '';
	        $alphamax = strlen($alphabet) - 1;
	        if ($alphamax < 1) {
	            throw new InvalidArgumentException('Invalid alphabet');
	        }
	        for ($i = 0; $i < $length; ++$i) {
	            $str .= $alphabet[mt_rand(0, $alphamax)];
	        }
	        return $str;
	    }

		public function setUser($companyID, $firstName, $lastName, $email, $password, $primaryAnswer, $projectManagementAnswer, $marketingAnswer, $salesAnswer, $installationAnswer, $bidVerificationAnswer, $bidCreationAnswer, $pierDataRecorderAnswer, $timecardApproverAnswer, $calendarBgColor, $userBio, $activeAnswer, $fileName, $fileContent, $fileType, $fileSize) {
			
			$this->companyID = $companyID;
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->email = $email;

			$this->password = password_hash($password, PASSWORD_BCRYPT, array(
				'cost' => 12
			));
			
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
			
		
		public function UploadPhoto($userID) {

			$ds = 				DIRECTORY_SEPARATOR;
			$path_parts = 		pathinfo($this->fileName);
			$name = 			$path_parts['filename'].'.'.$path_parts['extension']; 
			$temp = 			$this->fileContent;  
			$type = 			$this->fileType;  
			$size = 			$this->fileSize; 
			$path = 			'assets/company/'.$this->companyID.'/users/'.$userID.'/'.$name.''; 
			
			$image = 			imagecreatefromstring(file_get_contents($this->fileContent));
			
			if($type == 'image/jpeg'){
				$exif = exif_read_data($this->fileContent);
			} 
			
			$dimentions = 		getimagesize($temp); 
			$origWidth = 		$dimentions[0];
			$origHeight = 		$dimentions[1];
		
		
			if( is_dir('assets/company/'.$this->companyID.'/users/'.$userID.'') === false )
			{
			mkdir('assets/company/'.$this->companyID.'/users/'.$userID.'', 0777, true);
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
							break;
							
						//landscape
						case 2:
							$newheight = 768;
							$ratio = $newheight/$height;
							$newwidth = round($width * $ratio);
							break;
						
						//portrait
						case 3:
							$newwidth = 768;
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
							$newwidth = 400;
							$newheight = 400;
							break;
							
						//landscape
						case 2:
							$newheight = 768;
							$ratio = $newheight/$height;
							$newwidth = round($width * $ratio);
							break;
						
						//portrait
						case 3:
							$newwidth = 768;
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
							$newwidth = 400;
							$newheight = 400;
							break;
							
						//landscape
						case 2:
							$newheight = 768;
							$ratio = $newheight/$height;
							$newwidth = round($width * $ratio);
							break;
						
						//portrait
						case 3:
							$newwidth = 768;
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
			$photoSt->bindParam(':userID', $userID);
			$photoSt->bindParam(':userPhoto', $this->fileName);
			
			$photoSt->execute();
		}	

			
		public function addUser() {
			
			if (!empty($this->firstName) && !empty($this->lastName) && !empty($this->email)) {
				$token = $this->random_string();
				
				$st = $this->db->prepare("select * from user where userEmail = :email");
				//write parameter query to avoid sql injections
				$st->bindParam(':email', $this->email);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					$this->results = "email already exists";
				} 
				
				else {
				
				$st = $this->db->prepare("INSERT INTO `user`
					(
					`companyID`,			
					`userFirstName`,
					`userLastName`,
					`userEmail`,
					`userPassword`,
					`primary`,
					`projectManagement`,
					`marketing`,
					`sales`,
					`installation`,
					`bidVerification`,
					`bidCreation`,
					`pierDataRecorder`,
					`timecardApprover`,
					`userAdded`,
					`userActive`,
					`calendarBgColor`,
					`userBio`,
					`token`
				
					) 
					VALUES
					(
					:companyID,			
					:firstName,
					:lastName,
					:email,
					:password,
					:primaryAnswer,
					:projectManagementAnswer,
					:marketingAnswer,
					:salesAnswer,
					:installationAnswer,
					:bidVerificationAnswer,
					:bidCreationAnswer,
					:pierDataRecorderAnswer,
					:timecardApproverAnswer,
					UTC_TIMESTAMP,
					:activeAnswer,
					:calendarBgColor,
					:userBio,
					:token
				)"
				
			);
				
					$st->bindParam(':companyID', $this->companyID);
					$st->bindParam(':firstName', $this->firstName);
					$st->bindParam(':lastName', $this->lastName);
					$st->bindParam(':email', $this->email);
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
					$st->bindParam(':calendarBgColor', $this->calendarBgColor);
					$st->bindParam(':userBio', $this->userBio);
					$st->bindParam(':token', $token);
					
					$st->execute();
					
					$userID = $this->db->lastInsertId();


					if (!empty($this->fileName) && !empty($this->fileContent)) {

						$this->UploadPhoto($userID);
							
					}
					
					
					$secondST = $this->db->prepare("select * from user where userID=? AND companyID=? LIMIT 1");
					//write parameter query to avoid sql injections
					$secondST->bindParam(1, $userID);	
					$secondST->bindParam(2, $this->companyID);				
					$secondST->execute();
					
					if ($secondST->rowCount()>=1) {
						while ($row = $secondST->fetch((PDO::FETCH_ASSOC))) {
							$returnUsers[] = $row;
							
						}
						
						$this->results = $returnUsers; 
					} 
					
					
					//$this->results = "User has been successfully added!";
				
				}
					
			} else {
				$this->results = "need username";
				}
		
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>