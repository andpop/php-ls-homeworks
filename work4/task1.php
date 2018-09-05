<?php
//Loading core classes
require_once 'core/I_Tarif.php';
require_once 'core/T_AdditionalService.php';
require_once 'core/A_Tariff.php';

//Loading classes for tariffes
require_once 'tariffes/Base.php';
require_once 'tariffes/Hourly.php';
require_once 'tariffes/Daily.php';
require_once 'tariffes/Student.php';

$tariffBase = new Base();
$tariffBase->calculateTripPrice(10, 1, 20, 20, true);
echo "======================================================================================\n";

$tariffHour = new Hourly();
$tariffHour->calculateTripPrice(10, 1, 20, 15, true, true);
echo "======================================================================================\n";

$tariffStudent = new Student();
$tariffStudent->calculateTripPrice(10, 1, 20, 20, true, true);
echo "======================================================================================\n";

$tariffDaily = new Daily();
$tariffDaily->calculateTripPrice(10, 25, 20, 20, true, true);
