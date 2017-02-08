<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';
	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}

	function clean($string) {
	   $string = str_replace(' ', '', $string); // Replaces all spaces
	   $string = preg_replace('/[^A-Za-z\-]/', '', $string); // Removes special chars and numbers

	   return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
	}

	if(isset($_POST['startDate'])) {
		$startDate = filter_input(INPUT_POST, 'startDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$startDate = date('Y-m-d', strtotime($startDate)) . ' 00:00:00'; //go all the way to end of the day, otherwise this defaults to 00:00:00 in the query
	}

	if(isset($_POST['endDate'])) {
		$endDate = filter_input(INPUT_POST, 'endDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$endDate = date('Y-m-d', strtotime($endDate)) . ' 23:59:59';
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
	$marketing = $userArray['marketing'];
	$sales = $userArray['sales'];
	$installation = $userArray['installation'];
	$bidVerification = $userArray['bidVerification'];
	$bidCreation = $userArray['bidCreation'];
	$pierDataRecorder = $userArray['pierDataRecorder'];
	$calendarBgColor = $userArray['calendarBgColor'];
	$userPhoto = $userArray['userPhoto'];

	function calculateSourceData($source, $leadsAll, $totalMarketingCostsAll, $isSubsource){
		$subsources = NULL;
		$sourceLeads = $source['leads'];
		$sourceAppointments = $source['appointments'];
		$sourceBids = $source['bids'];
		$sourceSales = $source['sales'];
		$sourceGrossSales = $source['grossSales'];
		$sourceMarketingCosts = $source['spendAmount'];
		$unspecified = $source['unspecified'];
		if (!$isSubsource){
			$subsources = $source['subsources'];
		}

		if ($unspecified){
			$sourceMarketingCosts = '0';
		}

		//Percent Total Marketing Costs = sourceMarketingCosts/totalMarketingCostsAll
		$percentTotalMarketingCosts = '0.00%';
		if (!empty($sourceMarketingCosts) && !(empty($totalMarketingCostsAll)) && !$unspecified){
			$percentTotalMarketingCosts = $sourceMarketingCosts/$totalMarketingCostsAll;
			$percentTotalMarketingCosts = sprintf("%.2f%%", $percentTotalMarketingCosts * 100); //format to two decimal places
		}

		//Percent Total Leads = sourceLeads/leadsAll
		$percentTotalLeads = '0.00%';
		if (!empty($sourceLeads) && !(empty($leadsAll))){
			$percentTotalLeads = $sourceLeads/$leadsAll;
			$percentTotalLeads = sprintf("%.2f%%", $percentTotalLeads * 100); //format to two decimal places
		}

		//Cost per lead = sourceMarketingCosts/sourceLeads
		$costPerLead = '0';
		if (!empty($sourceLeads) && !(empty($sourceMarketingCosts))){
			$costPerLead = $sourceMarketingCosts/$sourceLeads;
		}

		//Cost Per Sale = sourceMarketingCosts/sourceSales
		$costPerSale = '0';
		if (!empty($sourceSales) && !(empty($sourceMarketingCosts))){
			$costPerSale = $sourceMarketingCosts/$sourceSales;
		}
		
		//Revenue Per Lead = sourceGrossSales/sourceLeads
		$revenuePerLead = '0';
		if (!empty($sourceLeads) && !(empty($sourceGrossSales))){
			$revenuePerLead = $sourceGrossSales/$sourceLeads;
		}

		$marketingMetricsArraySource = array(
									'leadSource' => $source['marketingTypeName'],
									'totalMarketingCosts' => '$' . number_format($sourceMarketingCosts, 2, '.', ','),
									'grossSales' => '$' . number_format($sourceGrossSales, 2, '.', ','),
									'leads' => $sourceLeads,
									'appointments' => $sourceAppointments,
									'bids' => $sourceBids,
									'sales' => $sourceSales,
									'costPerLead' => '$' . number_format($costPerLead, 2, '.', ','),
									'costPerSale' => '$' . number_format($costPerSale, 2, '.', ','),
									'percentTotalMarketingCosts' => $percentTotalMarketingCosts,
									'percentTotalLeads' => $percentTotalLeads,
									'revenuePerLead' => '$' . number_format($revenuePerLead, 2, '.', ','),
									'subsources' => $subsources, 'unspecified' => $unspecified);
		return $marketingMetricsArraySource;
	}
	
	include_once('includes/classes/class_Metrics_MarketingReport.php');
		
		$object = new MarketingReport();
		$object->setCompanyID($companyID);
		$object->setStartDate($startDate);
		$object->setEndDate($endDate);

		$marketingMetricsArray = array();

		//Get Metrics for All Marketing
		$object->getMarketingAll();
		$marketingAll = $object->getResults();

		$totalMarketingCostsAll = $marketingAll['totalMarketingCosts'];
		$leadsAll = $marketingAll['leads'];
		$grossSalesAll = $marketingAll['grossSales'];
		$appointmentsAll = $marketingAll['appointments'];
		$bidsAll = $marketingAll['bids'];
		$salesAll = $marketingAll['sales'];
		$unspecified = false;

		//Cost per lead = totalMarketingCosts/leadsAll
		$costPerLeadAll = '0';
		if (!empty($leadsAll) && !(empty($totalMarketingCostsAll))){
			$costPerLeadAll = $totalMarketingCostsAll/$leadsAll;
		}

		//Cost Per Sale = totalMarketingCostsAll/salesAll
		$costPerSaleAll = '0';
		if (!empty($salesAll) && !(empty($totalMarketingCostsAll))){
			$costPerSaleAll = $totalMarketingCostsAll/$salesAll;
		}
		
		//Revenue Per Lead = grossSalesAll/leadsAll
		$revenuePerLeadAll = '0';
		if (!empty($leadsAll) && !(empty($grossSalesAll))){
			$revenuePerLeadAll = $grossSalesAll/$leadsAll;
		}

		$marketingMetricsArrayAll = array(
										'leadSource' => 'All Marketing',
										'totalMarketingCosts' => '$' . number_format($totalMarketingCostsAll, 2, '.', ','),
										'grossSales' => '$' . number_format($grossSalesAll, 2, '.', ','),
										'leads' => $leadsAll,
										'appointments' => $appointmentsAll,
										'bids' => $bidsAll,
										'sales' => $salesAll,
										'costPerLead' => '$' . number_format($costPerLeadAll, 2, '.', ','),
										'costPerSale' => '$' . number_format($costPerSaleAll, 2, '.', ','),
										'percentTotalMarketingCosts' => '100.00%',
										'percentTotalLeads' => '100.00%',
										'revenuePerLead' => '$' . number_format($revenuePerLeadAll, 2, '.', ','), 'unspecified' => $unspecified);

		$marketingMetricsArray['all'] = $marketingMetricsArrayAll;

		$unsourcedArray = array();

		//Get Metrics for Projects With No Source
		$object->getUnsourced();
		$unsourced = $object->getResults();

		$totalMarketingCostsUnsourced = '$0.00';
		$costPerLeadUnsourced = '$0.00';
		$costPerSaleUnsourced = '$0.00';
		$leadsUnsourced = $unsourced['leads'];
		$grossSalesUnsourced = $unsourced['grossSales'];
		$appointmentsUnsourced = $unsourced['appointments'];
		$bidsUnsourced = $unsourced['bids'];
		$salesUnsourced = $unsourced['sales'];
		$unspecified = false;

		//Percent Total Leads = sourceLeads/leadsAll
		$percentTotalLeadsUnsourced = '0.00%';
		if (!empty($leadsUnsourced) && !(empty($leadsAll))){
			$percentTotalLeadsUnsourced = $leadsUnsourced/$leadsAll;
			$percentTotalLeadsUnsourced = sprintf("%.2f%%", $percentTotalLeadsUnsourced * 100); //format to two decimal places
		}

		//Revenue Per Lead = grossSalesUnsourced/leadsUnsourced
		$revenuePerLeadUnsourced = '0';
		if (!empty($leadsUnsourced) && !(empty($grossSalesUnsourced))){
			$revenuePerLeadUnsourced = $grossSalesUnsourced/$leadsUnsourced;
		}

		$unsourcedArray = array(
										'leadSource' => 'Uncategorized',
										'totalMarketingCosts' => $totalMarketingCostsUnsourced,
										'grossSales' => '$' . number_format($grossSalesUnsourced, 2, '.', ','),
										'leads' => $leadsUnsourced,
										'appointments' => $appointmentsUnsourced,
										'bids' => $bidsUnsourced,
										'sales' => $salesUnsourced,
										'costPerLead' => $costPerSaleUnsourced,
										'costPerSale' => $costPerSaleUnsourced,
										'percentTotalMarketingCosts' => '0.00%',
										'percentTotalLeads' => $percentTotalLeadsUnsourced,
										'revenuePerLead' => '$' . number_format($revenuePerLeadUnsourced, 2, '.', ','), 'unspecified' => $unspecified);

		$marketingMetricsArray['unsourced'] = $unsourcedArray;

		//Get Metrics for Sources
		$object->getMarketingSources();
		$sources =  $object->getResults();

		foreach ($sources as $source) {
			$marketingMetricsArraySource = calculateSourceData($source, $leadsAll, $totalMarketingCostsAll, false);
			$subsources = $marketingMetricsArraySource['subsources'];
			$marketingMetricsArraySource['subsources'] = NULL;
			$marketingMetricsArraySubsource = NULL;

			if(!empty($subsources)){
				foreach ($subsources as $subsource) {
					$marketingMetricsArraySubsource[] = calculateSourceData($subsource, $leadsAll, $totalMarketingCostsAll, true);
					
				}
				$marketingMetricsArraySource['subsources'] = $marketingMetricsArraySubsource;
			}

			$marketingMetricsArray['sources'][] = $marketingMetricsArraySource;
		}
		
		echo json_encode($marketingMetricsArray);
?>