<?php
    require 'includes/PHPAuthorizeAutoload.php';
    use net\authorize\api\contract\v1 as AnetAPI;
    use net\authorize\api\controller as AnetController;
    date_default_timezone_set('America/Chicago');
  
    define("AUTHORIZENET_LOG_FILE", "phplog");

    include_once('includes/settings.php');

    function createSubscription($companyID, $firstName, $lastName, $companyName, $companyAddress, $companyCity, $companyState, $companyZip, $email, $subscriptionName, $amount, $cardNumber, $expirationDate, $cardCode, $subscriptionLength, $subscriptionUnit, $trialOccurrences, $trialAmount) {

        // Common Set Up for API Credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(AUTHORIZE_NAME);
        $merchantAuthentication->setTransactionKey(AUTHORIZE_KEY);
        
        $refId = 'ref' . time();

        $today = date("Y-m-d");

        // Subscription Type Info
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName($subscriptionName);

        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength($subscriptionLength);
        $interval->setUnit($subscriptionUnit);

        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(new DateTime($today));
        $paymentSchedule->setTotalOccurrences('9999');
        $paymentSchedule->setTrialOccurrences($trialOccurrences);

        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setAmount($amount);
        $subscription->setTrialAmount($trialAmount);
        
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($expirationDate);
        $creditCard->setCardCode($cardCode);


        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);

        $subscription->setPayment($payment);

        $customerProfile = new AnetAPI\CustomerType();
        $customerProfile->setId($companyID);
        $customerProfile->setEmail($email);

        $subscription->setCustomer($customerProfile);

        $billTo = new AnetAPI\NameAndAddressType();
        $billTo->setFirstName($firstName);
        $billTo->setLastName($lastName);
        $billTo->setCompany($companyName);
        $billTo->setAddress($companyAddress);
        $billTo->setCity($companyCity);
        $billTo->setState($companyState);
        $billTo->setZip($companyZip);

        $subscription->setBillTo($billTo);

        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscription($subscription);
        $controller = new AnetController\ARBCreateSubscriptionController($request);

        if (SERVER_ROLE == 'PROD'){
            $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION); 
        } else {
            $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }
        
        
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
        {
            //$xmlresponse = simplexml_load_string($response);
            //echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
            //echo "SUCCESS: Customer Profile ID : " . $response->getProfile()->getCustomerProfileId() . "\n";  
            $customerProfileID = $response->getProfile()->getCustomerProfileId();
            $subscriptionID = $response->getSubscriptionId();

            $response = array('status' => 'success','customerProfileID' => $customerProfileID, 'subscriptionID' => $subscriptionID);
            //print_r($responseArray);
         }
        else
        {
            // echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            echo "" . $errorMessages[0]->getText() . "";
        }

        return $response;
    }

      // if(!defined('DONT_RUN_SAMPLES'))
      //   createSubscription(23);

?>