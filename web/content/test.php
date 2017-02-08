<?php
	$todaysDateTime = date("Y-m-d H:i:s");
			$todaysDateTime = new DateTime();

			
	$todaysDate = date("Y-m-d");
		
	$time = new DateTime('2016-12-28 14:00:00');
	$daysAgo = $todaysDateTime->diff($time);

	$daysAgo = $daysAgo->format("%a"); 

	//var_dump($daysAgo);

	if ($daysAgo == 0) {
		$thisTime = date('Y-m-d', strtotime('2016-12-28 14:00:00')); 


		if ($todaysDate == $thisTime) {
			echo 'Appointment is today'; 
		} else {
			echo 'Appointment is tomorrow'; 
		}
	}
	
				
?>