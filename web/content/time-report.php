<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}

	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;
		
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

	function clean($string) {
	   $string = str_replace(' ', '', $string); // Replaces all spaces
	   $string = preg_replace('/[^A-Za-z\-]/', '', $string); // Removes special chars and numbers

	   return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
	}

	function getWeek($week, $year){
		$thisWeek = null;

		for($day=1; $day<=7; $day++){
			$date = date('Y-m-d', strtotime($year."W".$week.$day));
		    $thisWeek[$date] = '00:00';
		}
		return $thisWeek;
	}

	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$userFirstName = $userArray['userFirstName'];
		$userLastName = $userArray['userLastName'];
		$userPhoneDirect = $userArray['userPhoneDirect'];
		$userPhoneCell = $userArray['userPhoneCell'];
		$userEmail = $userArray['userEmail'];
		$primary = $userArray['primary'];
		$timecardApprover = $userArray['timecardApprover'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$calendarBgColor = $userArray['calendarBgColor'];
		$userPhoto = $userArray['userPhoto'];

	//Get Company Info
	include_once('includes/classes/class_Company.php');
		
		$object = new Company();
		$object->setCompany($companyID);
		$object->getCompany();
		$companyArray = $object->getResults();		
		
		//Company
		$companyID = $companyArray['companyID'];
		$companyName = $companyArray['companyName'];
		$companyAddress1 = $companyArray['companyAddress1'];
		$companyAddress2 = $companyArray['companyAddress2'];
		$companyCity = $companyArray['companyCity'];
		$companyState = $companyArray['companyState'];
		$companyZip = $companyArray['companyZip'];
		$companyWebsite = $companyArray['companyWebsite'];
		$companyLogo = $companyArray['companyLogo'];
		$companyColor = $companyArray['companyColor'];
		$companyColorHover = $companyArray['companyColorHover'];
		$companyEmailAddCustomer = $companyArray['companyEmailAddCustomer'];
		$companyEmailSchedule = $companyArray['companyEmailSchedule'];
		$companyEmailFrom = $companyArray['companyEmailFrom'];
		$companyEmailReply = $companyArray['companyEmailReply'];
		
		if(isset($_GET['week'])) {
			 $week = filter_input(INPUT_GET, 'week', FILTER_SANITIZE_NUMBER_INT);
			 //For some reason, full calendar's week numbers start at 1  
			 //and end at 53, and this was offsetting the dates by a week.
			 $week = $week - 1;
		}

		if(isset($_GET['year'])) {
			 $year = filter_input(INPUT_GET, 'year', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		$table = null;
		$thisWeek = null;
		$formattedDays = null;
		$day1 = null;
		$day7 = null;
		$weekStart = null;
		$weekEnd = null;

		for($day = 1; $day <= 7; $day++){
			if ($day == 1){
				$day1 = date('F d', strtotime($year."W".$week.$day));
				$weekStart = date('Y-m-d', strtotime($year."W".$week.$day));
			}
			if ($day == 7){
				$day7 = date('F d', strtotime($year."W".$week.$day));
				$weekEnd = date('Y-m-d', strtotime($year."W".$week.$day));
			}
			$date = date('Y-m-d', strtotime($year."W".$week.$day));
			$formattedDays[] = date('d-M', strtotime($year."W".$week.$day));
		    $thisWeek[$date] = '00:00';
		}

		$weekRangeDisplay = $day1 . ' - ' . $day7;

		include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_GetAllCrewmen.php');	

		if ($primary == 1 || $timecardApprover ==  1) {

			$object = new GetCrewmen();
			$object->setCompanyID($companyID);
			$object->setWeekStart($weekStart);
			$object->setWeekEnd($weekEnd);
			$object->setActive(1);
			$object->getCrewmenApproved();
			$punchTimes = $object->getResults();

			$crewmen = array();
			if ($punchTimes != "false"){
				foreach ($punchTimes as $timeEntry ) {
					$crewmanID = $timeEntry['crewmanID'];
					$crewmanName = $timeEntry['crewmanName'];
					$firstName = $timeEntry['firstName'];
					$lastName = $timeEntry['lastName'];
					$date = $timeEntry['timecardDate'];
					$time = $timeEntry['time'];
					if (empty($time)){
						$time = '00:00';
					}
					else{
						$time = substr($time, 0, -3);
					}
				    if (!empty($crewmen[$crewmanID])) {
					    if (!empty($crewmen[$crewmanID]['days'][$date])) {
					    	$crewmen[$crewmanID]['days'][$date] = addTime($crewmen[$crewmanID]['days'][$date], $time);
					    	$crewmen[$crewmanID]['sum'] = addTime($crewmen[$crewmanID]['sum'], $time);
					    }
					    else{
							$crewmen[$crewmanID]['days'][$date] = $time;
							$crewmen[$crewmanID]['sum'] = addTime($crewmen[$crewmanID]['sum'], $time);
					    }
				    }
				    else{
				    	$firstNames[] = strtolower($firstName);
				    	$lastNames[] = strtolower($lastName);
				    	$crewmen[$crewmanID] = array('crewmanName' => $crewmanName, 'crewmanID' => $crewmanID, 'days' => array($date => $time), 'sum' => $time);
				    }
				}
			}
			if (!empty($crewmen)){
				array_multisort($lastNames, SORT_ASC, $crewmen);
			}

			foreach ($crewmen as $crewman) {
				$thisWeek = getWeek($week, $year);
				$row = '<tr class="crewTimes"><td class="leftColumn">' .$crewman['crewmanName']. '</td>';
				$index = 0;
                $sum = $crewman['sum'];
                $total = '<td class="time">' . $sum . '</td>';
                if ($sum == null){
                	$total = '<td class="time">00:00</td>';
                }
                $days = $crewman['days'];

                if ($sum == null){
                    $sum = '00:00';
                }

                foreach ($days as $day => $time) {

                	if ($day != null){
                		$thisWeek[$day] = $time;
                	}              
                }

                foreach ($thisWeek as $day) {
                	if ($day == '00:00'){
                		$day = '';
                	}
                	$row .= '<td class="time">' . $day . '</td>';
                }

                $table .= $row . $total . '</tr>';
			}
		}

	
	$dompdf = new DOMPDF();
	
	$date =  date('F j, Y');

	$html =
		'<html>
	  	 	<style>
	  	 		body {
	  	 			font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	  	 		}

				table {
					border-collapse: collapse;
					border: 1px solid black;
				}

				tr:nth-child(even) {
					background: #eeeeee
				}

				tr:nth-child(odd) {
					background: #ffffff
				}

				table td {
					border: 1px solid black;
				}

				.title {
					text-align: center;
				}

				.weekRange {
					text-align: center;
					margin-bottom: 0;
				}

				.topRow td {
					height: 35px;
					vertical-align: top;
				}

				td.leftColumn  {
					text-align: left;
					padding-left:10px;
				}

				.tableTitle {
					padding-top:10px;
					padding-bottom:0px;
				}

				.day {
					text-align: center;
					padding-top:10px;
					padding-bottom:0px;
				}

				.time {
					text-align: center;
				}

				.crewTimes td {
					height: 25px;
				}
		  	</style>
		  	<h3 class="title">'.$companyName.' Weekly Timesheet</h3>
		  	<p class="weekRange">'. $weekRangeDisplay .'</p>
			<table width="100%">
			  	<tbody>
			    	<tr class="topRow">
			      		<td class="leftColumn tableTitle">Crewperson</td>

		      			<td class="day">'.$formattedDays[0].'</td>

			      		<td class="day">'.$formattedDays[1].'</td>

			      		<td class="day">'.$formattedDays[2].'</td>

			      		<td class="day">'.$formattedDays[3].'</td>

			      		<td class="day">'.$formattedDays[4].'</td>

			      		<td class="day">'.$formattedDays[5].'</td>

			      		<td class="day">'.$formattedDays[6].'</td>

			      		<td class="day">Total</td>
			    	</tr>
			    	'.$table.'
			  	</tbody>
			</table>
		</html>';
		
	$dompdf->load_html($html);
	$dompdf->set_paper('letter', 'landscape');
	$dompdf->render();

	$dompdf->stream('Timesheet-' . $weekStart . '_' . $weekEnd);//Direct Download
	// $dompdf->stream($firstName.'-'.$lastName.'-Timesheet-Report',array('Attachment'=>0));//Display in Browser	

?>