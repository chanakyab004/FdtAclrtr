<?php
  require 'includes/PHPAuthorizeAutoload.php';

  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;

  define("AUTHORIZENET_LOG_FILE", "phplog");

  include_once('includes/settings.php');

    function createCustomerProfile($companyID, $firstName, $lastName, $companyName, $companyAddress, $companyCity, $companyState, $companyZip, $email, $cardNumber, $expirationDate, $cardCode, $authorizeTransactionID){
      
        // Common setup for API credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(AUTHORIZE_NAME);
        $merchantAuthentication->setTransactionKey(AUTHORIZE_KEY);

      // $refId = 'ref' . time();

        // Create the payment data for a credit card
      $creditCard = new AnetAPI\CreditCardType();
      $creditCard->setCardNumber($cardNumber);
      $creditCard->setExpirationDate($expirationDate);
      $creditCard->setCardCode($cardCode);
      $paymentCreditCard = new AnetAPI\PaymentType();
      $paymentCreditCard->setCreditCard($creditCard);

      // Create the Bill To info
      $billto = new AnetAPI\CustomerAddressType();
      $billto->setFirstName($firstName);
      $billto->setLastName($lastName);
      $billto->setCompany($companyName);
      $billto->setAddress($companyAddress);
      $billto->setCity($companyCity);
      $billto->setState($companyState);
      $billto->setZip($companyZip);
      
     // Create a Customer Profile Request
     //  1. create a Payment Profile
     //  2. create a Customer Profile   
     //  3. Submit a CreateCustomerProfile Request
     //  4. Validate Profile ID returned

      $paymentprofile = new AnetAPI\CustomerPaymentProfileType();

      $paymentprofile->setCustomerType('business');
      $paymentprofile->setBillTo($billto);
      $paymentprofile->setPayment($paymentCreditCard);
      $paymentprofiles[] = $paymentprofile;
      $customerprofile = new AnetAPI\CustomerProfileType();
      $customerprofile->setDescription("Profile Created by Authorized Transation ".$authorizeTransactionID);

      $customerprofile->setMerchantCustomerId($companyID);
      $customerprofile->setEmail($email);
      $customerprofile->setPaymentProfiles($paymentprofiles);

      $request = new AnetAPI\CreateCustomerProfileRequest();
      $request->setMerchantAuthentication($merchantAuthentication);
      $request->setRefId( $refId);
      $request->setProfile($customerprofile);
      $controller = new AnetController\CreateCustomerProfileController($request);

        if (SERVER_ROLE == 'PROD'){
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION); 
        } else {
            $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }


      if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
      {
          $result = array();
          $result['customerProfileID'] = $response->getCustomerProfileId();
          $paymentProfiles = $response->getCustomerPaymentProfileIdList();
          $result['customerPaymentProfileID'] = $paymentProfiles[0];
          return $result;

          //return $response->getCustomerProfileId();
          //$paymentProfiles = $response->getCustomerPaymentProfileIdList();
          //echo "SUCCESS: PAYMENT PROFILE ID : " . $paymentProfiles[0] . "\n";
       }
      else
      {
          //echo "ERROR :  Invalid response\n";
          $errorMessages = $response->getMessages()->getMessage();
          return $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText();
      }
      //return $response;
  }
  // if(!defined('DONT_RUN_SAMPLES'))
  //     createCustomerProfile("test123@test.com");
?>
