<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class MarketingReport {
		
		private $db;
		private $companyID;
		private $startDate;
		private $endDate;
		private $results;
		
		public function __construct() {
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}
			
		public function setCompanyID($companyID) {
			$this->companyID = $companyID;
		}

		public function setStartDate($startDate) {
			$this->startDate = $startDate;
		}

		public function setEndDate($endDate) {
			$this->endDate = $endDate;
		}

		public function getMarketingAll() {
			$marketingArrayAll = array();
			$marketingArrayAll['totalMarketingCosts'] = $this->getTotalMarketingCostsAll();
			$marketingArrayAll['leads'] = $this->getLeadsAll();
			$marketingArrayAll['grossSales'] = $this->getGrossSalesAll();
			$marketingArrayAll['appointments'] = $this->getAppointmentsAll();
			$marketingArrayAll['bids'] = $this->getBidsAll();
			$marketingArrayAll['sales'] = $this->getSalesAll();
			$this->results = $marketingArrayAll;
		}

		public function getUnsourced(){
			$unsourcedArray = array();
			$unsourcedArray['leads'] = $this->getLeadsUnsourced();
			$unsourcedArray['grossSales'] = $this->getGrossSalesUnsourced();
			$unsourcedArray['appointments'] = $this->getAppointmentsUnsourced();
			$unsourcedArray['bids'] = $this->getBidsUnsourced();
			$unsourcedArray['sales'] = $this->getSalesUnsourced();
			$this->results = $unsourcedArray;
		}
			
		public function getTotalMarketingCostsAll() {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT SUM(spendAmount) as totalMarketingCosts FROM marketingSpend as s
					LEFT JOIN marketingType as t on t.marketingTypeID = s.marketingTypeID
					WHERE t.companyID = :companyID 
					AND s.startDate <=  :endDate
					AND s.endDate >=  :startDate");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCosts = $row['totalMarketingCosts'];
					}
					$results = $returnCosts;
				} 
			} 
			return $results;
		}

		public function getGrossSalesAll() {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT SUM(bidTotal) as grossSales FROM (SELECT b.bidTotal FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate AND c.companyID = :companyID

											UNION ALL

											SELECT b.bidTotal FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate AND c.companyID = :companyID) as t ");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnGrossSales = $row['grossSales'];
					}
					$results = $returnGrossSales;
				} 
			}
			return $results; 
		}

		public function getLeadsAll() {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as leads FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											WHERE p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate AND c.companyID = :companyID");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnLeads = $row['leads'];
					}
					$results = $returnLeads;
				} 
			}
			return $results; 
		}

		public function getAppointmentsAll() {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as appointments FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN projectSchedule as s ON p.projectID = s.projectID
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND c.companyID = :companyID
											AND s.scheduleType = 'Evaluation' 
											AND s.cancelledDate IS NULL");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnAppointments = $row['appointments'];
					}
					$results = $returnAppointments;
				} 
			}
			return $results; 
		}

		public function getBidsAll() {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as bids FROM (SELECT e.evaluationID as bids FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											WHERE b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND c.companyID = :companyID

											UNION

											SELECT e.evaluationID as bids FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											WHERE b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND c.companyID = :companyID) as t
											");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnBids = $row['bids'];
					}
					$results = $returnBids;
				} 
			}
			return $results; 
		}

		public function getSalesAll() {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as sales FROM (SELECT e.evaluationID as sales FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate AND c.companyID = :companyID

											UNION

											SELECT e.evaluationID as sales FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate AND c.companyID = :companyID) as t ");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnSales = $row['sales'];
					}
					$results = $returnSales;
				} 
			}
			return $results; 
		}

		public function getGrossSalesUnsourced() {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT SUM(bidTotal) as grossSales FROM (SELECT b.bidTotal FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate 
											AND c.companyID = :companyID
											AND p.referralMarketingTypeID IS NULL

											UNION ALL

											SELECT b.bidTotal FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND c.companyID = :companyID
											AND p.referralMarketingTypeID IS NULL) as t ");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnGrossSales = $row['grossSales'];
					}
					$results = $returnGrossSales;
				} 
			}
			return $results; 
		}

		public function getLeadsUnsourced() {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as leads FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											WHERE p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND c.companyID = :companyID
											AND p.referralMarketingTypeID IS NULL");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnLeads = $row['leads'];
					}
					$results = $returnLeads;
				} 
			}
			return $results; 
		}

		public function getAppointmentsUnsourced() {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as appointments FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN projectSchedule as s ON p.projectID = s.projectID
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND c.companyID = :companyID
											AND s.scheduleType = 'Evaluation' 
											AND s.cancelledDate IS NULL
											AND p.referralMarketingTypeID IS NULL");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnAppointments = $row['appointments'];
					}
					$results = $returnAppointments;
				} 
			}
			return $results; 
		}

		public function getBidsUnsourced() {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as bids FROM (SELECT e.evaluationID as bids FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											WHERE b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND c.companyID = :companyID
											AND p.referralMarketingTypeID IS NULL

											UNION

											SELECT e.evaluationID as bids FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											WHERE b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND c.companyID = :companyID
											AND p.referralMarketingTypeID IS NULL) as t
											");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnBids = $row['bids'];
					}
					$results = $returnBids;
				} 
			}
			return $results; 
		}

		public function getSalesUnsourced() {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as sales FROM (SELECT e.evaluationID as sales FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate 
											AND c.companyID = :companyID
											AND p.referralMarketingTypeID IS NULL

											UNION

											SELECT e.evaluationID as sales FROM project as p
											JOIN customer as c on p.customerID = c.customerID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate 
											AND c.companyID = :companyID
											AND p.referralMarketingTypeID IS NULL) as t ");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnSales = $row['sales'];
					}
					$results = $returnSales;
				} 
			}
			return $results; 
		}

		public function getTotalMarketingCostsForSource($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT SUM(spendAmount) as spendAmount, t.marketingTypeName FROM marketingSpend as s
					LEFT JOIN marketingType as t on t.marketingTypeID = s.marketingTypeID
					WHERE t.companyID = :companyID
					AND t.parentMarketingTypeID = :marketingTypeID 
					AND s.startDate <=  :endDate
					AND s.endDate >=  :startDate");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCosts = $row['spendAmount'];
					}
					$results = $returnCosts;
				} 
			}
			return $results; 
		}

		public function getTotalMarketingCostsForSubsource($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT SUM(spendAmount) as spendAmount, t.marketingTypeName FROM marketingSpend as s
					LEFT JOIN marketingType as t on t.marketingTypeID = s.marketingTypeID
					WHERE t.companyID = :companyID
					AND t.marketingTypeID = :marketingTypeID 
					AND s.startDate <=  :endDate
					AND s.endDate >=  :startDate");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCosts = $row['spendAmount'];
					}
					$results = $returnCosts;
				} 
			}
			return $results; 
		}

		public function getLeadsForSource($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as leads FROM project as p
											JOIN marketingType as t
											ON p.referralMarketingTypeID = t.marketingTypeID
											WHERE (t.marketingTypeID = :marketingTypeID 
											OR t.parentMarketingTypeID = :marketingTypeID) 
											AND p.projectAdded >= :startDate 
											AND p.projectAdded <= :endDate ");

				//write parameter query to avoid sql injections
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnLeads = $row['leads'];
					}
					$results = $returnLeads;
				} 
			}
			return $results; 
		}

		public function getLeadsForUnspecified($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as leads FROM project as p
											JOIN marketingType as t
											ON p.referralMarketingTypeID = t.marketingTypeID
											WHERE t.marketingTypeID = :marketingTypeID 
											AND p.projectAdded >= :startDate 
											AND p.projectAdded <= :endDate ");

				//write parameter query to avoid sql injections
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnLeads = $row['leads'];
					}
					$results = $returnLeads;
				} 
			}
			return $results; 
		}

		public function getAppointmentsForSource($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as appointments FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN projectSchedule as s ON p.projectID = s.projectID
											WHERE (t.marketingTypeID = :marketingTypeID
											OR t.parentMarketingTypeID = :marketingTypeID) 
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate 
											AND s.scheduleType = 'Evaluation' 
											AND s.cancelledDate IS NULL ");

				//write parameter query to avoid sql injections
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnAppointments = $row['appointments'];
					}
					$results = $returnAppointments;
				} 
			}
			return $results; 
		}

		public function getAppointmentsForUnspecified($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as appointments FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN projectSchedule as s ON p.projectID = s.projectID
											WHERE t.marketingTypeID = :marketingTypeID
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate 
											AND s.scheduleType = 'Evaluation' 
											AND s.cancelledDate IS NULL ");

				//write parameter query to avoid sql injections
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnAppointments = $row['appointments'];
					}
					$results = $returnAppointments;
				} 
			}
			return $results; 
		}

		public function getBidsForSource($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as bids FROM (SELECT e.evaluationID as bids FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											WHERE (t.marketingTypeID = :marketingTypeID
											OR t.parentMarketingTypeID = :marketingTypeID) 
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL

											UNION

											SELECT e.evaluationID as bids FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											WHERE (t.marketingTypeID = :marketingTypeID
											OR t.parentMarketingTypeID = :marketingTypeID) 
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL) as t");

				//write parameter query to avoid sql injections
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnBids = $row['bids'];
					}
					$results = $returnBids;
				} 
			}
			return $results; 
		}

		public function getBidsForUnspecified($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as bids FROM (SELECT e.evaluationID as bids FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											WHERE t.marketingTypeID = :marketingTypeID 
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL

											UNION

											SELECT e.evaluationID as bids FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											WHERE t.marketingTypeID = :marketingTypeID 
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL) as t
											");

				//write parameter query to avoid sql injections
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnBids = $row['bids'];
					}
					$results = $returnBids;
				} 
			}
			return $results; 
		}

		public function getSalesForSource($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as sales FROM (SELECT e.evaluationID as sales FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											WHERE (t.marketingTypeID = :marketingTypeID
											OR t.parentMarketingTypeID = :marketingTypeID) 
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL

											UNION

											SELECT e.evaluationID as sales FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											WHERE (t.marketingTypeID = :marketingTypeID
											OR t.parentMarketingTypeID = :marketingTypeID) 
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL) as t");

				//write parameter query to avoid sql injections
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnSales = $row['sales'];
					}
					$results = $returnSales;
				} 
			}
			return $results; 
		}

		public function getSalesForUnspecified($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT COUNT(*) as sales FROM (SELECT e.evaluationID as sales FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											WHERE t.marketingTypeID = :marketingTypeID 
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL

											UNION

											SELECT e.evaluationID as sales FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											WHERE t.marketingTypeID = :marketingTypeID 
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL) as t
											");

				//write parameter query to avoid sql injections
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnSales = $row['sales'];
					}
					$results = $returnSales;
				} 
			}
			return $results; 
		}

		public function getGrossSalesForSource($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT SUM(bidTotal) as grossSales FROM (SELECT b.bidTotal FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											WHERE (t.marketingTypeID = :marketingTypeID
											OR t.parentMarketingTypeID = :marketingTypeID) 
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL

											UNION ALL

											SELECT b.bidTotal FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											WHERE (t.marketingTypeID = :marketingTypeID
											OR t.parentMarketingTypeID = :marketingTypeID) 
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL) as t");

				//write parameter query to avoid sql injections
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnGrossSales = $row['grossSales'];
					}
					$results = $returnGrossSales;
				} 
			}
			return $results; 
		}

		public function getGrossSalesForUnspecified($marketingTypeID) {
			$results = NULL;
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("SELECT SUM(bidTotal) as grossSales FROM (SELECT b.bidTotal FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID
											WHERE t.marketingTypeID = :marketingTypeID
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL

											UNION

											SELECT b.bidTotal FROM project as p
											JOIN marketingType as t ON p.referralMarketingTypeID = t.marketingTypeID
											JOIN evaluation as e ON p.projectID = e.projectID
											JOIN customBid AS b ON e.evaluationID = b.evaluationID
											WHERE t.marketingTypeID = :marketingTypeID
											AND p.projectAdded >= :startDate
											AND p.projectAdded <= :endDate
											AND b.bidFirstSent IS NOT NULL
											AND b.bidRejected IS NULL
											AND b.bidAccepted IS NOT NULL) as t");

				//write parameter query to avoid sql injections
				$st->bindParam(':marketingTypeID', $marketingTypeID);
				$st->bindParam(':startDate', $this->startDate);
				$st->bindParam(':endDate', $this->endDate);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnGrossSales = $row['grossSales'];
					}
					$results = $returnGrossSales;
				} 
			}
			return $results; 
		}

		public function getMarketingSources() {
	      if (!empty($this->companyID)) {
	        $st = $this->db->prepare("SELECT * FROM `marketingType` WHERE parentMarketingTypeID IS NULL AND isDeleted IS NULL AND companyID = :companyID");
	        $st->bindParam(':companyID', $this->companyID);   
	        $st->execute();
	        
	        if ($st->rowCount()>=1) {
	          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
	            $sources[] = $row;
	          }
	          foreach ($sources as $source) {
	          	$marketingTypeID = $source['marketingTypeID'];
	          	$marketingTypeName = $source['marketingTypeName'];
	          	$cost = $this->getTotalMarketingCostsForSource($marketingTypeID);
	          	$leads = $this->getLeadsForSource($marketingTypeID);
	          	$appointments = $this->getAppointmentsForSource($marketingTypeID);
	          	$bids = $this->getBidsForSource($marketingTypeID);
	          	$sales = $this->getSalesForSource($marketingTypeID);
	          	$grossSales = $this->getGrossSalesForSource($marketingTypeID);
	          	$subsourceArray = $this->getMarketingSubsources($marketingTypeID, $marketingTypeName);
	          	$returnSources[] = array('spendAmount' => $cost, 'marketingTypeID' => $marketingTypeID, 'marketingTypeName' => $marketingTypeName, 'leads' => $leads, 'appointments' => $appointments, 'bids' => $bids, 'sales' => $sales, 'grossSales' => $grossSales, 'subsources' => $subsourceArray, 'unspecified' => false);
	          }
	          $this->results = $returnSources;
	        } 
	      } 
		}

		public function getMarketingSubsources($parentMarketingTypeID, $parentMarketingTypeName) {
			$results = NULL;
	      if (!empty($this->companyID)) {
	        $st = $this->db->prepare("SELECT * FROM `marketingType` WHERE parentMarketingTypeID = :parentMarketingTypeID AND isDeleted IS NULL AND companyID = :companyID");
	        $st->bindParam(':companyID', $this->companyID);   
	        $st->bindParam(':parentMarketingTypeID', $parentMarketingTypeID);   
	        $st->execute();
	        
	        if ($st->rowCount()>=1) {
	          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
	            $subsources[] = $row;
	          }

	          foreach ($subsources as $subsource) {
	          	$marketingTypeID = $subsource['marketingTypeID'];
	          	$marketingTypeName = $subsource['marketingTypeName'];
	          	$cost = $this->getTotalMarketingCostsForSubsource($marketingTypeID);
	          	$leads = $this->getLeadsForSource($marketingTypeID);
	          	$appointments = $this->getAppointmentsForSource($marketingTypeID);
	          	$bids = $this->getBidsForSource($marketingTypeID);
	          	$sales = $this->getSalesForSource($marketingTypeID);
	          	$grossSales = $this->getGrossSalesForSource($marketingTypeID);
	          	$returnSubsources[] = array('spendAmount' => $cost, 'marketingTypeID' => $marketingTypeID, 'marketingTypeName' => $marketingTypeName, 'leads' => $leads, 'appointments' => $appointments, 'bids' => $bids, 'sales' => $sales, 'grossSales' => $grossSales, 'unspecified' => false);
	          }

			$unspecified = array('marketingTypeID' => $parentMarketingTypeID, 'marketingTypeName' => 'Unspecified ' . $parentMarketingTypeName);
			$marketingTypeID = $unspecified['marketingTypeID'];
			$marketingTypeName = $unspecified['marketingTypeName'];
			$cost = $this->getTotalMarketingCostsForSource($marketingTypeID);
			$leads = $this->getLeadsForUnspecified($marketingTypeID);
			$appointments = $this->getAppointmentsForUnspecified($marketingTypeID);
			$bids = $this->getBidsForUnspecified($marketingTypeID);
			$sales = $this->getSalesForUnspecified($marketingTypeID);
			$grossSales = $this->getGrossSalesForUnspecified($marketingTypeID);
			$returnSubsources[] = array('spendAmount' => $cost, 'marketingTypeID' => $marketingTypeID, 'marketingTypeName' => $marketingTypeName, 'leads' => $leads, 'appointments' => $appointments, 'bids' => $bids, 'sales' => $sales, 'grossSales' => $grossSales, 'unspecified' => true);

	          $results = $returnSubsources;
	        } 
	      } 
	      return $results; 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>