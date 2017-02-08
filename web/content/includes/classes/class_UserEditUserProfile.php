<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class UserEdit {
		
		private $db;
		private $userID;
		private $companyID;
		private $userFirstName;
		private $userLastName;
		private $userEmail;
		private $userBio;
		private $userPassword;
		private $userOldPassword;
		private $fileName;
		private $fileContent;
		private $fileType;
		private $fileSize;
		private $resultString;
		
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
			

		public function setUser($userID, $companyID, $userFirstName, $userLastName, $userEmail, $userBio, $userPassword, $userOldPassword, $fileName, $fileContent, $fileType, $fileSize) {
			
			$this->userID = $userID;
			$this->companyID = $companyID;
			$this->userFirstName = $userFirstName;
			$this->userLastName = $userLastName;
			$this->userEmail = $userEmail;
			$this->userBio = $userBio;


			if (!empty($userPassword)) {
				$this->userPassword = password_hash($userPassword, PASSWORD_BCRYPT, array(
					'cost' => 12
				));
			}

			if (!empty($userOldPassword)){
				$resultString = $this->userOldPassword;
				$this->userOldPassword = $userOldPassword;

				// $this->userOldPassword = password_hash($userOldPassword, PASSWORD_BCRYPT, array('cost' => 12));
			}

			$this->fileName = $fileName;
			$this->fileContent = $fileContent;
			$this->fileType = $fileType;
			$this->fileSize = $fileSize;
		
		}


		public function UploadPhoto() {

			// if( is_dir('companies/'.$this->companyID.'') === false )
			// {
			// 	mkdir('companies/'.$this->companyID.'');
			// }
		
			// $filePath = 'companies/'.$this->companyID.'/'.$this->fileName.'';

			// 	move_uploaded_file($this->fileContent, $filePath);

			
			// $photoSt = $this->db->prepare("UPDATE `user`
			// SET	
			// `userPhoto` = :userPhoto
			// WHERE companyID = :companyID AND userID = :userID");
		
			// $photoSt->bindParam(':companyID', $this->companyID);
			// $photoSt->bindParam(':userID', $this->userID);
			// $photoSt->bindParam(':userPhoto', $this->fileName);
			
			// $photoSt->execute();





			$ds = 				DIRECTORY_SEPARATOR;
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
		

		//Function to decide whether to update the existing password.

		public function confirmPasswordUpdate(){



			//1.  Get the existing password from DB
			//2.  Encrypt the 'oldPassword variable sent'
			//3.  Encrypt the  'newPassword' variable sent
			//4.  If the oldPassword is correct, set the existing password = the new password after encrypting it
			//5.  Otherwise, do not change the existing password, and send back a message.

		}
			
		public function UpdateUser() {
			

			if (!empty($this->userID) && !empty($this->userFirstName) && !empty($this->userLastName) && !empty($this->userEmail)) {
				
				$st = $this->db->prepare("select * from user where userEmail = :userEmail AND userID = :userID");
				//write parameter query to avoid sql injections
				$st->bindParam(':userEmail', $this->userEmail);
				$st->bindParam(':userID', $this->userID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					
					while ($row = $st->fetch((PDO::FETCH_ASSOC))){
						$currentPassword = $row["userPassword"];
					}
					

					if (empty($this->userPassword)) {
						
						$st = $this->db->prepare("UPDATE `user`
						SET	
						
						`userFirstName` = :userFirstName,
						`userLastName` = :userLastName, 
						`userBio` = :userBio
						
						
						WHERE userID = :userID AND companyID = :companyID AND userEmail = :userEmail");
				
						
						$st->bindParam(':userFirstName', $this->userFirstName);
						$st->bindParam(':userLastName', $this->userLastName);
						$st->bindParam(':userID', $this->userID);
						$st->bindParam(':companyID', $this->companyID);
						$st->bindParam(':userEmail', $this->userEmail);
						$st->bindParam(':userBio', $this->userBio);
						
						$st->execute();
						
						if (!empty($this->fileName) && !empty($this->fileContent)) {

							$this->UploadPhoto();
							
						}

						$this->results = 'true'; 
						
					} else {
						
					
						//check to make sure the old password is ok
						if (password_verify($this->userOldPassword, $currentPassword)){

							$token = $this->random_string();
								
								$st = $this->db->prepare("UPDATE `user`
								SET	
								
								`userFirstName` = :userFirstName,
								`userLastName` = :userLastName,
								`userPassword` = :userPassword,
								`userBio` = :userBio,
								`token` = :token
								
								WHERE userID = :userID AND companyID = :companyID AND userEmail = :userEmail");
						
								
								$st->bindParam(':userFirstName', $this->userFirstName);
								$st->bindParam(':userLastName', $this->userLastName);
								$st->bindParam(':userPassword', $this->userPassword);
								$st->bindParam(':userID', $this->userID);
								$st->bindParam(':companyID', $this->companyID);
								$st->bindParam(':userEmail', $this->userEmail);
								$st->bindParam(':userBio', $this->userBio);
								$st->bindParam(':token', $token);
								
								$st->execute();


								if (!empty($this->fileName) && !empty($this->fileContent)) {

									$this->UploadPhoto();
									
								}
								$this->results = 'true'; 

								
							}else{
								// $this->results = 'false';
								$this->results = "999";
							}
								
					}
					
					
				} 
				
				else {	
					$st = $this->db->prepare("select * from user where userEmail = :userEmail");
					//write parameter query to avoid sql injections
					$st->bindParam(':userEmail', $this->userEmail);
					
					$st->execute();
					
					if ($st->rowCount()==1) {
						$this->results = "The new email address you entered already exists.";
					} else {
						
						if (empty($this->userPassword)) {
						
							$st = $this->db->prepare("UPDATE `user`
							
							SET	
							
							`userFirstName` = :userFirstName,
							`userLastName` = :userLastName,
							`userEmail` = :userEmail,
							`userBio` = :userBio
							
							WHERE userID = :userID AND companyID = :companyID");
					
							
							$st->bindParam(':userFirstName', $this->userFirstName);
							$st->bindParam(':userLastName', $this->userLastName);
							$st->bindParam(':userEmail', $this->userEmail);
							$st->bindParam(':userID', $this->userID);
							$st->bindParam(':companyID', $this->companyID);
							$st->bindParam(':userBio', $this->userBio);
							
							$st->execute();
							
							if (!empty($this->fileName) && !empty($this->fileContent)) {

								$this->UploadPhoto();
							
							}


							$this->results = 'true'; 
						
						} else {
							
							$st = $this->db->prepare("select * from user where userID = :userID AND companyID = :companyID");
							$st->bindParam(':userID', $this->userID);
							$st->bindParam(':companyID', $this->companyID);

							$st->execute();

							while ($row = $st->fetch((PDO::FETCH_ASSOC))){
								$currentPassword = $row["userPassword"];
							};

							if(password_verify($this->userOldPassword, $currentPassword)){

								$token = $this->random_string();

									$st = $this->db->prepare("UPDATE `user`
									
									SET	
									
									`userFirstName` = :userFirstName,
									`userLastName` = :userLastName,
									`userEmail` = :userEmail,
									`userPassword` = :userPassword,
									`userBio` = :userBio,
									`token` = :token
									
									WHERE userID = :userID AND companyID = :companyID");
							
									
									$st->bindParam(':userFirstName', $this->userFirstName);
									$st->bindParam(':userLastName', $this->userLastName);
									$st->bindParam(':userEmail', $this->userEmail);
									$st->bindParam(':userPassword', $this->userPassword);
									$st->bindParam(':userID', $this->userID);
									$st->bindParam(':companyID', $this->companyID);
									$st->bindParam(':userBio', $this->userBio);
									$st->bindParam(':token', $token);
									
									$st->execute();
									
									if (!empty($this->fileName) && !empty($this->fileContent)) {

										$this->UploadPhoto();
									
									}

									$this->results = 'true'; 
									
							}else{
									$this->results = "999"; //passwords didn't match
							}

						}
						
							
					}
				
					
				}
			}
		
		}
		
		
		public function getResults () {
			// $myVar[0] = $this->results;
			// $myVar[1] = $this->userPassword;
			// $myVar[2] = $userPassword;

			// return $myVar;

		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>