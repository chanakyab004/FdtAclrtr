<?php
	$userID = NULL;

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	} 


	if ($userID != '') {
		include_once('includes/classes/class_User.php');

		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();

		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
	} else {
		if(isset($_GET['id'])) {
			$bidID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		include_once('includes/classes/class_FindEvaluation.php');
		
			$object = new Bid();
			$object->setBid($bidID);
			$object->getEvaluation();
			$bidArray = $object->getResults();	
		
			//Find Evaluation
			$evaluationID = $bidArray['evaluationID'];
			$companyID = $bidArray['companyID'];
			$customEvaluation = $bidArray['customEvaluation'];
			
		// session_start();

		// if(isset($_SESSION["companyID"])) {
		// 	$companyID = $_SESSION['companyID'];
		// }

	}


	include_once 'settings.php';
	$qbToken = QUICKBOOKS_TOKEN;
	$qbKey = QUICKBOOKS_KEY;
	$qbSecret = QUICKBOOKS_SECRET;
	$severRole = SERVER_ROLE;
	$qbDSN = QUICKBOOKS_DSN;
	$root = EMAIL_ROOT;

/**
 * Intuit Partner Platform configuration variables
 * 
 * See the scripts that use these variables for more details. 
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Turn on some error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Require the library code
require_once dirname(__FILE__) . '/QuickBooks.php';

// Your application token (Intuit will give you this when you register an Intuit Anywhere app)
$token = $qbToken;

// Your OAuth consumer key and secret (Intuit will give you both of these when you register an Intuit app)
// 
// IMPORTANT:
//	To pass your tech review with Intuit, you'll have to AES encrypt these and 
//	store them somewhere safe. 
// 
// The OAuth request/access tokens will be encrypted and stored for you by the 
//	PHP DevKit IntuitAnywhere classes automatically. 
$oauth_consumer_key = $qbKey;
$oauth_consumer_secret = $qbSecret;

// If you're using DEVELOPMENT TOKENS, you MUST USE SANDBOX MODE!!!  If you're in PRODUCTION, then DO NOT use sandbox.
//$sandbox = true;     // When you're using development tokens
//$sandbox = false;    // When you're using production tokens

	if ($severRole == 'PROD') {
		$sandbox = false; 
	} else {
		$sandbox = true;
	}

	// This is the URL of your OAuth auth handler page
	if ($severRole == 'PROD') {
		$quickbooks_oauth_url = 'https://www.fxlratr.com/qb-oauth.php';
	} else {
		$quickbooks_oauth_url = $root.'/qb-oauth.php';
	}

	// This is the URL to forward the user to after they have connected to IPP/IDS via OAuth
	if ($severRole == 'PROD') {
		$quickbooks_success_url = 'https://www.fxlratr.com/qb-success.php';
	} else {
		$quickbooks_success_url = $root.'/qb-success.php';
	}

	// This is the menu URL script 
	if ($severRole == 'PROD') {
		$quickbooks_menu_url = 'https://www.fxlratr.com/qb-menu.php';
	} else {
		$quickbooks_menu_url = $root.'/qb-menu.php';
	}


// This is a database connection string that will be used to store the OAuth credentials 
// $dsn = 'pgsql://username:password@hostname/database';
// $dsn = 'mysql://username:password@hostname/database';
$dsn = $qbDSN;		

// You should set this to an encryption key specific to your app
$encryption_key = 'styles91';

// Do not change this unless you really know what you're doing!!!  99% of apps will not require a change to this.
$the_username = 'DO_NOT_CHANGE_ME';

// The tenant that user is accessing within your own app
$the_tenant = $companyID;

// Initialize the database tables for storing OAuth information
if (!QuickBooks_Utilities::initialized($dsn))
{
	// Initialize creates the neccessary database schema for queueing up requests and logging
	QuickBooks_Utilities::initialize($dsn);
}

// Instantiate our Intuit Anywhere auth handler 
// 
// The parameters passed to the constructor are:
//	$dsn					
//	$oauth_consumer_key		Intuit will give this to you when you create a new Intuit Anywhere application at AppCenter.Intuit.com
//	$oauth_consumer_secret	Intuit will give this to you too
//	$this_url				This is the full URL (e.g. http://path/to/this/file.php) of THIS SCRIPT
//	$that_url				After the user authenticates, they will be forwarded to this URL
// 
$IntuitAnywhere = new QuickBooks_IPP_IntuitAnywhere($dsn, $encryption_key, $oauth_consumer_key, $oauth_consumer_secret, $quickbooks_oauth_url, $quickbooks_success_url);

// Are they connected to QuickBooks right now? 
if ($IntuitAnywhere->check($the_username, $the_tenant) and 
	$IntuitAnywhere->test($the_username, $the_tenant))
{
	// Yes, they are 
	$quickbooks_is_connected = true;

	// Set up the IPP instance
	$IPP = new QuickBooks_IPP($dsn);

	// Get our OAuth credentials from the database
	$creds = $IntuitAnywhere->load($the_username, $the_tenant);

	// Tell the framework to load some data from the OAuth store
	$IPP->authMode(
		QuickBooks_IPP::AUTHMODE_OAUTH, 
		$the_username, 
		$creds);

	if ($sandbox) {
		// Turn on sandbox mode/URLs 
		$IPP->sandbox(true);
	}

	// Print the credentials we're using
	//print_r($creds);

	// This is our current realm
	$realm = $creds['qb_realm'];

	// Load the OAuth information from the database
	$Context = $IPP->context();

	// Get some company info
	$CompanyInfoService = new QuickBooks_IPP_Service_CompanyInfo();
	$quickbooks_CompanyInfo = $CompanyInfoService->get($Context, $realm);
}
else
{
	// No, they are not
	$quickbooks_is_connected = false;
}