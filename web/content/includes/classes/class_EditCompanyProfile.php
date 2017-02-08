<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');

	class CompanyEdit {

		private $db;
		private $companyID;
		private $companyName;
		private $companyAddress1;
		private $companyAddress2;
		private $companyCity;
		private $companyState;
		private $companyZip;
		// adding billing address - FXLRATR-350
		private $companyBillingAddress1;
		private $companyBillingAddress2;
		private $companyBillingCity;
		private $companyBillingState;
		private $companyBillingZip;


		private $companyWebsite;
		private $companyColor;
		private $companyColorHover;
		private $companyEmailFrom;
		private $companyEmailReply;
		private $defaultInvoices;
		private $invoiceSplitBidAcceptance;
		private $invoiceSplitProjectComplete;
		private $timezone;
		private $daylightSavings;
		private $recentlyCompletedStatus;
		private $fileName;
		private $fileContent;
		private $fileType;
		private $fileSize;

		private $results;


		public function __construct() {

			$this->db = new Connection();
			$this->db = $this->db->dbConnect();

			}

		public function setCompany($companyID, $companyName, $companyAddress1, $companyAddress2, $companyCity, $companyState, $companyZip,$companyBillingAddress1, $companyBillingAddress2, $companyBillingCity, $companyBillingState, $companyBillingZip, $companyWebsite, $companyColor, $companyColorHover,
				$companyEmailFrom, $companyEmailReply, $defaultInvoices, $invoiceSplitBidAcceptance, $invoiceSplitProjectComplete, $timezone, $daylightSavings, $recentlyCompletedStatus, $fileName, $fileContent,
				$fileType, $fileSize) {

			$this->companyID = $companyID;
			$this->companyName = $companyName;
			$this->companyAddress1 = $companyAddress1;
			$this->companyAddress2 = $companyAddress2;
			$this->companyCity = $companyCity;
			$this->companyState = $companyState;
			$this->companyZip = $companyZip;
			// billing address FXLRATR-350
			$this->companyBillingAddress1 = $companyBillingAddress1;
			$this->companyBillingAddress2 = $companyBillingAddress2;
			$this->companyBillingCity = $companyBillingCity;
			$this->companyBillingState = $companyBillingState;
			$this->companyBillingZip = $companyBillingZip;
		
			$this->companyWebsite = $companyWebsite;
			$this->companyColor = $companyColor;
			$this->companyColorHover = $companyColorHover;
			$this->companyEmailFrom = $companyEmailFrom;
			$this->companyEmailReply = $companyEmailReply;
			$this->defaultInvoices = $defaultInvoices;
			$this->invoiceSplitBidAcceptance = $invoiceSplitBidAcceptance;
			$this->invoiceSplitProjectComplete = $invoiceSplitProjectComplete;
			$this->timezone = $timezone;
			$this->daylightSavings = $daylightSavings;
			$this->recentlyCompletedStatus = $recentlyCompletedStatus;

			$this->fileName = $fileName;
			$this->fileContent = $fileContent;
			$this->fileType = $fileType;
			$this->fileSize = $fileSize;

		}


		public function UploadPhoto() {

			$ds = 				DIRECTORY_SEPARATOR;
			$path_parts = 		pathinfo($this->fileName);
			$name = 			'Logo.'.$path_parts['extension'];
			$temp = 			$this->fileContent;
			$type = 			$this->fileType;
			$size = 			$this->fileSize;
			$path = 			'assets/company/'.$this->companyID.$ds.$name.'';

			$image = 			imagecreatefromstring(file_get_contents($this->fileContent));

			if($type == 'image/jpeg'){
				$exif = exif_read_data($this->fileContent);
			}

			$dimentions = 		getimagesize($temp);
			$origWidth = 		$dimentions[0];
			$origHeight = 		$dimentions[1];


			if( is_dir('assets/company/'.$this->companyID.'') === false ) {
				mkdir('assets/company/'.$this->companyID.'');
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

			$photoSt = $this->db->prepare("UPDATE `company`
				SET
				`companyLogo` = :companyLogo
				WHERE companyID = :companyID");

			$photoSt->bindParam(':companyLogo', $name);
			$photoSt->bindParam(':companyID', $this->companyID);

			$photoSt->execute();
		}


		public function UpdateCompany() {

			if (!empty($this->companyID)) {


				$st = $this->db->prepare("UPDATE `company`
				SET

				`companyName` = :companyName,
				`companyAddress1` = :companyAddress1,
				`companyAddress2` = :companyAddress2,
				`companyCity` = :companyCity,
				`companyState` = :companyState,
				`companyZip` = :companyZip,
				`companyBillingAddress1` =:companyBillingAddress1,
				`companyBillingAddress2` = :companyBillingAddress2,
				`companyBillingCity` = :companyBillingCity,
				`companyBillingState` = :companyBillingState,
				`companyBillingZip` = :companyBillingZip,
				`companyWebsite` = :companyWebsite,
				`companyColor` = :companyColor,
				`companyColorHover` = :companyColorHover,
				`companyEmailFrom` = :companyEmailFrom,
				`companyEmailReply` = :companyEmailReply,
				`defaultInvoices` = :defaultInvoices,
				`invoiceSplitBidAcceptance` = :invoiceSplitBidAcceptance,
				`invoiceSplitProjectComplete` = :invoiceSplitProjectComplete,
				`timezone` = :timezone,
				`daylightSavings` = :daylightSavings,
				`recentlyCompletedStatus` = :recentlyCompletedStatus,
				`companyUpdated` = UTC_TIMESTAMP

				WHERE companyID = :companyID");


				$st->bindParam(':companyName', $this->companyName);
				$st->bindParam(':companyAddress1', $this->companyAddress1);
				$st->bindParam(':companyAddress2', $this->companyAddress2);
				$st->bindParam(':companyCity', $this->companyCity);
				$st->bindParam(':companyState', $this->companyState);
				$st->bindParam(':companyZip', $this->companyZip);

				// BILLING address
				$st->bindParam(':companyBillingAddress1', $this->companyBillingAddress1);
				$st->bindParam(':companyBillingAddress2', $this->companyBillingAddress2);
				$st->bindParam(':companyBillingCity', $this->companyBillingCity);
				$st->bindParam(':companyBillingState', $this->companyBillingState);
				$st->bindParam(':companyBillingZip', $this->companyBillingZip);


				$st->bindParam(':companyWebsite', $this->companyWebsite);
				$st->bindParam(':companyColor', $this->companyColor);
				$st->bindParam(':companyColorHover', $this->companyColorHover);
				$st->bindParam(':companyEmailFrom', $this->companyEmailFrom);
				$st->bindParam(':companyEmailReply', $this->companyEmailReply);
				$st->bindParam(':defaultInvoices', $this->defaultInvoices);
				$st->bindParam(':invoiceSplitBidAcceptance', $this->invoiceSplitBidAcceptance);
				$st->bindParam(':invoiceSplitProjectComplete', $this->invoiceSplitProjectComplete);
				$st->bindParam(':timezone', $this->timezone);
				$st->bindParam(':daylightSavings', $this->daylightSavings);
				$st->bindParam(':recentlyCompletedStatus', $this->recentlyCompletedStatus);
				$st->bindParam(':companyID', $this->companyID);

				$st->execute();

				if (!empty($this->fileName) && !empty($this->fileContent)) {

					$this->UploadPhoto();
				}

				$this->results = 'true';

			}

		}


		public function getResults () {
		 	return $this->results;
		}

	}

	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>
