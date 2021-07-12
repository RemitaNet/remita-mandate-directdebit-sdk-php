<?php
include 'Config/Credentials.php';
include 'Constants/ApplicationUrl.php';
include 'Util/HTTPUtil.php';

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

    // GET HEADERS
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

    // ACTIVATE MANDATE
    public static function activateMandate($mandateActivateRequestOTP)
    {
        $url = MandateDirectDebitService::$credentials->url . ApplicationUrl::$mandateActivateRequestOTPPath;
        $mandateId = utf8_encode($mandateActivateRequestOTP->mandateId);

        $merchantId = MandateDirectDebitService::$credentials->merchantId;
        $apiKey = MandateDirectDebitService::$credentials->apiKey;
        $apiToken = MandateDirectDebitService::$credentials->apiToken;
        $requestId = MandateDirectDebitService::$credentials->requestId;
        $time = date("H:i:s+000000");
        $date = date("Y-m-d");
        $timeStamp = $date . "T" . $time; // 2019-09-11T05:33:39+000000

        $hash = hash('sha512', $apiKey . $requestId . $apiToken);

        $headers = array(
            'Content-Type: application/json',
            'MERCHANT_ID:' . $merchantId,
            'API_KEY:' . $apiKey,
            'REQUEST_ID:' . $requestId,
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
}

?>

