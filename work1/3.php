<?php
$age = rand(0, 100);
echo $age . PHP_EOL;
if ($age >= 18 and $age <= 65) {
    echo "Вам еще работать и работать".PHP_EOL;
} elseif ($age > 65) {
    echo "Вам пора на пенсию".PHP_EOL;
} elseif ($age >= 1 and $age <=17) {
    echo "Вам ещё рано работать".PHP_EOL;
} else {
    echo "Неизвестный возраст".PHP_EOL;
};
