<?php
interface I_Tariff
{
    public function calculateTripPrice($distance, $hours, $minutes, $driverBirthday, $isGPS = null, $isAdditionalDriver = null);
};

abstract class A_Tariff implements I_Tariff
{
    protected $pricePerKilometer;   // Цена за километр
    protected $pricePerMinute;      // Цена за минуту
    protected $distance;

    public function __construct($distance, $hours, $minutes, $driverBirthday, $isGPS = null, $isAdditionalDriver = null)
    {
        $this->distance = $distance;
    }

};

class TariffBase extends A_Tariff
{
    public function __construct($distance, $hours, $minutes, $driverBirthday, $isGPS = null, $isAdditionalDriver = null)
    {
        parent::__construct($distance, $hours, $minutes, $driverBirthday, $isGPS, $isAdditionalDriver);
        $this->pricePerMinute = 3;
        $this->pricePerKilometer = 10;
    }

    public function calculateTripPrice($distance, $hours, $minutes, $driverBirthday, $isGPS = null, $isAdditionalDriver = null)
    {
        $tripPrice = $this->pricePerKilometer * $this->distance + $this->pricePerMinute * ($hours * 60 + $minutes);
        return $tripPrice;
    }
};

$tariffBase = new TariffBase(10, 1, 20, '09.11.1974');
echo $tariffBase->calculateTripPrice(10, 1, 20, '09.11.1974');
echo "\n";