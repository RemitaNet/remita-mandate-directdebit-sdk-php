<?php
include 'MandateDirectDebitService.php';
include 'Request/SetupMandate/SetupMandateRequest.php';

function initTest()
{
    // SDK Credentials
    $merchantId = "27768931";
    $serviceTypeId = "35126630";
    $apiKey = "Q1dHREVNTzEyMzR8Q1dHREVNTw==";
    $amount = "100";
    $requestId = round(microtime(true) * 1000);

    // Initialize SDK
    $credentials = new Credentials();
    $credentials->url = ApplicationUrl::$demoUrl;
    $credentials->merchantId = $merchantId;
    $credentials->serviceTypeId = $serviceTypeId;
    $credentials->apiKey = $apiKey;
    $credentials->amount = $amount;
    $credentials->requestId = $requestId;

    return $credentials;
}

class TestMandateDirectDebit
{

    function test()
    {
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
        $setupMandateRequest->requestId = "Regular Payment";
        $setupMandateRequest->startDate = "19/07/2021";
        $setupMandateRequest->endDate = "22/08/2021";
        $setupMandateRequest->mandateType = "DD";
        $setupMandateRequest->maxNoOfDebits = "6";

        $response = MandateDirectDebitService::setupMandate($setupMandateRequest);
        echo "\n";
        echo "\n";
        echo "Setup Mandate Response:\n", json_encode($response);
    }
}

$testRITs = new TestMandateDirectDebit();
$testRITs->test();
?>

