<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Evaluation {
		
		private $db;
		private $projectID;
		private $companyID;
		private $description;
		private $fileName;
		private $fileContent;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}

		public function fileNameTaken($fileName, $projectID){
			$taken = false;
			$st = $this->db->prepare("SELECT * FROM `projectDocuments` 
				WHERE `name`= :fileName
				AND `projectID`= :projectID");
			//write parameter query to avoid sql injections
			$st->bindParam(':fileName', $fileName);
			$st->bindParam(':projectID', $projectID);
			
			$st->execute();
			if ($st->rowCount()>=1) {
				$taken = true;
			}
			return $taken;
		}

		public function newFileName($fileName, $projectID){
			$number = 0;
		    if ($pos = strrpos($fileName, '.')) {
		    	if ($numPos = strrpos($fileName, '_')){
		            $name = substr($fileName, 0, $numPos);
		            $ext = substr($fileName, $pos);
		       		$number = substr($fileName, $numPos + 1, -strlen($ext));
		       		if (!is_numeric($number)){
		       			$number = 0;
		       		}
	           	}
	           	else{
	           		$number = 0;
		          	$name = substr($fileName, 0, $pos);
		           	$ext = substr($fileName, $pos);
	           	}          
		    } 
		    else {
		           $name = $fileName;
		    }

		    $newname = $fileName;
		    while ($this->fileNameTaken($newname, $projectID)) {
		           $newname = $name .'_'. $number . $ext;
		           $number++;
		     }

		    return $newname;
		}
			
		public function setEvaluation($projectID, $companyID, $description, $fileName, $fileContent) {
			$this->projectID = $projectID;
			$this->companyID = $companyID;
			$this->description = $description;
			$this->fileName = $fileName;
			$this->fileContent = $fileContent;
			
		}
			
		public function sendEvaluation() {
			
			if (!empty($this->projectID) && !empty($this->companyID) && !empty($this->fileName)) {

				$this->fileName = $this->newFileName($this->fileName, $this->projectID);
	
				$secondST = $this->db->prepare("INSERT INTO `projectDocuments`
					(
					`projectID`,
					`companyID`,
					`description`,
					`name`,
					`lastEdited`
					) 
					VALUES
					(
					:projectID,
					:companyID,
					:description,
					:fileName,
					UTC_TIMESTAMP
				)");
				
				$secondST->bindParam(':projectID', $this->projectID);	 
				$secondST->bindParam(':companyID', $this->companyID);	
				$secondST->bindParam(':description', $this->description);
				$secondST->bindParam(':fileName', $this->fileName);	 
					 
				
				$secondST->execute();

				if (!empty($this->fileName) && !empty($this->fileContent)) {

					if( is_dir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/documents') === false ) {
						mkdir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/documents', 0777, true);
					}
				
					$filePath = 'assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/documents/'.$this->fileName.'';
				
     				move_uploaded_file($this->fileContent, $filePath);
					
				}
			}
		} 
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>