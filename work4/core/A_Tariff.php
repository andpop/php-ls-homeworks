<?php
abstract class A_Tariff implements I_Tariff
{
    const MIN_AGE = 18;
    const MAX_AGE = 65;
    const MAX_YOUTH_AGE = 21;
    const MAX_STUDENT_AGE = 21;
    const YOUTH_RATE = 0.1;
    const GPS_PRICE = 15;
    const ADDITIONAL_DRIVER_PRICE = 100;

    protected $tariffName;
    protected $pricePerKilometer;   // Цена за километр
    protected $pricePerTime;      // Цена за минуту
    protected $isGpsAvailable = true;
    protected $isAdditionalDriverAvailable = true;

    protected $distance, $hours, $minutes, $age, $isGPS = false, $isAdditionalDriver = false;
    protected $baseTripPrice, $additionalTripPrice, $totalTripPrice;
    protected $errorMessage;

    use T_AdditionalService;

    protected function setTripProperties(int $distance, int $hours, int $minutes, int $age, $isGPS, $isAdditionalDriver)
    {
        $this->distance = $distance;
        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->age = $age;
        $this->isGPS = $isGPS;
        $this->isAdditionalDriver = $isAdditionalDriver;
    }

    protected function isValidAge()
    {
        return ($this->age >= self::MIN_AGE && $this->age <= self::MAX_AGE);
    }

    protected function isYouthAge()
    {
        return ($this->age >= self::MIN_AGE && $this->age <= self::MAX_YOUTH_AGE);
    }

    protected function isStudentAge()
    {
        return ($this->age >= self::MIN_AGE && $this->age <= self::MAX_STUDENT_AGE);
    }

    protected function calculateYouthRatePrice(int $tripPrice)
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
        if ($this->isGpsAvailable && $this->isGPS) {
            echo "Дополнительная услуга: GPS".PHP_EOL;
        };
        if ($this->isAdditionalDriverAvailable && $this->isAdditionalDriver) {
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
            $additionalPrice += $this->calculateGPSPrice($this->hours, $this->minutes, self::GPS_PRICE);
        };
        if ($this->isAdditionalDriverAvailable && $this->isAdditionalDriver) {
            $additionalPrice += $this->calculateAdditionalDriverPrice(self::ADDITIONAL_DRIVER_PRICE);
        };
        if ($this->isYouthAge()) {
            $additionalPrice += $this->calculateYouthRatePrice($this->baseTripPrice);
        };

        return $additionalPrice;
    }

    public function calculateTripPrice(int $distance, int $hours, int $minutes, int $age, $isGPS = null, $isAdditionalDriver = null)
    {
        $this->setTripProperties($distance, $hours, $minutes, $age, $isGPS, $isAdditionalDriver);
        $this->errorMessage = "";

        if (!$this->isValidAge()) {
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
