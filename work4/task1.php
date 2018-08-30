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
    protected $hours;
    protected $minutes;
    protected $driverAge;
    protected $isGPS;
    protected $isAdditionalDriver;


    public function __construct($distance, $hours, $minutes, $driverBirthday, $isGPS = null, $isAdditionalDriver = null)
    {
        $this->distance = $distance;
        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->driverAge = $this->calculateAge($driverBirthday);
        $this->isGPS = isset($isGPS);
        $this->isAdditionalDriver = isset($this->isAdditionalDriver);
    }

    /**
     * Вычисление возраста человека по дню его рождения
     * @param string $birthday - дата рождения в формате 'день.месяц.год'
     * @return integer - возраст на текущую дату
     */
    protected function calculateAge(string $birthday)
    {
        $birthdayTimestamp = strtotime($birthday);
        $age = date('Y') - date('Y', $birthdayTimestamp);
        if (date('md', $birthdayTimestamp) > date('md')) {
            $age--;
        }
        return $age;
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
        $tripPrice = $this->pricePerKilometer * $this->distance + $this->pricePerMinute * ($this->$hours * 60 + $this->$minutes);
        return $tripPrice;
    }
};

$tariffBase = new TariffBase(10, 1, 20, '09.11.1974');
//echo $tariffBase->calculateTripPrice(10, 1, 20, '09.11.1974');
echo "Age=", $tariffBase->$driverAge;
echo "\n";