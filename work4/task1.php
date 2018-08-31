<?php
interface I_Tariff
{
    function calculateTripPrice(int $distance, int $hours, int $minutes, int $age, $isGPS = null, $isAdditionalDriver = null);
    function calculateBaseTripPrice();
    function calculateAdditionalPrice();
//    function isValidAge();
//    function isYouthAge();
//    function youthRatePrice($tripPrice);
//    function setTripProperties($distance, $hours, $minutes, $age, $isGPS, $isAdditionalDriver);
};

trait AdditionalService
{
    /**
     * Вычисление стоимости услуги по предоставлению GPS
     * gps в салон - 15 рублей в час, минимум 1 час. Округление в большую сторону. Доступно на всех тарифах
     * @param int $hours
     * @param int $minutes
     * @param int $gpsPrice
     * @return float|int
     */
    function calculateGPSPrice(int $hours, int $minutes, int $gpsPrice)
    {
        $time = $hours;
        if ($minutes > 0) {
            $time++;
        }
        return ($gpsPrice * $time);
    }

    /**
     * Вычисление стоимости услуги дополнительного водителя
     * Дополнительный водитель - 100 рублей единоразово, доступен на всех тарифах кроме базового и студенческого
     * @param int $additionalDriverPrice
     * @return int
     */
    function calculateAdditionalDriverPrice(int $additionalDriverPrice)
    {
        return $additionalDriverPrice;
    }
}

/**
 * Абстрактный класс, от которого наследуются все тарифы
 */
abstract class A_Tariff implements I_Tariff
{
    const MIN_AGE = 18;
    const MAX_AGE = 65;
    const MAX_YOUTH_AGE = 21;
    const MAX_STUDENT_AGE = 25;
    const YOUTH_RATE = 0.1;
    const GPS_PRICE = 15;
    const ADDITIONAL_DRIVER_PRICE = 100;

    protected $tariffName;
    protected $pricePerKilometer;   // Цена за километр
    protected $pricePerTime;      // Цена за минуту

    // Доступность дополнительных услуг для тарифов
    protected $isGpsAvailable = true;
    protected $isAdditionalDriverAvailable = true;

    protected $distance, $hours, $minutes, $age, $isGPS = false, $isAdditionalDriver = false; // Параметры поездки, для которой рассчитывается стоимость
    protected $baseTripPrice, $additionalTripPrice, $totalTripPrice;
    protected $errorMessage;

    use AdditionalService;

    /**
     * Сохранение параметров поездки в свойствах объекта
     * @param int $distance - путь в км
     * @param int $hours - время поездки (сколько часов)
     * @param int $minutes - время поездки (сколько минут)
     * @param int $age - возраст водителя
     * @param $isGPS - использование допуслуги GPS
     * @param $isAdditionalDriver - использование допуслуги второго водителя
     */
    protected function setTripProperties(int $distance, int $hours, int $minutes, int $age, $isGPS, $isAdditionalDriver)
    {
        $this->distance = $distance;
        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->age = $age;
        $this->isGPS = $isGPS;
        $this->isAdditionalDriver = $isAdditionalDriver;
    }

    /**
     * Проверка возраста водителя
     * Минимальный возраст водителя - 18 лет, максимальный - 65 лет.
     * @return bool
     */
    protected function isValidAge()
    {
        return ($this->age >= self::MIN_AGE && $this->age <= self::MAX_AGE);
    }

    /**
     * Проверка возраста водителя на требование: "В случае возраста от 18 до 21 года, тариф повышается на 10%."
     * @return bool
     */
    protected function isYouthAge()
    {
        return ($this->age >= self::MIN_AGE && $this->age <= self::MAX_YOUTH_AGE);
    }

    /**
     * Проверка возраста водителя на применимость студенческого тарифа "Возраст водителя не может быть более 25 лет"
     * @return bool
     */

    protected function isStudentAge()
    {
        return ($this->age >= self::MIN_AGE && $this->age <= self::MAX_STUDENT_AGE);
    }

    /**
     * Вычисление дополнительной платы "В случае возраста от 18 до 21 года, тариф повышается на 10%."
     * @param int $tripPrice
     * @return float|int
     */
    protected function calculateYouthRatePrice(int $tripPrice)
    {
        return ($tripPrice * self::YOUTH_RATE);
    }

    /**
     * Вывод на экран информации о параметрах и стоимости поездки
     */
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

    /**
     * Вычисление стоимости дополнительных услуг
     * @return float|int
     */
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

    /**
     * Вычисление полной стоимости поездки
     * @param int $distance - путь в км
     * @param int $hours - время поездки (сколько часов)
     * @param int $minutes - время поездки (сколько минут)
     * @param int $age - возраст водителя
     * @param $isGPS - использование допуслуги GPS
     * @param $isAdditionalDriver - использование допуслуги второго водителя
     * @return float|int
     */
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

/**
 * Класс для тарифа Базовый
 */
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

    /**
     * Вычисление базовой стоимости поездки по тарифу Базовый
     * цена за 1 км = 10 рублей
     * цена за 1 минуту = 3 рубля
     * @return float|int
     */
    public function calculateBaseTripPrice()
    {
        $baseTripPrice = $this->pricePerKilometer * $this->distance + $this->pricePerTime * ($this->hours * 60 + $this->minutes);

        return $baseTripPrice;
    }
};

/**
 * Класс для тарифа Почасовой
 */
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

    /**
     * Вычисление базовой стоимости поездки по тарифу Почасовой
     * Цена за 1 км = 0
     * Цена за 60 минут = 200 рублей
     * Округление до 60 минут в большую сторону
     * @return float|int
     */
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

/**
 * Класс для тарифа Суточный
 */
class TariffDaily extends A_Tariff
{
    public function __construct()
    {
        $this->tariffName = 'Тариф суточный';
        $this->pricePerTime = 1000;
        $this->pricePerKilometer = 1;
        $this->isGpsAvailable = true;
        $this->isAdditionalDriverAvailable = true;
    }

    /**
     * Вычисление базовой стоимости поездки по тарифу Суточный
     * цена за 1 км = 1 рубль
     * цена за 24 часа = 1000 рублей
     * округление до 24 часов в большую сторону, но не менее 30 минут.
     * @return float|int
     */
    public function calculateBaseTripPrice()
    {
        $days = floor($this->hours / 24);
        if ($days == 0) {
            $days = 1;
        } else {
            $days += ($this->minutes < 30 ? 0 : 1);
        };

        $baseTripPrice = $this->pricePerKilometer * $this->distance + $this->pricePerTime * $days;

        return $baseTripPrice;
    }
};

/**
 * Класс для тарифа Студенческий
 */
class TariffStudent extends A_Tariff
{
    public function __construct()
    {
        $this->tariffName = 'Тариф студенческий';
        $this->pricePerTime = 1;
        $this->pricePerKilometer = 4;
        $this->isGpsAvailable = true;
        $this->isAdditionalDriverAvailable = false;
    }

    /**
     * Вычисление базовой стоимости поездки по тарифу Студенческий
     * цена за 1 км = 4 рубля
     * цена за 1 минуту = 1 рубль
     * Возраст водителя не может быть более 25 лет
     * @return float|int
     */
    public function calculateBaseTripPrice()
    {
        if (!$this->isStudentAge()) {
            $this->errorMessage = "Студенческий тариф неприменим - ограничение по возрасту";
            return -1;
        }
        $baseTripPrice = $this->pricePerKilometer * $this->distance + $this->pricePerTime * ($this->hours * 60 + $this->minutes);

        return $baseTripPrice;
    }
};

//=======================================================================================
$tariffBase = new TariffBase();
$tariffBase->calculateTripPrice(10, 1, 20, 20, true);
echo "======================================================================================\n";

$tariffHour = new TariffHourly();
$tariffHour->calculateTripPrice(10, 1, 20, 15, true, true);
echo "======================================================================================\n";

$tariffStudent = new TariffStudent();
$tariffStudent->calculateTripPrice(10, 1, 20, 20, true, true);
echo "======================================================================================\n";

$tariffDaily = new TariffDaily();
$tariffDaily->calculateTripPrice(10, 25, 20, 20, true, true);
