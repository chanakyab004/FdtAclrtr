<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class marketingMetrics {
		
		private $db;
		private $companyID;
		private $dateFrom;
		private $dateTo;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setMarketingMetrics($companyID, $dateFrom, $dateTo) {
			$this->companyID = $companyID;
			$this->dateFrom = $dateFrom;
			$this->dateTo = $dateTo;
			
		}
			
			
		public function getMarketingMetrics() {
			
			if (!empty($this->companyID)) {
			
				$st = $this->db->prepare("SELECT * FROM (SELECT s.isDeleted as spendDeleted, t.isDeleted as typeDeleted, d.category AS parentCategory, d.marketingTypeName AS parentName, 
								t.marketingTypeID, t.category, t.marketingTypeName, t.parentMarketingTypeID, 
								s.marketingSpendID, s.spendDate, s.startDate, s.endDate, s.spendAmount, t.isRepeatBusiness
								FROM marketingType AS t
								LEFT JOIN marketingType AS d ON d.marketingTypeID = t.parentMarketingTypeID
								LEFT JOIN marketingSpend AS s ON t.marketingTypeID = s.marketingTypeID
								WHERE t.companyID = :companyID 
								AND s.marketingSpendID IS NULL 

								UNION ALL 

								SELECT s.isDeleted as spendDeleted, t.isDeleted as typeDeleted, d.category AS parentCategory, d.marketingTypeName AS parentName, 
								t.marketingTypeID, t.category, t.marketingTypeName, t.parentMarketingTypeID, 
								s.marketingSpendID, s.spendDate, s.startDate, s.endDate, s.spendAmount, t.isRepeatBusiness
								FROM marketingType AS t
								LEFT JOIN marketingType AS d ON d.marketingTypeID = t.parentMarketingTypeID
								LEFT JOIN marketingSpend AS s ON t.marketingTypeID = s.marketingTypeID
								WHERE t.companyID = :companyID
								AND s.startDate <=  :dateTo
								AND s.endDate >=  :dateFrom

								UNION ALL

								SELECT s.isDeleted as spendDeleted, t.isDeleted as typeDeleted, d.category AS parentCategory, d.marketingTypeName AS parentName, 
								t.marketingTypeID, t.category, t.marketingTypeName, t.parentMarketingTypeID, 
								NULL AS marketingSpendID, NULL AS spendDate, NULL AS startDate, NULL AS endDate, NULL AS spendAmount, t.isRepeatBusiness
								FROM marketingType AS t
								LEFT JOIN marketingType AS d ON d.marketingTypeID = t.parentMarketingTypeID
								LEFT JOIN marketingSpend AS s ON t.marketingTypeID = s.marketingTypeID
								WHERE t.companyID = :companyID
								)  as g");

									$st->bindParam(':companyID', $this->companyID);	 
									$st->bindParam(':dateFrom', $this->dateFrom);	
									$st->bindParam(':dateTo', $this->dateTo);

									$st->execute();

									if ($st->rowCount()>=1) {
											while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
											$marketingMetrics[] = $row;
										}

										$this->results = $marketingMetrics;

									}else{
										$this->results="false";
									}
								
			} 
		}
		
		public function getResults () {
				return $this->results;		 
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>