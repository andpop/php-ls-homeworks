<?php
class Hourly extends A_Tariff
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
