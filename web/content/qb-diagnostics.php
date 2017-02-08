<?php
include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();

	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}

header('Content-Type: text/plain');

require_once dirname(__FILE__) . '/includes/quickbooks-config.php';

$check = $IntuitAnywhere->check($the_username, $the_tenant);
$test = $IntuitAnywhere->test($the_username, $the_tenant);

$creds = $IntuitAnywhere->load($the_username, $the_tenant);

$diagnostics = array_merge(array(
	'check' => $check,
	'test' => $test,
	), (array) $creds);

print_r($diagnostics);