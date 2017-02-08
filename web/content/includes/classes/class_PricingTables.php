<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class TablePricing {
		
		private $db;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}
			
		public function setCompany($companyID) {	
			$this->companyID = $companyID;
		}
			
		public function getCompany() {
			
			if (!empty($this->companyID)) {
				
				$st = $this->db->prepare("
					
				(SELECT 'pricingPier' AS tableType, companyID, pricingPierID AS id, manufacturerItemID, name, description, price, sort, manufacturerPierName 

					FROM pricingPier AS p LEFT JOIN

					manufacturerPiers AS m ON m.manufacturerPierID = p.manufacturerItemID

					WHERE companyID = :companyID AND isDELETE IS NULL)
				
				UNION ALL
				
				(SELECT 'pricingPost' AS tableType, companyID, pricingPostID AS id, null, name, description, price, sort, NULL FROM pricingPost WHERE companyID = :companyID AND isDELETE IS NULL)
				
				UNION ALL
				
				(SELECT 'pricingPostFooting' AS tableType, companyID, pricingPostFootingID AS id, null, name, description, price, sort, NULL FROM pricingPostFooting WHERE companyID = :companyID AND isDELETE IS NULL)
				
				UNION ALL
				
				(SELECT 'pricingFloorCracks' AS tableType, companyID, pricingFloorCracksID AS id, null, name, description, price, sort, NULL FROM pricingFloorCracks WHERE companyID = :companyID AND isDELETE IS NULL)
				
				UNION ALL
				
				(SELECT 'pricingWallCracks' AS tableType, companyID, pricingWallCracksID AS id, null, name, description, price, sort, NULL FROM pricingWallCracks WHERE companyID = :companyID AND isDELETE IS NULL)
				
				UNION ALL
				
				(SELECT 'pricingWallBraces' AS tableType, companyID, pricingWallBracesID AS id, null, name, description, price, sort, NULL FROM pricingWallBraces WHERE companyID = :companyID AND isDELETE IS NULL)
				
				UNION ALL
				
				(SELECT 'pricingWallStiffener' AS tableType, companyID, pricingWallStiffenerID AS id, null, name, description, price, sort, NULL FROM pricingWallStiffener WHERE companyID = :companyID AND isDELETE IS NULL)
				
				UNION ALL
				
				(SELECT 'pricingWallAnchor' AS tableType, companyID, pricingWallAnchorID AS id, null, name, description, price, sort, NULL FROM pricingWallAnchor WHERE companyID = :companyID AND isDELETE IS NULL)
				
				UNION ALL
				
				(SELECT 'pricingSumpPump' AS tableType, companyID, pricingSumpPumpID AS id, null, name, description, price, sort, NULL FROM pricingSumpPump WHERE companyID = :companyID AND isDELETE IS NULL)
				
				UNION ALL
				
				(SELECT 'pricingBasin' AS tableType, companyID, pricingBasinID AS id, null, name, description, price, sort, NULL FROM pricingBasin WHERE companyID = :companyID AND isDELETE IS NULL)
				
				UNION ALL
				
				(SELECT 'pricingDrainInlet' AS tableType, companyID, pricingDrainInletID AS id, null, name, description, price, sort, NULL FROM pricingDrainInlet WHERE companyID = :companyID AND isDELETE IS NULL)

				UNION ALL
				
				(SELECT 'pricingMembrane' AS tableType, companyID, pricingMembraneID AS id, null, name, description, price, sort, NULL FROM pricingMembrane WHERE companyID = :companyID AND isDELETE IS NULL)

				UNION ALL
				
				(SELECT 'pricingTileDrain' AS tableType, companyID, pricingTileDrainID AS id, null, name, description, price, sort, NULL FROM pricingTileDrain WHERE companyID = :companyID AND isDELETE IS NULL)

				UNION ALL
				
				(SELECT 'pricingCustomServices' AS tableType, companyID, pricingCustomServicesID AS id, null, name, description, price, sort, NULL FROM pricingCustomServices WHERE companyID = :companyID AND isDELETE IS NULL)
				
				ORDER BY tableType ASC, sort ASC

				");
				//write parameter query to avoid sql injections
				$st->bindParam('companyID', $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCompany[] = $row;
					}
					
					$this->results = $returnCompany;
					
				} 
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>