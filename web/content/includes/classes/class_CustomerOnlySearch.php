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
			
      public function search($keyword){
        //Separate the keywords and append boolean operators to them.
        //Short words aren't considered, as full text search ignores them.
        $keywords = explode(" ", $keyword);
        $keyword = '';
        foreach ($keywords as $key) {
          if (trim($key) != ''){
            if (strlen($key) > 2){
              $key = '+'.$key.'* ';
              $keyword = $keyword.$key;
            }
          }
        }
        $keyword = trim($keyword);
        $this->keyword = $keyword;
      }

      public function searchEmail($keyword){
        //Full text search breaks on '@' symbol. 
        //To prevent this when searching emails, we need to wrap it in double quotes.
        $keyword = '"'.$keyword.'"';
        $this->keyword = $keyword;
      }

      public function setCompany($companyID, $keyword) {
        $this->companyID = $companyID;
        $this->search($keyword);
      }

			
		public function getCustomers() {
			
			if (!empty($this->companyID)) {
				
				$st = $this->db->prepare("
					SELECT m.customerID, m.firstName, m.lastName, m.ownerAddress, m.ownerAddress2, m.ownerCity, m.ownerState, m.ownerZip, m.email, p.phoneNumber FROM customer AS m
                         
                    LEFT JOIN customerPhone AS p ON p.customerID = m.customerID 
                    LEFT JOIN company AS c ON c.companyID = m.companyID 
                
                    WHERE c.companyID=:companyID AND p.isPrimary='1' AND MATCH(firstName, lastName) AGAINST (:keyword IN BOOLEAN MODE) 
				");

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