<?php
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
