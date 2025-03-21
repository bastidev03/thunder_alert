<?php

namespace App\Service;

use Symfony\Component\HttpKernel\Log\Logger as SymfonyLogger;

use App\Lib\FormatValidator;
use App\Lib\Logger;

class SmsService
{
    const LOG_FILE = 'sms_history.log';

    private $phone_number;

    private $message;

    public function __construct(string $phone_number, string $message)
    {
        if(!FormatValidator::checkPhone($phone_number))
        {
            throw new \Exception("Invalid phone number format ($phone_number)");
        }

        $this->$phone_number = $phone_number;
        $this->message = $message;
    }

    public function sendSms():void
    {
        $log_message = "
            SMS SENT
                tel : {$this->phone_number}

                sending_date : ".(date('Y-m-d H:i:s'))."

                content : $message
        \n";
          
        $http_logger = new SymfonyLogger();
        $http_logger->log($log_message);
        Logger::log($log_message, self::LOG_FILE);
    }
}