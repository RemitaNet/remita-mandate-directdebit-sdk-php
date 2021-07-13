<?php

class ApplicationUrl
{

    public static $demoUrl = "https://remitademo.net";

    public static $liveUrl = "https://login.remita.net";

    public static $setupMandatePath = "/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/setup";

    public static $mandateStatusPath = "/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/status";

    public static $mandateActivateRequestOTPPath = "/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/requestAuthorization";

    public static $mandateActivateValidateOTPPath = "/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/validateAuthorization";

    public static $sendDebitInstructionPath = "/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/payment/send";

    public static $debitStatusPath = "/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/payment/status";

    public static $cancelDebitInstructionPath = "/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/payment/stop";

    public static $mandatePaymentHistoryPath = "/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/payment/history";

    public static $stopMandatePath = "/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/stop";

    public static $mandateFormPath = "/remita/ecomm/mandate/form/{{merchantId}}/{{hash}}/{{mandateId}}/{{requestId}}/rest.reg";
}

?>
