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
