<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_GetCrewmanTimeDetail.php');

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

		if(isset($_POST['crewmanID'])) {
			 $crewmanID = filter_input(INPUT_POST, 'crewmanID', FILTER_SANITIZE_NUMBER_INT);
		}

		if(isset($_POST['active'])) {
			 $active = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_NUMBER_INT);
		}
		else{
			$active = 1;
		}			

	// if ($primary == 1 || $projectManagement == 1 || $timecardApprover) {

		$object = new GetCrewmanTimeDetail();
		$object->setCompanyID($companyID);
		$object->setCrewmanID($crewmanID);
		$object->setWeekStart($weekStart);
		$object->setWeekEnd($weekEnd);
		$object->getCrewmanTimeDetail();
		$punchTimes = $object->getResults();

		$days = array();
		if(!empty($punchTimes)){
			foreach ($punchTimes as $timeEntry ) {
				$date = $timeEntry['timecardDate'];
				$time = $timeEntry['time'];
				$inTime = $timeEntry['inTime'];
				$outTime = $timeEntry['outTime'];
				$notes = $timeEntry['notes'];
				$approved = $timeEntry['approvedDT'];
				$crewmanName = $timeEntry['crewmanName'];
				if (empty($time)){
					$time = '00:00:00';
				}
				if(!empty($days['total'])){
				    if (!empty($days[$date])) {
				    	$days[$date]['punchTimes'][] = array('inTime' => $inTime, 'outTime' => $outTime, 'sum' => $time, 'notes' => $notes);
				    	if(substr($time, 0, 1) != '-'){
				    		$days[$date]['total'] = addTime($days[$date]['total'], $time);
				    		$days['total'] = addTime($days['total'], $time);
				    	}
				    }
				    else{
				    	$days[$date] = array('punchTimes' => array(array('inTime' => $inTime, 'outTime' => $outTime, 'sum' => $time, 'notes' => $notes)), 'total' => $time);
				    	$days['total'] = addTime($days['total'], $time);
				    	$days[$date]['approved'] = $approved;
				    }
				}
				else{
					$days[$date] = array('punchTimes' => array(array('inTime' => $inTime, 'outTime' => $outTime, 'sum' => $time, 'notes' => $notes)), 'total' => $time);
			    	$days['total'] = $time;
			    	$days[$date]['approved'] = $approved;
			    	$days['crewmanName'] = $crewmanName;
				}
			}
			$results = $days;
		}
		else{
			//just return name
			$object->getCrewmanName();
			$results = $object->getResults();
		}

		echo json_encode($results);
	// }

?>