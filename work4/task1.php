<?php
interface I_Tariff
{
    function calculateTripPrice($distance, $hours, $minutes, $age, $isGPS = null, $isAdditionalDriver = null);
    function calculateBaseTripPrice();
    function calculateAdditionalPrice($baseTripPrice);
//    function isValidAge($age);
//    function isYouthAge($age);
//    function youthRatePrice($tripPrice);
//    function setTripProperties($distance, $hours, $minutes, $age, $isGPS, $isAdditionalDriver);
};

trait AdditionalService
{
    function gpsPrice($hours, $minutes)
    {
        define("GPS_PRICE", 15);

        $time = $hours;
        if ($minutes > 0) {
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
    const MIN_AGE = 18;
    const MAX_AGE = 65;
    const MIN_YOUTH_AGE = 18;
    const MAX_YOUTH_AGE = 21;
    const YOUTH_RATE = 0.1;

    protected $pricePerKilometer;   // Цена за километр
    protected $pricePerMinute;      // Цена за минуту
    protected $isGpsAvailable = true;
    protected $isAdditionalDriverAvailable = true;

    protected $distance, $hours, $minutes, $age, $isGPS = false, $isAdditionalDriver = false;

    use AdditionalService;

    protected function setTripProperties($distance, $hours, $minutes, $age, $isGPS, $isAdditionalDriver)
    {
        $this->distance = $distance;
        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->age = $age;
        $this->isGPS = $isGPS;
        $this->isAdditionalDriver = $isAdditionalDriver;
    }

    protected function isValidAge($age)
    {
        return ($age >= self::MIN_AGE && $age <= self::MAX_AGE);
    }

    protected function isYouthAge($age)
    {
        return ($age >= self::MIN_YOUTH_AGE && $age <= self::MAX_YOUTH_AGE);
    }

    protected function youthRatePrice($tripPrice)
    {
        return ($tripPrice * self::YOUTH_RATE);
    }

    public function calculateAdditionalPrice($baseTripPrice)
    {
        $additionalPrice = 0;
        if ($this->isGpsAvailable && $this->isGPS) {
            $additionalPrice += $this->gpsPrice($this->hours, $this->minutes);
        };
        if ($this->isYouthAge($this->age)) {
          $additionalPrice += $this->youthRatePrice($baseTripPrice);
        };

        return $additionalPrice;
    }

    public function calculateTripPrice($distance, $hours, $minutes, $age, $isGPS = null, $isAdditionalDriver = null)
    {
        if (!$this->isValidAge($age)) {
            echo "К сожалению, вынуждены отказать Вам в поездке - ограничение по возрасту.";
            return -1;
        };
        $this->setTripProperties($distance, $hours, $minutes, $age, $isGPS, $isAdditionalDriver);
        $baseTripPrice = $this->calculateBaseTripPrice();
        $additionalTripPrice = $this->calculateAdditionalPrice($baseTripPrice);
        $tripPrice = $baseTripPrice + $additionalTripPrice;

        return $tripPrice;
    }
};

class TariffBase extends A_Tariff
{
    public function __construct()
    {
        $this->pricePerMinute = 3;
        $this->pricePerKilometer = 10;
        $this->isGpsAvailable = true;
        $this->isAdditionalDriverAvailable = false;
    }

    public function calculateBaseTripPrice()
    {
        $baseTripPrice = $this->pricePerKilometer * $this->distance + $this->pricePerMinute * ($this->hours * 60 + $this->minutes);

        return $baseTripPrice;
    }
};

$tariffBase = new TariffBase();
echo $tariffBase->calculateTripPrice(10, 1, 20, 20, true);
echo "\n";