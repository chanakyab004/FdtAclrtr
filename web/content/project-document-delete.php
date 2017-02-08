<?php

    include $_SERVER['DOCUMENT_ROOT'] . "/includes/include.php";

    $object = new Session();
    $object->sessionCheck();
    
    set_error_handler('error_handler');

    if(isset($_SESSION["userID"])) {
        $userID = $_SESSION['userID']; 
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
        
        if ($primary == 1 || $sales == 1 || $projectManagement == 1) {
            
            if(isset($_POST['projectID'])) {
                $projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
            }

            if(isset($_POST['projectDocumentID'])) {
                $projectDocumentID = filter_input(INPUT_POST, 'projectDocumentID', FILTER_SANITIZE_NUMBER_INT);
            }

            if(isset($_POST['fileName'])) {
                $fileName = filter_input(INPUT_POST, 'fileName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $fileName = urldecode($fileName);
            }


            include_once('includes/classes/class_DeleteProjectDocument.php');
                    
                $object = new DeleteProjectDocument();
                $object->setProject($companyID, $projectID, $projectDocumentID, $fileName);
                $object->deleteProjectDocument();
                $results = $object->getResults();   
                
                echo json_encode($results);
        }
        
?>