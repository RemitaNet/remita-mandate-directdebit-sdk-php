<?php
include 'Config/Credentials.php';
include 'Constants/ApplicationUrl.php';
include 'Util/HTTPUtil.php';
include 'Request/AuthParams1.php';
include 'Request/AuthParams2.php';

class MandateDirectDebitService
{

    public static $credentials;

    // INITIALIZE CREDENTIALS
    public static function initCredentials($initCredentials)
    {
        if (is_null($initCredentials)) {
            echo 'Credentials must be initialized';
            return;
        }

        MandateDirectDebitService::$credentials = $initCredentials;
    }

    // FORMAT RESPONSE
    public static function formatResponse($response)
    {
        $result = $response;
        $result = substr($result, 7);
        $newLength = strlen($result);
        $result = substr($result, 0, $newLength - 1);
        return json_decode($result);
    }

    // SETUP MANDATE
    public static function setupMandate($setupMandateRequest)
    {
        $url = MandateDirectDebitService::$credentials->url . ApplicationUrl::$setupMandatePath;

        $merchantId = utf8_encode(MandateDirectDebitService::$credentials->merchantId);
        $serviceTypeId = utf8_encode(MandateDirectDebitService::$credentials->serviceTypeId);
        $apiKey = utf8_encode(MandateDirectDebitService::$credentials->apiKey);
        $amount = utf8_encode(MandateDirectDebitService::$credentials->amount);
        $requestId = utf8_encode($setupMandateRequest->requestId);
        $hash = hash('sha512', $merchantId . $serviceTypeId . $requestId . $amount . $apiKey);

        $headers = $headers = array(
            'Content-Type: application/json'
        );

        // POST BODY
        $phpArray = array(
            'merchantId' => $merchantId,
            'serviceTypeId' => $serviceTypeId,
            'hash' => $hash,
            'payerName' => $setupMandateRequest->payerName,
            'payerEmail' => $setupMandateRequest->payerEmail,
            'payerPhone' => $setupMandateRequest->payerPhone,
            'payerBankCode' => $setupMandateRequest->payerBankCode,
            'payerAccount' => $setupMandateRequest->payerAccount,
            'requestId' => $requestId,
            'amount' => $amount,
            'startDate' => $setupMandateRequest->startDate,
            'endDate' => $setupMandateRequest->endDate,
            'mandateType' => $setupMandateRequest->mandateType,
            'maxNoOfDebits' => $setupMandateRequest->maxNoOfDebits
        );

        // echo "\n";
        // echo "headers: ", json_encode($headers);
        // echo "\n";
        // echo "phpArray: ", json_encode($phpArray);

        // POST CALL
        $result = HTTPUtil::postMethod($url, $headers, json_encode($phpArray));
        return MandateDirectDebitService::formatResponse($result);
    }

    // ACTIVATE MANDATE OTP REQUEST
    public static function activateMandateRequestOTP($mandateActivateRequestOTP)
    {
        $url = MandateDirectDebitService::$credentials->url . ApplicationUrl::$mandateActivateRequestOTPPath;
        $mandateId = utf8_encode($mandateActivateRequestOTP->mandateId);
        $requestId = utf8_encode($mandateActivateRequestOTP->requestId);

        $merchantId = utf8_encode(MandateDirectDebitService::$credentials->merchantId);
        $apiKey = utf8_encode(MandateDirectDebitService::$credentials->apiKey);
        $apiToken = utf8_encode(MandateDirectDebitService::$credentials->apiToken);
        $time = date("H:i:s+000000");
        $date = date("Y-m-d");
        $timeStamp = utf8_encode($date . "T" . $time); // 2019-09-11T05:33:39+000000
        $headerRequestId = round(microtime(true) * 1000);

        $hash = hash('sha512', $apiKey . $headerRequestId . $apiToken);

        $headers = array(
            'Content-Type: application/json',
            'MERCHANT_ID:' . $merchantId,
            'API_KEY:' . $apiKey,
            'REQUEST_ID:' . $headerRequestId,
            'REQUEST_TS:' . $timeStamp,
            'API_DETAILS_HASH:' . $hash
        );

        // POST BODY
        $phpArray = array(
            'mandateId' => $mandateId,
            'requestId' => $requestId
        );

        // POST CALL
        $result = HTTPUtil::postMethod($url, $headers, json_encode($phpArray));
        return MandateDirectDebitService::formatResponse($result);
    }

    // ACTIVATE MANDATE OTP VALIDATE
    public static function activateMandateValidatetOTP($mandateActivateValidateOTP)
    {
        $url = MandateDirectDebitService::$credentials->url . ApplicationUrl::$mandateActivateValidateOTPPath;
        $remitaTransRef = utf8_encode($mandateActivateValidateOTP->remitaTransRef);
        $card = utf8_encode($mandateActivateValidateOTP->card);
        $otp = utf8_encode($mandateActivateValidateOTP->otp);

        $merchantId = utf8_encode(MandateDirectDebitService::$credentials->merchantId);
        $apiKey = utf8_encode(MandateDirectDebitService::$credentials->apiKey);
        $apiToken = utf8_encode(MandateDirectDebitService::$credentials->apiToken);
        $requestId = utf8_encode(round(microtime(true) * 1000));
        $time = date("H:i:s+000000");
        $date = date("Y-m-d");
        $timeStamp = utf8_encode($date . "T" . $time); // 2019-09-11T05:33:39+000000

        $hash = hash('sha512', $apiKey . $requestId . $apiToken);

        $headers = array(
            'Content-Type: application/json',
            'MERCHANT_ID:' . $merchantId,
            'API_KEY:' . $apiKey,
            'REQUEST_ID:' . $requestId,
            'REQUEST_TS:' . $timeStamp,
            'API_DETAILS_HASH:' . $hash
        );

        $authParam1 = new AuthParams1();
        $authParam1->param1 = "OTP";
        $authParam1->value = $otp;

        $authParam2 = new AuthParams2();
        $authParam2->param2 = "CARD";
        $authParam2->value = $card;

        $authParams = array(
            $authParam1,
            $authParam2
        );

        // POST BODY
        $phpArray = array(
            'remitaTransRef' => $remitaTransRef,
            'authParams' => $authParams
        );

        // echo "\n";
        // echo "headers: ", json_encode($headers);
        // echo "\n";
        // echo "phpArray: ", json_encode($phpArray);

        // POST CALL
        $result = HTTPUtil::postMethod($url, $headers, json_encode($phpArray));
        return MandateDirectDebitService::formatResponse($result);
    }

    // DEBIT INSTRUCTION
    public static function sendDebitInstruction($sendDebitInstructionRequest)
    {
        $url = MandateDirectDebitService::$credentials->url . ApplicationUrl::$sendDebitInstructionPath;

        $merchantId = utf8_encode(MandateDirectDebitService::$credentials->merchantId);
        $serviceTypeId = utf8_encode(MandateDirectDebitService::$credentials->serviceTypeId);
        $apiKey = utf8_encode(MandateDirectDebitService::$credentials->apiKey);
        $amount = utf8_encode(MandateDirectDebitService::$credentials->amount);
        $mandateId = utf8_encode($sendDebitInstructionRequest->mandateId);
        $fundingAccount = utf8_encode($sendDebitInstructionRequest->fundingAccount);
        $fundingBankCode = utf8_encode($sendDebitInstructionRequest->fundingBankCode);
        $requestId = utf8_encode($sendDebitInstructionRequest->requestId);
        $hash = hash('sha512', $merchantId . $serviceTypeId . $requestId . $amount . $apiKey);

        $headers = $headers = array(
            'Content-Type: application/json'
        );

        // POST BODY
        $phpArray = array(
            'merchantId' => $merchantId,
            'serviceTypeId' => $serviceTypeId,
            'hash' => $hash,
            'requestId' => $requestId,
            'totalAmount' => $amount,
            'mandateId' => $mandateId,
            'fundingAccount' => $fundingAccount,
            'fundingBankCode' => $fundingBankCode
        );

        echo "\n";
        echo "headers: ", json_encode($headers);
        echo "\n";
        echo "phpArray: ", json_encode($phpArray);

        // POST CALL
        $result = HTTPUtil::postMethod($url, $headers, json_encode($phpArray));
        return MandateDirectDebitService::formatResponse($result);
    }

    // DEBIT STATUS
    public static function debitStatus($debitStatusRequest)
    {
        $url = MandateDirectDebitService::$credentials->url . ApplicationUrl::$debitStatusPath;

        $merchantId = utf8_encode(MandateDirectDebitService::$credentials->merchantId);
        $apiKey = utf8_encode(MandateDirectDebitService::$credentials->apiKey);
        $mandateId = utf8_encode($debitStatusRequest->mandateId);
        $requestId = utf8_encode($debitStatusRequest->requestId);
        $hash = hash('sha512', $mandateId . $merchantId . $requestId . $apiKey);

        $headers = $headers = array(
            'Content-Type: application/json'
        );

        // POST BODY
        $phpArray = array(
            'merchantId' => $merchantId,
            'mandateId' => $mandateId,
            'hash' => $hash,
            'requestId' => $requestId
        );

        // POST CALL
        $result = HTTPUtil::postMethod($url, $headers, json_encode($phpArray));
        return MandateDirectDebitService::formatResponse($result);
    }

    // CANCEL DEBIT INSTRUCTION
    public static function cancelDebitInstruction($cancelDebitInstructionRequest)
    {
        $url = MandateDirectDebitService::$credentials->url . ApplicationUrl::$cancelDebitInstructionPath;

        $merchantId = utf8_encode(MandateDirectDebitService::$credentials->merchantId);
        $apiKey = utf8_encode(MandateDirectDebitService::$credentials->apiKey);
        $mandateId = utf8_encode($cancelDebitInstructionRequest->mandateId);
        $requestId = utf8_encode($cancelDebitInstructionRequest->requestId);
        $transactionRef = utf8_encode($cancelDebitInstructionRequest->transactionRef);
        $hash = hash('sha512', $transactionRef . $merchantId . $requestId . $apiKey);

        $headers = $headers = array(
            'Content-Type: application/json'
        );

        // POST BODY
        $phpArray = array(
            'merchantId' => $merchantId,
            'mandateId' => $mandateId,
            'hash' => $hash,
            'transactionRef' => $transactionRef,
            'requestId' => $requestId
        );

        // POST CALL
        $result = HTTPUtil::postMethod($url, $headers, json_encode($phpArray));
        return MandateDirectDebitService::formatResponse($result);
    }

    // MANDATE STATUS
    public static function mandateStatus($mandateStatusRequest)
    {
        $url = MandateDirectDebitService::$credentials->url . ApplicationUrl::$mandateStatusPath;

        $merchantId = utf8_encode(MandateDirectDebitService::$credentials->merchantId);
        $apiKey = utf8_encode(MandateDirectDebitService::$credentials->apiKey);
        $mandateId = utf8_encode($mandateStatusRequest->mandateId);
        $requestId = utf8_encode($mandateStatusRequest->requestId);
        $hash = hash('sha512', $mandateId . $merchantId . $requestId . $apiKey);

        $headers = $headers = array(
            'Content-Type: application/json'
        );

        // POST BODY
        $phpArray = array(
            'merchantId' => $merchantId,
            'mandateId' => $mandateId,
            'hash' => $hash,
            'requestId' => $requestId
        );

        // POST CALL
        $result = HTTPUtil::postMethod($url, $headers, json_encode($phpArray));
        return MandateDirectDebitService::formatResponse($result);
    }

    // MANDATE PAYMENT HISTORY
    public static function mandatePaymentHistory($mandatePaymentHistoryRequest)
    {
        $url = MandateDirectDebitService::$credentials->url . ApplicationUrl::$mandatePaymentHistoryPath;

        $merchantId = utf8_encode(MandateDirectDebitService::$credentials->merchantId);
        $apiKey = utf8_encode(MandateDirectDebitService::$credentials->apiKey);
        $mandateId = utf8_encode($mandatePaymentHistoryRequest->mandateId);
        $requestId = utf8_encode($mandatePaymentHistoryRequest->requestId);
        $hash = hash('sha512', $mandateId . $merchantId . $requestId . $apiKey);

        $headers = $headers = array(
            'Content-Type: application/json'
        );

        // POST BODY
        $phpArray = array(
            'merchantId' => $merchantId,
            'mandateId' => $mandateId,
            'hash' => $hash,
            'requestId' => $requestId
        );

        // POST CALL
        $result = HTTPUtil::postMethod($url, $headers, json_encode($phpArray));
        return MandateDirectDebitService::formatResponse($result);
    }

    // STOP MANDATE
    public static function stopMandate($stopMandateRequest)
    {
        $url = MandateDirectDebitService::$credentials->url . ApplicationUrl::$stopMandatePath;

        $merchantId = utf8_encode(MandateDirectDebitService::$credentials->merchantId);
        $apiKey = utf8_encode(MandateDirectDebitService::$credentials->apiKey);
        $mandateId = utf8_encode($stopMandateRequest->mandateId);
        $requestId = utf8_encode($stopMandateRequest->requestId);
        $hash = hash('sha512', $mandateId . $merchantId . $requestId . $apiKey);

        $headers = $headers = array(
            'Content-Type: application/json'
        );

        // POST BODY
        $phpArray = array(
            'merchantId' => $merchantId,
            'mandateId' => $mandateId,
            'hash' => $hash,
            'requestId' => $requestId
        );

        // POST CALL
        $result = HTTPUtil::postMethod($url, $headers, json_encode($phpArray));
        return MandateDirectDebitService::formatResponse($result);
    }
}

?>

