<?php
class Daily extends A_Tariff
{
    public function __construct()
    {
        $this->tariffName = 'Тариф суточный';
        $this->pricePerTime = 1000;
        $this->pricePerKilometer = 1;
        $this->isGpsAvailable = true;
        $this->isAdditionalDriverAvailable = true;
    }

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
