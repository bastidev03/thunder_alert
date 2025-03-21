<?php
namespace App\Message;

class AlertSms
{
    private const MESSAGE = "ALERTE : Vigilance orange orages et vents violents. Veuillez rester chez vous.";

    private $phone_number;

    public function __construct(string $phone_number)
    {
        $this->phone_number = $phone_number;
    }

    public function getPhoneNumber():string
    {
        return $this->phone_number;
    }

    public function getMessage():string
    {
        return self::MESSAGE;
    }
}