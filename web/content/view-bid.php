<?php

	if(isset($_GET['id'])) {
		$bidID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
		
	$currentDate = date('n/j/Y');
	$viewBidButtons = NULL;
	$drawingDisplay = NULL;
	
	include_once('includes/classes/class_FindEvaluation.php');
		
		$object = new Bid();
		$object->setBid($bidID);
		$object->getEvaluation();
		$bidArray = $object->getResults();	
	
		//Find Evaluation
		$evaluationID = $bidArray['evaluationID'];
		$bidNumber = $bidArray['bidNumber'];
		$companyID = $bidArray['companyID'];
		$customEvaluation = $bidArray['customEvaluation'];

		include_once('includes/classes/class_Company.php');
					
				$object = new Company();
				$object->setCompany($companyID);
				$object->getCompany();
				$companyArray = $object->getResults();		
				
				//Company
				$companyID = $companyArray['companyID'];
				$companyName = $companyArray['companyName'];
				$companyAddress1 = $companyArray['companyAddress1'];
				$companyAddress2 = $companyArray['companyAddress2'];
				$companyCity = $companyArray['companyCity'];
				$companyState = $companyArray['companyState'];
				$companyZip = $companyArray['companyZip'];
				$companyWebsite = $companyArray['companyWebsite'];
				$companyLogo = $companyArray['companyLogo'];
				$companyColor = $companyArray['companyColor'];
				$companyColorHover = $companyArray['companyColorHover'];
				$timezone = $companyArray['timezone'];
				$daylightSavings = $companyArray['daylightSavings'];
				
				$logoDisplay = "image.php?type=companylogo&cid=".$companyID."&name=".$companyLogo;
				
				if ($companyColor == "#000000" || $companyColor == ''){
					$companyColor = "#2089ca";
				}

				if ($companyColorHover == "#000000" || $companyColorHover == ''){
					$companyColorHover = "#1c76ae";
				}		

				if ($companyAddress2 == '') {
					$companyAddressBlock = '
						'.$companyAddress1.'<br/>
						'.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';
				} else {
					$companyAddressBlock = '
						'.$companyAddress1.'<br/>
						'.$companyAddress2.'<br/>
						'.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';
				}

				//Phone	
				include_once('includes/classes/class_CompanyPhone.php');
						
					$object = new CompanyPhone();
					$object->setCompany($companyID);
					$object->getPhone();
					$phoneArray = $object->getResults();	
					
					foreach($phoneArray as &$row) {
						$phoneNumber = $row['phoneNumber'];
						$phoneDescription = $row['phoneDescription'];
						
						$companyPhoneDisplay .= '
							'.$phoneDescription.' '.$phoneNumber.' | ';	
					}
					$companyPhoneDisplay = rtrim($companyPhoneDisplay, ' | ');


		
			include 'convertDateTime.php';
	
			if (empty($evaluationID)) {
				$viewBidContentDisplay = '
					<div class="row">
						<div class="medium-12 columns">
							<p class="text-center" style="margin-top:2rem;">
								<strong>Bid Does Not Exist</strong>
							</p>
						</div>
					</div>';
			} else {
		
			include_once('includes/classes/class_EvaluationProject.php');
					
				$object = new EvaluationProject();
				$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
				$object->getEvaluation();
				$projectArray = $object->getResults();	

				//Project
				$projectID = $projectArray['projectID'];
				$propertyID = $projectArray['propertyID'];
				$customerID = $projectArray['customerID'];
				$firstName = $projectArray['firstName'];
				$lastName = $projectArray['lastName'];
				$address = $projectArray['address'];
				$address2 = $projectArray['address2'];
				$city = $projectArray['city'];
				$state = $projectArray['state'];
				$zip = $projectArray['zip'];
				$ownerAddress = $projectArray['ownerAddress'];
				$ownerAddress2 = $projectArray['ownerAddress2'];
				$ownerCity = $projectArray['ownerCity'];
				$ownerState = $projectArray['ownerState'];
				$ownerZip = $projectArray['ownerZip'];
				$email = $projectArray['email'];
				$projectDescription = $projectArray['projectDescription'];
				$evaluationDescription = $projectArray['evaluationDescription'];
				$evaluationCreated = $projectArray['evaluationCreated'];
				$createdFirstName = $projectArray['createdFirstName'];
				$createdLastName = $projectArray['createdLastName'];
				$createdEmail = $projectArray['createdEmail'];
				$createdPhone = $projectArray['createdPhone'];
				$bidAccepted = $projectArray['bidAccepted'];
				$bidRejected = $projectArray['bidRejected'];
				$evaluationCancelled = $projectArray['evaluationCancelled'];
				$contractID = $projectArray['contractID'];
				
				
				$evaluationCreated = convertDateTime($evaluationCreated, $timezone, $daylightSavings);
				$evaluationCreated = date('n/j/Y', strtotime($evaluationCreated));
				
				
				$inlineAddress = $address.' '.$address2.', '.$city.', '.$state.' '.$zip;
				
				//Address Display
				$addressDisplay = '
		        	'.$address.' '.$address2.'<br/>
					'.$city.', '.$state.' '.$zip.'';
					
				include_once('includes/classes/class_Drawing.php');
					
				$object = new Drawing();
				$object->setDrawing($evaluationID);
				$object->getDrawing();
				$drawing = $object->getResults();

				if (!empty($drawing)){
					$evaluationDrawing = $drawing['evaluationDrawing'];

					//Drawing Display
					$drawingDisplay = '<a target="_blank" href="image.php?type=evaldrawing&cid='.$companyID.'&pid='.$projectID.'&eid='.$evaluationID.'&name='.$evaluationDrawing.'" download>Download Evaluation Drawing</a><br/><br/>';
		            }
				
				
				if ($bidRejected == NULL && $bidAccepted == NULL) {
					$viewBidButtons = '
						<button class="button" id="accept">Accept Bid</button>
						<button class="button" id="reject">Reject Bid</button>
		       			<br/>
		       			';	
		       			//<a style="font-style:italic;" href="">Unsubscribe from future Emails</a>
						
				} else if ($bidAccepted != NULL) {
					$bidAccepted = convertDateTime($bidAccepted, $timezone, $daylightSavings);
					$bidAccepted = date('n/j/Y g:i a', strtotime($bidAccepted));
					
					$viewBidButtons = '<span>Bid Accepted '.$bidAccepted.'</span>';
					
				} else if ($bidRejected != NULL) {
					$bidRejected = convertDateTime($bidRejected, $timezone, $daylightSavings);
					$bidRejected = date('n/j/Y g:i a', strtotime($bidRejected));
					
					$viewBidButtons = '
						<button class="button" id="accept">Accept Bid</button>
						<br/>
						<span>Bid Rejected '.$bidRejected.'</span>
						';
				} 
				
				
					
			//Phone	
			include_once('includes/classes/class_CustomerPhone.php');
					
				$object = new CustomerPhone();
				$object->setCustomer($customerID);
				$object->getPhone();
				$phoneArray = $object->getResults();	
				
				
				foreach($phoneArray as &$row) {
					$phoneNumber = $row['phoneNumber'];
					$phoneDescription = $row['phoneDescription'];
					$isPrimary = $row['isPrimary'];
					
					if ($isPrimary == '1') {
						$phoneDisplay = ''.$phoneNumber.'';	
					} 
				}		
				
			
			
				
			
			include_once('includes/classes/class_GetContract.php');
					
				$object = new Contract();
				$object->setCompany($companyID, $contractID);
				$object->getContract();
				$contractArray = $object->getResults();	
				
				if ($contractArray != NULL) {
				
					$companyContract = $contractArray['contractText'];

					$tags = array("{date}", "{firstName}", "{lastName}", "{address}", "{address2}", "{city}", "{state}", "{zip}", "{phone}", "{email}", "{bidNumber}");
					$variables   = array($currentDate, $firstName, $lastName, $address, $address2, $city, $state, $zip, $phoneDisplay, $email);

					if ($bidNumber != NULL){
						$variables[] = '#'.$bidNumber;
					}
					else{
						$variables[] = '';
					}
				
					$companyContractText = str_replace($tags, $variables, $companyContract);	

					$companyContractText = html_entity_decode($companyContractText);


					$contract = '
					<div class="medium-12 columns">
						<p class="no-margin" style="text-align:center;font-size:1.5rem;font-weight: bold;line-height:1;">Contract</p>
						<p class="no-margin" style="text-align:center;font-size:2.5rem;font-weight: bold;">
							'.$companyName.'
						</p>
						<p style="text-align:center;font-size:12px;line-height: 1.2;">
							'.$companyAddress1.', '.$companyCity.', '.$companyState.' '.$companyZip.'<br/>
							'.$companyPhoneDisplay.'<br/>
					 		'.$companyWebsite.'<br/>
						</p>
					</div>
					<div>
		                <div style="display:inline-block;">
		                    <p style="display:inline-block;margin-bottom:0;">Customer Name:</p>
		                </div>
		                <div style="border-bottom:1px solid #000000;width: 30rem;display:inline-block;">
		                    <p style="display:inline-block;margin-bottom:0;padding-left:10px;">
		                    	'.$firstName.' '.$lastName.'
		                    </p>
		                </div>

		                <div style="display:inline-block;">
		                    <p style="display:inline-block;text-align:right;margin-bottom:0;">
		                    	Date:
		                    </p>
		                </div>
		                <div style="border-bottom:1px solid #000000;width: 7rem;display:inline-block;">
		                    <p style="display:inline-block;margin-bottom:0;padding-left: 10px;text-align:center;">
		                    	'.$currentDate.'
		                    </p>
		                </div>
		            </div>
		            <div>
		                <div style="display:inline-block;">
		                    <p style="display:inline-block;margin-bottom:0;">
		                    	Located:
		                    </p>
		                </div>
		                <div style="border-bottom:1px solid #000000;width: 44rem;display:inline-block;">
		                    <p style="display:inline-block;margin-bottom:0;padding-left:10px;">
		                    	'.$address.' '.$address2.', '.$city.', '.$state.' '.$zip.'
		                    </p>
		                </div>
		            </div>
		             <div style="margin-bottom: 1rem;">
		                <div style="display:inline-block;">
		                    <p style="display:inline-block;margin-bottom:0;">
		                    	Phone:
		                    </p>
		                </div>
		                <div style="border-bottom:1px solid #000000;width: 20rem;display:inline-block;">
		                    <p style="display:inline-block;margin-bottom:0;padding-left:10px;">
		                    	'.$phoneDisplay.'
		                    </p>
		                </div>

		                <div style="display:inline-block;">
		                    <p style="display:inline-block;text-align:right;margin-bottom:0;">
		                    	Email:
		                    </p>
		                </div>
		                <div style="border-bottom:1px solid #000000;width: 22rem;display:inline-block;">
		                    <p style="display:inline-block;margin-bottom:0;padding-left:10px;">
		                    	'.$email.'
		                    </p>
		                </div>
		            </div>
		            <p>
					'.$companyContractText.'
					<div>
		                <div style="display:inline-block;">
		                    <p style="display:inline-block;margin-bottom:0;">
		                    	Signature:
		                    </p>
		                </div>
		                <div style="border-bottom:1px solid #000000;width: 30rem;display:inline-block;">
		                    <p style="display:inline-block;margin-bottom:0;padding-left:10px">
		                    	'.$firstName.' '.$lastName.'
		                    </p>
		                </div>

		                <div style="display:inline-block;">
		                    <p style="display:inline-block;text-align:right;margin-bottom:0;">
		                    	Date:
		                    </p>
		                </div>
		                <div style="border-bottom:1px solid #000000;width: 7rem;display:inline-block;">
		                    <p style="display:inline-block;margin-bottom:0;text-align:center;padding-left:10px">
		                    	'.$currentDate.'
		                    </p>
		                </div>
		            </div>
					';
					
				}
				
				
				if ($evaluationCancelled == NULL) {
					$viewBidDisplay = '
					<p>
		            	<strong>Customer</strong><br/>
		            	'.$firstName.' '.$lastName.'
		            	<br/><br/>
		           		<strong>Project</strong><br/>
		            	'.$evaluationDescription.'
		            	<br/><br/>
		            	<strong>Address</strong><br/>
		            	'.$addressDisplay.'
		            	<br/><br/>
		            	<strong>Evaluation Performed on '.$evaluationCreated.' by '.$createdFirstName.' '.$createdLastName.'</strong>
		            	<br/><br/>
		            	Thank you for giving us the opportunity to serve you.  If you have any questions, including questions about our evaluation of your property, the work to be performed, or the bid, please feel free to call me.
		            	<br/><br/>
		             	'.$createdFirstName.' '.$createdLastName.'<br/>
		            	'.$companyName.'<br/>
		           	'.$createdPhone.'<br/>
		            	'.$createdEmail.'
		           	<br/><br/>
		           	<a target="_blank" href="bid-accept-email.php?id='.$bidID.'">Download Bid</a><br/>
		            	<br/>
		            '.$drawingDisplay.'
		           </p>
		           <p id="viewBidButtons">  
		           	'.$viewBidButtons.'
					</p>
					';
					
				} else {
					$viewBidDisplay = 'This bid has been cancelled.';
				}


				$viewBidContentDisplay = '
				<div class="row">
			     	<div class="medium-6 columns">
			      		<img src="'.$logoDisplay.'" style="width:8rem; margin: 1rem 0;">
			  		</div>
			      	<div class="medium-6 columns">
			        	<p class="text-right" style="margin-top:2rem;">
			            	'.$companyAddressBlock.'
			          	</p>
			      	</div>
			     	<div class="medium-12 columns">
			        	'.$viewBidDisplay.'
			  		</div>
			   	</div>
			    <div id="contractModal" class="reveal large" data-reveal data-close-on-esc="false" data-close-on-click="false">
			       	<div class="row">
			       		'.$contract.'
			      	</div>
			    	<div class="row" style="margin-top:1rem;">
			        	<div class="medium-12 columns text-center">
			      			<button class="button" id="signContract">Sign Contract</button> 
			        		<button data-close class="button secondary">Cancel</button>
			          	</div>
			   		</div>
				</div>
				<div id="contractModalAccept" class="reveal small" data-reveal data-close-on-esc="false" data-close-on-click="false">
			       	<div class="row">
			       		By signing any forms or agreements provided to you by '.$companyName.', you understand, agree and acknowledge that your electronic signature is the legally binding equivalent to your 
			       		handwritten signature.  You agree, by providing your electronic signature, that you will not repudiate, deny or challenge the validity of your electronic signature or of any 
			       		electronic agreement that you electronically sign or their legally binding effect.  
			      	</div>
			    	<div class="row" style="margin-top:1rem;">
			        	<div class="medium-12 columns text-center">
			      			<button class="button" id="signContractAccept">Agree</button> 
			        		<button data-close class="button secondary">Cancel</button>
			          	</div>
			   		</div>
				</div>
			    <div id="rejectBidModal" class="reveal tiny" data-reveal data-close-on-esc="false" data-close-on-click="false">
			 		<div class="row align-center">
			       		<p style="margin-top: 1rem;text-align: center;">Are you sure you want to reject this bid?</p>
			      	</div>
			     	<div class="row">
			       		<div class="medium-12 columns text-center">
			          		<button id="rejectBid" class="button">Ok</button>
			         		<button data-close class="button secondary">Cancel</button> 
			       		</div>
					</div>
				</div>
			    <div id="evaluationID" class="is-hidden">'.$evaluationID.'</div>
			    <div id="customEvaluation" class="is-hidden">'.$customEvaluation.'</div>

				';
		}
		
			
?>
<?php include "templates/view-bid.html";  ?>