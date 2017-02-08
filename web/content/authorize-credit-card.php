<?php
  require 'includes/PHPAuthorizeAutoload.php';

  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;

  define("AUTHORIZENET_LOG_FILE", "phplog");

  include_once('includes/settings.php');

  function authorizeCreditCard($firstName, $lastName, $companyName, $companyCCBillingAddress1, $companyCCBillingCity, $companyCCBillingState, $companyCCBillingZip, $price, $cardNumber, $expirationDate, $cardCode){
    // Common setup for API credentials
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName(AUTHORIZE_NAME);
    $merchantAuthentication->setTransactionKey(AUTHORIZE_KEY);

    $refId = 'ref' . time();

    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber($cardNumber);
    $creditCard->setExpirationDate($expirationDate);
    $creditCard->setCardCode($cardCode);
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);

    //Set the Bill To
    $billTo = new AnetAPI\CustomerAddressType();
    $billTo->setFirstName($firstName);
    $billTo->setLastName($lastName);
    $billTo->setCompany($companyName);
    $billTo->setAddress($companyCCBillingAddress1);
    $billTo->setCity($companyCCBillingCity);
    $billTo->setState($companyCCBillingState);
    $billTo->setZip($companyCCBillingZip);


    //create a transaction
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType( "authOnlyTransaction"); 
    $transactionRequestType->setAmount($price);
    $transactionRequestType->setPayment($paymentOne);
    $transactionRequestType->setBillTo($billTo);

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
          $result['status'] = $tresponse->getResponseCode();
          $result['authCode'] = $tresponse->getAuthCode();
          $result['transCode'] = $tresponse->getTransId();
          return $result;
          //echo "" . $tresponse->getResponseCode() . "";
          // return "success";
          // echo " Successfully created a transaction with Auth code : " . $tresponse->getAuthCode() . "\n";
          // echo " TRANS ID  : " . $tresponse->getTransId() . "\n";
          // echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n"; 
          // echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
        }
        else
        {
          //echo "Transaction Failed \n";
          if($tresponse->getErrors() != null)
          {
            //echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
            return "" . $tresponse->getErrors()[0]->getErrorText() . "";            
          }
        }
      }
      else
      {
        //echo "Transaction Failed \n";
        $tresponse = $response->getTransactionResponse();
        
        if($tresponse != null && $tresponse->getErrors() != null)
        {
          //echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
          return "" . $tresponse->getErrors()[0]->getErrorText() . "";                      
        }
        else
        {
          //echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
          return "" . $response->getMessages()->getMessage()[0]->getText() . "";
        }
      }      
    }
    else
    {
      return  "No response returned";
    }
    
    //return $response;
  }
  // if(!defined('DONT_RUN_SAMPLES'))
  //   authorizeCreditCard( 23.32);
?>