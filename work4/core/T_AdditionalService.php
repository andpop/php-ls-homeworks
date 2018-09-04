<?php
trait T_AdditionalService
{
    function calculateGPSPrice(int $hours, int $minutes, int $gpsPrice)
    {

        $time = $hours;
        if ($minutes > 0) {
            $time++;
        }
        return ($gpsPrice * $time);
    }

    function calculateAdditionalDriverPrice(int $additionalDriverPrice)
    {
        return $additionalDriverPrice;
    }
}
