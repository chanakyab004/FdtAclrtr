<?php

	include "includes/include.php";

	if(isset($_GET['referralCode'])) {
		$referralCode = filter_input(INPUT_GET, 'referralCode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	include_once('includes/classes/class_ReferralName.php');
		
	$object = new Referral();
	$object->setReferralCode($referralCode);
	$object->getReferralName();
	$referralArray = $object->getResults();	

	echo json_encode($referralArray);

?>