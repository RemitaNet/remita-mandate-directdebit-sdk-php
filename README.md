# remita-mandate-directdebit-sdk-php

```php
  // Initialize Credentials++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $credentials = initTest();
        MandateDirectDebitService::initCredentials($credentials);

        echo "// Setup Mandate ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $setupMandateRequest = new SetupMandateRequest();
        $setupMandateRequest->payerName = "Michelle Alozie";
        $setupMandateRequest->payerEmail = "alozie@systemspecs.com.ng";
        $setupMandateRequest->payerPhone = "09062067384";
        $setupMandateRequest->payerBankCode = "057";
        $setupMandateRequest->payerAccount = "0035509366";
        $setupMandateRequest->requestId = round(microtime(true) * 1000);
        $setupMandateRequest->startDate = "19/07/2021";
        $setupMandateRequest->endDate = "22/08/2021";
        $setupMandateRequest->mandateType = "DD";
        $setupMandateRequest->maxNoOfDebits = "6";
        $response = MandateDirectDebitService::setupMandate($setupMandateRequest);
        echo "\n";
        echo "\n";
        echo "Response:\n", json_encode($response);
        echo "\n";
        echo "\n";

        echo "// MandateActivateRequestOTP++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $mandateActivateRequestOTP = new MandateActivateRequestOTP();
        $mandateActivateRequestOTP->mandateId = $response->mandateId;
        $mandateActivateRequestOTP->requestId = $response->requestId;
        ;
        $response = MandateDirectDebitService::activateMandateRequestOTP($mandateActivateRequestOTP);
        echo "\n";
        echo "\n";
        echo "Response:\n", json_encode($response);
        echo "\n";
        echo "\n";

        echo "// MandateActivateValidateOTP++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $mandateActivateValidateOTP = new MandateActivateValidateOTP();
        $mandateActivateValidateOTP->remitaTransRef = "1587568766736";

        $authParam1 = new AuthParams();
        $authParam1->param1 = "OTP";
        $authParam1->value1 = "1234";

        $authParam2 = new AuthParams();
        $authParam2->param2 = "CARD";
        $authParam2->value2 = "0441234567890";

        $mandateActivateValidateOTP->authParams = array(
            $authParam1,
            $authParam2
        );
        $response = MandateDirectDebitService::activateMandateValidatetOTP($mandateActivateValidateOTP);
        echo "\n";
        echo "\n";
        echo "Response:\n", json_encode($response);
        echo "\n";
        echo "\n";

        echo "// Send Debit Instruction ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $sendDebitInstructionRequest = new SendDebitInstructionRequest();
        $sendDebitInstructionRequest->mandateId = "280007806861";
        $sendDebitInstructionRequest->fundingAccount = "3072119052";
        $sendDebitInstructionRequest->fundingBankCode = "057";
        $sendDebitInstructionRequest->requestId = round(microtime(true) * 1000);
        $response = MandateDirectDebitService::sendDebitInstruction($sendDebitInstructionRequest);
        echo "\n";
        echo "\n";
        echo "Response:\n", json_encode($response);
        echo "\n";
        echo "\n";

        echo "// Debit Status ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $debitStatusRequest = new DebitStatusRequest();
        $debitStatusRequest->mandateId = "140007735469";
        $debitStatusRequest->requestId = "1551782788673";
        $response = MandateDirectDebitService::debitStatus($debitStatusRequest);
        echo "\n";
        echo "\n";
        echo "Response:\n", json_encode($response);
        echo "\n";
        echo "\n";

        echo "// Cancel Debit Instruction++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $cancelDebitInstructionRequest = new CancelDebitInstructionRequest();
        $cancelDebitInstructionRequest->transactionRef = "7681307";
        $cancelDebitInstructionRequest->mandateId = "200007681305";
        $cancelDebitInstructionRequest->requestId = "1524034885236";
        $response = MandateDirectDebitService::cancelDebitInstruction($cancelDebitInstructionRequest);
        echo "\n";
        echo "\n";
        echo "Response:\n", json_encode($response);
        echo "\n";
        echo "\n";

        echo "// Mandate Payment History Request++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $mandatePaymentHistoryRequest = new MandatePaymentHistoryRequest();
        $mandatePaymentHistoryRequest->mandateId = "280007807262";
        $mandatePaymentHistoryRequest->requestId = "1582194580";
        $response = MandateDirectDebitService::mandatePaymentHistory($mandatePaymentHistoryRequest);
        echo "\n";
        echo "\n";
        echo "Response:\n", json_encode($response);
        echo "\n";
        echo "\n";

        echo "// Stop Mandate++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $stopMandateRequest = new StopMandateRequest();
        $stopMandateRequest->mandateId = "150007761106";
        $stopMandateRequest->requestId = "1564489623447";
        $response = MandateDirectDebitService::stopMandate($stopMandateRequest);
        echo "\n";
        echo "\n";
        echo "Response:\n", json_encode($response);
        echo "\n";
        echo "\n";

        echo "// Mandate Status++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $mandateStatusRequest = new MandateStatusRequest();
        $mandateStatusRequest->mandateId = "290007822729";
        $mandateStatusRequest->requestId = "STR-1587564374156-iFIV3uFAXv";
        $response = MandateDirectDebitService::mandateStatus($mandateStatusRequest);
        echo "\n";
        echo "\n";
        echo "Response:\n", json_encode($response);
        echo "\n";
        echo "\n";
 ```