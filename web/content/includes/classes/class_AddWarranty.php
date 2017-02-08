<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Warranty {
		
		private $db;
		private $companyID;
		private $warrantyName;
		private $warrantyBody;
		private $warrantyType;
		private $results;
		private $warrantyID;



		// private $fileName;
		// private $fileContent;
		// private $fileType;
		// private $fileSize;
		// private $results;

		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		// public function setWarranty($companyID, $warrantyName, $fileName, $fileContent, $fileType, $fileSize) {
		// 	$this->companyID = $companyID;
		// 	$this->warrantyName = $warrantyName;
		// 	$this->fileName = $fileName;
		// 	$this->fileContent = $fileContent;
		// 	$this->fileType = $fileType;
		// 	$this->fileSize = $fileSize;
			
		// }

		
		public function setWarranty($companyID, $warrantyName, $warrantyBody, $warrantyType) {
			$this->companyID = $companyID;
			$this->warrantyName = $warrantyName;
			$this->warrantyBody = $warrantyBody;
			$this->warrantyType = $warrantyType;

		}



		// public function UploadPhoto($warrantyID) {

		// 	$ds = 				DIRECTORY_SEPARATOR;
		// 	$path_parts = 		pathinfo($this->fileName);
		// 	$name = 			$path_parts['filename'].'_'.time().'.'.$path_parts['extension']; 
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
		// 					$newwidth = 600;
		// 					$newheight = 600;
		// 					break;
							
		// 				//landscape
		// 				case 2:
		// 					if ($height >= 820) {
		// 						$newheight = 820;
		// 						$ratio = $newheight/$height;
		// 						$newwidth = round($width * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
						
		// 				//portrait
		// 				case 3:
		// 					if ($height >= 820) {
		// 						$newwidth = 820;
		// 						$ratio = $newwidth/$width;
		// 						$newheight = round($height * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
		// 			}
						
		// 			$newimage = imagecreatetruecolor($newwidth, $newheight);
		// 			if ($height >= 820) {
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
		// 					$newwidth = 600;
		// 					$newheight = 600;
		// 					break;
							
		// 				//landscape
		// 				case 2:
		// 					if ($height >= 612) {
		// 						$newheight = 612;
		// 						$ratio = $newheight/$height;
		// 						$newwidth = round($width * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
						
		// 				//portrait
		// 				case 3:
		// 					if ($height >= 612) {
		// 						$newwidth = 612;
		// 						$ratio = $newwidth/$width;
		// 						$newheight = round($height * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
		// 				}
						
		// 				$newimage = imagecreatetruecolor($newwidth, $newheight);
		// 				if ($height >= 612) {
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
		// 					$newwidth = 600;
		// 					$newheight = 600;
		// 					break;
							
		// 				//landscape
		// 				case 2:
		// 					if ($height >= 612) {
		// 						$newheight = 612;
		// 						$ratio = $newheight/$height;
		// 						$newwidth = round($width * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
						
		// 				//portrait
		// 				case 3:
		// 					if ($height >= 612) {
		// 						$newwidth = 612;
		// 						$ratio = $newwidth/$width;
		// 						$newheight = round($height * $ratio);
		// 					} else {
		// 						$newheight = $height;
		// 						$newwidth = $width;
		// 					}
		// 					break;
		// 			}
						
		// 			$newimage = imagecreatetruecolor($newwidth, $newheight);
		// 			if ($height >= 612) {
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
		// 	$photoSt->bindParam(':file', $name);
			
		// 	$photoSt->execute();
		// }	
			
			
		public function sendWarranty() {
			
			// echo("cid" . $this->companyID . " warranty name:" . $this->warrantyName ." warrantybody" . $this->warrantyBody . " warrantytype" .   $this->warrantyType);

			if (!empty($this->companyID) && !empty($this->warrantyName) && !empty($this->warrantyBody)) {
					

				$st = $this->db->prepare("INSERT INTO `warranty`
					(
					`companyID`,
					`name`,
					`warranty`,
					`type`,  
					`lastUpdated`
					) 
					VALUES
					(
					:companyID,
					:warrantyName,
					:warrantyBody,
					:warrantyType,
					UTC_TIMESTAMP
				)");
				
				$st->bindParam(':companyID', $this->companyID);	 
				$st->bindParam(':warrantyName', $this->warrantyName);
				$st->bindParam(':warrantyBody', $this->warrantyBody);
				$st->bindParam(':warrantyType', $this->warrantyType);
				

				$st->execute();
				
				$warrantyID = $this->db->lastInsertId();
				
				
				// if (!empty($this->fileName) && !empty($this->fileContent)) {
					
				// 	$this->UploadPhoto($warrantyID);
				// }

				$this->results = $warrantyID;

				
			} 

		}
		
		public function getResults () {

		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>