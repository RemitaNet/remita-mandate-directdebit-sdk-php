<?php
include 'MandateDirectDebitService.php';
include 'Request/SetupMandateRequest.php';
include 'Request/MandateStatusRequest.php';
include 'Request/MandateActivateRequestOTP.php';
include 'Request/MandateActivateValidateOTP.php';
include 'Request/AuthParams.php';

function initTest()
{
    // SDK Credentials
    $merchantId = "27768931";
    $serviceTypeId = "35126630";
    $apiKey = "Q1dHREVNTzEyMzR8Q1dHREVNTw==";
    $apiToken = "SGlQekNzMEdMbjhlRUZsUzJCWk5saDB6SU14Zk15djR4WmkxaUpDTll6bGIxRCs4UkVvaGhnPT0=";
    $amount = "100";

    // Initialize SDK
    $credentials = new Credentials();
    $credentials->url = ApplicationUrl::$demoUrl;
    $credentials->merchantId = $merchantId;
    $credentials->serviceTypeId = $serviceTypeId;
    $credentials->apiKey = $apiKey;
    $credentials->amount = $amount;
    $credentials->apiToken = $apiToken;

    return $credentials;
}

class TestMandateDirectDebit
{

    function test()
    {
        echo "// Initialize Credentials++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
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
        echo "Setup Mandate Response:\n", json_encode($response);
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
        echo "Mandate Status Response:\n", json_encode($response);
        echo "\n";
        echo "\n";

        echo "// MandateActivateRequestOTP++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $mandateActivateRequestOTP = new MandateActivateRequestOTP();
        $mandateActivateRequestOTP->mandateId = "350007841368";
        $mandateActivateRequestOTP->requestId = "1593695291235";
        $response = MandateDirectDebitService::activateMandateRequestOTP($mandateActivateRequestOTP);
        echo "\n";
        echo "\n";
        echo "Mandate Activate Request OTP Response:\n", json_encode($response);
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
        echo "Mandate Activate Validate OTP:\n", json_encode($response);
        echo "\n";
        echo "\n";
    }
}

$testRITs = new TestMandateDirectDebit();
$testRITs->test();
?>

