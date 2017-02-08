<?php

	function getStatus($projectAdded, $scheduledStartEvaluation, $evaluationFinalized, $bidFirstSent, $bidAccepted, $scheduledStartInstallation, $installationInProgress, $projectCompleted, $finalReportSent){
    	
    	$statusArray = array();

    	if ($projectAdded != NULL) {
    		$projectAddedArray = array();
    		$projectAddedArray["projectSetupActive"] = "active";

    		$statusArray = array_merge($statusArray, $projectAddedArray);
    	}

    	if ($scheduledStartEvaluation != NULL) {
    		$scheduledStartEvaluationArray = array();
    		$scheduledStartEvaluationArray["scheduledAppointmentActive"] = "active";

    		$statusArray = array_merge($statusArray, $scheduledStartEvaluationArray);
    	}

    	if ($evaluationFinalized != NULL) {
    		$evaluationFinalizedArray = array();
    		$evaluationFinalizedArray["submittedRepairActive"] = "active";

    		$statusArray = array_merge($statusArray, $evaluationFinalizedArray);
    	}

    	if ($bidFirstSent != NULL) {
    		$bidFirstSentArray = array();
    		$bidFirstSentArray["bidSentActive"] = "active";

    		$statusArray = array_merge($statusArray, $bidFirstSentArray);
    	}

    	if ($bidAccepted != NULL) {
    		$bidAcceptedArray = array();
    		$bidAcceptedArray["bidAcceptedActive"] = "active";

    		$statusArray = array_merge($statusArray, $bidAcceptedArray);
    	}

    	if ($scheduledStartInstallation != NULL) {
    		$scheduledStartInstallationArray = array();
    		$scheduledStartInstallationArray["scheduledInstallationActive"] = "active";

    		$statusArray = array_merge($statusArray, $scheduledStartInstallationArray);
    	}

    	if ($installationInProgress != NULL) {
    		$installationInProgressArray = array();
    		$installationInProgressArray["installationInProgressActive"] = "active";

    		$statusArray = array_merge($statusArray, $installationInProgressArray);
    	}

    	if ($projectCompleted != NULL) {
    		$projectCompletedArray = array();
    		$projectCompletedArray["projectCompletedActive"] = "active";

    		$statusArray = array_merge($statusArray, $projectCompletedArray);
    	}

    	if ($finalReportSent != NULL) {
    		$finalReportSentArray = array();
    		$finalReportSentArray["finalReportActive"] = "active";

    		$statusArray = array_merge($statusArray, $finalReportSentArray);
    	}



    	return $statusArray;
  	}



 //  	projectAdded

	// scheduledStart Evaluation

	// evaluationFinalized

	// bidFirstSent

	// bidApproved

	// scheduledStart Installation

	// *installationInProgress
		
	// projectCompleted

	// *finalReportSent
?>