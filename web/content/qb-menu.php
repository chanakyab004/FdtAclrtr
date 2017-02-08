<?php
include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();

	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}

require_once dirname(__FILE__) . '/includes/quickbooks-config.php';

// Display the menu
die($IntuitAnywhere->widgetMenu($the_username, $the_tenant));