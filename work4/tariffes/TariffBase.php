<?php
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
