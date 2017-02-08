<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_GetAllCrewmen.php');

	include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 

	class Time {
		private $hours;
		private $minutes;

		public function __construct() {
			$this->hours = 0;
			$this->minutes = 0;
		}

		public function setHours($hours){
			$this->hours = $hours;
		}

		public function setMinutes($minutes){
			$this->minutes = $minutes;
		}

		public function getHours(){
			return $this->hours;
		}

		public function getMinutes(){
			return $this->minutes;
		}

		public function add($time1, $time2){
			$hours = $time1->getHours() + $time2->getHours();
			$minutes = $time1->getMinutes() + $time2->getMinutes();

			if (floor($minutes / 60) > 0){
				$hours += floor($minutes / 60);
				$minutes = $minutes % 60;
			}
			return sprintf("%02d", $hours) . ':' . sprintf("%02d", $minutes);
		}
	}

	function convertTime($time){
		return explode(':', $time);
	}

	function addTime($stringTime1, $stringTime2){
		$time1 = new Time();
		$timeArray1 = convertTime($stringTime1);
		$time1->setHours($timeArray1[0]);
		$time1->setMinutes($timeArray1[1]);

		$time2 = new Time();
		$timeArray2 = convertTime($stringTime2);
		$time2->setHours($timeArray2[0]);
		$time2->setMinutes($timeArray2[1]);

		$total = new Time();

		return($total->add($time2, $time1));
	}

	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$timecardApprover = $userArray['timecardApprover'];
	
		if(isset($_POST['weekStart'])) {
			 $weekStart = filter_input(INPUT_POST, 'weekStart', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		
		if(isset($_POST['weekEnd'])) {
			 $weekEnd = filter_input(INPUT_POST, 'weekEnd', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}	

		if(isset($_POST['sort'])) {
			 $sort = filter_input(INPUT_POST, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		else{
			$sort = "last";
		}

		if(isset($_POST['active'])) {
			 $active = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_NUMBER_INT);
		}
		else{
			$active = 1;
		}		

	// if ($primary == 1 || $projectManagement == 1 || $timecardApprover) {

		$object = new GetCrewmen();
		$object->setCompanyID($companyID);
		$object->setWeekStart($weekStart);
		$object->setWeekEnd($weekEnd);
		$object->setActive($active);
		$object->getCrewmen();
		$punchTimes = $object->getResults();

		$crewmen = array();
		$firstNames = array();
		$lastNames = array();
		if ($punchTimes != "false"){
			foreach ($punchTimes as $timeEntry ) {
				$crewmanID = $timeEntry['crewmanID'];
				$crewmanName = $timeEntry['crewmanName'];
				$firstName = $timeEntry['firstName'];
				$lastName = $timeEntry['lastName'];
				$date = $timeEntry['timecardDate'];
				$time = $timeEntry['time'];
				$inTime = $timeEntry['inTime'];
				$outTime = $timeEntry['outTime'];
				$invalidTime = false;
				if (empty($time)){
					$time = '00:00:00';
				}
				$approved = $timeEntry['approvedDT'];
			    if (!empty($crewmen[$crewmanID])) {
				    if (!empty($crewmen[$crewmanID]['days'][$date])) {
				    	$crewmen[$crewmanID]['days'][$date] = addTime($crewmen[$crewmanID]['days'][$date], $time);
				    	$crewmen[$crewmanID]['sum'] = addTime($crewmen[$crewmanID]['sum'], $time);
				    }
				    else{
						$crewmen[$crewmanID]['days'][$date] = $time;
						$crewmen[$crewmanID]['sum'] = addTime($crewmen[$crewmanID]['sum'], $time);
						$crewmen[$crewmanID]['approved'][$date] = $approved;
				    }
			    }
			    else{
					$firstNames[] = strtolower($firstName);
			    	$lastNames[] = strtolower($lastName);
			    	$crewmen[$crewmanID] = array('crewmanName' => $crewmanName, 'crewmanID' => $crewmanID, 'days' => array($date => $time), 'sum' => $time, 'approved' => array($date => $approved));
			    }
				if (empty($outTime) && !empty($inTime) && !empty($time)){
					$crewmen[$crewmanID]['invalidTime'][$date] = $invalidTime;
				}
			}

			if ($sort == "first"){
				array_multisort($firstNames, SORT_ASC, $crewmen);
			}

			if ($sort == "last"){
				array_multisort($lastNames, SORT_ASC, $crewmen);
			}
		}
		else{ //no crewmen
			$crewmen = null;
		}

		echo json_encode($crewmen);
	// }

?>