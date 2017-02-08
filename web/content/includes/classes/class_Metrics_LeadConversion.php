<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Metrics {
		
		private $db;
		private $companyID;
		private $dateFrom;
		private $dateTo;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
			
		public function setMetrics($companyID, $dateFrom, $dateTo) {
			$this->companyID = $companyID;
			$this->dateFrom = $dateFrom;
			$this->dateTo = strtotime($dateTo);
			$this->dateTo = strtotime("+1 day", $this->dateTo);

			$this->dateTo = date('Y-m-d', $this->dateTo);
		}
			
		public function getMetrics() {
			
			if (!empty($this->companyID)) {
				
				
				$st = $this->db->prepare("SELECT sales, COUNT(sent) as sent, SUM(ISNULL(sold)) as sold, calendarBgColor FROM 
					((SELECT p.projectSalesperson, CONCAT( u.userFirstName,' ', u.userLastName) AS sales, bidFirstSent AS sent, bidAccepted AS sold, u.calendarBgColor

					FROM `evaluationBid` AS b

					LEFT JOIN evaluation AS e ON e.evaluationID = b.evaluationID
					LEFT JOIN project AS p ON p.projectID = e.projectID
					LEFT JOIN user AS u ON u.userID = p.projectSalesperson
					LEFT JOIN property AS t ON t.propertyID = p.propertyID
					LEFT JOIN customer AS c ON c.customerID = t.customerID

					WHERE 

					c.companyID = :companyID AND
					b.bidFirstSent >= :dateFrom AND b.bidFirstSent < :dateTo)

					UNION ALL

					(SELECT p.projectSalesperson, CONCAT( u.userFirstName,' ', u.userLastName) AS sales, bidFirstSent AS sent, bidAccepted AS sold, u.calendarBgColor

					FROM `customBid` AS b

					LEFT JOIN evaluation AS e ON e.evaluationID = b.evaluationID
					LEFT JOIN project AS p ON p.projectID = e.projectID
					LEFT JOIN user AS u ON u.userID = p.projectSalesperson
					LEFT JOIN property AS t ON t.propertyID = p.propertyID
					LEFT JOIN customer AS c ON c.customerID = t.customerID

					WHERE 

					c.companyID = :companyID AND
					b.bidFirstSent >= :dateFrom AND b.bidFirstSent < :dateTo)) as eval

					GROUP BY projectSalesperson ASC
				");
				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);		
				$st->bindParam(':dateFrom', $this->dateFrom);		
				$st->bindParam(':dateTo', $this->dateTo);	
							
				$st->execute();
				
				if ($st->rowCount()>=1) {

					$rows = array();

					$table = array();
					$table['cols'] = array(

					    // Labels for your chart, these represent the column titles
					    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
					    array('label' => 'Salesperson', 'type' => 'string'),
					    array('label' => 'Lead Conversion', 'type' => 'number'),
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

					    $leadConversion = ((int) $row['sold'])/((int) $row['sent']);
					    $leadConversion *= 100;

					    // Values of each slice
					    $temp[] = array('v' => round($leadConversion, 2)); 
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

					$data['title'] = 'Lead Conversion %';

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