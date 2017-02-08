<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Metrics {
		
		private $db;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
			
		public function setMetrics($companyID) {
			$this->companyID = $companyID;
		}	
			
			
		public function getMetrics() {
			
			if (!empty($this->companyID)) {
				
				
				$st = $this->db->prepare("SELECT sales, projectSalesperson, COUNT(count) as count, calendarBgColor FROM 
					((SELECT p.projectSalesperson,  CONCAT( u.userFirstName,' ', u.userLastName) AS sales, p.projectSalesperson AS count, u.calendarBgColor

						FROM `evaluationBid` AS b

						LEFT JOIN evaluation AS e ON e.evaluationID = b.evaluationID
						LEFT JOIN project AS p ON p.projectID = e.projectID
							AND p.projectSalesperson IS NOT NULL
						LEFT JOIN user AS u ON u.userID = p.projectSalesperson
						LEFT JOIN property AS t ON t.propertyID = p.propertyID
						LEFT JOIN customer AS c ON c.customerID = t.customerID

						WHERE 

						c.companyID = :companyID AND
						b.bidFirstSent IS NOT NULL AND
						b.bidAccepted IS NULL AND
						b.bidRejected IS NULL)

						UNION ALL	

					(SELECT p.projectSalesperson,  CONCAT( u.userFirstName,' ', u.userLastName) AS sales, 'unspecified' AS count, u.calendarBgColor

						FROM `evaluationBid` AS b

						LEFT JOIN evaluation AS e ON e.evaluationID = b.evaluationID
						LEFT JOIN project AS p ON p.projectID = e.projectID
							AND p.projectSalesperson IS NULL
						LEFT JOIN user AS u ON u.userID = p.projectSalesperson
						LEFT JOIN property AS t ON t.propertyID = p.propertyID
						LEFT JOIN customer AS c ON c.customerID = t.customerID

						WHERE 

						c.companyID = :companyID AND
						b.bidFirstSent IS NOT NULL AND
						b.bidAccepted IS NULL AND
						b.bidRejected IS NULL)	

						UNION ALL

					(SELECT p.projectSalesperson,  CONCAT( u.userFirstName,' ', u.userLastName) AS sales, p.projectSalesperson AS count, u.calendarBgColor

						FROM `customBid` AS b

						LEFT JOIN evaluation AS e ON e.evaluationID = b.evaluationID
						LEFT JOIN project AS p ON p.projectID = e.projectID
							AND p.projectSalesperson IS NOT NULL
						LEFT JOIN user AS u ON u.userID = p.projectSalesperson
						LEFT JOIN property AS t ON t.propertyID = p.propertyID
						LEFT JOIN customer AS c ON c.customerID = t.customerID

						WHERE 

						c.companyID = :companyID AND
						b.bidFirstSent IS NOT NULL AND
						b.bidAccepted IS NULL AND
						b.bidRejected IS NULL) 

						UNION ALL

					(SELECT p.projectSalesperson,  CONCAT( u.userFirstName,' ', u.userLastName) AS sales, 'unspecified' AS count, u.calendarBgColor

						FROM `customBid` AS b

						LEFT JOIN evaluation AS e ON e.evaluationID = b.evaluationID
						LEFT JOIN project AS p ON p.projectID = e.projectID
							AND p.projectSalesperson IS NULL
						LEFT JOIN user AS u ON u.userID = p.projectSalesperson
						LEFT JOIN property AS t ON t.propertyID = p.propertyID
						LEFT JOIN customer AS c ON c.customerID = t.customerID

						WHERE 

						c.companyID = :companyID AND
						b.bidFirstSent IS NOT NULL AND
						b.bidAccepted IS NULL AND
						b.bidRejected IS NULL)

						) as eval

				GROUP BY projectSalesperson ASC
				");
				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);		
							
				$st->execute();
				
				if ($st->rowCount()>=1) {

					$rows = array();

					$table = array();
					$table['cols'] = array(

					    // Labels for your chart, these represent the column titles
					    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
					    array('label' => 'Salesperson', 'type' => 'string'),
					    array('label' => 'Open Bids', 'type' => 'number'),
					    array('type' => 'string', 'p' => array('role' => 'style')),

					);

					$rows = array();
					while($row = $st->fetch((PDO::FETCH_ASSOC))) {
					    $temp = array();
					    // the following line will be used to slice the Pie chart
					    if (empty($row['sales'])) {
					    	$temp[] = array('v' => 'Unspecified Salesperson'); 
					    } else {
					    	$temp[] = array('v' => (string) $row['sales']); 
					    }

					    // Values of each slice
					    $temp[] = array('v' => (int) $row['count']); 
					    if (empty($row['sales'])) {
					    	$temp[] = array('v' => (string) "color: #000000"); 
					    } else {
					    	$temp[] = array('v' => (string) "color: ".$row['calendarBgColor']); 
					    }
					    
					    $rows[] = array('c' => $temp);
					}

					$table['rows'] = $rows;

					$data = array();

					$data['data'] = $table;

					$data['title'] = 'Open Bids Per Salesman';

					$this->results = $data;

				} 
				
			} 
		}
		
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>