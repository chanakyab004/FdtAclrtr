<?php
	session_start();

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	} else {
		header("Location: login.php");
	}

	if (!empty($_SESSION["registrationComplete"])) {
		header("Location: index.php");
	}

	$currentYear = date('y');
	$pricingDisplay = NULL;
	$bestDealDisplay = NULL;
	$bestDealColor = NULL;
	$subscriptionTypeDisplay = NULL;
	$setupFeePrice = NULL;

	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$companyID = $userArray['companyID'];
		$subscriptionCategoryID = $userArray['subscriptionCategoryID'];


	include_once('includes/classes/class_SubscriptionCategoryPricing.php');
			
		$object = new CategoryPricing();
		$object->setCategory($subscriptionCategoryID);
		$object->getCategoryPricing();
		$categoryPricingArray = $object->getResults();	

		foreach($categoryPricingArray as &$row) {
			$subscriptionPricingID = $row['subscriptionPricingID'];
			$subscriptionCategoryID = $row['subscriptionCategoryID'];
			$subscriptionType = $row['subscriptionType'];
			$title = $row['title'];
			$titleDisplay = $row['titleDisplay'];
			$price = $row['price'];
			$priceDisplay = $row['priceDisplay'];
			$priceDetails = $row['priceDetails'];
			$usersIncluded = $row['usersIncluded'];
			$usersIncludedDisplay = $row['usersIncludedDisplay'];
			$additionalUsersPrice = $row['additionalUsersPrice'];
			$additionalUsersDisplay = $row['additionalUsersDisplay'];
			$discount = $row['discount'];
			$discountDisplay = $row['discountDisplay'];
			$intervalLength = $row['intervalLength'];
			$intervalUnit = $row['intervalUnit'];
			$totalOccurrences = $row['totalOccurrences'];
			$trialOccurrences = $row['trialOccurrences'];
			$trialAmount = $row['trialAmount'];
			$description = $row['description'];
			$setupFee = $row['setupFee'];
			$isSetupFeeWaived = $row['isSetupFeeWaived'];
			$isBestDeal = $row['isBestDeal'];
			$isExpired = $row['isExpired'];

			if (!empty($discountDisplay)) {
				$discountDisplay = '<strong>'.$discountDisplay.'</strong><br/>';
			}

			if ($subscriptionType == 1) {
				$subscriptionTypeDisplay = 'Monthly Subscription';
			} else if ($subscriptionType == 2){
				$subscriptionTypeDisplay = 'Annual Subscription';
			} else if ($subscriptionType == 3){
				$subscriptionTypeDisplay = 'Annual Subscription';
			}

			if (!empty($setupFee)) {
				if ($isSetupFeeWaived == 1) {
					$setupFeePrice = '0.00';

					$setupFee = '<s>$'.$setupFee.' Set Up Fee</s>';

					if (empty($discountDisplay)){
						$setupFee = $setupFee.'<br/>';
					}
				} else {
					$setupFeePrice = $setupFee.'.00';

					$setupFee = '$'.$setupFee.' Set Up Fee';

					if (empty($discountDisplay)){
						$setupFee = $setupFee.'<br/>';
					}
					
				}
			}

			if ($isBestDeal == 1) {
				$bestDealDisplay = '<strong>BEST DEAL!</strong>';
				$bestDealColor = 'style="border: 2px solid #2089C9;"';
			} else {
				$bestDealDisplay = '&nbsp;';
				$bestDealColor = '';
			}


			$pricingDisplay .= '
				<div class="medium-4 columns" data-total="'.$trialAmount.'" data-type="'.$subscriptionType.'" data-setup-fee="'.$setupFeePrice.'" data-monthly-payment="'.$price.'">
                    <p class="text-center" style="color:#2089ca;margin-bottom:0rem;">'.$bestDealDisplay.'</p>
                    <div class="callout" '.$bestDealColor.'>
                        <h4 class="text-center">'.$titleDisplay.'</h4>
                        <h5 class="text-center" style="margin-bottom:0;">'.$priceDisplay.'</h5>
                        <p class="no-margin text-center">
                            <span>'.$priceDetails.'</span><br/>
                            <span style="color:#2089ca;font-size: 1rem;font-style: normal;">'.$usersIncludedDisplay.'</span><br/>
                            '.$additionalUsersDisplay.'<br/> 
                            '.$discountDisplay.'
                            '.$subscriptionTypeDisplay.'<br/>
                            '.$setupFee.'<br/><br/>
                            <label>
                                <input name="subscriptionPricingID" type="radio" value="'.$subscriptionPricingID.'" required />
                                '.$title.'
                            </label>
                        </p>
                    </div>
                </div>';

		}




	include_once('includes/classes/class_StateList.php');
			
	$object = new States(null, null);
	$stateOptions = $object->output;	
	
	//$formMessage = '';

	
	// include_once('includes/classes/class_RegisterCompanyStep1.php');
	
	// // Parse the log in form if the user has filled it out and pressed "Log In"
	// if (isset($_POST["submit"])) {

	// 	$companyName = filter_input(INPUT_POST, 'companyName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$companyAddress1 = filter_input(INPUT_POST, 'companyAddress1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$companyAddress2 = filter_input(INPUT_POST, 'companyAddress2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$companyCity = filter_input(INPUT_POST, 'companyCity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$companyState = filter_input(INPUT_POST, 'companyState', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$companyZip = filter_input(INPUT_POST, 'companyZip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	// 	$object = new RegisterCompany();
	// 	$object->setCompany($companyID, $companyName, $companyAddress1, $companyAddress2, $companyCity, $companyState, $companyZip);
	// 	$object->sendCompany();
	// 	//$formMessage = $object->getMessage();

	// }

?>
<?php include "templates/registration-step2.html";  ?>
