<?php

    require 'includes/PHPAuthorizeAutoload.php';
    use net\authorize\api\contract\v1 as AnetAPI;
    use net\authorize\api\controller as AnetController;

    define("AUTHORIZENET_LOG_FILE", "phplog");

    function chargeCreditCard($amount, $cardNumber, $expirationDate, $cardCode){
          // Common setup for API credentials
          $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
          $merchantAuthentication->setName('57nD6yF8pd');
          $merchantAuthentication->setTransactionKey('588AsBNpBz6N3A7J');


          $refId = 'ref' . time();

          // Create the payment data for a credit card
          $creditCard = new AnetAPI\CreditCardType();
          $creditCard->setCardNumber($cardNumber);
          $creditCard->setExpirationDate($expirationDate);
          $creditCard->setCardCode($cardCode);
          $paymentOne = new AnetAPI\PaymentType();
          $paymentOne->setCreditCard($creditCard);

          $order = new AnetAPI\OrderType();
          $order->setDescription("New Item");

          //create a transaction
          $transactionRequestType = new AnetAPI\TransactionRequestType();
          $transactionRequestType->setTransactionType( "authCaptureTransaction"); 
          $transactionRequestType->setAmount($amount);
          $transactionRequestType->setOrder($order);
          $transactionRequestType->setPayment($paymentOne);
          

          $request = new AnetAPI\CreateTransactionRequest();
          $request->setMerchantAuthentication($merchantAuthentication);
          $request->setRefId( $refId);
          $request->setTransactionRequest( $transactionRequestType);
          $controller = new AnetController\CreateTransactionController($request);
          $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
          

          if ($response != null)
          {
            if($response->getMessages()->getResultCode() == 'Ok')
            {
              $tresponse = $response->getTransactionResponse();
              
                if ($tresponse != null && $tresponse->getMessages() != null)   
              {
                echo " Transaction Response code : " . $tresponse->getResponseCode() . "\n";
                echo "Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "\n";
                echo "Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
                echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n"; 
                  echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
              }
              else
              {
                //echo "Transaction Failed \n";
                if($tresponse->getErrors() != null)
                {
                  //echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                  echo "" . $tresponse->getErrors()[0]->getErrorText() . "\n";            
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
                echo "" . $tresponse->getErrors()[0]->getErrorText() . "\n";                      
              }
              else
              {
                //echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
                echo "" . $response->getMessages()->getMessage()[0]->getText() . "\n";
              }
            }      
          }
          else
          {
            echo  "No response returned \n";
          }

          return $response;
      }
      // if(!defined('DONT_RUN_SAMPLES'))
      //     chargeCreditCard(\SampleCode\Constants::SAMPLE_AMOUNT);
?>