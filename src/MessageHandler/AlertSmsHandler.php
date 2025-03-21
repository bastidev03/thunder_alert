<?php

namespace App\MessageHandler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

use App\Message\AlertSms;
use App\Service\SmsService;

#[AsMessageHandler]
class AlertSmsHandler
{
    public function __invoke(AlertSms $alert_sms)
    {
        $sms_service = new SmsService($alert_sms->getPhoneNumber(), $alert_sms->getMessage());
        $sms_service->sendSms();      
    }
}