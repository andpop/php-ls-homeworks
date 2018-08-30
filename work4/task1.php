<?php
interface I_Tariff
{
    function calculateTripPrice($distance, $hours, $minutes, $age, $isGPS = null, $isAdditionalDriver = null);
    function calculateBaseTripPrice();
    function calculateAdditionalPrice();
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
    const MAX_YOUTH_AGE = 21;
    const MAX_STUDENT_AGE = 21;
    const YOUTH_RATE = 0.1;

    protected $tariffName;
    protected $pricePerKilometer;   // Цена за километр
    protected $pricePerTime;      // Цена за минуту
    protected $isGpsAvailable = true;
    protected $isAdditionalDriverAvailable = true;

    protected $distance, $hours, $minutes, $age, $isGPS = false, $isAdditionalDriver = false;
    protected $baseTripPrice, $additionalTripPrice, $totalTripPrice;
    protected $errorMessage;

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
        return ($age >= self::MIN_AGE && $age <= self::MAX_YOUTH_AGE);
    }

    protected function isStudentAge($age)
    {
        return ($age >= self::MIN_AGE && $age <= self::MAX_STUDENT_AGE);
    }

    protected function youthRatePrice($tripPrice)
    {
        return ($tripPrice * self::YOUTH_RATE);
    }

    protected function printPriceInfo()
    {
        echo $this->tariffName.PHP_EOL;
        echo '--------------------------------------------'.PHP_EOL;
        echo "Возраст водителя: {$this->age}".PHP_EOL;
        echo "Время поездки: {$this->hours} ч. {$this->minutes} мин.".PHP_EOL;
        echo "Путь: {$this->distance} км".PHP_EOL;
        if ($this->isGPS) {
            echo "Дополнительная услуга: GPS".PHP_EOL;
        };
        if ($this->isAdditionalDriver) {
            echo "Дополнительная услуга: второй водитель".PHP_EOL;
        };
        echo '--------------------------------------------'.PHP_EOL;
        if ($this->errorMessage) {
          echo $this->errorMessage.PHP_EOL;
          return;
        };
        echo "Базовая стоимость: {$this->baseTripPrice} руб.".PHP_EOL;
        echo "Дополнительная стоимость: {$this->additionalTripPrice} руб.".PHP_EOL;
        echo "Итого: {$this->totalTripPrice} руб.".PHP_EOL;
    }

    public function calculateAdditionalPrice()
    {
        $additionalPrice = 0;
        if ($this->isGpsAvailable && $this->isGPS) {
            $additionalPrice += $this->gpsPrice($this->hours, $this->minutes);
        };
        if ($this->isAdditionalDriverAvailable && $this->isAdditionalDriver) {
            $additionalPrice += $this->additionalDriverPrice();
        };
        if ($this->isYouthAge($this->age)) {
          $additionalPrice += $this->youthRatePrice($this->baseTripPrice);
        };

        return $additionalPrice;
    }

    public function calculateTripPrice($distance, $hours, $minutes, $age, $isGPS = null, $isAdditionalDriver = null)
    {
        $this->setTripProperties($distance, $hours, $minutes, $age, $isGPS, $isAdditionalDriver);
        $this->errorMessage = "";

        if (!$this->isValidAge($age)) {
            $this->errorMessage = "К сожалению, вынуждены отказать Вам в поездке - ограничение по возрасту.";
            $this->printPriceInfo();
            return -1;
        };

        $this->baseTripPrice = $this->calculateBaseTripPrice();
        if ($this->baseTripPrice < 0) {
            $this->printPriceInfo();
            return -1;
        }
        $this->additionalTripPrice = $this->calculateAdditionalPrice();
        $this->totalTripPrice = $this->baseTripPrice + $this->additionalTripPrice;

        $this->printPriceInfo();

        return $this->totalTripPrice;
    }
};

class TariffBase extends A_Tariff
{
    public function __construct()
    {
        $this->tariffName = 'Тариф базовый';
        $this->pricePerTime = 3;
        $this->pricePerKilometer = 10;
        $this->isGpsAvailable = true;
        $this->isAdditionalDriverAvailable = false;
    }

    public function calculateBaseTripPrice()
    {
        $baseTripPrice = $this->pricePerKilometer * $this->distance + $this->pricePerTime * ($this->hours * 60 + $this->minutes);

        return $baseTripPrice;
    }
};

class TariffHourly extends A_Tariff
{
    public function __construct()
    {
        $this->tariffName = 'Тариф почасовой';
        $this->pricePerTime = 200;
        $this->pricePerKilometer = 0;
        $this->isGpsAvailable = true;
        $this->isAdditionalDriverAvailable = true;
    }

    public function calculateBaseTripPrice()
    {
        $hours = $this->hours;
        if ($this->minutes > 0) {
            $hours++;
        };
        $baseTripPrice = $this->pricePerTime * $hours;

        return $baseTripPrice;
    }
};

class TariffDaily extends A_Tariff
{
    public function __construct()
    {
        $this->tariffName = 'Тариф почасовой';
        $this->pricePerTime = 200;
        $this->pricePerKilometer = 0;
        $this->isGpsAvailable = true;
        $this->isAdditionalDriverAvailable = true;
    }

    public function calculateBaseTripPrice()
    {
        $hours = $this->hours;
        if ($this->minutes > 0) {
            $hours++;
        };
        $baseTripPrice = $this->pricePerTime * $hours;

        return $baseTripPrice;
    }
};

class TariffStudent extends A_Tariff
{
    public function __construct()
    {
        $this->tariffName = 'Тариф почасовой';
        $this->pricePerTime = 1;
        $this->pricePerKilometer = 4;
        $this->isGpsAvailable = true;
        $this->isAdditionalDriverAvailable = false;
    }

    public function calculateBaseTripPrice()
    {
        if (!$this->isStudentAge($this->age)) {
            $this->errorMessage = "Студенческий тариф неприменим - ограничение по возрасту";
            return -1;
        }
        $hours = $this->hours;
        if ($this->minutes > 0) {
            $hours++;
        };
        $baseTripPrice = $this->pricePerTime * $hours;

        return $baseTripPrice;
    }
};

//=======================================================================================
//$tariffBase = new TariffBase();
//$tariffBase->calculateTripPrice(10, 1, 20, 20, true);

//$tariffHour = new TariffHourly();
//$tariffHour->calculateTripPrice(10, 1, 20, 15, true, true);

$tariffStudent = new TariffStudent();
$tariffStudent->calculateTripPrice(10, 1, 20, 27, true, true);