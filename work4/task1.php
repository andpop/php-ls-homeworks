<?php
//Loading core classes
require_once 'core/I_Tarif.php';
require_once 'core/T_AdditionalService.php';
require_once 'core/A_Tariff.php';

//Loading classes for tariffes
require_once 'tariffes/TariffBase.php';
require_once 'tariffes/TariffHourly.php';
require_once 'tariffes/TariffDaily.php';
require_once 'tariffes/TariffStudent.php';

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
