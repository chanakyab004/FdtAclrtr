<?php
session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class PhotoUpload {
		
		private $db;
		private $projectID;
		private $section;
		
		
		public function __construct() {
			
			$db = new Connection();
			$db = $db->dbConnect();
			
			}
			
		public function setProject($projectID, $section) {
			$this->projectID = $projectID;
			$this->section = $section;
			
		}
		
		
			
		public function sendPhotos() {
			
			if (!empty($this->projectID) && !empty($this->section)) {
				
				$st = $this->db->prepare("SELECT * FROM evaluationPhoto WHERE projectID=? AND photoSection=? ORDER BY photoOrder ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->section);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnPhotos[] = $row;
					}
					
					echo json_encode($returnPhotos);
				} 
				
			} 
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>



<?php



$ds = DIRECTORY_SEPARATOR;  //1


if (!empty($_FILES)) {
	
	$section = $_POST["section"]; 
	$projectID = $_POST["projectID"]; 
	
	$dir = $projectID;
 
	$storeFolder = 'uploads/'.$dir.'';   //2

	if( is_dir('uploads/'.$dir.'') === false )
	{
    mkdir('uploads/'.$dir.'');
	}
 
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = $storeFolder . $ds;  //4
     
    $targetFile = $_FILES['file']['name'];  //5
 
    move_uploaded_file($tempFile,$targetPath.$targetFile); //6
	
	$sql = mysql_query("INSERT INTO evaluationPhoto SET projectID='$projectID', photoSection='$section', photoFilename='$targetFile'") 
	or die (mysql_error());
	
	
     
}
?> 