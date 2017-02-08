<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Warranty {
		
		private $db;
		private $companyID;
		private $warrantyID;
		private $warrantyName;
		private $warrantyBody;
		private $documentType;

		// private $addressCoordinatesX;
		// private $addressCoordinatesY;
		// private $addressPosition;
		// private $fileName;
		// private $fileType;
		// private $fileContent;
		// private $fileSize;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		// public function setWarranty($companyID, $warrantyID, $warrantyName, $addressCoordinatesX, $addressCoordinatesY, $addressPosition, $fileName, $fileType, $fileContent, $fileSize) {
		// 	$this->companyID = $companyID;
		// 	$this->warrantyID = $warrantyID;
		// 	$this->warrantyName = $warrantyName;
		// 	$this->addressCoordinatesX = $addressCoordinatesX;
		// 	$this->addressCoordinatesY = $addressCoordinatesY;
		// 	$this->addressPosition = $addressPosition;
		// 	$this->fileName = $fileName;
		// 	$this->fileType = $fileType;
		// 	$this->fileContent = $fileContent;
		// 	$this->fileSize = $fileSize;
		// }
			
	public function setWarranty($companyID, $warrantyID, $warrantyName, $warrantyBody, $documentType) {
			$this->companyID = $companyID;
			$this->warrantyID = $warrantyID;
			$this->warrantyName = $warrantyName;
			$this->warrantyBody = $warrantyBody;
			$this->documentType = $documentType;
		}

		// public function UploadPhoto($warrantyID) {

		// 	$ds = 				DIRECTORY_SEPARATOR;
		// 	$path_parts = 		pathinfo($this->fileName);
		// 	$name = 			$path_parts['filename'].'.'.$path_parts['extension']; 
		// 	$temp = 			$this->fileContent;  
		// 	$type = 			$this->fileType;  
		// 	$size = 			$this->fileSize; 
		// 	$path = 			'assets/company/'.$this->companyID.'/warranties/'.$name.''; 
			
		// 	$image = 			imagecreatefromstring(file_get_contents($this->fileContent));

		// 	$dimentions = 		getimagesize($temp, $info); 
		// 	$origWidth = 		$dimentions[0];
		// 	$origHeight = 		$dimentions[1];
		
		
		// 	if( is_dir('assets/company/'.$this->companyID.'/warranties/') === false )
		// 	{
		// 	mkdir('assets/company/'.$this->companyID.'/warranties/', 0777, true);
		// 	}
			
			
		// 	switch ($type) {
					
		// 		case 'image/jpeg':
					
		// 			$width = $origWidth; 
		// 			$height = $origHeight; 
		// 			$upload = imagecreatefromjpeg($temp);
				
						
		// 			if ($width == $height) { $case=1; }
		// 			if ($width > $height) { $case=2; }
		// 			if ($width < $height) { $case=3; }
			
		// 			switch ($case) {
		// 				//square
		// 				case 1:
		// 					$newwidth = 1000;
		// 					$newheight = 1000;
		// 					break;
							
		// 				//landscape
		// 				case 2:
		// 					if ($height >= 2550) {
		// 						$newheight = 2550;
		// 						$ratio = $newheight/$height;
		// 						$newwidth = round($width * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
						
		// 				//portrait
		// 				case 3:
		// 					if ($height >= 2550) {
		// 						$newwidth = 2550;
		// 						$ratio = $newwidth/$width;
		// 						$newheight = round($height * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
		// 			}
						
		// 			$newimage = imagecreatetruecolor($newwidth, $newheight);
		// 			if ($height >= 2550) {
		// 				imagecopyresampled($newimage, $upload, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		// 			}
		// 			imagejpeg($newimage, $path, 100);
					
		// 			break;
					
		// 		case 'image/png':
					
		// 			$width = $origWidth;
		// 			$height = $origHeight;
		// 			$upload = imagecreatefrompng($temp);
				
		// 			if ($width == $height) { $case=1; }
		// 			if ($width > $height) { $case=2; }
		// 			if ($width < $height) { $case=3; }
			
		// 			switch ($case) {
		// 				//square
		// 				case 1:
		// 					$newwidth = 1000;
		// 					$newheight = 1000;
		// 					break;
							
		// 				//landscape
		// 				case 2:
		// 					if ($height >= 2550) {
		// 						$newheight = 2550;
		// 						$ratio = $newheight/$height;
		// 						$newwidth = round($width * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
						
		// 				//portrait
		// 				case 3:
		// 					if ($height >= 2550) {
		// 						$newwidth = 2550;
		// 						$ratio = $newwidth/$width;
		// 						$newheight = round($height * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
		// 				}
						
		// 				$newimage = imagecreatetruecolor($newwidth, $newheight);
		// 				if ($height >= 2550) {
		// 					imagecopyresampled($newimage, $upload, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		// 				}
		// 				imagepng($newimage, $path, 9);
					
		// 			break;
					
		// 		case 'image/gif':
					
		// 			$width = $origWidth;
		// 			$height = $origHeight;
		// 			$upload = imagecreatefromgif($temp); 
				
		// 			if ($width == $height) { $case=1; }
		// 			if ($width > $height) { $case=2; }
		// 			if ($width < $height) { $case=3; }
			
		// 			switch ($case) {
		// 				//square
		// 				case 1:
		// 					$newwidth = 1000;
		// 					$newheight = 1000;
		// 					break;
							
		// 				//landscape
		// 				case 2:
		// 					if ($height >= 2550) {
		// 						$newheight = 2550;
		// 						$ratio = $newheight/$height;
		// 						$newwidth = round($width * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
						
		// 				//portrait
		// 				case 3:
		// 					if ($height >= 2550) {
		// 						$newwidth = 2550;
		// 						$ratio = $newwidth/$width;
		// 						$newheight = round($height * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
		// 			}
						
		// 			$newimage = imagecreatetruecolor($newwidth, $newheight);
		// 			if ($height >= 2550) {
		// 				imagecopyresampled($newimage, $upload, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		// 			}
		// 			imagegif($newimage, $path);
					
		// 			break;
		// 	}

		// 	$photoSt = $this->db->prepare("UPDATE `warranty`
		// 		SET	
		// 		`file` = :file
		// 		WHERE companyID = :companyID AND warrantyID = :warrantyID");
		
		// 	$photoSt->bindParam(':companyID', $this->companyID);
		// 	$photoSt->bindParam(':warrantyID', $warrantyID);
		// 	$photoSt->bindParam(':file', $this->fileName);
			
		// 	$photoSt->execute();
		// }	

public function sendWarranty() {
			
			if (!empty($this->companyID) && !empty($this->warrantyID)) {
				
				$st = $this->db->prepare("UPDATE `warranty`

				SET	
				
				`name` = :warrantyName,
				`warranty` = :warrantyBody,
				`type` = :documentType,
				`lastUpdated` = UTC_TIMESTAMP
				
				WHERE warrantyID = :warrantyID AND companyID = :companyID");
				//write parameter query to avoid sql injections
				$st->bindParam('companyID', $this->companyID);
				$st->bindParam('warrantyID', $this->warrantyID);
				$st->bindParam('warrantyName', $this->warrantyName);
				$st->bindParam('warrantyBody', $this->warrantyBody);
				$st->bindParam('documentType', $this->documentType);
				
				$st->execute();
				
				
				// if (!empty($this->fileName) && !empty($this->fileContent)) {
					
				// 	$this->UploadPhoto($this->warrantyID);
				// }

				if ($st->execute()) { 
					$this->results = 'true'; 
				}
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}

			
	// 	public function sendWarranty() {
			
	// 		if (!empty($this->companyID) && !empty($this->warrantyID) && !empty($this->addressCoordinatesX) && !empty($this->addressCoordinatesY)) {
				
	// 			$st = $this->db->prepare("UPDATE `warranty`

	// 			SET	
				
	// 			`name` = :warrantyName,
	// 			`addressCoordinatesX` = :addressCoordinatesX,
	// 			`addressCoordinatesY` = :addressCoordinatesY,
	// 			`addressPosition` = :addressPosition,
	// 			`lastUpdated` = UTC_TIMESTAMP
				
	// 			WHERE warrantyID = :warrantyID AND companyID = :companyID");
	// 			//write parameter query to avoid sql injections
	// 			$st->bindParam('companyID', $this->companyID);
	// 			$st->bindParam('warrantyID', $this->warrantyID);
	// 			$st->bindParam('warrantyName', $this->warrantyName);
	// 			$st->bindParam('addressCoordinatesX', $this->addressCoordinatesX);
	// 			$st->bindParam('addressCoordinatesY', $this->addressCoordinatesY);
	// 			$st->bindParam('addressPosition', $this->addressPosition);
				
	// 			$st->execute();
				
				
	// 			if (!empty($this->fileName) && !empty($this->fileContent)) {
					
	// 				$this->UploadPhoto($this->warrantyID);
	// 			}

	// 			if ($st->execute()) { 
	// 				$this->results = 'true'; 
	// 			}
				
	// 		} else if (!empty($this->companyID) && !empty($this->warrantyID)) {
				
	// 			$st = $this->db->prepare("UPDATE `warranty`

	// 			SET	
				
	// 			`name` = :warrantyName,
	// 			`lastUpdated` = UTC_TIMESTAMP
				
	// 			WHERE warrantyID = :warrantyID AND companyID = :companyID");
	// 			//write parameter query to avoid sql injections
	// 			$st->bindParam('companyID', $this->companyID);
	// 			$st->bindParam('warrantyID', $this->warrantyID);
	// 			$st->bindParam('warrantyName', $this->warrantyName);
				
	// 			$st->execute();
				
				
	// 			if (!empty($this->fileName) && !empty($this->fileContent)) {
					
	// 				$this->UploadPhoto($this->warrantyID);
	// 			}

	// 			if ($st->execute()) { 
	// 				$this->results = 'true'; 
	// 			}
				
	// 		} 
	// 	}
		
	// 	public function getResults () {
	// 	 	return $this->results;
	// 	}
		
	// }
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>