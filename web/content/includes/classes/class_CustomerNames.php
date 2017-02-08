<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class AllCustomers {
		
		private $db;
		private $companyID;
		private $keyword;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $keyword) {
			$this->companyID = $companyID;
			$this->keyword = '%'.$keyword.'%';
		}

			
		public function getCustomers() {
			
			if (!empty($this->companyID)) {
				
				$st = $this->db->prepare("(SELECT DISTINCT m.firstName, m.lastName, NULL as city, NULL as state, NULL as zip FROM customer AS m

                	LEFT JOIN company AS c ON c.companyID = m.companyID 
                
					WHERE 
					
					c.companyID=:companyID AND firstName LIKE :keyword OR 
                 	c.companyID=:companyID AND lastName LIKE :keyword)

					UNION ALL

					(SELECT DISTINCT t.address, t.address2, t.city, t.state, t.zip FROM customer AS m
					
					LEFT JOIN customerPhone AS p ON p.customerID = m.customerID 
	                LEFT JOIN company AS c ON c.companyID = m.companyID 
                    LEFT JOIN property AS t ON t.customerID = m.customerID
                
					WHERE 

					c.companyID=:companyID AND firstName LIKE :keyword OR 
 	                c.companyID=:companyID AND lastName LIKE :keyword	OR
 	                c.companyID=:companyID AND address LIKE :keyword	OR
 	                c.companyID=:companyID AND address2 LIKE :keyword) ");
				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':keyword', $this->keyword);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$allCustomers[] = $row;
						
					$this->results = $allCustomers; 
					
					}
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>