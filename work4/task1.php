<?php
interface I_Tariff
{
    public function calculateTripPrice($distance, $hours, $minutes, $age, $isGPS = null, $isAdditionalDriver = null);
};

trait AdditionalService
{
    function gpsPrice($hour, $minute )
    {
        define("GPS_PRICE", 15);

        $time = $hour;
        if ($minute > 0) {
            $time++;
        }
        $gpsPrice = GPS_PRICE * $time;
        return $gpsPrice;
    }

    function additionalDriverPrice()
    {
        define("ADDITIONAL_DRIVER_PRICE", 100);

        return ADDITIONAL_DRIVER_PRICE;
    }
}

abstract class A_Tariff implements I_Tariff
{
    protected $pricePerKilometer;   // Цена за километр
    protected $pricePerMinute;      // Цена за минуту
    protected $isGPS = false;
    protected $isAdditionalDriver = false;

};

class TariffBase extends A_Tariff
{
    public function __construct()
    {
        $this->pricePerMinute = 3;
        $this->pricePerKilometer = 10;
    }

    use AdditionalService;

    public function calculateTripPrice($distance, $hours, $minutes, $age, $isGPS = null, $isAdditionalDriver = null)
    {
        $tripPrice = $this->pricePerKilometer * $distance + $this->pricePerMinute * ($hours * 60 + $minutes);
        if ($isGPS) {
          $tripPrice += $this->gpsPrice($hours, $minutes);
        };
        return $tripPrice;
    }
};

$tariffBase = new TariffBase();
echo $tariffBase->calculateTripPrice(10, 1, 20, 43, true);
echo "\n";