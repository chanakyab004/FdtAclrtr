<?php

	function convertDateTime($dateTime, $timezone, $daylightSavings) {

		$isDaylightSavings = date("I"); 

		if ($daylightSavings == 1 && $isDaylightSavings == 1) {

			$timezone = $timezone + 3600;
		}

		//$calculate = $timezone;

		return date('Y-m-d H:i:s', strtotime($dateTime) + $timezone);

	}

?>