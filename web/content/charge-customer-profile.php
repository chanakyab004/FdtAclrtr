<?php
  require 'includes/PHPAuthorizeAutoload.php';

  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;

  //define("AUTHORIZENET_LOG_FILE", "phplog");

  include_once('includes/settings.php');


    function chargeCustomerProfile($profileid, $paymentprofileid, $amount){
    // Common setup for API credentials
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName(AUTHORIZE_NAME);
    $merchantAuthentication->setTransactionKey(AUTHORIZE_KEY);
    $refId = 'ref' . time();

    $profileToCharge = new AnetAPI\CustomerProfilePaymentType();
    $profileToCharge->setCustomerProfileId($profileid);
    $paymentProfile = new AnetAPI\PaymentProfileType();
    $paymentProfile->setPaymentProfileId($paymentprofileid);
    $profileToCharge->setPaymentProfile($paymentProfile);

    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType( "authCaptureTransaction"); 
    $transactionRequestType->setAmount($amount);
    $transactionRequestType->setProfile($profileToCharge);

    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId( $refId);
    $request->setTransactionRequest( $transactionRequestType);
    $controller = new AnetController\CreateTransactionController($request);

    if (SERVER_ROLE == 'PROD'){
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION); 
    } else {
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
    }

    if ($response != null)
    {
      if($response->getMessages()->getResultCode() == "Ok")
      {
        $tresponse = $response->getTransactionResponse();
        
        if ($tresponse != null && $tresponse->getMessages() != null)   
        {
          $result = array();
          $result['message'] = 'true';
          $result['authorizeTransactionID'] = $tresponse->getTransId();
          return $result;
          // echo " Transaction Response code : " . $tresponse->getResponseCode() . "\n";
          // echo  "Charge Customer Profile APPROVED  :" . "\n";
          // echo " Charge Customer Profile AUTH CODE : " . $tresponse->getAuthCode() . "\n";
          // echo " Charge Customer Profile TRANS ID  : " . $tresponse->getTransId() . "\n";
          // echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n"; 
          // echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
        }
        else
        {
          //echo "Transaction Failed \n";
          if($tresponse->getErrors() != null)
          {
            $result = array();
            $result['message'] = $tresponse->getErrors()[0]->getErrorText();
            return $result;
            // echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
            // echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";            
          }
        }
      }
      else
      {
        //echo "Transaction Failed \n";
        $tresponse = $response->getTransactionResponse();
        if($tresponse != null && $tresponse->getErrors() != null)
        {
          // echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
          // echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";       
          $result = array();
          $result['message'] = $tresponse->getErrors()[0]->getErrorText();        
          return $result;       
        }
        else
        {
          // echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
          // echo " Error message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
          $result = array();
          $result['message'] = $tresponse->getErrors()[0]->getErrorText();  
          return $result;   
        }
      }
    }
    else
    {
      $result = array();
      $result['message'] = 'No response returned';     
      return $result;
    }

    //return $response;
  }

  // if(!defined('DONT_RUN_SAMPLES'))
  //   chargeCustomerProfile("36731856","32689274",12.23);


?>